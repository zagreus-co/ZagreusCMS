<div wire:loading @if (isset($target)) wire:target='{{ $target }}' @endif
    class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-[100] overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
    <div class="my-72 px-4">
        <div style='border-top-color: #48bb78;'
            class="mx-auto animate-spin ease-linear rounded-full border-4 border-t-4 border-g border-gray-200 h-12 w-12 mb-4">
        </div>
        <h2 class="text-center text-white text-xl font-semibold">{{ __('Loading') }} ...</h2>
        <p class="text-center text-white">
            {{ __('This operation may take a few seconds. Please do not close this page') }}
        </p>
    </div>
</div>
