@if (checkGate('manage_blog') || checkGate('manage_categories'))
<div x-data="{ isOpen: {{ isActive('module.blog.*', 'true', 'false') }} }" class='mb-3'>
    <a href="#" @click='isOpen = !isOpen' :class='{ "text-teal-600": isOpen }' class="capitalize hover:text-teal-600 font-medium text-md transition ease-in-out duration-200">
        <i class="fad fa-rss text-xs mr-2"></i>                
        {{ __('Manage blog') }}
        <i :class='{ "transform rotate-90": isOpen }' class="float-right mt-2 text-xs fa fa-angle-right"></i>
    </a>
    <div x-show='isOpen' class='flex flex-wrap p-2 pl-3 bg-gray-300 rounded mb-2'>
        @can('manage_blog')
        <a href="{{ route('module.blog.posts.create') }}" class="capitalize {{ isActive('module.blog.posts.create', 'text-teal-600') }} hover:text-teal-600 font-medium text-md transition ease-in-out duration-200">
            <i class="fad fa-angle-right text-xs mr-2"></i>                
            {{ __('Create post') }}
        </a>
        
        <a href="{{ route('module.blog.posts.index') }}" class="capitalize {{ isActive('module.blog.posts.index', 'text-teal-600') }} hover:text-teal-600 font-medium text-md transition ease-in-out duration-200">
            <i class="fad fa-angle-right text-xs mr-2"></i>                
            {{ __('Manage posts') }}
        </a>
        @endcan

        @can('manage_categories')
            <a href="{{ route('module.blog.categories.index') }}" class="mb-2 capitalize font-medium text-md {{ isActive('module.blog.categories.*', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
                <i class="fad fa-ribbon text-xs mr-2"></i>                
                {{ __('Manage categories') }}
            </a>
        @endcan
    </div>
</div>
@endif

