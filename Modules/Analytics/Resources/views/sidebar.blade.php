@can('manage_analytics')
<div x-data="{ isOpen: {{ isActive('module.analytics.*', 'true', 'false') }} }" class='mb-3'>
    <a href="#" @click='isOpen = !isOpen' :class='{ "text-teal-600": isOpen }' class="capitalize hover:text-teal-600 font-medium text-md transition ease-in-out duration-200">
        <i class="fad fa-analytics text-xs mr-2"></i>                
        {{ __('Analytics') }}
        <i :class='{ "transform rotate-90": isOpen }' class="float-right mt-2 text-xs fa fa-angle-right"></i>
    </a>
    <div x-show='isOpen' class='flex flex-wrap p-2 pl-3 bg-gray-300 rounded mb-2'>
        <a href="{{ route('module.analytics.index') }}" class="capitalize {{ isActive('module.analytics.index', 'text-teal-600') }} hover:text-teal-600 font-medium text-md transition ease-in-out duration-200">
            <i class="fad fa-angle-right text-xs mr-2"></i>                
            {{ __('View analytics') }}
        </a>
        
        <a href="{{ route('module.analytics.rules') }}" class="capitalize {{ isActive('module.analytics.rules', 'text-teal-600') }} hover:text-teal-600 font-medium text-md transition ease-in-out duration-200">
            <i class="fad fa-angle-right text-xs mr-2"></i>                
            {{ __('Analytic rules') }}
        </a>
    </div>
</div>

@endcan