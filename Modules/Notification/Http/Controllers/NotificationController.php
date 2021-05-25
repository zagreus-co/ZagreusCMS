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
        if ($request->ajax()) return $this->table();
        if (class_exists('\SEO')) \SEO::setTitle(__("View all notifications"));

        Notification::whereUserId(auth()->id())->whereSeen(0)->whereVisible(1)->update(['seen'=> 1]);
        return view('notification::index');
    }

    public function seen(Notification $notification) {
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
        return Notification::whereUserId(auth()->user()->id)
            ->whereVisible(1)
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($notification) {
                return [
                    'id'=> $notification->id,
                    "title"=> $notification->title,
                    "message"=> mb_substr($notification->message, 0, 35).'[...]',
                    'time'=> jdate($notification->created_at)->ago(),
                    'seen'=> !!$notification->seen
                ];
            });
    }

    public function table() {
        $notifications = Notification::query();

        if (checkGate('view_all_notifications'))
            $notifications = $notifications->latest();
        else
            $notifications = $notifications->whereUserId(auth()->user()->id)->whereVisible(1)->latest();

        return datatables()
            ->of( $notifications )
            ->addColumn('user', function($row) {
                return "<a href='".route('module.users.users.edit', $row->user->id)."'>{$row->user->full_name}</a>";
            })
            ->editColumn('message', function($row) {
                return str_replace("\n","<br>", $row->message);
            })
            ->editColumn('created_at', function($row) {
                return jdate($row->created_at)->format('%A, %d %B %y [%H:%M]');
            })
            ->rawColumns(['user', 'message'])
            ->make(true);
    }
}
