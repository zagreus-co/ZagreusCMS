@themeInclude('partials.errors-alert')
<form action="{{ route('module.comment.submit') }}" method="post" class='mt-3' id='commentReplyForm'>
    @csrf
    <div class="p-3 bg-gray-300 hidden" id='replyTo'>
        <div class="flex justify-between">
            <strong>In reply to:</strong>
            <button type='button' onclick='closeReply()' class="btn-danger p-1">X</button>
        </div>
        <p></p>
    </div>
    <input type="hidden" name="commentable_id" value='{{ $post->id }}'>
    <input type="hidden" name="commentable_type" value='{{ get_class($post) }}'>
    <input type="hidden" name="parent_id" value='0'>
    @guest
    <input type="text" name="guest_name" placeholder='{{ __("Full name") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
    <input type="text" name="guest_contact" placeholder='{{ __("Email address") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
    @endguest
    <textarea name="comment" rows="6" placeholder='Please enter your comment here' class='block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring'></textarea>

    <button class='bg-green-500 hover:bg-green-600 text-white rounded duration-300 p-2 px-3 mt-3'>{{ __('Submit comment') }}</button>
</form>