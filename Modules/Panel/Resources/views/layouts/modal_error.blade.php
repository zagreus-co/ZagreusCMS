@if ($errors->all())
<div class="modal mt-5" id='errorModal'>
    <div class="modal-dialog modal-lg mt-5">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">خطا !</h5>
            </div>
            <div class="modal-body">
                <strong>لطفا خطا های زیر را برسی کنید :</strong>
                <br><br>
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">متوجه شدم</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#errorModal").modal('show');
</script>
@endif