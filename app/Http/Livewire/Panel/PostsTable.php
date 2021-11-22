<?php

namespace App\Http\Livewire\Panel;

use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Category;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PostsTable extends LivewireDatatable
{
    public $model = Post::class;

    public function columns()
    {
        return [            
            Column::callback(['id', 'published'], function ($id) {
                return Post::find($id)->title;
            })->label(__("Title")),
            
            Column::callback(['category_id'], function ($id) {
                return Category::find($id)->title ?? '-';
            })->label(__('Category')),

            DateColumn::name('updated_at')->label(__('last update')),
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