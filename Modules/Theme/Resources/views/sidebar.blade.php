@can('manage_themes')
<a href="{{ route('panel.theme.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('panel.theme.index', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="fad fa-brush text-xs mr-2"></i>                
    {{ __('Manage themes') }}
</a>
@endcan
