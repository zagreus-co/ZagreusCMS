<!DOCTYPE html>
<html lang="en">
@themeInclude('partials.head')
<body class="bg-gray-100">
    @themeInclude('partials.header')
    
    <section class="px-20 mt-10">
        <div class='grid md:grid-cols-12 sm:grid-cols-1 gap-5'>
            <div class="md:col-span-8">
                    @foreach( $datas as $data )
                    <div class="overflow-hidden bg-white rounded-lg shadow-md mb-3">
                        
                        @if ($data->cover) 
                            <img class="object-cover w-full h-128" src="{{$data->cover}}" alt="Article">
                        @endif
                        <div class="p-6">
                            <div>
                                <span class="text-xs font-medium text-blue-600 uppercase dark:text-blue-400">{{ $data->category->title ?? '' }}</span>
                                <a href="{{ route('module.blog.posts.openBySlug', $data->slug) }}" class="block mt-2 text-2xl font-semibold text-gray-800 hover:text-gray-600 transition duration-200">{{ $data->title }}</a>
                                <p class="mt-2 text-sm text-gray-600">{{ sanitizeContent($data->content, 185) . '[...]' }}</p>
                            </div>

                            <div class="mt-4 flex justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <img class="object-cover h-10 rounded-full" src="https://zagreus.company/assets/images/ZagreusDevs-logo.svg" alt="Avatar">
                                        <a href="#" class="mx-2 font-semibold text-gray-700">{{ $data->user->full_name ?? '' }}</a>
                                    </div>
                                    <span class="mx-1 text-xs text-gray-600">{{ $data->created_at->ago() }}</span>
                                </div>

                                @php
                                    $route = 'module.blog.posts.openBySlug';
                                    if ($data->categoryable_type == 'Modules\Page\Entities\Page')
                                        $route = 'module.page.show'
                                @endphp
                                <a href="{{ route($route, $data->slug) }}" class="text-fuchsia-600 hover:text-fuchsia-500">Read more</a>

                            </div>
                        </div>
                    </div>
                    @endforeach
                <!--  -->

            </div>
            <div class="md:col-span-4"> @themeInclude("partials.sidebar") </div>
        </div>
    </section>

    @themeInclude('partials.footer')
</body>
</html>