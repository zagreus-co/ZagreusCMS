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
    
</script>
@endsection
