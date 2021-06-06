<?php

namespace Modules\Analytics\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Analytics\Entities\Analytic;
use Modules\Analytics\Entities\Rule as AnalyticRule;
use Illuminate\Validation\Rule;

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
            "mostViewdPages"=> Analytic::whereDate('created_at', ">=", \Carbon\Carbon::today()->subDay(7))
                ->orderBy('views', 'desc')->get()
                ->groupBy(function($row) {
                    return $row->url;
                })->slice(0, 8),
        ];

        return view('analytics::index' , ['analytics'=> $analytics, 'analytic'=> new Analytic() ]);
    }

    public function rules(Request $request) {
        if (! checkGate(['manage_analytics']) ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Analytic rules'));

        if ($request->method() == 'POST') return $this->createRule($request);

        return view('analytics::rules' , ['rule'=> new AnalyticRule() ]);
    }

    protected function createRule(Request $request) {
        $rule = $request->validate([
            'name'=> ['required', Rule::in(['disallow_page']) ],
            'data'=> ['required', 'string']
        ]);

        AnalyticRule::create($rule);

        alert()->success(__("Analytic rule created "));
        return back();
    }

    public function deleteRule(AnalyticRule $rule) {
        if (! checkGate(['manage_analytics']) ) abort(403);

        $rule->delete();

        alert()->success(__('Analytic rule has been deleted successfully!'));
        return true;
    }
}
