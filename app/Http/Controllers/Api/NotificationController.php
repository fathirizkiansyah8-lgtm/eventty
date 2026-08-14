<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all notifications for authenticated user
     */
    public function index(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $notifications = $user->notifications()
                ->with('event:id,title')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $notifications->items(),
                'pagination' => [
                    'total' => $notifications->total(),
                    'per_page' => $notifications->perPage(),
                    'current_page' => $notifications->currentPage(),
                ],
                'unread_count' => $user->notifications()->where('is_read', false)->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notifications',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single notification
     */
    public function show(Notification $notification)
    {
        try {
            $user = auth('sanctum')->user();

            if ($notification->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $notification->load('event:id,title');

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'event' => $notification->event,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        try {
            $user = auth('sanctum')->user();

            if ($notification->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $notification->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'data' => $notification,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as read',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        try {
            $user = auth('sanctum')->user();

            if ($notification->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $user->notifications()->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all as read',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get unread count
     */
    public function unreadCount(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $count = $user->notifications()->where('is_read', false)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'unread_count' => $count,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch count',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
