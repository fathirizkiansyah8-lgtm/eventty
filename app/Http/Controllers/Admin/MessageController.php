<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Halaman messages admin — daftar semua percakapan dengan siswa
     */
    public function index(): View
    {
        return view('admin.messages');
    }

    /**
     * GET /api/admin/messages/conversations — daftar siswa yang pernah chat
     */
    public function conversations(): JsonResponse
    {
        $admin = Auth::user();

        // Ambil semua user yang pernah kirim/terima pesan dari admin ini
        $conversations = Message::where('sender_id', $admin->id)
            ->orWhere('receiver_id', $admin->id)
            ->with(['sender', 'receiver'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($msg) use ($admin) {
                // Tentukan siapa partner chat-nya
                return $msg->sender_id === $admin->id
                    ? $msg->receiver
                    : $msg->sender;
            })
            ->filter(fn($u) => $u && $u->id !== $admin->id)
            ->unique('id')
            ->values()
            ->map(function ($student) use ($admin) {
                // Pesan terakhir
                $last = Message::conversation($admin->id, $student->id)
                    ->latest()
                    ->first();

                // Pesan belum dibaca (dari student ke admin)
                $unread = Message::where('sender_id', $student->id)
                    ->where('receiver_id', $admin->id)
                    ->whereNull('read_at')
                    ->count();

                return [
                    'id'           => $student->id,
                    'name'         => $student->name,
                    'nis'          => $student->nis ?? '-',
                    'class'        => $student->class ?? '-',
                    'avatar_init'  => strtoupper(substr($student->name, 0, 1)),
                    'last_message' => $last?->body ?? 'Belum ada pesan',
                    'last_time'    => $last?->created_at->diffForHumans() ?? '',
                    'unread'       => $unread,
                ];
            });

        return response()->json($conversations);
    }

    /**
     * GET /api/admin/messages/{studentId} — riwayat percakapan dengan satu siswa
     */
    public function getMessages(int $studentId): JsonResponse
    {
        $admin = Auth::user();

        $messages = Message::conversation($admin->id, $studentId)
            ->get()
            ->map(function ($msg) use ($admin) {
                return [
                    'id'        => $msg->id,
                    'body'      => $msg->body,
                    'is_mine'   => $msg->sender_id === $admin->id,
                    'time'      => $msg->created_at->format('H:i'),
                    'date'      => $msg->created_at->format('d M Y'),
                    'read_at'   => $msg->read_at?->toISOString(),
                    'created_at'=> $msg->created_at->toISOString(),
                ];
            });

        // Tandai pesan dari student sebagai sudah dibaca
        Message::where('sender_id', $studentId)
            ->where('receiver_id', $admin->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    /**
     * POST /api/admin/messages/{studentId} — admin kirim pesan ke siswa
     */
    public function send(Request $request, int $studentId): JsonResponse
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $admin = Auth::user();

        $student = User::where('id', $studentId)->where('role', 'student')->firstOrFail();

        $message = Message::create([
            'sender_id'   => $admin->id,
            'receiver_id' => $student->id,
            'body'        => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'         => $message->id,
                'body'       => $message->body,
                'is_mine'    => true,
                'time'       => $message->created_at->format('H:i'),
                'date'       => $message->created_at->format('d M Y'),
                'read_at'    => null,
                'created_at' => $message->created_at->toISOString(),
            ],
        ]);
    }

    /**
     * GET /api/admin/messages/unread-total — total pesan belum dibaca dari semua siswa
     */
    public function unreadTotal(): JsonResponse
    {
        $admin = Auth::user();
        $count = Message::where('receiver_id', $admin->id)->whereNull('read_at')->count();
        return response()->json(['count' => $count]);
    }
}
