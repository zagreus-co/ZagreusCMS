@extends(panelLayout())
@section('content')

@foreach(auth()->user()->notifications()->whereVisible(1)->limit(6)->latest()->get() as $notification)
    <a onclick="openNotification(this, 1 );" class="mb-3 flex flex-row items-center justify-start px-4 py-4 capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out shadow-md" href="#">
        <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
            <i class="{{ $notification->icon }} text-sm"></i>
        </div>
        <div class="flex-1 flex flex-rowbg-green-100">
            <div class="flex-1">
                <h1 class="text-md font-semibold">{{ $notification->title }}</h1>
                <p class="text-lg text-gray-600">{!! str_replace("\n", "<br>",$notification->message) !!}</p>
            </div>
            <div class="text-right text-xs text-gray-500">
                <p>{{ $notification->created_at->ago() }}</p>
            </div>
        </div>
    </a>
@endforeach

@endsection