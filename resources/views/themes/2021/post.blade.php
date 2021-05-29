<!DOCTYPE html>
<html lang="en">
@themeInclude('partials.head')
<body>
    @themeInclude('partials.header')
    <section class='container mt-4'>
        <div class='grid md:grid-cols-12 sm:grid-cols-1 gap-5'>
            <div class="md:col-span-8">
                <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mb-3">
                    @if ($post->cover) 
                        <img class="object-cover w-full h-128" src="{{$post->cover}}" alt="Article">
                    @endif
                    <div class="p-6">
                        <div>
                            <span class="text-xs font-medium text-blue-600 uppercase dark:text-blue-400">{{ $post->category->title ?? '-' }}</span>
                            <a href="{{ route('module.blog.posts.openBySlug', $post->slug) }}" class="block mt-2 text-2xl font-semibold text-gray-800 dark:text-white hover:text-gray-600 hover:underline">{{ $post->title }}</a>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{!! $post->content !!}</p>
                        </div>

                        <div class="mt-4 flex justify-between">
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <img class="object-cover h-10 rounded-full" src="https://zagreus.company/assets/images/ZagreusDevs-logo.svg" alt="Avatar">
                                    <a href="#" class="mx-2 font-semibold text-gray-700 dark:text-gray-200">{{ $post->user->full_name }}</a>
                                </div>
                                <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">{{ $post->created_at->ago() }}</span>
                            </div>

                        </div>
                    </div>
                </div>
                @if ($comments->count() == 0)
                    <div class="rounded shadow-md p-3 text-white text-lg bg-blue-400 mb-3">{{__('There is no comment submitted yet, be the first one!')}}</div>
                @else
                    @themeInclude('partials.comments', compact('comments'))
                @endif

                <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mb-3">
                    <div class="p-6">
                        <h4 class="h4 mt-3">{{__('Submit your comment')}}</h4>
                        <hr>
                        @themeInclude('partials.errors-alert')
                        <form action="{{ route('module.comment.submit') }}" method="post" class='mt-3'>
                            @csrf
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
                    </div>
                </div>

            </div>
            <div class="md:col-span-4"> @themeInclude("partials.sidebar") </div>
        </div>
    </section>
    @themeInclude('partials.footer')
</body>
</html>