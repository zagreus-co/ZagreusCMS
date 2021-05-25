@can('manage_comments')
<a href="{{ route('module.comment.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('module.comment.index', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="fad fa-comment text-xs mr-2"></i>                
    {{ __('Manage comments') }}
</a>
@endcan
