@extends(panelLayout())

@section('content')

<div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
    <!-- card -->
    <div class="report-card">
        <div class="card">
            <div class="card-body flex flex-col">
                
                <!-- top -->
                <div class="flex flex-row justify-between items-center">
                    @php $difference = $analytics['todayViewers'] - $analytics['yesterdayViewers']; @endphp
                    <div>👥</div>
                    <span class="rounded-full text-white badge bg-{{ $difference > 0 ? 'teal' : 'red' }}-400 text-xs">
                        {{ $difference }}
                        <ion-icon name="{{ $difference > 0 ? 'trending-up-outline' : 'trending-down-outline' }}"></ion-icon>
                    </span>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-4">
                    <h5 class='font-bold'>{{ $analytics['todayViewers'] }}</h5>
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
                    @php $difference = $analytics['todayViews'] - $analytics['yesterdayViews']; @endphp
                    <div>{{ $difference > 0 ? '📈' : '📉' }}</div>
                    <span class="rounded-full text-white badge bg-{{ $difference > 0 ? 'teal' : 'red' }}-400 text-xs">
                        {{ $difference }}
                        <ion-icon name="{{ $difference > 0 ? 'trending-up-outline' : 'trending-down-outline' }}"></ion-icon>
                    </span>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-4">
                    <h5 class='font-bold'>{{ $analytics['todayViews'] }}</h5>
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
                    @php $difference = $analytics['currentMonth'] - $analytics['lastMonth']; @endphp
                    <div>📊</div>
                    <span class="rounded-full text-white badge bg-{{ $difference > 0 ? 'teal' : 'red' }}-400 text-xs">
                        {{ $difference }}
                        <ion-icon name="{{ $difference > 0 ? 'trending-up-outline' : 'trending-down-outline' }}"></ion-icon>
                    </span>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-4">
                    <h5 class='font-bold'>{{ $analytics['currentMonth'] }}</h5>
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
                    <div>📌</div>
                </div>
                <!-- end top -->

                <!-- bottom -->
                <div class="mt-4">
                    <h5 class='font-bold'>{{ $analytic->count() }}</h5>
                    <p>{{__('Total viewers')}}</p>
                </div>                
                <!-- end bottom -->
    
            </div>
        </div>
        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
    <!-- end card -->

</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6 ">
    <div class="">
        <div class="card">
            <div class="card-header flex justify-between">
                <strong class="pt-2">{{ __('Weekly chart') }}</strong>
            </div>

            <div class="card-body"> <canvas id="analyticChart" width="100%" height="60"></canvas> </div>
        </div>
    </div>

    <div class="">
        <div class="card">
            <div class="card-header flex justify-between">
                <strong class="pt-2">{{ __('Top pages for last 7 days') }}</strong>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="">
                        <tr class="bg-gray-800 text-white text-lg">
                            <th class="px-4 py-2 font-5">{{__('Page')}}</th>
                            <th class="px-4 py-2">{{__('Viewers')}}</th>
                            <th class="px-4 py-2">{{__('Views')}}</th>
                        </tr>
                    </thead>
                    <tbody class="text-lg">
                        @foreach($analytics['mostViewdPages'] as $row)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ str_replace(\URL::to('/'), '', $row[0]->url) == '' ? '/' : str_replace(\URL::to('/'), '', $row[0]->url) }}</td>
                            <td class="px-4 py-2">{{ $row->count() }}</td>
                            <td class="px-4 py-2">{{ $row->pluck('views')->sum() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
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
                    label: '{{__("Viewers")}}',
                    data: [
                        @foreach($analytics['weekDates'] as $day)
                        "{{ $analytic->whereDate('created_at', $day)->get()->groupBy(function($row) { return $row->ip; })->count() }}",
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
@endpush