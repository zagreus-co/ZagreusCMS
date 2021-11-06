<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Comment\Entities\Comment;

class CommentController extends Controller
{
    public function index(Request $request) {
        if (!checkGate('manage_comments')) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Manage comments'));

        return view('comment::index');
    }
    public function update(Request $request, Comment $comment) {
        if (!checkGate('manage_comments')) abort(403);
        
        $request->validate([
            'comment'=> ['required', 'string', 'min:4']
        ]);

        $comment->update([
            'comment'=> e($request->comment)
        ]);
        
        return ['result'=> true, 'comment'=> str_replace("\n", "<br>", $comment->comment)];
    }
    
    public function submit(Request $request) {
        $request->validate([
            'parent_id'=> ['required', 'numeric'],
            'commentable_id'=> ['required', 'numeric'],
            'commentable_type'=> ['required', 'string', Rule::in(config('comment.allowed_classes')) ],
            'comment'=> ['required', 'string', 'min:4'],
            'guest_name'=> ['sometimes', 'required', 'string', 'min:4'],
            'guest_contact'=> ['sometimes', 'required', 'string', 'min:4'],
        ]);
        
        try {
            $commentable = (new $request->commentable_type)->findOrFail($request->commentable_id);
        } catch (\Throwable $th) {
            return back()->withErrors(['Something happens during submitting comment [Wrong-Class]']);;
        }
        
        if (!$commentable->can_comment || isset($commentable->published) && !$commentable->published) {
            return back()->withErrors([
                __('You can not comment on this post!')
            ]);
        }
        
        $commentable->comments()->create([
            'parent_id'=> $request->parent_id,
            'user_id'=> auth()->user()->id ?? null,
            'guest_name'=> $request->guest_name ?? null,
            'guest_contact'=> $request->guest_contact ?? null,
            'comment'=> e($request->comment),
            'published'=> get_option('straight_publish_comments'),
        ]);

        // $this->handleNotifications($request, $commentable);

        alert()->success(__('Your comment has been submited successfully!'));
        return back();
    }

    public function togglePublish(Comment $comment) {
        if (!checkGate('manage_comments')) abort(403);

        $comment->update([
            'published'=> !$comment->published
        ]);
        alert()->success(__('Selected comment status has been changed successfully!'));
        return back();
    }
}
