@extends(panelLayout())

@section('content')
<div class="grid gap-4 grid-cols-1 md:grid-cols-4">
    <!-- card -->
    <div class="card hover:shadow">
        <div class="card-header">
            <h5>{{__('Today registration')}}</h5>
            
            <span class="icon-area">
                👥
            </span>
        </div>
        <div class="card-body">
            <h6 class="font-bold inline-block">{{ number_format(\App\Models\User::whereDate('created_at', \Carbon\Carbon::today())->count()) }}</h6>
        </div>
    </div>
    <!-- end card -->

    @action('panel.widgets.report_cards')
</div>

<div class="mt-6">
    @action('panel.widgets.main')
</div>
@endsection
