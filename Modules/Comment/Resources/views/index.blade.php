@extends(panelLayout())
@section('content')
<div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">
    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Manage comments') }}</strong>
        </div>

        <livewire:comments-table />
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
        $(self).html('...');
        $.ajax({
            url: '{{ route("module.comment.index") }}/' + id,
            type: 'POST',
            data: JSON.stringify({
                _method: 'PATCH',
                comment: $(`#comment_${id} div.edit-div textarea`).val()
            }),
            dataType: 'json',
            success: function (data) {
                $(`#comment_${id} label`).html(data.comment)
                editComment(id);
            },
            error: function (data) {
                swal(data.responseJSON.message);
            }
        });
    }
</script>
@endsection