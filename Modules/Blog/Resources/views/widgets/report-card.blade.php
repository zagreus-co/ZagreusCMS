<div class="card hover:shadow">
    <div class="card-header">
        <h5>{{__('Total posts')}}</h5>
        <span class="icon-area">
            🔊
        </span>
    </div>
    <div class="card-body">
        <h6 class="font-bold inline-block">{{ number_format(\Modules\Blog\Entities\Post::count()) }}</h6>
    </div>
</div>