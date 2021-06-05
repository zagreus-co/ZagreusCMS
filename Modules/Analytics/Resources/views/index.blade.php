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


    <!-- card -->
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                
                <!-- top -->
                <div class="flex flex-row justify-between items-center">
                    <div class="h6 text-yellow-500 fad fa-eye"></div>
                    @php $difference = $analytics['todayViews'] - $analytics['yesterdayViews']; @endphp
                    <span class="rounded-full text-white badge bg-{{ $difference > 0 ? 'teal' : 'red' }}-400 text-xs">
                        {{ $difference }}
                        <i class="fal fa-chevron-{{ $difference > 0 ? 'up' : 'down' }} ml-1"></i>
                    </span>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-8">
                    <h1 class="h5">{{ $analytics['todayViews'] }}</h1>
                    <p>{{__('Today views')}}</p>
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
                    <div class="h6 text-red-600 fad fa-sitemap"></div>
                    @php $difference = $analytics['currentMonth'] - $analytics['lastMonth']; @endphp
                    <span class="rounded-full text-white badge bg-{{ $difference > 0 ? 'teal' : 'red' }}-400 text-xs">
                        {{ $difference }}
                        <i class="fal fa-chevron-{{ $difference > 0 ? 'up' : 'down' }} ml-1"></i>
                    </span>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-8">
                    <h1 class="h5">{{ $analytics['currentMonth'] }}</h1>
                    <p>{{__('This month viewers')}}</p>
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
                    <div class="h6 text-green-700 fad fa-chart-line"></div>
                    
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-8">
                    <h1 class="h5">{{ $analytic->count() }}</h1>
                    <p>{{__('Total viewers')}}</p>
                </div>                
                <!-- end bottom -->
    
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
    <!-- end card -->

</div>

<div class="grid grid-cols-2 gap-6 mt-6 xl:grid-cols-1">
    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Weekly chart') }}</strong>
        </div>

        <div class="card-body"> <canvas id="analyticChart" width="100%" height="60"></canvas> </div>

    </div>

    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Top pages for last 7 days') }}</strong>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead class="">
                    <tr class="bg-gray-800 text-white text-lg">
                        <th class="px-16 py-2 font-5">{{__('Page')}}</th>
                        <th class="px-16 py-2">{{__('Viewers')}}</th>
                        <th class="px-16 py-2">{{__('Views')}}</th>
                    </tr>
                </thead>
                <tbody class="text-lg">
                    @foreach($analytics['mostViewdPages'] as $row)
                    <tr class="bg-white border-4 border-gray-200">
                        <td class="px-16 py-2">{{ str_replace(\URL::to('/'), '', $row[0]->url) == '' ? '/' : str_replace(\URL::to('/'), '', $row[0]->url) }}</td>
                        <td class="px-16 py-2">{{ $row->count() }}</td>
                        <td class="px-16 py-2">{{ $row->pluck('views')->sum() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
                    label: '{{__("Viewers")}}',
                    data: [
                        @foreach($analytics['weekDates'] as $day)
                        "{{ $analytic->whereDate('created_at', $day)->count() }}",
                        @endforeach
                    ],
                    backgroundColor: '#4c51bf',
                    borderColor: '#4c51bf',
                    borderWidth: 1
                },
                {
                    label: '{{__("Views")}}',
                    data: [
                        @foreach($analytics['weekDates'] as $day)
                        "{{ $analytic->whereDate('created_at', $day)->pluck('views')->sum() }}",
                        @endforeach
                    ],
                    backgroundColor: '#ecc94b',
                    borderColor: '#ecc94b',
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