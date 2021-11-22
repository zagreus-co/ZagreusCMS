@if (is_null($menu_item_gate) || !is_null($menu_item_gate) && checkGate($menu_item_gate))
<div
    @if(strpos($menu_item_route, '*') !== false) x-data="{ isOpen: {{ isActive('module.analytics.*', 'true', 'false') }} }" @endif
    class='mb-3'>
    <a
        @if(strpos($menu_item_route, '*') !== false) @click='isOpen = !isOpen' @endif
        href="{{ strpos($menu_item_route, '*') !== false ? 'javascript:void(0)' : route($menu_item_route) }}"
        class="font-medium text-md {{ isActive($menu_item_route, 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
            <i class="{{$menu_item_icon}} text-xs mr-2"></i>                
            {{ $menu_item_text }}
            @if(strpos($menu_item_route, '*') !== false)
                <i :class='{ "transform rotate-90": isOpen }' class="float-right mt-2 text-xs fa fa-angle-right"></i>
            @endif
    </a>
    @if (strpos($menu_item_route, '*') !== false)
        <div x-show='isOpen' class='flex flex-wrap p-2 pl-3 bg-gray-300 rounded mb-2'>
            @foreach($menu_item_extra['dropdowns'] as $dropdown)
            <a href="{{ route($dropdown['menu_item_route']) }}" class="{{ isActive($dropdown['menu_item_route'], 'text-teal-600') }} hover:text-teal-600 font-medium text-md transition ease-in-out duration-200">
                <i class="{{$dropdown['menu_item_icon']}} text-xs mr-2"></i>                
                {{ $dropdown['menu_item_text'] }}
            </a>
            @endforeach
        </div>
    @endif
</div>
@endif