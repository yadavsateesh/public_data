<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OrderNotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(string $id)
    {
        $notification = auth()->user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        $notification->markAsRead();

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification marked as read.');
    }
}