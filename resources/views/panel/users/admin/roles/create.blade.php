@extends(panelLayout())

@section('content')
    <div class="flex items-center justify-between mb-3">
        <h5 class="font-bold">{{ __('Create new role') }}</h5>
        <a href='{{ route("panel.roles.index") }}' class='btn btn-sm btn-secondary'>{{__('Back')}}</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('panel.roles.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="title">{{ __('Role title') }}</label>
                    <input type="text" name='title' class="form-control" value='{{ old("title") }}'>
                </div>

                <div class="form-group mt-3">
                    <label for="permissions">{{ __('Permissions') }}</label>
                    <select name="permissions[]" id='permissions_select' multiple="multiple" class="form-control">
                        @foreach (\App\Models\User\Permission::all() as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->title }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success mt-3">{{__("Create")}}</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script> $('#permissions_select').select2(); </script>
@endpush