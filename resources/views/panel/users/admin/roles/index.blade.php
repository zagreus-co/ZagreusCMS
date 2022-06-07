@extends(panelLayout())

@section('content')
<div class="flex items-center justify-between mb-3">
    <h5 class="font-bold">{{ __('Manage roles') }}</h5>
    <a href='{{ route("panel.roles.create") }}' class='btn btn-sm btn-success'>{{__('Create')}}</a>
</div>
<div class="grid grid-cols-1 xl:grid-cols-{{ $roles->count() == 1 ? 1 : 2 }} gap-6 mt-6">
    
    @foreach($roles as $role)
        <div class=''>
            <div class="card">
                <div class='card-header flex justify-between'>
                    <h5 class="font-bold">{{ __($role->title) }}</h5>
                    <div class='flex flex-nowrap'>
                        <a href='{{ route("panel.roles.edit", $role->id) }}' class="btn btn-sm btn-primary mr-1"> {{__('Edit')}} </a>
                        <button onclick="fireDelete(this, '{{ route('panel.roles.destroy', $role->id) }}')" class="p-1 px-2 btn btn-sm btn-danger"> {{__('Delete')}} </button>
                    </div>
                </div>
                
                <div class='h-64 overflow-y-auto'>
                    <div class="card-body grid grid-cols-1 xl:grid-cols-2">
                        @foreach($role->permissions as $permission)
                            <div class="{{ $loop->odd && $loop->last ? 'col-span-2' : ''}} bg-gray-300 rounded p-2 m-2">
                                <label>{{ $permission->title }}</label>
                                <br>
                                <small>({{ $permission->tag }})</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection
