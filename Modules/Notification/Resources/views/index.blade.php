@extends('panel::layouts.app', ['title'=> 'مشاهده کل اعلانات'])

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id='notificationsTable'>
                <thead>
                    <tr>
                        <th>کاربر</th>
                        <th>عنوان</th>
                        <th>پیام</th>
                        <!-- <th>دیده شده</th> -->
                        <th>زمان ایجاد</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let notificationsTable = $('#notificationsTable').DataTable({
        language: {
            "url": "{{ asset('assets/plugins/datatables/fa.json') }}"
        },
        responsive: true,
        sScrollX: "100%",
        sScrollXInner: "100%",
        processing: true,
        serverSide: true,
        ajax: "{{ route('module.notification.index') }}",
        order: [[ 3, "desc" ]],
        columns: [
            {data: 'user', name: 'user' },
            {data: 'title', name: 'title' },
            {data: 'message', name: 'message' },
            // {data: 'seen', name: 'seen', orderable: true, searchable: false},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
        ]
    });
</script>
@endsection
