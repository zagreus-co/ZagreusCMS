@can('manage_options')
<a href="{{ route('module.options.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('module.options.index', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="fad fa-clipboard-list text-xs mr-2"></i>                
    {{ __('Manage options') }}
</a>
@endcan
