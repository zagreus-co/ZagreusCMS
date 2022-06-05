@if (is_null($menu_item_gate) || !is_null($menu_item_gate) && checkGate($menu_item_gate))
    <!-- When menu has dropdown -->
    @if (strpos($menu_item_route, '*') !== false)
        <ul class="dropdown-container" x-data="{ isOpen: {{ isActive($menu_item_route, 'true', 'false') }} }">
            <li @click="isOpen = !isOpen" :class="isOpen ? 'active' : ''">
                <a href="javascript:void(0)" :class="isOpen ? 'rounded-t-md' : ''">
                    <span>
                        <ion-icon name="{{ $menu_item_icon }}"></ion-icon>
                        {{ $menu_item_text }}
                        @if (isset($menu_item_extra['badge']) && $menu_item_extra['badge'] > 0)
                            <span class="badge badge-danger">{{ $menu_item_extra['badge'] }}</span>
                        @endif
                    </span>

                    <ion-icon name="chevron-down-outline"></ion-icon>
                </a>
            </li>
            <div x-show="isOpen" class="dropdown-items">
                @foreach($menu_item_extra['dropdowns'] as $dropdown)
                    <a href="{{ route($dropdown['menu_item_route']) }}" class="{{ isActive($dropdown['menu_item_route'], 'text-theme-primary') }} hover:text-theme-primary">
                        <ion-icon name="{{ $dropdown['menu_item_icon'] }}"></ion-icon>           
                        {{ $dropdown['menu_item_text'] }}
                    </a>
                @endforeach
            </div>
        </ul>
    @else
    <!-- sample menu item -->
        <li class="{{ isActive($menu_item_route, 'active') }}">
            <a href="{{ route($menu_item_route) }}">
                <ion-icon name="{{ $menu_item_icon }}"></ion-icon>
                {{ $menu_item_text }}

                @if (isset($menu_item_extra['badge']) && $menu_item_extra['badge'] > 0)
                    <span class="badge badge-danger mr-2">{{ $menu_item_extra['badge'] }}</span>
                @endif
            </a>
        </li>
    @endif
@endif