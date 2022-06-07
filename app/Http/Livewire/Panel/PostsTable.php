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
                $btn = '<div class="flex items-center flex-wrap space-x-1">';
                $btn .= '<a href="'.route('module.blog.posts.edit', $id).'" class="btn btn-sm btn-secondary">'.__('Edit').'</i></a>';
                $btn .= '<a href="'.route('module.blog.posts.openById', $id).'" target="_blank" class="btn btn-sm btn-warning">'.__('View post').'</a>';
            
                return $btn.'</div>';
            })->label('*'),

            Column::delete()
        ];
    }
}