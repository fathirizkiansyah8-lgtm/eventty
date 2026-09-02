<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EventController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * Display a listing of events.
     */
    public function index(Request $request): View
    {
        $query = Event::with(['category', 'creator']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categories = EventCategory::orderBy('name')->get();

        return view('admin.events', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        $categories = EventCategory::orderBy('name')->get();
        return view('admin.create-event', compact('categories'));
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:event_categories,id',
            'date'        => 'required|date|after_or_equal:today',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'location'    => 'required|string|max:255',
            'organizer'   => 'required|string|max:255',
            'quota'       => 'required|integer|min:1',
            'banner'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'      => 'required|in:draft,open,closed',
        ], [
            'name.required'        => 'Nama event harus diisi.',
            'description.required' => 'Deskripsi harus diisi.',
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'date.required'        => 'Tanggal harus diisi.',
            'date.after_or_equal'  => 'Tanggal tidak boleh sebelum hari ini.',
            'start_time.required'  => 'Waktu mulai harus diisi.',
            'end_time.required'    => 'Waktu selesai harus diisi.',
            'end_time.after'       => 'Waktu selesai harus lebih dari waktu mulai.',
            'location.required'    => 'Lokasi harus diisi.',
            'organizer.required'   => 'Penyelenggara harus diisi.',
            'quota.required'       => 'Kuota peserta harus diisi.',
            'quota.min'            => 'Kuota minimal 1.',
            'banner.image'         => 'Banner harus berupa gambar.',
            'banner.max'           => 'Ukuran banner maksimal 2MB.',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            try {
                $bannerPath = $this->fileUploadService->uploadEventBanner($request->file('banner'));
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['banner' => 'Gagal mengupload banner: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        Event::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'category_id'     => $request->category_id,
            'date'            => $request->date,
            'start_time'      => $request->start_time,
            'end_time'        => $request->end_time,
            'location'        => $request->location,
            'organizer'       => $request->organizer,
            'quota'           => $request->quota,
            'banner_path'     => $bannerPath,
            'has_certificate' => $request->boolean('has_certificate'),
            'status'          => $request->status,
            'created_by'      => Auth::id(),
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat!');
    }

    /**
     * Display the specified event.
     */
    public function show($id): JsonResponse
    {
        $event = Event::with(['category', 'creator', 'participants'])->findOrFail($id);

        return response()->json([
            'id' => $event->id,
            'name' => $event->name,
            'description' => $event->description,
            'category' => $event->category->name,
            'category_id' => $event->category_id,
            'date' => $event->date->format('Y-m-d'),
            'start_time' => $event->start_time->format('H:i'),
            'end_time' => $event->end_time->format('H:i'),
            'formatted_date' => $event->formatted_date,
            'formatted_time' => $event->formatted_time,
            'location' => $event->location,
            'organizer' => $event->organizer,
            'quota' => $event->quota,
            'registered_count' => $event->registered_count,
            'remaining_slots' => $event->getRemainingSlots(),
            'banner_url' => $event->banner_url,
            'status' => $event->status,
            'created_by' => $event->creator->name,
            'participants_count' => $event->participants->count(),
            'created_at' => $event->created_at->format('d F Y H:i'),
        ]);
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit($id): View
    {
        $event = Event::findOrFail($id);
        $categories = EventCategory::orderBy('name')->get();

        return view('admin.edit-event', compact('event', 'categories'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:event_categories,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,open,closed,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $bannerPath = $event->banner_path;
        if ($request->hasFile('banner')) {
            try {
                $bannerPath = $this->fileUploadService->uploadEventBanner(
                    $request->file('banner'),
                    $event->banner_path
                );
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupload banner: ' . $e->getMessage()
                ], 422);
            }
        }

        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'organizer' => $request->organizer,
            'quota' => $request->quota,
            'banner_path' => $bannerPath,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil diperbarui.',
            'event' => $event
        ]);
    }

    /**
     * Remove the specified event.
     */
    public function destroy($id): JsonResponse
    {
        $event = Event::findOrFail($id);

        // Check if event has participants
        if ($event->registered_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Event tidak dapat dihapus karena sudah memiliki peserta.'
            ], 400);
        }

        // Delete banner file
        if ($event->banner_path) {
            $this->fileUploadService->deleteFile($event->banner_path);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dihapus.'
        ]);
    }

    /**
     * Get events list (API)
     */
    public function getEvents(Request $request): JsonResponse
    {
        $query = Event::with(['category', 'creator']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $events = $query->paginate(10)->through(function ($event) {
            return [
                'id'               => $event->id,
                'name'             => $event->name,
                'category'         => $event->category->name,
                'category_color'   => $event->category->color,
                'date'             => $event->formatted_date,
                'time'             => $event->formatted_time,
                'location'         => $event->location,
                'quota'            => $event->quota,
                'registered_count' => $event->registered_count,
                'remaining_slots'  => $event->getRemainingSlots(),
                'status'           => $event->status,
                'created_by'       => $event->creator->name,
                'created_at'       => $event->created_at->format('d M Y'),
                'has_certificate'  => (bool) $event->has_certificate,
            ];
        });

        return response()->json($events);
    }

    /**
     * Get categories for dropdown
     */
    public function getCategories(): JsonResponse
    {
        $categories = EventCategory::orderBy('name')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'color' => $category->color,
            ];
        });

        return response()->json($categories);
    }
}
