@can('manage_analytics')
<a href="{{ route('module.analytics.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('module.analytics.*', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="fad fa-analytics text-xs mr-2"></i>                
    {{ __('Analytics') }}
</a>
@endcan