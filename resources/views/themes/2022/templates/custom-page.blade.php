{{-- name: Custom page name --}}
<!DOCTYPE html>
<html lang="en">
@themeInclude('partials.head')
<body class="bg-gray-50">
    
    {{-- IMPORTANT NOTE: --}}
    {{-- This page is only create for demonstrating how you can create custom pages and design it in a different way --}}
    
    @themeInclude('partials.header')
    <article class='px-20 mt-4'>
        <section class="flex items-center justify-between">
            <small class="text-gray-500">
                {{ $page->created_at->format('F j, Y') }}
                <span> - {{ round(str_word_count(strip_tags($page->content)) / 165) }} min read</span>
            </small>

            <a href="{{ route('index') }}" class="px-3 py-1 hover:text-fuchsia-500 transition duration-200">Back to Home</a>
        </section>

        <header class="mt-1">
            <h1 class='text-5xl'>{{ $page->title }}</h1>
            @if ($page->cover)
                <img class='w-full rounded-md mt-2' src="{{ $page->cover }}" alt="{{ $page->title }}">
            @endif
        </header>

        <div class="mt-2 py-3 px-6 rounded-md bg-white shadow">{!! $page->content !!}</div>

    </article>
    @themeInclude('partials.footer')
</body>
</html>