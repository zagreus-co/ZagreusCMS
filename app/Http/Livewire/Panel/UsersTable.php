<?php

namespace App\Http\Livewire\Panel;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class UsersTable extends LivewireDatatable
{
    public $model = User::class;
    public $hideable = 'select';

    public function columns()
    {
        return [ 
            NumberColumn::name('id')->label('#')->defaultSort('desc'),

            Column::name('full_name')->label(__('Full name')),
            
            Column::callback(['role_id'], function ($id) {
                return \App\Models\User\Role::find($id)->title ?? __('Normal user');
            })->label(__('Role')),
            
            Column::name('email')->label(__('Email')),
            Column::name('number')->label(__('Number'))->hide(),
            
            DateColumn::name('created_at')->label(__('Creation time'))->hide(),

            Column::callback(['id'], function ($id) {
                $btn = '<div class="flex items-center flex-wrap space-x-1">';
                $btn .= '<a href="'.route('panel.users.edit', $id).'" class="btn btn-sm btn-primary">'.__('Edit').'</i></a>';
                $btn .= '<a href="'.route('panel.users.loginUsingId', $id).'" class="btn btn-sm btn-warning">'.__('Login as user').'</a>';
                return $btn.'</div>';
            })->label('*'),

            Column::delete()
        ];
    }
}