<?php

namespace Modules\Notification\Http\Livewire\Panel;

use App\Models\User;
use Livewire\Component;
use Modules\Notification\Entities\Notification;

class HeaderNotification extends Component
{
    protected function getUser(): User
    {
        return auth()->user();
    }

    public function seen(Notification $notification) {
        if ($notification->user_id == auth()->user()->id) $notification->seen();
    }

    public function render()
    {
        $notifications = $this->getUser()
            ->notifications()
            ->whereVisible(1)
            ->limit(6)
            ->latest()->get();

        $unread_notifications = $this->getUser()
            ->notifications()->whereSeen(0)
            ->count();
        
        return view(
            'notification::livewire.panel.header-notification', 
            compact('notifications', 'unread_notifications')
        );
    }
}
