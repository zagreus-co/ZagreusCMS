@extends(panelLayout())

@section('content')
<div class="col-md-12">
    @panelView('errors-alert')

    <div class="card">
        <div class="card-header font-bold border-b mb-3 pb-3">{{__('Update password')}}</div>
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>{{__("Current password")}}</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label>{{__("New password")}}</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label>{{__('New password confirmation')}}</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button class="btn btn-success mt-3">{{__('Update password')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection