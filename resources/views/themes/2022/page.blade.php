<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->getLocale() == 'fa') dir="rtl" @endif >
@themeInclude('partials.head')
<body class="bg-gray-50">
    @themeInclude('partials.header')
    <article class='px-6 md:px-14 lg:px-20 mt-4'>
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

        <div class="mt-6">{!! $page->content !!}</div>

    </article>
    @themeInclude('partials.footer')
</body>
</html>