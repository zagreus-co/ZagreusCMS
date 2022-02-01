<!DOCTYPE html>
<html lang="en">
@themeInclude('partials.head')
<body class='dark:bg-gray-900'>
    @themeInclude('partials.header')

    <section class="bg-gradient-to-r from-emerald-400 to-emerald-600 text-white z-0 relative">
        <div class="container px-6 py-8 mx-auto text-center">
            <h1 class='text-4xl font-bold'>{{ get_option('site_short_name') }}</h1>
            <p class='text-xl mt-2 text-gray-50'>{{ get_option('site_description') }}</p class='text-md mt-2'>
        </div>
    </section>

    <section class='px-28 mt-4'>
        <div class='grid md:grid-cols-12 sm:grid-cols-1 gap-4'>
            <div class="md:col-span-8">
                <!--  -->
                    @foreach( blogPosts(10) as $post )
                    <div class="overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-md mb-3">
                        
                        @if ($post->cover) 
                            <img class="object-cover w-full h-128" src="{{$post->cover}}" alt="{{ $post->title }}">
                        @endif
                        <div class="p-6">
                            <div>
                                <span class="text-xs font-medium text-emerald-600 uppercase dark:text-emerald-500">{{ $post->category->title ?? '-' }}</span>
                                <a href="{{ route('module.blog.posts.openBySlug', $post->slug) }}" class="block mt-2 text-2xl font-semibold text-gray-800 dark:text-white hover:text-gray-600 dark:hover:text-gray-200 transition duration-150">{{ $post->title }}</a>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ \Str::words( strip_tags($post->content), 40, ' [...]') }}</p>
                            </div>

                            <div class="mt-4 flex justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <img class="object-cover h-10 rounded-full" src="https://zagreus.company/assets/images/ZagreusDevs-logo.svg" alt="Avatar">
                                        <a href="#" class="mx-2 font-semibold text-gray-700 dark:text-gray-200">{{ $post->user->full_name }}</a>
                                    </div>
                                    <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">{{ $post->created_at->ago() }}</span>
                                </div>

                                <a href="{{ route('module.blog.posts.openBySlug', $post->slug) }}" class="hidden md:block px-4 pt-3 pb-2 mt-2 text-xs font-bold text-white uppercase transition-colors duration-200 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 rounded focus:outline-none">{{ __('Read more') }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                <!--  -->

                {{ blogPosts(10)->links() }}
            </div>
            <div class="md:col-span-4"> @themeInclude("partials.sidebar") </div>
        </div>
    </section>

    @themeInclude('partials.footer')

</body>
</html>