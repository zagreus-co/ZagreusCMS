<?php

namespace Modules\Panel\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

        return view('panel::index');
    }
}
