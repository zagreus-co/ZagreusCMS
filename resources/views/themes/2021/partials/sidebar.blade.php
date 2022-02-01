<div class="px-8 py-4 mx-auto bg-white rounded-lg shadow-md dark:bg-gray-700 dark:text-gray-100 ">
    <h3 class='text-lg mb-3 pb-2 font-bold border-b border-gray-100'>Categories</h3>
    
    @foreach(\Modules\Blog\Entities\Category::all() as $category)
        <a href="{{ route('module.blog.categories.view', $category->slug) }}" class='text-lg block hover:text-emerald-700 dark:hover:text-emerald-500 transition duration-200'>
            {{$category->title}}
            ({{ $category->posts()->wherePublished(1)->count() }})
        </a>
    @endforeach
</div>