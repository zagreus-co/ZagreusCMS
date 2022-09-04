<nav class='flex items-center justify-between px-6 md:px-14 lg:px-20 py-4'>
    <div>
        <a href="{{ route('index') }}">
            <h1 class="text-2xl font-bold text-fuchsia-500 hover:text-fuchsia-600 transition duration-200">{{ get_option('site_short_name') }}</h1>
        </a>
    </div>

    <div class="hidden md:flex items-center">
        <a href="{{ route('index') }}" class="px-3 py-1 border-b {{ isCurrentUrl(route('index'), 'text-fuchsia-500 border-fuchsia-500') }} hover:text-fuchsia-500 hover:border-fuchsia-500 transition duration-200">{{ __('Home') }}</a>
        
        {{-- Pages list --}}
        @foreach (activePages() as $page)
            <a href="{{ route('module.page.show', $page->slug) }}" class="px-3 py-1 border-b {{ isCurrentUrl(route('module.page.show', $page->slug), 'text-fuchsia-500 border-fuchsia-500') }} hover:text-fuchsia-500 hover:border-fuchsia-500 transition duration-200">{{ $page->title }}</a>
        @endforeach
        
        @guest
            <a href="{{ route('login') }}" data-turbolinks="false" class="px-3 py-1 border-b hover:text-fuchsia-500 hover:border-fuchsia-500 transition duration-200">
                {{__('Account')}}
            </a>
        @else
            <a href="{{ route('panel.index') }}" data-turbolinks="false" class="px-3 py-1 border-b hover:text-fuchsia-500 hover:border-fuchsia-500 transition duration-200">
                {{__('Dashboard')}}
            </a>
        @endguest

        {{-- Language dropdown --}}
        <div class="relative" x-data='{ isOpen: false }' @click.outside='isOpen = false'>
            <!-- Dropdown toggle button -->
            <button @click='isOpen = !isOpen' class="relative z-10 block p-2 rounded-md focus:outline-none">
                <svg :class='{"transform rotate-180": isOpen}' class="w-5 h-5 text-gray-800 transition duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div x-show='isOpen' x-transition class="absolute {{ app()->getLocale() == 'fa' ? 'left-0' : 'right-0' }} z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl">
                @foreach(locales() as $locale => $value)
                <a href="?lang={{$locale}}" data-turbolinks="false" class="block px-4 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 transform hover:bg-emerald-700 hover:text-white">
                    {{$value}}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    <div class="md:hidden relative" x-data="{ open: false }" @click.outside = "open = false">
        <button x-on:click="open = !open"
                class="flex items-center space-x-2 focus:outline-none px-2 py-4">            
            <div class="w-6 flex items-center justify-center relative">
                <span x-bind:class="open ? 'translate-y-0 rotate-45' : '-translate-y-2'"
                        class="transform transition w-full h-px bg-black absolute"></span>
                
                <span x-bind:class="open ? 'opacity-0 translate-x-3' : 'opacity-100'"
                        class="transform transition w-full h-px bg-black absolute"></span>
                
                <span x-bind:class="open ? 'translate-y-0 -rotate-45' : 'translate-y-2'"
                    class="transform transition w-full h-px bg-black absolute"></span>
            </div>
        </button>

        <ul x-show='open' class=' w-60 absolute right-0 bg-white py-2 px-4 rounded-sm shadow text-center space-y-2'>
            <li>
                <a href="{{ route('index') }}" class="px-3 py-1 block w-full {{ isCurrentUrl(route('index'), 'text-fuchsia-500') }} hover:text-fuchsia-500 hover:border-fuchsia-500 transition duration-200">{{ __('Home') }}</a>
            </li>

            @foreach (activePages() as $page)
                <li>
                    <a href="{{ route('module.page.show', $page->slug) }}" class="px-3 py-1 block w-full {{ isCurrentUrl(route('module.page.show', $page->slug), 'text-fuchsia-500') }} hover:text-fuchsia-500 hover:border-fuchsia-500 transition duration-200">{{ $page->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>