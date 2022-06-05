@php $difference = $analytics['todayViewers'] - $analytics['yesterdayViewers']; @endphp
<div class="card hover:shadow">
    <div class="card-header">
        <h5>{{__('Today viewers')}}</h5>
        <span class="icon-area">
            {{ $difference > 0 ? '📈' : '📉' }}
        </span>
    </div>
    <div class="card-body">
        <h6 class="font-bold inline-block">
            {{ number_format($analytics['todayViewers']) }}
            <span class="badge {{ $difference > 0 ? 'badge-success' : 'badge-danger' }}">
                {{ $difference > 0 ? '+'.$difference : $difference }}
                <i class="fal fa-chevron-{{ $difference > 0 ? 'up' : 'down' }} ml-1"></i>
            </span>
        </h6>
    </div>
</div>