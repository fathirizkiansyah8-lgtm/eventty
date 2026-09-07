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
     * Halaman chat siswa — selalu chat dengan admin
     */
    public function index(): View
    {
        // Ambil admin pertama sebagai CS
        $admin = User::where('role', 'admin')->first();
        return view('user.messages', compact('admin'));
    }

    /**
     * GET /api/user/messages — ambil riwayat percakapan dengan admin
     */
    public function getMessages(): JsonResponse
    {
        $user  = Auth::user();
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json([]);
        }

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

        // Tandai semua pesan dari admin sebagai sudah dibaca
        Message::where('sender_id', $admin->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    /**
     * POST /api/user/messages — kirim pesan ke admin
     */
    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $user  = Auth::user();
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
        }

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
     * GET /api/user/messages/unread — jumlah pesan belum dibaca dari admin
     */
    public function unreadCount(): JsonResponse
    {
        $user  = Auth::user();
        $admin = User::where('role', 'admin')->first();

        $count = $admin
            ? Message::where('sender_id', $admin->id)
                     ->where('receiver_id', $user->id)
                     ->whereNull('read_at')
                     ->count()
            : 0;

        return response()->json(['count' => $count]);
    }
}
