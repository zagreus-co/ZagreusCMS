@extends(panelLayout())

@section('content')
    <div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">

        <div class="card">
            <div class="card-header flex justify-between">
                <strong class="pt-2">{{ __('Manage posts') }}</strong>
                <a href='{{ route('module.blog.posts.create') }}' class="btn btn-sm btn-success">{{ __('Create') }}</a>
            </div>

            @livewire('table.table', [
                'model' => new \Modules\Blog\Entities\Post(),
                'actions' => [
                    'edit'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-primary')
                            ->icon('create-outline')
                            ->link(route('module.blog.posts.edit', $model->id))
                            ->html(),
                    'login'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-warning')
                            ->icon('eye')
                            ->link(route('module.blog.posts.openById', $model->id))
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
                    'category_id' => [
                        'remark' => __('Category'),
                        'type' => 'string',
                        'callback' => fn($model) => __($model->category->title ?? '-'),
                    ],
                    'created_at' => [
                        'remark' => __('Creation time'),
                        'type' => 'string',
                        'callback' => fn($model) => __($model->created_at->ago()),
                        'hidden' => false,
                    ],
                ],
            ])

        </div>

    </div>
@endsection
