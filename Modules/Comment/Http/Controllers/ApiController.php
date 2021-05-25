<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Post;

class ApiController extends Controller
{
    public function postComments(Post $post) {
        return $post->comments()->wherePublished(1)->get()->map(function ($item, $key) {
            $item['user_id'] = \App\Models\User::find($item['user_id'])->first();
            $item['user_id'] = $item['user_id']->full_name ?? 'کاربر';
            return $item;
        });
    }

    public function submit(Request $request, Post $post) {
        $request->validate([
            'comment'=> ['required', 'string', 'min:4'],
            'guest_name'=> ['sometimes', 'required', 'string', 'min:4'],
            'guest_contact'=> ['sometimes', 'required', 'string', 'min:4'],
        ]);
        
        $request->parent_id = $request->filled('parent_id') ? intval($request->parent_id) : 0;

        if (!$post->can_comment || isset($post->published) && !$post->published) {
            return [
                'result'=> false,
                'message'=> 'ثبت نظر برای این بخش امکان پذیر نمیباشد.'
            ];
        }
        
        $post->comments()->create([
            'parent_id'=> $request->parent_id,
            'user_id'=> auth()->user()->id ?? null,
            'guest_name'=> $request->guest_name ?? null,
            'guest_contact'=> $request->guest_contact ?? null,
            'comment'=> $request->comment,
            'published'=> \Option::get('straight_publish_comments')->data,
        ]);

        return ['result'=> true, 'message'=> 'نظر شما با موفقیت در سامانه ثبت شد.'];
    }

}
