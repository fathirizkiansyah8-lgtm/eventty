<?php

namespace App\Http\Controllers\User;

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
     * Halaman chat siswa — tampilkan semua admin sebagai pilihan chat
     */
    public function index(): View
    {
        $admins = User::where('role', 'admin')->orderBy('name')->get();
        return view('user.messages', compact('admins'));
    }

    /**
     * GET /api/user/messages/{adminId} — ambil riwayat percakapan dengan admin tertentu
     */
    public function getMessages(int $adminId): JsonResponse
    {
        $user  = Auth::user();
        $admin = User::where('id', $adminId)->where('role', 'admin')->firstOrFail();

        $messages = Message::conversation($user->id, $admin->id)
            ->get()
            ->map(function ($msg) use ($user) {
                return [
                    'id'         => $msg->id,
                    'body'       => $msg->body,
                    'sender_id'  => $msg->sender_id,
                    'is_mine'    => $msg->sender_id === $user->id,
                    'time'       => $msg->created_at->format('H:i'),
                    'date'       => $msg->created_at->format('d M Y'),
                    'read_at'    => $msg->read_at?->toISOString(),
                    'created_at' => $msg->created_at->toISOString(),
                ];
            });

        // Tandai pesan dari admin ini sebagai sudah dibaca
        Message::where('sender_id', $admin->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    /**
     * POST /api/user/messages/{adminId} — kirim pesan ke admin tertentu
     */
    public function send(Request $request, int $adminId): JsonResponse
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $user  = Auth::user();
        $admin = User::where('id', $adminId)->where('role', 'admin')->firstOrFail();

        $message = Message::create([
            'sender_id'   => $user->id,
            'receiver_id' => $admin->id,
            'body'        => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'         => $message->id,
                'body'       => $message->body,
                'sender_id'  => $message->sender_id,
                'is_mine'    => true,
                'time'       => $message->created_at->format('H:i'),
                'date'       => $message->created_at->format('d M Y'),
                'read_at'    => null,
                'created_at' => $message->created_at->toISOString(),
            ],
        ]);
    }

    /**
     * GET /api/user/messages/admins — daftar semua admin + unread count per admin
     */
    public function getAdmins(): JsonResponse
    {
        $user   = Auth::user();
        $admins = User::where('role', 'admin')->orderBy('name')->get();

        $result = $admins->map(function ($admin) use ($user) {
            $last = Message::conversation($user->id, $admin->id)
                ->latest()->first();

            $unread = Message::where('sender_id', $admin->id)
                ->where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->count();

            return [
                'id'           => $admin->id,
                'name'         => $admin->name,
                'avatar_init'  => strtoupper(substr($admin->name, 0, 1)),
                'last_message' => $last?->body ?? null,
                'last_time'    => $last?->created_at->diffForHumans() ?? null,
                'unread'       => $unread,
            ];
        });

        return response()->json($result);
    }

    /**
     * GET /api/user/messages/unread — total pesan belum dibaca dari semua admin
     */
    public function unreadCount(): JsonResponse
    {
        $user = Auth::user();

        // Ambil semua admin IDs
        $adminIds = User::where('role', 'admin')->pluck('id');

        $count = Message::whereIn('sender_id', $adminIds)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }
}
