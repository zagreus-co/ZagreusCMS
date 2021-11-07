<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Response;

class ThemeController extends Controller
{
    public function index() {
        if (! checkGate('manage_themes') ) abort(403);

        \SEO::setTitle(__('Manage themes'));
        return view('panel.theme.index', ['themes'=> $this->loadFrontThemes()]);
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

    public function themeScreenshot($theme) {
        $path = base_path("resources/views/themes/{$theme}/screenshot.png");

        if(!File::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    protected function loadFrontThemes() {
        try {
            $dirs = scandir(base_path('resources/views/themes'));
            $themes = [];

            foreach($dirs as $key => $dir) {
                if (!is_dir(base_path('resources/views/themes/'.$dir)) || $key <= 1) { unset($dirs[$key]); }
                else {
                    $dirs[$key] = [
                        'dir'=> $dir,
                        'path'=> base_path('resources/views/themes/'.$dir),
                    ];
                    $dirs[$key]['screenshot'] = file_exists($dirs[$key]['path'].'/screenshot.png')
                        ? route('panel.theme.image', $dir) : null;
                    $dirs[$key]['data'] = file_exists($dirs[$key]['path'].'/theme.json')
                        ? json_decode(file_get_contents($dirs[$key]['path'].'/theme.json'), true) : null;
                }
            }

            return array_values($dirs);
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }
}
