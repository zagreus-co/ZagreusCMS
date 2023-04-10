<div class='card'>
    <div class="card-header justify-between mb-3">
        <strong>{{ __("Select user") }}</strong>

        <div class="form-check">
            <input wire:model='only_staff' class="form-check-input" type="checkbox" id="only_staff">
            <label class="form-check-label" for="only_staff">{{ __('Only staffs') }}</label>
        </div>
    </div>
    <div x-data="{showResult: false, selected: @entangle('selected'), view_mode: @entangle('view_mode') }" @click.outside="showResult = false" class="card-body relative">        
        <!-- Hidden multiple selectbox that allows to get the selected users on the HTTP form requests -->

        <div wire:loading.inline>
            <ion-icon class="z-50 {{ empty($selected) ? 'text-theme-primary' : 'text-white' }} animate-spin absolute top-3 left-3 hydrated" name="reload-outline"></ion-icon>
        </div>

        
        <input 
            @keyup="showResult = true"
            @click="showResult = true"
            type="text" 
            wire:model="search_input" 
            placeholder='{{ __("Name, username or ID") }}' 
            class="form-control">
        
        <!-- Users list -->
        <div 
            @if ($view_mode == "absolute" ) 
            x-show="showResult"
            :class="view_mode == 'absolute' ? 'absolute w-full' : ''"
            @endif
            class='rounded-b-md bg-gray-100 overflow-y-scroll max-h-[140px]'
        >
            @if ($selected)
                <button type='button' wire:click='selectUser({{ $selected->id }})' class="btn btn-success w-full text-right rounded-b-md"> <span class='text-blue-700'>({{ $selected->id }})</span> {{ $selected->full_name }}</button>
            @else
                @foreach($users as $user)
                    <button type='button' wire:click='selectUser({{ $user->id }})' class="btn btn-light w-full text-right {{ $loop->last ? 'rounded-b-md' : 'rounded-none' }}"> <span class='text-blue-700'>({{ $user->id }})</span> {{ $user->full_name }}</button>
                @endforeach
            @endif
        </div>
    </div>
</div>