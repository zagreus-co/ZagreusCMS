<?php

namespace Modules\Notification\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notification\Entities\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if (class_exists('\SEO')) \SEO::setTitle(__("View all notifications"));

        auth()->user()->notifications()->whereSeen(0)->whereVisible(1)->update(['seen'=> 1]);
        return view('notification::index');
    }

    public function open(Notification $notification) {
        if ($notification->user_id != auth()->user()->id) {
            return response()->json([
                'result'=> false,
                'message'=> __("Access denied!")
            ],403);
        }
        $result = [
            'result'=> (!$notification->seen ? true : false),
            'message'=> $notification->message
        ];
        $notification->seen();
        return response()->json($result);
    }
    
    public function load() {
        return auth()->user()->notifications()
            ->whereVisible(1)
            ->limit(6)
            ->latest()
            ->get()
            ->map(function ($notification) {
                return [
                    'id'=> $notification->id,
                    "icon"=> $notification->icon,
                    "title"=> $notification->title,
                    "message"=> \Str::words($notification->message, 8, ' ...'),
                    'time'=> $notification->created_at->ago(),
                    'seen'=> !!$notification->seen
                ];
            });
    }
}
