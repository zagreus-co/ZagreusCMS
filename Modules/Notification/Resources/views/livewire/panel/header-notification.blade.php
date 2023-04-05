<div class="relative inline-block" x-data='{open: false}' wire:poll.60s>
    <button @click='open = !open' :class="open ? 'bg-gray-100' : '' " x-transition class='text-xl rounded px-2 hover:bg-gray-100 transition duration-200'>
        <ion-icon class='mt-2 hydrated' name="notifications-outline"></ion-icon>
        @if ($unread_notifications > 0)
            <span class="bg-theme-primary text-white h-5 w-5 text-[12px] rounded-full absolute -bottom-1 -right-1">{{ $unread_notifications }}</span>
        @endif
    </button>
    <div x-show="open" @click.outside="open = false" class="dropdown-content -right-14 sm:-right-8 md:right-1 text-center" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-y-0 transform" x-transition:enter-end="opacity-100 scale-y-100 transform" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <a href="{{ route('module.notification.index') }}" class='block p-3 text-sm text-gray-500 hover:bg-gray-50 transition duration-200'>
            <span class="text-theme-primary">{{ $unread_notifications }}</span> {{ __('Unread notification') }}
        </a>
        @foreach($notifications as $notification)
            <div wire:click='seen({{ $notification->id }})' onclick="this.style.opacity = '0.2';" class="card flex-card hover:bg-theme-secondary items-center text-right cursor-pointer">
                @if (isset($notification->meta['icon_type']) && $notification->meta['icon_type'] == 'icon_font')
                <span class="border py-1 px-2 {{ !$notification->seen ? 'border-theme-primary text-theme-primary' : ''  }} rounded-full ml-3">
                    <ion-icon class="mt-1 md hydrated" name="{{ $notification->icon }}"></ion-icon>
                </span>
                @elseif (isset($notification->meta['icon_type']) && $notification->meta['icon_type'] == 'image_url')
                <img src="{{ $notification->icon }}" class="w-8 h-8 border {{ !$notification->seen ? 'border-theme-primary text-theme-primary' : ''  }} rounded-full ml-3">
                @else
                <span class="border py-1 px-2 {{ !$notification->seen ? 'border-theme-primary text-theme-primary' : ''  }} rounded-full ml-3">
                    <ion-icon class="mt-1 md hydrated" name="notifications-outline"></ion-icon>
                </span>
                @endif
                <div>
                    <div class="card-header">{{ $notification->title }}</div>
                    <small class="text-gray-500">{{ $notification->created_at->ago() }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
