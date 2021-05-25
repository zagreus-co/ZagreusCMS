@extends('panel::layouts.app', ['title'=> 'پروفایل کاربری'])

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">ویرایش رمزعبور</div>
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>رمزعبور فعلی</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                <div class="form-group">
                    <label>رمزعبور جدید</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>تکرار رمزعبور جدید</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button class="btn btn-success">ثبت تغییرات</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection