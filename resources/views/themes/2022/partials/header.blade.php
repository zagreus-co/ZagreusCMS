<nav class='flex items-center justify-between px-20 py-4'>
    <div>
        <a href="{{ route('index') }}">
            <h1 class="text-2xl font-bold text-fuchsia-500 hover:text-fuchsia-600 transition duration-200">{{ get_option('site_short_name') }}</h1>
        </a>
    </div>

    <div class="flex items-center">
        <a href="{{ route('index') }}" class="px-3 py-1 border-b {{ isCurrentUrl(route('index'), 'text-fuchsia-500 border-fuchsia-500') }} hover:text-fuchsia-500 hover:border-fuchsia-500 transition duration-200">{{ __('Home') }}</a>
        
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
    </div>
</nav>