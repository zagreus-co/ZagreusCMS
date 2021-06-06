@extends(panelLayout())

@section('content')
<div class="grid grid-cols-4 gap-6 xl:grid-cols-1">
    <!-- card -->
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                
                <!-- top -->
                <div class="flex flex-row justify-between items-center">
                    <div class="h6 text-indigo-700 fad fa-users"></div>
                    
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-8">
                    <h1 class="h5">{{ \App\Models\User::whereDate('created_at', \Carbon\Carbon::today())->count() }}</h1>
                    <p>{{__('Today registration')}}</p>
                </div>                
                <!-- end bottom -->
    
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
    <!-- end card -->


    <!-- card -->
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                
                <!-- top -->
                <div class="flex flex-row justify-between items-center">
                    <div class="h6 text-yellow-500 fad fa-rss"></div>
                    
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-8">
                    <h1 class="h5">{{ \Modules\Blog\Entities\Post::count() }}</h1>
                    <p>{{__('Total posts')}}</p>
                </div>                
                <!-- end bottom -->
    
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
    <!-- end card -->


    <!-- card -->
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                
                <!-- top -->
                <div class="flex flex-row justify-between items-center">
                    <div class="h6 text-red-600 fad fa-pager"></div>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-8">
                    <h1 class="h5">{{ \Modules\Page\Entities\Page::count() }}</h1>
                    <p>{{__('Total pages')}}</p>
                </div>                
                <!-- end bottom -->
    
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
    <!-- end card -->


    <!-- card -->
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                
                <!-- top -->
                <div class="flex flex-row justify-between items-center">
                    <div class="h6 text-green-500 fad fa-chart-line"></div>
                    @php $difference = $analytics['todayViewers'] - $analytics['yesterdayViewers']; @endphp
                    <span class="rounded-full text-white badge bg-{{ $difference > 0 ? 'teal' : 'red' }}-400 text-xs">
                        {{ $difference }}
                        <i class="fal fa-chevron-{{ $difference > 0 ? 'up' : 'down' }} ml-1"></i>
                    </span>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-8">
                    <h1 class="h5">{{ $analytics['todayViewers'] }}</h1>
                    <p>{{__('Today viewers')}}</p>
                </div>
                <!-- end bottom -->
    
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
    <!-- end card -->
</div>

<div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">
    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Weekly chart') }}</strong>
        </div>

        <div class="card-body"> <canvas id="analyticChart" width="100%" height="50"></canvas> </div>

    </div>
</div>
@endsection
@section('script')
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
                mode: 'nearest'
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        },
    });
</script>
@endsection