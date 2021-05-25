<?php

namespace Modules\Theme\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (! checkGate('manage_themes') ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Manage themes'));

        return view('theme::index', ['themes'=> $this->loadFrontThemes()]);
    }

    public function selectTheme(Request $request) {
        if (! checkGate('manage_themes') ) abort(403);
        $request->validate([
            'type'=> ['required'],
            'dir'=> ['required']
        ]);

        if ($request->type != 'front') abort(403);
        if (!file_exists(base_path('resources\views\themes\\'.$request->dir.'\\theme.json')))
            return response()->json(['result'=> false, 'message'=> 'Theme directory not found'], 400);
        
        if (update_option('front_theme', ['plain_data'=> $request->dir]) == false)
            return response()->json(['result'=> false, 'message'=> 'There is problem in updating theme optoin!'], 400);

        return response()->json(['result'=> true, 'message'=> __('Your website theme has been updated successfully!')]);
    }

    protected function loadFrontThemes() {
        try {
            $dirs = scandir(base_path('resources\views\themes'));
            $themes = [];

            foreach($dirs as $key => $dir) {
                if (!is_dir(base_path('resources\views\themes\\'.$dir)) || $key <= 1) { unset($dirs[$key]); }
                else {
                    $dirs[$key] = [
                        'dir'=> $dir,
                        'path'=> base_path('resources\views\themes\\'.$dir),
                    ];
                    $dirs[$key]['screenshot'] = file_exists($dirs[$key]['path'].'\screenshot.png')
                        ? route('module.theme.image', $dir) : null;
                    $dirs[$key]['data'] = file_exists($dirs[$key]['path'].'\theme.json')
                        ? json_decode(file_get_contents($dirs[$key]['path'].'\theme.json'), true) : null;
                }
            }

            return array_values($dirs);
        } catch (\Throwable $th) {
            return false;
        }
    }
    
}
