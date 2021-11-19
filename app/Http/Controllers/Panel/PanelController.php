<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Analytics\Entities\Analytic;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (class_exists('\SEO')) \SEO::setTitle(__('Dashboard'));

        if (auth()->user()->role_id == 0) return view('panel::client-dashboard');

        $analytics = [
            'yesterdayViewers'=> Analytic::whereDate('created_at', \Carbon\Carbon::yesterday())->get()->groupBy(function($row) { return $row->ip; })->count(),
            'todayViewers'=> Analytic::whereDate('created_at', \Carbon\Carbon::today())->get()->groupBy(function($row) { return $row->ip; })->count(),
            
        ];

        return view('panel.index', compact('analytics'));
    }
}
