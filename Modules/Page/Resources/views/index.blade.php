@extends(panelLayout())

@section('content')
    <div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">
        <div class="card">
            <div class="card-header flex justify-between">
                <strong class="pt-2">{{ __('Manage pages') }}</strong>
                <a href='{{ route('module.page.create') }}' class="btn btn-sm btn-success">{{ __('Create') }}</a>
            </div>

            @livewire('table.table', [
                'model' => new \Modules\Page\Entities\Page(),
                'actions' => [
                    'edit'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-primary')
                            ->icon('create-outline')
                            ->link(route('module.page.edit', $model->id))
                            ->html(),
                    'delete'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-outline-danger')
                            ->icon('trash-outline')
                            ->livewire("deleteModel(".$model->id.")")
                            ->html()
                ],
                'columns' => [
                    'title' => [
                        'remark' => __('Title'),
                        'type' => 'string',
                    ],
                    'slug' => [
                        'remark' => __('Slug'),
                        'type' => 'string',
                    ],
                    'updated_at' => [
                        'remark' => __('Last update'),
                        'type' => 'string',
                        'callback' => fn($model) => __($model->updated_at->ago()),
                        'hidden' => false,
                    ],
                ],
            ])

        </div>
    </div>
@endsection
