@extends(panelLayout())

@section('content')
<div class="grid grid-cols-4 gap-6 mt-6 xl:grid-cols-2">
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h1 class="h5">{{ number_format(\App\Models\User::count()) }}</h1>
                        <p>{{ __('Total users') }}</p>
                    </div>
                    <div class="h6 text-indigo-700 fad fa-users"></div>
                </div>
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
    
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h1 class="h5">{{ number_format(\App\Models\User::where('role_id', '!=', 0)->count()) }}</h1>
                        <p>{{ __('Staff users') }}</p>
                    </div>
                    <div class="h6 text-green-600 fad fa-user-tie"></div>
                </div>
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>

    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h1 class="h5">{{ number_format(\App\Models\User::where('role_id', 0)->count()) }}</h1>
                        <p>{{ __('Normal users') }}</p>
                    </div>
                    <div class="h6 text-blue-600 fad fa-user"></div>
                </div>
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>

    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h1 class="h5">{{ number_format(\App\Models\User::whereDate('created_at', \Carbon\Carbon::today())->count()) }}</h1>
                        <p>{{ __('Today registration') }}</p>
                    </div>
                    <div class="h6 text-yellow-700 fad fa-user-plus"></div>
                </div>
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>

</div>

<div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">
    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Manage users') }}</strong>
            <div class='flex flex-nowrap'>
                <a href='{{ route("panel.roles.index") }}' class="p-2 px-3 mr-2 btn-bs-secondary">{{__('Manage roles')}}</a>
                <a href='{{ route("panel.users.create") }}' class="p-2 px-3 btn-success">{{__('Create user')}}</a>
            </div>
        </div>

        <livewire:users-table />

    </div>
</div>
@endsection
