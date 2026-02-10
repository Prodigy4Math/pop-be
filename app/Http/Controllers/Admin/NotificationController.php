<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();

        $notifications = Notification::query()
            ->where(function ($query) use ($admin) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', $admin->id);
            })
            ->latest()
            ->paginate(20);

        $unreadCount = Notification::query()
            ->where(function ($query) use ($admin) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', $admin->id);
            })
            ->where('is_read', false)
            ->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markRead(Notification $notification)
    {
        $admin = auth('admin')->user();

        if ($notification->user_id !== null && $notification->user_id !== $admin->id) {
            abort(403);
        }

        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead()
    {
        $admin = auth('admin')->user();

        Notification::query()
            ->where(function ($query) use ($admin) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', $admin->id);
            })
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
