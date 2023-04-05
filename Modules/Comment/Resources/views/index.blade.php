@extends(panelLayout())
@section('content')
    <div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">
        <div class="card">
            <div class="card-header flex justify-between">
                <strong class="pt-2">{{ __('Manage comments') }}</strong>
            </div>

            @livewire('table.table', [
                'model' => new \Modules\Comment\Entities\Comment(),
                'actions' => [
                    'delete'=> fn($model) 
                        => (new TableButton)
                            ->class('btn btn-sm btn-outline-danger')
                            ->icon('trash-outline')
                            ->livewire("deleteModel(".$model->id.")")
                            ->html()
                ],
                'columns' => [
                    'user_id' => [
                        'remark' => 'Author',
                        'callback' => fn($model) => __($model->user->full_name ?? '-'),
                        'type' => 'string',
                    ],
                    'comment' => [
                        'remark' => __('Comment'),
                        'type' => 'string',
                    ],
                    'commentable_id' => [
                        'remark' => __('Commented on'),
                        'type' => 'string',
                        'callback' => fn($model) => $model->commentable_type,
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

@section('script')
    <script>
        let editComment = (id) => {
            document.querySelector(`#comment_${id} label`).classList.toggle('hidden')
            document.querySelector(`#comment_${id} div.edit-div`).classList.toggle('hidden');
        }

        let submitEdit = (self, id) => {
            $(self).css('opacity', '0.4');
            $.ajax({
                url: '{{ route('module.comment.index') }}/' + id,
                type: 'POST',
                data: JSON.stringify({
                    _method: 'PATCH',
                    comment: $(`#comment_${id} div.edit-div textarea`).val()
                }),
                dataType: 'json',
                success: function(data) {
                    $(self).css('opacity', '1');
                    $(`#comment_${id} label`).html(data.comment)
                    editComment(id);
                },
                error: function(data) {
                    swal(data.responseJSON.message);
                }
            });
        }
    </script>
@endsection
