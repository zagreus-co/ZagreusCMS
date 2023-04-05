<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (class_exists('\SEO')) SEOTools::setTitle(__('Dashboard'));
        
        return view('panel.index');
    }
}
