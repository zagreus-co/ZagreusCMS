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
  let submitEditForm = (self) => {
      $(self).html('...');
      let form = collectForm('#editForm');
      $.ajax({
          url: '{{ route("module.comment.index") }}/' + form.comment_id,
          type: 'POST',
          data: JSON.stringify(form),
          dataType: 'json',
          success: function (data) {
              location.reload();
          },
          error: function (data) {
              swal(data.responseJSON.message);
          }
      });
  }
</script>
@endsection