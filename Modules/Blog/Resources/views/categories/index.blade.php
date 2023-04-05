@extends(panelLayout())

@section('content')
    <div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">

        <div class="card">
            <div class="card-header flex justify-between">
                <strong class="pt-2">{{ __('Manage categories') }}</strong>
                <a href='{{ route('module.blog.categories.create') }}' class="btn btn-sm btn-success">{{ __('Create') }}</a>
            </div>


            @livewire('table.table', [
                'model' => new \Modules\Blog\Entities\Category(),
                'actions' => [
                    'edit'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-primary')
                            ->icon('create-outline')
                            ->link(route('module.blog.categories.edit', $model->id))
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
                    'title' => [
                        'remark' => __('Title'),
                        'type' => 'string',
                    ],
                    'parent_id' => [
                        'remark' => __('Category'),
                        'type' => 'string',
                        'callback' => fn($model) => __($model->parent->title ?? '-'),
                    ],
                ],
            ])
        </div>

    </div>
@endsection
