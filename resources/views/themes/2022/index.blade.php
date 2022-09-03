<!DOCTYPE html>
<html lang="en">
@themeInclude('partials.head')
<body>
    @themeInclude('partials.header')

    <section class="px-20 mt-10">
        <header class='mb-6'>
            <h2 class=" text-8xl font-bold">The Blog</h2>
        </header>

        @php ($posts = blogPosts())

        <article class='grid grid-cols-2 gap-4'>
            <div>
                <img class='w-full rounded-md' src="{{ $posts[0]->cover ?? '' }}" alt="{{ $posts[0]->title }}">
            </div>
            <div>
                <time class="text-gray-500 text-sm" datetime="{{ $posts[0]->created_at->format('Y-m-d') }}">{{ $posts[0]->created_at->format('F j, Y') }}</time>
                <h3 class="text-4xl font-bold mt-1">{{ $posts[0]->title }}</h3>
                <p>
                    {{ sanitizeContent($posts[0]->content, 950) . '...' }}
                    <a href="{{ route('module.blog.posts.openBySlug', $posts[0]->slug) }}" class="text-fuchsia-600 hover:text-fuchsia-500">[Read more]</a>
                </p>
            </div>
        </article>

        <section class="grid grid-cols-3 gap-4 mt-12">
            @foreach($posts as $post)
                @if ($loop->iteration == 1) @continue @endif
                <article class='grid grid-cols-1 gap-2'>
                    <div>
                        <img class='w-full rounded-md' src="{{ $post->cover ?? '' }}" alt="{{ $post->title }}">
                    </div>
                    <div>
                        <time class="text-gray-500 text-sm" datetime="{{ $post->created_at->format('Y-m-d') }}">{{ $post->created_at->format('F j, Y') }}</time>
                        <h3 class="text-4xl font-bold mt-1">{{ $post->title }}</h3>
                        <p>
                            {{ sanitizeContent($post->content) . '...' }}
                            <a href="{{ route('module.blog.posts.openBySlug', $post->slug) }}" class="text-fuchsia-600 hover:text-fuchsia-500">[Read more]</a>
                        </p>
                    </div>
                </article>
            @endforeach
        </section>


    </section>

    @themeInclude('partials.footer')

</body>
</html>