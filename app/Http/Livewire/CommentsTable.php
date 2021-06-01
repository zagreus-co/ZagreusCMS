<?php

namespace App\Http\Livewire;

use Modules\Blog\Entities\Post;
use Modules\Comment\Entities\Comment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CommentsTable extends LivewireDatatable
{
    public $model = Comment::class;

    public function columns()
    {
        return [            
            Column::callback(['user_id', 'guest_name', 'guest_contact'], function ($id, $guest_name, $guest_contact) {
                return \App\Models\User::find($id)->full_name ?? $guest_name."<br><small>($guest_contact)</small>";
            })->label(__("Author")),
            
            Column::callback(['id', 'comment'], function ($id, $comment) {
                return "<div id='comment_{$id}'>
                    <label>".str_replace("\n", "<br>", $comment)."</label>
                    <div class='hidden edit-div'>
                        <textarea class='form-control' rows='3'>$comment</textarea>
                        <div class='mt-2 grid grid-cols-2 gap-3'>
                            <button onclick='submitEdit(this, $id)' class='btn-primary inline p-2'><i class='nav-icon fa fa-pen'></i></button>
                            <button onclick='editComment($id)' class='btn-danger inline p-2'>X</button>
                        </div>
                    </div>
                </div>";
            })->label(__('Comment')),

            Column::callback(['commentable_id', 'commentable_type'], function($id, $commentable_type) {
                if ($commentable_type == 'Modules\Blog\Entities\Post') {
                    return '<a href="'.route('module.blog.posts.openById', $id).'" target="_blank">
                            '.(Post::find($id)->title ?? '-').'
                        </a>';
                }
                
                return $commentable_type;
            })->label(__('Submitted on')),

            DateColumn::name('created_at')->defaultSort('desc')->label(__('creation time')),

            Column::callback(['id', 'published'], function ($id, $published) {
                $btn = '<button onclick="editComment('.$id.')" class="btn-bs-secondary inline p-2"><i class="nav-icon fa fa-pen"></i></button>';
                $btn .= '<a href="'.route('module.comment.togglePublish', $id).'" class="btn-warning ml-2 inline p-2">
                    <i class="nav-icon fa fa-'.(!$published ? 'eye' : 'eye-slash').'"></i></a>';
            
                return $btn;
            })->label('*'),

            Column::delete()
        ];
    }
}