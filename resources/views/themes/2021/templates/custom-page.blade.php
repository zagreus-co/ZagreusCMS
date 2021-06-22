<!-- name: Custom page -->
<!DOCTYPE html>
<html lang="en">
@themeInclude('partials.head')
<body>
    @themeInclude('partials.header')
    <section class='container mt-4'>
        <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mb-3">
            @if ($page->cover) 
                <img class="object-cover w-full h-128" src="{{$page->cover}}" alt="Article">
            @endif
            <div class="p-6">
                <div>
                    <a href="{{ route('module.page.show', $page->slug) }}" class="block mt-2 text-2xl font-semibold text-gray-800 dark:text-white hover:text-gray-600 hover:underline">{{ $page->title }}</a>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{!! $page->content !!}</p>
                </div>

                <div class="mt-4 flex justify-between">
                    <div class="flex items-center">
                        
                        <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">{{ $page->created_at->ago() ?? '-' }}</span>
                    </div>

                </div>
            </div>
        </div>
    </section>
    @themeInclude('partials.footer')
</body>
</html>