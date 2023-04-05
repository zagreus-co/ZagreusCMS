<div class="flex justify-end">
    <div x-data="{
        open: false,
        toggle() {
            if (this.open) {
                return this.close()
            }
    
            this.$refs.button.focus()
    
            this.open = true
        },
        close(focusAfter) {
            if (!this.open) return
    
            this.open = false
    
            focusAfter && focusAfter.focus()
        }
    }" x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['dropdown-button']" class="relative">
        <!-- Button -->
        <button x-ref="button" x-on:click="toggle()" :aria-expanded="open" :aria-controls="$id('dropdown-button')"
            type="button" class="flex items-center gap-2 bg-white px-5 py-2.5 rounded-md shadow">
            {{ __('Hidden columns') }}

            <!-- Heroicon: chevron-down -->
            <svg xmlns="http://www.w3.org/2000/svg" :class="open ? 'transform rotate-180' : ''" class="transition duration-200 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Panel -->
        <div x-ref="panel" x-show="open" x-transition.origin.top.left x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')" style="display: none;"
            class="absolute left-0 mt-2 w-40 rounded-md bg-white shadow-md">

            @foreach (collect($columns)->filter(fn($item) => isset($item['hidden']))->toArray() as $key => $column)
                <button wire:click="toggleHiddenColumn('{{ $key }}')"
                    class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500 {{ $column['hidden'] ? 'text-gray-500' : '' }} ">
                    <span>{{ $column['remark'] }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>
