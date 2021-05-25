@can('manage_pages')
<a href="{{ route('module.page.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('module.page.*', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="fad fa-pager text-xs mr-2"></i>                
    {{ __('Manage pages') }}
</a>
@endcan