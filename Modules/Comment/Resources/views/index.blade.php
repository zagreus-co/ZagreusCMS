@extends('panel::layouts.app', ['title'=> 'مدیریت نظرات'])

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-light">
            فیلتر ها
            <div class='float-left'>
                <button onclick='addFilter("view", "card");' class="btn btn-sm {{ $viewMode == 'card' ? 'btn-dark' : 'btn-secondary' }}"><i class="fa fa-stream"></i></button>
                <button onclick='addFilter("view", "table");' class="btn btn-sm {{ $viewMode == 'table' ? 'btn-dark' : 'btn-secondary' }}"><i class="fa fa-th-list"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
              <div class="form-check">
                  <label class="form-check-label">
                      <input type="checkbox" name="filter_unreads" onchange='addFilter("undreads", this.checked);' class="form-check-input" {{ isset($_GET['undreads']) && $_GET['undreads'] == 'false' ? '' : 'checked' }}>
                      فقط تایید نشده ها
                  </label>
              </div>
            </div>
        </div>
    </div>

    @include('comment::partials.'.$viewMode, compact('comments'))

    {{ $comments->links('vendor.pagination.bootstrap-4') }}
</div>

<div class="modal mt-5" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ویرایش نظر</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="javascript:void(0)" id='editForm' method="post">
            @csrf
            <input type="hidden" name="_method" value='PATCH'>
            <input type="hidden" name="comment_id" value='0'>
            <div class="form-group">
                <label for="comment">متن نظر</label>
                <textarea rows='5' type="text" name='comment' class="form-control" placeholder='متن نظر انتخاب شده'></textarea>
            </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary ml-2" onclick='submitEditForm(this);'>ثبت تغییرات</button>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
      </div>

    </div>
  </div>
</div>

<div class="modal mt-5" id="answerModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">پاسخ به نظر</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="alert alert-secondary mb-3" id='comment_alert'></div>

        <form action="{{ route('module.comment.submit') }}" id='answerForm' method="post">
            @csrf
            <input type="hidden" name="commentable_id" value='0'>
            <input type="hidden" name="commentable_type" value='0'>
            <input type="hidden" name="parent_id" value='0'>
            <div class="form-group">
                <label for="comment">متن پاسخ شما به این نظر</label>
                <textarea rows='5' type="text" name='comment' class="form-control" placeholder='متن پاسخ شما به نظر بالا'></textarea>
            </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success ml-2" onclick='$("#answerForm").submit();'>ثبت پاسخ</button>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
      </div>

    </div>
  </div>
</div>
@endsection
@section('script')
<script>
    let addFilter = (key, value) => {
      let url = new URL("{!! url()->full() !!}");
      url.searchParams.set(key, value);

      window.location = url;
    }

    let openAnswerModal = (self, id, commentable) => {
        let row = $(self).parent().parent().children();
        console.log(row[1]);
        $('#answerForm input[name=commentable_id]').val(commentable.id);
        $('#answerForm input[name=commentable_type]').val(commentable.type);
        $('#answerForm input[name=parent_id]').val(id);
        $('#comment_alert').html(row[1].innerHTML);
        $("#answerModal").modal('show');
    }
    let openEditModal = (self, id) => {
        let row = $(self).parent().parent().children();
        $('#editForm input[name=comment_id]').val(id);
        $('#editForm textarea[name=comment]').val(row[1].innerHTML.replace(/<br>/g, "") );
        $("#editModal").modal('show');
    }
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