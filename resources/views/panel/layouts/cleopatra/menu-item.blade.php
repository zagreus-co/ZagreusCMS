<a href="{{ route($menu_item_route) }}" class="mb-3 capitalize font-medium text-md {{ isActive($menu_item_route, 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
    <i class="{{$menu_item_icon}} text-xs mr-2"></i>                
    {{ $menu_item_text }}
</a>