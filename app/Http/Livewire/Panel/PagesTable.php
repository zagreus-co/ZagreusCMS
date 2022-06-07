<?php

namespace App\Http\Livewire\Panel;

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

            Column::callback(['id', 'template'], function ($id) {
                return Page::find($id)->slug;
            })->label(__("Slug")),

            DateColumn::name('updated_at')->label(__('last update')),

            Column::callback(['id'], function ($id) {
                $btn = '<a href="'.route('module.page.edit', $id).'" class="btn btns-m btn-primary">'.__('Edit').'</a>';
                return $btn;
            })->label('*'),

            Column::delete()
        ];
    }
}