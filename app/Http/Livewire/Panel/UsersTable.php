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
            NumberColumn::name('id')->label('#'),

            Column::name('full_name')->label(__('Full name')),
            
            Column::callback(['role_id'], function ($id) {
                return \App\Models\User\Role::find($id)->title ?? __('Normal user');
            })->label(__('Role')),
            
            Column::name('email')->label(__('Email')),
            Column::name('number')->label(__('Number'))->hide(),
            
            DateColumn::name('updated_at')->label(__('last update')),

            Column::callback(['id'], function ($id) {
                $btn = '<a href="'.route('panel.users.edit', $id).'" class="btn-bs-secondary inline p-2"><i class="nav-icon fa fa-pen"></i></a>';
                $btn .= '<a href="'.route('panel.users.loginUsingId', $id).'" class="btn-warning inline p-2 ml-2"><i class="nav-icon fa fa-sign-in-alt"></i></a>';
                return $btn;
            })->label('*'),

            Column::delete()
        ];
    }
}