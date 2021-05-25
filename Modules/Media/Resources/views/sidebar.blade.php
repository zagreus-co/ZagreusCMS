@can('manage_media')
<a href="{{ route('module.media.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('module.media.index', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="fad fa-folder-open text-xs mr-2"></i>                
    {{ __('Manage medias') }}
</a>
@endcan
