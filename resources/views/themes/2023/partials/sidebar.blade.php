<div class="px-8 py-4 mx-auto rounded-lg shadow-md bg-white ">
    <h3 class='text-lg mb-3 pb-2 font-bold border-b border-gray-200'>Categories</h3>
    
    @foreach(\Modules\Blog\Entities\Category::all() as $category)
        <a href="{{ route('module.blog.categories.view', $category->slug) }}" class='text-lg block hover:text-fuchsia-500 transition duration-200'>
            {{$category->title}}
            ({{ $category->posts()->wherePublished(1)->count() }})
        </a>
    @endforeach
</div>