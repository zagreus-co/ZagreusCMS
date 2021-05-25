@can('manage_users')
<a href="{{ route('module.user.users.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('module.user.users.*', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="fad fa-users text-xs mr-2"></i>                
    {{ __('Manage users') }}
</a>
@endcan