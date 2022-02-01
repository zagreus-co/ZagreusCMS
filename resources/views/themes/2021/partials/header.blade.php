<nav class="bg-white shadow-md dark:bg-gray-700 z-50 relative">
    <div class="container px-6 py-3 mx-auto md:flex md:justify-between md:items-center">
        <div class="flex items-center justify-between">
            <div>
                <a class="text-xl font-bold text-emerald-600 dark:text-emerald-300 md:text-2xl hover:text-emerald-500 dark:hover:text-emerald-400 hover:no-underline" href="{{ route('index') }}">
                    {{ get_option('site_short_name') }}
                </a>
            </div>
            
            <!-- Mobile menu button -->
            <div class="flex md:hidden">
                <button onclick='document.querySelector("#headerMenu").classList.toggle("hidden");' type="button" class="px-3 py-1 text-md font-medium text-gray-700 transition-colors duration-200 transform rounded-md md:mt-0 dark:text-gray-200 hover:text-emerald-700 dark:hover:text-emerald-500" aria-label="toggle menu">
                    <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                        <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
        <div class="items-center md:flex hidden" id='headerMenu'>
            <div class="flex flex-col -mx-4 md:flex-row md:items-center md:mx-8">
                @foreach (activePages() as $page)
                    <a href="{{ route('module.page.show', $page->slug) }}" class="px-3 py-1 mx-2 text-md font-medium text-gray-700 transition-colors duration-200 transform rounded-md md:mt-0 dark:text-gray-200 hover:bg-gray-300 hover:text-emerald-700 dark:hover:bg-gray-800 dark:hover:text-emerald-500 hover:no-underline">{{ $page->title }}</a>
                @endforeach
                @guest
                <a href="{{ route('login') }}" data-turbolinks="false" class="px-3 py-1 mx-2 text-md font-medium text-gray-700 transition-colors duration-200 transform rounded-md md:mt-0 dark:text-gray-200 hover:bg-gray-300 hover:text-emerald-700 dark:hover:bg-gray-800 dark:hover:text-emerald-500 hover:no-underline">
                    {{__('Account')}}
                </a>
                @else
                <a href="{{ route('panel.index') }}" data-turbolinks="false" class="px-3 py-1 mx-2 text-md font-medium text-gray-700 transition-colors duration-200 transform rounded-md md:mt-0 dark:text-gray-200 hover:bg-gray-300 hover:text-emerald-700 dark:hover:bg-gray-800 dark:hover:text-emerald-500 hover:no-underline">
                    {{__('Dashboard')}}
                </a>
                @endguest
                <div class="relative" x-data='{ isOpen: false }'>
                    <!-- Dropdown toggle button -->
                    <button @click='isOpen = !isOpen' class="relative z-10 block p-2 bg-white rounded-md dark:bg-gray-700 focus:outline-none">
                        <svg :class='{"transform rotate-180": isOpen}' class="w-5 h-5 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show='isOpen' class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl dark:bg-gray-800">
                        @foreach(locales() as $locale => $value)
                        <a href="?lang={{$locale}}" data-turbolinks="false" class="block px-4 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-emerald-700 hover:text-white dark:hover:text-white">
                            {{$value}}
                        </a>
                        @endforeach
                    </div>
                </div>

                
            </div>
            
        </div>
    </div>
</nav>