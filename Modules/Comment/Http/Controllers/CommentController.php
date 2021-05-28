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
            'comment'=> $request->comment
        ]);
        alert()->success('نظر انتخاب شده با موفقیت ویرایش شد.');
        return true;
    }
    public function destroy(Comment $comment) {
        if (!checkGate('manage_comments')) abort(403);

        $comment->delete();
        alert()->success('نظر انتخاب شده با موفقیت حذف شد.');
        return true;
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
            return back()->withErrors(['خطایی در ثبت نظر پیش آمده است! [Wrong-Class]']);;
        }
        
        if (!$commentable->can_comment || isset($commentable->published) && !$commentable->published) {
            return back()->withErrors([
                'ثبت نظر برای این بخش امکان پذیر نمیباشد.'
            ]);
        }
        
        $commentable->comments()->create([
            'parent_id'=> $request->parent_id,
            'user_id'=> auth()->user()->id ?? null,
            'guest_name'=> $request->guest_name ?? null,
            'guest_contact'=> $request->guest_contact ?? null,
            'comment'=> $request->comment,
            'published'=> \Option::get('straight_publish_comments')->data,
        ]);

        $this->handleNotifications($request, $commentable);

        alert()->success('نظر شما با موفقیت ثبت شد و پس از تایید مدیر نمایش داده می شود');
        return back();
    }

    public function togglePublish(Comment $comment) {
        if (!checkGate('manage_comments')) abort(403);

        // if (auth()->user()->hasPermission('manage_own_posts') && !auth()->user()->hasPermission('manage_all_posts') && $post->user_id != auth()->user()->id ) abort(403);

        $comment->update([
            'published'=> !$comment->published
        ]);
        alert()->success('وضعیت انتشار نظر انتخاب شده با موفقیت تغییر یافت.');
        return back();
    }

    public function report(Request $request) {
        $request->validate([
            'id'=> ['required', 'numeric', 'exists:comments'],
            'commentable_id'=> ['required', 'numeric'],
            'commentable_type'=> ['required', 'string', Rule::in(config('comment.allowed_classes')) ],
        ]);

        try {
            $comment = Comment::findOrFail($request->id);
        } catch (\Throwable $th) {
            return response(['message'=> 'خطایی در ثبت نظر پیش آمده است! [Wrong-Comment-id]'], 500);;
        }

        // $commentable->comments()->create([
        //     'parent_id'=> $request->id,
        //     'user_id'=> auth()->user()->id ?? null,
        //     'guest_name'=> null,
        //     'guest_contact'=> null,
        //     'comment'=> "یک گذارش تخلف توسط کاربر (".auth()->user()->full_name.") بر روی این نظر ثبت شده است.",
        //     'published'=> 0,
        // ]);

        $this->createReportNotificatoin($comment);

        return ['message'=> 'نظر انتخاب شده با موفقیت گذارش شد! تشکر از همکاری شما.'];
    }

    protected function handleNotifications($request, $commentable) {
        $this->createNotificationForAdmins($commentable);

        if ($request->parent_id != 0) {
            try {
                $parent_comment = (new \Modules\Comment\Entities\Comment )->findOrFail($request->parent_id);
                return $this->createResponseNotification($parent_comment);
            } catch (\Throwable $th) {
                return false;
            }
        }

        return true;
    }

    protected function createResponseNotification($parent_comment) {
        if ($parent_comment->user == null) return false;

        $commented = ($parent_comment->commentable->public_name ?? '')." ({$parent_comment->commentable->title})";

        $parent_comment->user->notifications()->create([
            'title'=> 'دریافت پاسخ جدید در نظرات',
            'message'=> "شما یک پاسخ جدید در $commented دریافت کردید."
        ]);

        return true;
    }

    protected function createReportNotificatoin($comment) {
        foreach($this->adminUsers() as $admin) {
            $admin->notifications()->create([
                'title'=> 'گذارش تخلف جدید',
                'message'=> "یک گذارش تخلف توسط کاربر (".auth()->user()->full_name.")
                    بر روی <a href=''>این نظر</a> ثبت شده است."
            ]);
        }
    }

    protected function createNotificationForAdmins($commentable) {
        $commented = ($commentable->public_name ?? '')." ({$commentable->title})";
        
        foreach($this->adminUsers() as $admin) {
            $admin->notifications()->create([
                'title'=> 'یک نظر جدید ارسال شد',
                'message'=> "یک نظر جدید بر روی $commented ثبت شد."
            ]);
        }
    }

    protected function adminUsers() {
        return \App\Models\User::query()
            ->whereHas('role', function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->whereHas('permissions', function (\Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('tag', '=', 'manage_comments');
                });
            })->get();
    }
}
