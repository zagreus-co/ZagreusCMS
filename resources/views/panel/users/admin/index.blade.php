@extends(panelLayout())

@section('content')
    <div class="grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6 mt-6">
        <div class="card hover:shadow bg-white hover:bg-indigo-50 transition duration-200">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h3>{{ number_format(\App\Models\User::count()) }}</h3>
                        <p>{{ __('Total users') }}</p>
                    </div>
                    <div class="text-indigo-700">
                        <ion-icon name="people"></ion-icon>
                    </div>
                </div>
            </div>
        </div>

        <div class="card hover:shadow bg-white hover:bg-blue-50 transition duration-200">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h3>{{ number_format(\App\Models\User::where('role_id', '!=', 0)->count()) }}</h3>
                        <p>{{ __('Staff users') }}</p>
                    </div>
                    <div class="text-blue-400">
                        <ion-icon name="shield-half"></ion-icon>
                    </div>
                </div>
            </div>
        </div>

        <div class="card hover:shadow bg-white hover:bg-gray-50 transition duration-200">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h3>{{ number_format(\App\Models\User::where('role_id', 0)->count()) }}</h3>
                        <p>{{ __('Normal users') }}</p>
                    </div>
                    <div class="text-gray-500">
                        <ion-icon name="walk"></ion-icon>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-card">
            <div class="card hover:shadow bg-white hover:bg-yellow-50 transition duration-200">
                <div class="card-body flex flex-col">
                    <div class="flex flex-row justify-between items-center">
                        <div>
                            <h3>{{ number_format(\App\Models\User::whereDate('created_at', \Carbon\Carbon::today())->count()) }}
                            </h3>
                            <p>{{ __('Today registration') }}</p>
                        </div>
                        <div class="text-yellow-500">
                            <ion-icon name="person-add"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">
        <div class="card">
            <div class="card-header flex justify-between mb-2">
                <strong class="pt-2">{{ __('Manage users') }}</strong>
                <div class='flex flex-nowrap'>
                    <a href='{{ route('panel.roles.index') }}'
                        class="p-2 px-3 mr-2 btn btn-sm btn-secondary">{{ __('Manage roles') }}</a>
                    <a href='{{ route('panel.users.create') }}'
                        class="p-2 px-3 btn btn-sm btn-success">{{ __('Create user') }}</a>
                </div>
            </div>

            @livewire('table.table', [
                'model' => new \App\Models\User(),
                'deletable' => true,
                'actions' => [
                    'edit'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-primary')
                            ->icon('create-outline')
                            ->link(route('panel.users.edit', $model->id))
                            ->html(),
                    'login'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-warning')
                            ->icon('key')
                            ->link(route('panel.users.loginUsingId', $model->id))
                            ->html(),
                    'delete'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-outline-danger')
                            ->icon('trash-outline')
                            ->livewire("deleteModel(".$model->id.")")
                            ->html()
                ],
                'columns' => [
                    'id' => [
                        'remark' => '#',
                        'type' => 'int',
                    ],
                    'full_name' => [
                        'remark' => __('Full name'),
                        'type' => 'string',
                    ],
                    'role_id' => [
                        'remark' => __('Role'),
                        'type' => 'string',
                        'callback' => fn($model) => __($model->role->title ?? 'Normal'),
                    ],
                    'email' => [
                        'remark' => __('Email'),
                        'type' => 'string',
                    ],
                    'number' => [
                        'remark' => __('Number'),
                        'type' => 'string',
                        'hidden' => true,
                    ],
                    'created_at' => [
                        'remark' => __('Creation time'),
                        'type' => 'string',
                        'callback' => fn($model) => __($model->created_at->ago()),
                        'hidden' => true,
                    ],
                ],
            ])
        </div>
    </div>
@endsection
