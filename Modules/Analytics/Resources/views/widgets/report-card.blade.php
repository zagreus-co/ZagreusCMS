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