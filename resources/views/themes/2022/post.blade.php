<!DOCTYPE html>
<html lang="en">
@themeInclude('partials.head')
<body>
    @themeInclude('partials.header')
    <article class='px-20 mt-4'>
        <section class="flex items-center justify-between">
            <div class="flex items-center">
                <img class="object-cover h-10 rounded-full" src="https://zagreus.company/assets/images/ZagreusDevs-logo.svg" alt="Avatar">
                
                <div class="ml-2">
                    <a href="#" class="font-semibold text-gray-700 block">{{ $post->user->full_name }}</a>
                    <small class="text-gray-500">
                        {{ $post->created_at->format('F j, Y') }}
                        <span> - {{ round(str_word_count(strip_tags($post->content)) / 165) }} min read</span>
                    </small>
                </div>
            </div>

            <a href="{{ route('index') }}" class="px-3 py-1 hover:text-fuchsia-500 transition duration-200">Back to Home</a>
        </section>

        <header class="mt-5">
            <h1 class='text-5xl'>{{ $post->title }}</h1>
            @if ($post->cover)
                <img class='w-full rounded-md mt-2' src="{{ $post->cover }}" alt="{{ $post->title }}">
            @endif
        </header>

        <p class="mt-6">{!! $post->content !!}</p>

    </article>

    <section class='px-20 mt-4'>
        @if ($comments->count() == 0)
            <div class="rounded shadow-md p-3 text-white text-lg bg-blue-400 mb-3">{{__('There is no comment submitted yet, be the first one!')}}</div>
        @else
            @themeInclude('partials.comments', compact('comments'))
        @endif

        <div class="overflow-hidden bg-gray-100 rounded-lg shadow-md mb-3">
            <div class="p-6">
                <h4 class="h4 mt-3">{{__('Submit your comment')}}</h4>
                <hr>
                @themeInclude('partials.comment-form', compact('post'))
            </div>
        </div>
    </section>
    @themeInclude('partials.footer')
</body>
</html>