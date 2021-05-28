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
            Column::callback(['user_id', 'guest_name'], function ($id, $guest_name) {
                return \App\Models\User::find($id)->full_name ?? $guest_name;
            })->label(__("Author")),
            
            Column::callback('comment', function ($comment) {
                return str_replace("\n", "<br>", $comment);
            })->label(__('Comment')),

            Column::callback(['commentable_id', 'commentable_type'], function($id, $commentable_type) {
                if ($commentable_type == 'Modules\Blog\Entities\Post') {
                    return '<a href="'.route('module.blog.posts.openById', $id).'" target="_blank">
                            '.(Post::find($id)->title ?? '-').'
                        </a>';
                }
                
                return $commentable_type;
            }),

            DateColumn::name('created_at')->defaultSort('desc')->label(__('creation time')),

            Column::callback(['id'], function ($id) {
                $btn = '<a href="'.route('module.blog.posts.edit', $id).'" class="btn-bs-secondary inline p-2"><i class="nav-icon fa fa-pen"></i></a>';
                $btn .= '<a href="'.route('module.blog.posts.openById', $id).'" target="_blank" class="btn-warning ml-2 inline p-2"><i class="nav-icon fa fa-eye"></i></a>';
            
                return $btn;
            })->label('*'),

            Column::delete()
        ];
    }
}