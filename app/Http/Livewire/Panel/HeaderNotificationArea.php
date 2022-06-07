<?php

namespace App\Http\Livewire\Panel;

use Livewire\Component;
use Modules\Notification\Entities\Notification;

class HeaderNotificationArea extends Component
{
    public function seen(Notification $notification) {
        if ($notification->user_id == auth()->user()->id) $notification->seen();
    }

    public function render()
    {
        $notifications = auth()->user()
            ->notifications()
            ->whereVisible(1)
            ->limit(6)
            ->latest()->get();

        $unread_notifications = auth()->user()
            ->notifications()->whereSeen(0)
            ->count();

        return view('livewire.panel.header-notification-area', compact('notifications', 'unread_notifications'));
    }
}
