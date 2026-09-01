<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Show notifications page
     */
    public function index(): View
    {
        return view('user.notifications');
    }

    /**
     * Get user notifications (API)
     */
    public function getNotifications(Request $request): JsonResponse
    {
        $user = Auth::user();
        $query = $user->notifications();

        // Filter by status
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'unread':
                    $query->unread();
                    break;
                case 'read':
                    $query->read();
                    break;
                // 'all' - no additional filter
            }
        }

        $notifications = $query->orderBy('created_at', 'desc')
                             ->paginate(20)
                             ->through(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'type' => $notification->type,
                'icon' => $notification->default_icon,
                'action_url' => $notification->action_url,
                'is_read' => $notification->isRead(),
                'formatted_time' => $notification->formatted_time,
                'created_at' => $notification->created_at->toISOString(),
                'type_badge_class' => $notification->type_badge_class,
            ];
        });

        return response()->json($notifications);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil ditandai sebagai sudah dibaca.'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        $user = Auth::user();
        $count = $user->notifications()->unread()->count();

        $user->notifications()->unread()->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => "{$count} notifikasi berhasil ditandai sebagai sudah dibaca."
        ]);
    }

    /**
     * Delete notification
     */
    public function delete($id): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.'
        ]);
    }

    /**
     * Delete all notifications
     */
    public function deleteAll(): JsonResponse
    {
        $user = Auth::user();
        $count = $user->notifications()->count();

        $user->notifications()->delete();

        return response()->json([
            'success' => true,
            'message' => "{$count} notifikasi berhasil dihapus."
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount(): JsonResponse
    {
        $user = Auth::user();
        $count = $user->unreadNotificationsCount();

        return response()->json(['count' => $count]);
    }
}
