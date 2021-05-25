<?php

namespace App\Http\Livewire;

use Modules\Page\Entities\Page;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PagesTable extends LivewireDatatable
{
    public $model = Page::class;

    public function columns()
    {
        return [ 
            Column::callback(['id', 'published'], function ($id) {
                return Page::find($id)->title;
            })->label(__("Title")),

            DateColumn::name('updated_at')->label(__('last update')),

            Column::callback(['id'], function ($id) {
                $btn = '<a href="'.route('module.page.edit', $id).'" class="btn-bs-secondary inline p-2"><i class="nav-icon fa fa-pen"></i></a>';
                return $btn;
            })->label('*'),

            Column::delete()
        ];
    }
}