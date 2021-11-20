@extends(panelLayout())

@section('content')
@php($roles = \App\Models\User\Role::all())
<div class="flex">
    <a href='{{ route("panel.roles.create") }}' class='btn-success inline'>Create</a>
</div>
<div class="grid grid-cols-{{ $roles->count() == 1 ? 1 : 2 }} gap-6 mt-6 xl:grid-cols-1">
    
    @foreach($roles as $role)
        <div class=''>
            <div class="card">
                <div class='card-header flex justify-between'>
                    <strong class="pt-2">{{ $role->title }}</strong>
                    <div class='flex flex-nowrap'>
                        <a href='{{ route("panel.roles.edit", $role->id) }}' class="p-1 px-2 mr-2 btn-primary"><i class="fa fa-edit"></i></a>
                        <button onclick="fireDelete(this, '{{ route('panel.roles.destroy', $role->id) }}')" class="p-1 px-2 btn-danger"><i class="fa fa-trash"></i></button>
                    </div>
                    
                </div>
                
                <div class='h-64 overflow-y-auto'>
                    <div class="card-body grid grid-cols-2 xl:grid-cols-1">
                        @foreach($role->permissions()->get() as $permission)
                            <div class="bg-gray-300 rounded p-2 m-2">
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
