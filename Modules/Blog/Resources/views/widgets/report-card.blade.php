<div class="report-card">
    <div class="card">
        <div class="card-body flex flex-col">
            
            <!-- top -->
            <div class="flex flex-row justify-between items-center">
                <div class="h6 text-yellow-500 fad fa-rss"></div>
                
            </div>
            <!-- end top -->

            <!-- bottom -->
            <div class="mt-8">
                <h1 class="h5">{{ \Modules\Blog\Entities\Post::count() }}</h1>
                <p>{{__('Total posts')}}</p>
            </div>                
            <!-- end bottom -->

        </div>
    </div>
    <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
</div>