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
@push('scripts')
<script src='{{ asset("js/chart.min.js") }}'></script>

<script>
    var ctx = document.querySelector('#analyticChart');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                <?php
                    for($d = 6; $d >= 0 ; $d--) {
                        $analytics['weekDates'][] = \Carbon\Carbon::today()->subDay($d);
                        echo '"'.__(\Carbon\Carbon::today()->subDay($d)->format('l')).'",';
                    }
                ?>
            ],
            datasets: [
                {
                    label: '{{__("Registration")}}',
                    data: [
                        @foreach($analytics['weekDates'] as $day)
                        "{{ \App\Models\User::whereDate('created_at', $day)->count() }}",
                        @endforeach
                    ],
                    backgroundColor: '#4c51bf',
                    borderColor: '#4c51bf',
                    borderWidth: 1
                },
                {
                    label: '{{__("Blog posts")}}',
                    data: [
                        @foreach($analytics['weekDates'] as $day)
                        "{{ \Modules\Blog\Entities\Post::whereDate('created_at', $day)->count() }}",
                        @endforeach
                    ],
                    backgroundColor: '#ecc94b',
                    borderColor: '#ecc94b',
                    borderWidth: 1
                },
                {
                    label: '{{__("Viewers")}}',
                    data: [
                        @foreach($analytics['weekDates'] as $day)
                        "{{ \Modules\Analytics\Entities\Analytic::whereDate('created_at', $day)->get()->groupBy(function($row) { return $row->ip; })->count() }}",
                        @endforeach
                    ],
                    backgroundColor: '#6EE7B7',
                    borderColor: '#6EE7B7',
                    borderWidth: 1
                },
                {
                    label: '{{__("Views")}}',
                    data: [
                        @foreach($analytics['weekDates'] as $day)
                        "{{ \Modules\Analytics\Entities\Analytic::whereDate('created_at', $day)->pluck('views')->sum() }}",
                        @endforeach
                    ],
                    backgroundColor: '#047857',
                    borderColor: '#047857',
                    borderWidth: 1
                },
            ]
        },
        options: {
            responsive: true,
            elements: {
                line: {
                    tension: 0.4,
                    borderJoinStyle: 'round'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        },
    });
</script>
@endpush