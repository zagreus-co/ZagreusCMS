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
                    <p>Today viewers</p>
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
                    <div class="h6 text-red-700 fad fa-eye"></div>
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
                    <p>Today views</p>
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
                    <div class="h6 text-yellow-600 fad fa-sitemap"></div>
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
                    <p>This month viewers</p>
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
                    <p>Total viewers</p>
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
            <strong class="pt-2">{{ __('Analytics') }}</strong>
        </div>

    </div>
</div>

@endsection
@section('script')
<script src='{{ asset("js/chart.min.js") }}'></script>
@endsection