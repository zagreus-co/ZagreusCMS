<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
  <link rel="stylesheet" type="text/css" href="{{panelAsset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
  <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
  @livewireStyles
  {!! SEO::Generate() !!}
</head>
<body class="bg-gray-100">


<!-- start navbar -->
<div class="md:fixed md:w-full md:top-0 md:z-20 flex flex-row flex-wrap items-center bg-white p-6 border-b border-gray-300">
    
    <!-- logo -->
    <div class="flex-none w-56 flex flex-row items-center">
      <strong class="capitalize ml-1 flex-1 text-2xl text-teal-600">ZagreusCMS</strong>

      <button id="sliderBtn" class="flex-none text-right text-gray-900 hidden md:block">
        <i class="fad fa-list-ul"></i>
      </button>
    </div>
    <!-- end logo -->   
    
    <!-- navbar content toggle -->
    <button id="navbarToggle" class="hidden md:block md:fixed right-0 mr-6">
      <i class="fad fa-chevron-double-down"></i>
    </button>
    <!-- end navbar content toggle -->

    <!-- navbar content -->
    <div id="navbar" class="animated md:hidden md:fixed md:top-0 md:w-full md:left-0 md:mt-16 md:border-t md:border-b md:border-gray-200 md:p-10 md:bg-white flex-1 pl-3 flex flex-row flex-wrap justify-between items-center md:flex-col md:items-center">
      <!-- left -->
      <div class="text-gray-600 md:w-full md:flex md:flex-row md:justify-evenly md:pb-10 md:mb-10 md:border-b md:border-gray-200"> 
        <!-- <a class="mr-2 transition duration-500 ease-in-out hover:text-gray-900" href="#" title="email"><i class="fad fa-calendar-exclamation"></i></a>         -->
      </div>
      <!-- end left -->      

      <!-- right -->
      <div class="flex flex-row-reverse items-center"> 

        <!-- user -->
        <div class="dropdown relative md:static">

          <button class="menu-btn focus:outline-none focus:shadow-outline flex flex-wrap items-center">
            <div class="w-8 h-8 overflow-hidden rounded-full">
              <img class="w-full h-full object-cover" src="{{panelAsset('img/user.svg')}}" >
            </div> 

            <div class="ml-2 capitalize flex ">
              <h1 class="text-sm text-gray-800 font-semibold m-0 p-0 leading-none">{{ auth()->user()->full_name }}</h1>
              <i class="fad fa-chevron-down ml-2 text-xs leading-none"></i>
            </div>                        
          </button>

          <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

          <div class="text-gray-500 menu hidden md:mt-10 md:w-full rounded bg-white shadow-md absolute z-20 right-0 w-40 mt-5 py-2 animated faster">

            <!-- item -->
            <a class="px-4 py-2 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 ease-in-out" href="#">
              <i class="fad fa-user-edit text-xs mr-1"></i> 
              edit my profile
            </a>     
            <!-- end item -->

            <hr>

            <!-- item -->
            <a href="{{ route('logout') }}" class="px-4 py-2 block capitalize font-medium text-sm text-red-400 tracking-wide bg-white hover:bg-gray-200 hover:text-red-600 transition-all duration-300 ease-in-out">
              <i class="fad fa-user-times text-xs mr-1"></i> 
              log out
            </a>     
            <!-- end item -->

          </div>
        </div>
        <!-- end user -->
        
        <!-- notifcation -->
        <div class="dropdown relative mr-5 md:static">

          <button class="text-gray-500 menu-btn p-0 m-0 hover:text-gray-900 focus:text-gray-900 focus:outline-none transition-all ease-in-out duration-300">
            <i class="fad fa-bells"></i>               
          </button>

          <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

          <div class="menu hidden rounded bg-white md:right-0 md:w-full shadow-md absolute z-20 right-0 w-84 mt-5 py-2 animated faster">
            <!-- top -->
            <div class="px-4 py-2 flex flex-row justify-between items-center capitalize font-semibold text-sm">
              <h1>notifications</h1>
              <div class="bg-teal-100 border border-teal-200 text-teal-500 text-xs rounded px-1">
                <strong>{{ auth()->user()->notifications()->whereSeen(0)->count() }}</strong>
              </div>
            </div>
            <hr>
            <!-- end top -->

            <!-- body -->

            @foreach(auth()->user()->notifications()->orderBy('seen', 'desc')->limit(6)->get() as $notification)
            <a onclick='openNotification(this, {{$notification->id}} );' class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out" href="#">

              @if (!is_null($notification->icon))
              <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
                <i class="{{ $notification->icon }} text-sm"></i>
              </div>
              @endif

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold {{ !$notification->seen ? 'text-red-400' : ''  }}">{{ $notification->title }}</h1>
                  <p class="text-xs text-gray-500">{{ \Str::words($notification->message, 8, ' ...') }}</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>{{ $notification->created_at->ago() }}</p>
                </div>
              </div>

            </a>
            @endforeach
            <hr>
            <!-- end item -->

            <!-- end body -->
            <!-- bottom -->
            <hr>
            <div class="px-4 py-2 mt-2">
              <a href="#" class="border border-gray-300 block text-center text-xs uppercase rounded p-1 hover:text-teal-500 transition-all ease-in-out duration-500">
                {{ __("View all") }}
              </a>
            </div>
            <!-- end bottom -->            
          </div>
        </div>
        <!-- end notifcation -->    
        
        <a href='{{route("index")}}' target='_blank' class="mr-5 text-gray-500 menu-btn p-0 m-0 hover:text-gray-900 focus:text-gray-900 focus:outline-none transition-all ease-in-out duration-300">
          <i class="fad fa-eye"></i>               
        </a>

      </div>
      <!-- end right -->
    </div>
    <!-- end navbar content -->

  </div>
<!-- end navbar -->

<!-- strat wrapper -->
<div class="h-screen flex flex-row flex-wrap">

    @panelView('sidebar')

    <!-- strat content -->
    <div class="bg-gray-100 flex-1 p-6 md:mt-16">
        @yield('content')
    </div>
    <!-- end content -->

</div>
<!-- end wrapper --> 

  

<!-- script -->
@livewireScripts
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{panelAsset('js/scripts.js')}}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{panelAsset('js/main.js')}}"></script>
@include('sweet::alert')
@yield('script')
@yield('components-script')
<!-- end script -->

</body>
</html>
