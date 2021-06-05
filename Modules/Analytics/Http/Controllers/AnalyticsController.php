<?php

namespace Modules\Analytics\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Analytics\Entities\Analytic;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (! checkGate(['manage_analytics']) ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Analytics'));

        $analytics = [
            'yesterdayViewers'=> Analytic::whereDate('created_at', \Carbon\Carbon::yesterday())->count(),
            'todayViewers'=> Analytic::whereDate('created_at', \Carbon\Carbon::today())->count(),
            'yesterdayViews'=> Analytic::whereDate('created_at', \Carbon\Carbon::yesterday())->pluck('views')->sum(),
            'todayViews'=> Analytic::whereDate('created_at', \Carbon\Carbon::today())->pluck('views')->sum(),
            'lastMonth'=> Analytic::whereMonth('created_at', \Carbon\Carbon::now()->subMonth()->month)->count(),
            'currentMonth'=> Analytic::whereMonth('created_at', \Carbon\Carbon::now()->month)->count(),
        ];

        return view('analytics::index' , ['analytics'=> $analytics, 'analytic'=> new Analytic() ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('analytics::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('analytics::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('analytics::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
