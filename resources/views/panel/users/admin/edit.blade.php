@extends(panelLayout())

@section('content')
<form action="{{ route('panel.users.update', $user->id) }}" method="post" class='grid grid-cols-12 md:grid-cols-1 gap-4'>
@csrf
@method('PATCH')
<div class="col-span-12"> @panelView('errors-alert') </div>

<div class="col-span-8 md:col-span-12">
    <div class="card" >
        <div class="card-body">

            <div class="form-group mb-3">
                <label>{{__('Full name')}}</label>
                <input type="text" name='full_name' value='{{ old("full_name", $user->full_name) }}' class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>{{__('Email address')}}</label>
                <input type="text" name='email' value='{{ old("email", $user->email) }}' class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>{{__('Phone number')}} <small>(optional)</small></label>
                <input type="text" name='number' value='{{ old("number", $user->number) }}' class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>{{__('Password')}}</label>
                <input type="password" name='password' class="form-control">
            </div>
            
        </div>
        
    </div>
</div>
<div class="col-span-4 md:col-span-12">

    <div class="card">
        <div class="card-header">
            <div class="form-group">
                <label for="permissions">{{__('Role')}}</label>
                <select name="role_id" id='role_select' class="form-control">
                    <option value="0">{{__('Normal user')}}</option>
                    @foreach (\App\Models\User\Role::all() as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button type='submit' class="btn-primary w-full">{{__('Update')}}</button>
        </div>
    </div>
</div>
</form>
@endsection
