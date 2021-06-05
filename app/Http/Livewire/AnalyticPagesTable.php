<?php

namespace App\Http\Livewire;

use Modules\Analytics\Entities\Analytic;
use Modules\Comment\Entities\Comment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AnalyticPagesTable extends LivewireDatatable
{
    public $model = Analytic::class;

    public function builder()
    {
        return Analytic::query();
    }

    public function columns()
    {
        return [
            Column::name('url')->label(__('Page')),

            NumberColumn::name('views')->label('views'),
        ];
    }
}