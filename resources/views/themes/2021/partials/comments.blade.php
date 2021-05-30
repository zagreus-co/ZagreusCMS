@foreach($comments as $comment)
<div class="@if (isset($answered)) bg-gray-100 mt-3 @else bg-white @endif rounded-lg p-3 flex flex-col justify-center items-center md:items-start shadow-md mb-3 w-full">
    <div class="flex flex-row justify-center mr-2">
        <img alt="avatar" width="48" height="48" class="rounded-full w-10 h-10 mr-3 shadow-lg mb-4" src="{{ asset('img/avatar.png') }}">
        <h3 class="text-purple-600 font-semibold text-lg text-center md:text-left mt-2">
            {{ $comment->user->full_name ?? $comment->guest_name }}
            <small class='text-gray-400 text-sm'>({{ $comment->created_at->ago() }})</small>
        </h3>
    </div>

    <p class="text-gray-600 text-lg" id='comment_{{ $comment->id }}'>{{ $comment->comment }}</p>
    <button onclick='replyComment({{ $comment->id }})' class='bg-green-500 hover:bg-green-600 text-white rounded duration-300 p-2 px-3 mt-3'>{{ __('Reply') }}</button>
    @if ($comment->child()->wherePublished(1)->count() > 0)
        @themeInclude('partials.comments', ['comments'=> $comment->child()->wherePublished(1)->get(), 'answered'=> 'answered'])
    @endif
</div>
@endforeach