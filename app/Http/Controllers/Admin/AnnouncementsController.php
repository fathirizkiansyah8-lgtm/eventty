<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementsController extends Controller
{
    public function index(Request $request): View
    {
        $query = Announcement::with('creator')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('content', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $announcements = $query->paginate(10)->withQueryString();

        return view('admin.announcements', compact('announcements'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'target'  => 'required|in:all_students,participants,all_users,specific_class',
            'status'  => 'required|in:active,inactive,scheduled',
        ]);

        Announcement::create([
            'title'        => $request->title,
            'content'      => $request->content,
            'target'       => $request->target,
            'status'       => $request->status,
            'publish_date' => now(),
            'created_by'   => Auth::id(),
            'priority'     => $request->get('priority', 'normal'),
            'is_pinned'    => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('admin.announcements')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function destroy($id): RedirectResponse
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.announcements')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function toggleStatus($id): RedirectResponse
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'status' => $announcement->status === 'active' ? 'inactive' : 'active',
        ]);

        return redirect()->route('admin.announcements')
            ->with('success', 'Status pengumuman berhasil diubah.');
    }
}
