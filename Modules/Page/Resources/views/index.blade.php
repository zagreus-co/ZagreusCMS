@extends(panelLayout())

@section('content')

<div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">
    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Manage pages') }}</strong>
            <a href='{{ route("module.page.create") }}' class="btn p-2 px-3 btn-success">{{__('Create')}}</a>
        </div>

        <livewire:pages-table />

    </div>
</div>

@endsection
