<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        if (! checkGate('manage_media') ) abort(403);

        if ($request->ajax()) return $this->table();
        if (class_exists('\SEO')) \SEO::setTitle('Manage media');
        return view('panel.media.index');
    }

    public function open() {
        if (Storage::disk('media')->exists($filename)) return response()->file( Storage::disk('media')->path($filename) );
        abort(404);
    }

    public function adminUpload(Request $request) {
        if (! checkGate('manage_media') ) abort(403);

        return asset('/uploads/'.
            $request->file('file')
            ->storeAs(date("Y"), $request->file('file')->getClientOriginalName(), 'public_uploads'));
    }
}
