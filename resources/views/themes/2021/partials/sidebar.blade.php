<div class="max-w-2xl px-8 py-4 mx-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
    <h3 class='text-lg mb-1 font-bold'>Categories</h3>
    <hr class='mb-3'>
    @foreach(\Modules\Blog\Entities\Category::all() as $category)
        <a href="{{ route('module.blog.categories.view', $category->slug) }}" class='text-lg block'>
            {{$category->title}}
            ({{ $category->posts()->wherePublished(1)->count() }})
        </a>
    @endforeach
</div>