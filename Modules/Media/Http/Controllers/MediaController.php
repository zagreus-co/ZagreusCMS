<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Media\Entities\Media;

class MediaController extends Controller
{
    
    public function index(Request $request)
    {
        if (! checkGate('manage_media') ) abort(403);

        if ($request->ajax()) return $this->table();
        if (class_exists('\SEO')) \SEO::setTitle('مدیریت رسانه ها');
        return view('media::index');
    }

    protected function table() {
        return datatables()
            ->of(
                Media::query()
            )
            ->editColumn('filename', function($row) {
                return "<a href='{$row->filename}' target='_blank'><img src='{$row->filename}' width='80px' height='80px'> {$row->filename}</a>";
            })
            ->editColumn('mediaable_id', function($row) {
                if ($row->mediaable_type == 'Modules\Blog\Entities\Post') {
                    return "<a href='".route('post', $row->mediaable->slug)."' target='_blank'>
                        {$row->mediaable->title}
                    </a>";
                }
                if ($row->mediaable_type == 'Modules\Page\Entities\Page') {
                    return "<a href='".route('module.page.view', $row->mediaable->slug)."' target='_blank'>
                        {$row->mediaable->title}
                    </a>";
                }
                
                return "<font>{$row->mediaable_type}</font>";
            })
            ->editColumn('user_id', function($row) {
                return $row->user->full_name;
            })
            ->editColumn('updated_at', function($row) {
                return jdate($row->updated_at)->format('Y-m-d H:i');
            })
            ->rawColumns(['filename', 'mediaable_id'])
            ->make(true);
    }

    public function upload(Request $request) {
        // dd($request->all());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $input = $request->all();
        $input['image'] = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $input['image']);


        return response()->json(['success'=>'done', 'file'=> $input]);
    }

    public function uploadAttachments(Request $request) {
        if (! checkGate('manage_media') ) abort(403);

        return asset('/uploads/'.$request->file('file')
            ->storeAs('attachments', $request->file('file')->getClientOriginalName(), 'public_uploads'));
    }

    public function uploadCover(Request $request) {
        if (! checkGate('manage_media') ) abort(403);

        return asset('/uploads/'.$request->file('file')
            ->storeAs(date("Y"), $request->file('file')->getClientOriginalName(), 'public_uploads'));
    }
}
