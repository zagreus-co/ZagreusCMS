<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#5c68ff" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    @vite(['resources/views/panel/layouts/ZedAdmin/src/css/app.css', 'resources/views/panel/layouts/ZedAdmin/src/js/dashboard.js', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    @livewireStyles
    {!! SEO::Generate() !!}
</head>

<body dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

    <nav class='mobile-navbar'>
        <button id='mobileMenuBtn' class='text-2xl px-4'>
            <ion-icon class='mt-2' name="menu-outline"></ion-icon>
        </button>

        <div>
            <livewire:notification::panel.header-notification />

            <div class="relative inline-block" x-data='{open: false}'>
                <button @click='open = !open' :class="open ? 'bg-gray-100' : ''"
                    class='text-xl rounded px-2 hover:bg-gray-100 transition duration-200'>
                    <ion-icon class='mt-2' name="person-outline"></ion-icon>
                </button>
                <div x-show="open" @click.outside="open = false"
                    class="dropdown-content -right-6 sm:-right-8 md:right-1 text-left"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-y-0 transform"
                    x-transition:enter-end="opacity-100 scale-y-100 transform"
                    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">

                    <div class='p-3 text-sm text-gray-500 border-b border-gray-100'>
                        {{ __('Logged in as') }}
                        <span class='block text-theme-darked-primary'>{{ auth()->user()->full_name }}</span>
                    </div>

                    <a class='flex items-center w-full p-3 hover:bg-theme-secondary transition duration-200'
                        href="{{ route('index') }}">
                        <ion-icon class='mr-2' name="compass-outline"></ion-icon>
                        {{ __('Visit website') }}
                    </a>

                    <a class='flex items-center w-full p-3 hover:bg-theme-secondary transition duration-200'
                        href="{{ route('panel.profile') }}">
                        <ion-icon class='mr-2' name="create-outline"></ion-icon>
                        {{ __('Edit profile') }}
                    </a>

                    <a class='flex items-center w-full p-3 text-red-500 hover:bg-red-50 transition duration-200 border-t border-gray-100'
                        href="{{ route('panel.logout') }}">
                        <ion-icon class='mr-2' name="log-out-outline"></ion-icon>
                        {{ __('Logout') }}
                    </a>

                </div>
            </div>
        </div>
    </nav>

    <aside class="sidebar hidden lg:block">
        <header>
            <h1>{{ __('ZedAdmin') }}<span>.</span></h1>
        </header>
        <nav>
            <ul>
                @panelView('sidebar')
            </ul>
        </nav>
    </aside>

    <main>
        @yield('content')
    </main>

    @livewireScripts
    <script>
        let base_url = "{{ \URL::to('/') }}";
    </script>
    <!-- Icons pack -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!-- ChartJS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    @stack('scripts')

</body>

</html>
