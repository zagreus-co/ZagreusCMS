@extends('panel::layouts.app', ['title'=> 'مدیریت رسانه و فایل ها'])

@section('content')
<div class="col-md-12">

    <div class="card">
        <div class="card-header">
            <div>
                <input type="text" id="image_label" class="d-none" name="image">
                <div class="input-group-append">
                    <button class="btn btn-success" type="button" id="button-image">مدیریت تمامی رسانه ها</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" id='mediasTable'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ناشر</th>
                            <th>تگ</th>
                            <th>دسترسی ها</th>
                            <th>استفاده شده در</th>
                            <th>آخرین ویرایش</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    let mediasTable = $('#mediasTable').DataTable({
        language: {
            "url": "{{ asset('assets/plugins/datatables/fa.json') }}"
        },
        responsive: true,
        sScrollX: "100%",
        sScrollXInner: "100%",
        processing: true,
        serverSide: true,
        ajax: "{{ route('module.media.index') }}",
        order: [[ 5, "desc" ]],
        columns: [
            {data: 'filename', name: 'filename'},
            {data: 'user_id', name: 'user_id'},
            {data: 'tag', name: 'tag'},
            {data: 'permissions', name: 'permissions', orderable: false, searchable: false},
            {data: 'mediaable_id', name: 'mediaable_id', searchable: false},
            {data: 'updated_at', name: 'updated_at'},
        ]
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

        // set file link
    function fmSetLink($url) {
        document.getElementById('image_label').value = $url;
    }
</script>
@endsection