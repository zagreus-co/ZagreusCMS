<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (class_exists('\SEO')) \SEO::setTitle(__('Dashboard'));

        // if (auth()->user()->role_id == 0) return view('panel::client-dashboard');

        return view('panel.index');
    }
}
