@extends(panelLayout())

@section('content')
<div class="flex items-center justify-between mb-1">
    <h5 class="font-bold">{{ __('Create new post') }}</h5>
    <a href='{{ route("module.blog.posts.index") }}' class='btn btn-sm btn-secondary'>{{__('Back')}}</a>
</div>

<form action="{{ route('module.blog.posts.update', $post->id) }}" method="post" class='grid grid-cols-1 md:grid-cols-12 gap-4'>
@csrf
@method('PATCH')
<div class="col-span-12"> @panelView('errors-alert') </div>

<div class="col-span-12 md:col-span-8">
    <div class="card mb-3" x-data="{tab: '{{config('app.locale')}}'}">
        <div class="p-2 bg-gray-200 rounded flex flex-nowrap items-center overflow-x-auto space-x-1 {{ app()->getLocale() == 'fa' ? 'space-x-reverse' : '' }}">
            @foreach(locales() as $locale => $value)
                <button :class="tab == '{{$locale}}' ? 'btn-dark' : 'btn-secondary'" @click.prevent="tab = '{{$locale}}'" class="btn btn-sm" type='button'>{{$value}}</button>
            @endforeach
        </div>
        @php $defaultLocale = app()->getLocale(); @endphp
        @foreach(locales() as $locale => $value)
        @php \App::setLocale($locale); @endphp
        <div class="card-body" x-show="tab === '{{$locale}}'">
            <!--  -->
            <div class="form-group">
                <label>{{__('Title')}}</label>
                <input type="text" name='{{$locale}}[title]' value='{{ old($locale.".title", $post->title) }}' class="form-control">
            </div>

            <div class='mt-3' x-data="{ generate: false }">
                <div class="form-group" x-show='generate == false'>
                    <label for="slug">{{__('Slug')}}</label>
                    <input type="text" name='{{$locale}}[slug]' value='{{ old($locale.".slug", $post->slug) }}' class="form-control">
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" @click='generate = !generate' name='{{$locale}}[generate_slug]' class="form-check-input">
                        {{__('Generate automatic and SEO-Friendly slug')}}
                    </label>
                </div>
            </div>

            <div class="form-group mt-4">
                <label for="content">{{__('Content')}}</label>
                <textarea type="text" name='{{$locale}}[content]' class="tinymce">{{ old($locale.".content", $post->content) }}</textarea>
            </div>
            <!--  -->
        </div>
        @endforeach
        @php \App::setLocale($defaultLocale); @endphp

    </div>

    <x-media.attachment-input current='{!!$post->medias()->whereTag("attachment")->select("filename")->get()->pluck("filename")->toJson()!!}' />
</div>
<div class="col-span-12 md:col-span-4">

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label>{{__('Category')}}</label>
                <select name="category_id" class="form-control">
                    <option value="0">{{__('None')}}</option>
                    @foreach(\Modules\Blog\Entities\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? "selected" : "" }}>{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            @php $themeTemplates = themeTemplates() @endphp
            @if (!is_null($themeTemplates) && count($themeTemplates) > 0)
            <div class="form-group mt-4">
                <label>{{__('Template')}}</label>
                <select name="template" class="form-control">
                    <option value="null">{{__('None')}}</option>
                    @foreach($themeTemplates as $filename => $name)
                    <option value="{{ $filename }}" {{ $filename == $post->template ? 'selected' : ''}}>{{ $name ?? $filename }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-group mt-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name='can_comment' class="form-check-input" @if ($post->can_comment) checked @endif />
                        {{__('Allow comment')}}
                    </label>
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name='published' class="form-check-input" @if ($post->published) checked @endif />
                        {{__('Published')}}
                    </label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type='submit' class="btn btn-primary">{{__('Update')}}</button>
        </div>
    </div>

    @php
        $image = '';
        if ($post->medias()->whereTag('cover')->first())
            $image = $post->medias()->whereTag('cover')->first()->filename;
    @endphp
    
    <x-media.cover-upload-input current='{{ $image }}' />
    <x-keywords parent='card' child='card-body' inputClass='form-control'  current='{!! json_encode($post->keywords->pluck("keyword")->toArray()) !!}'/>

</div>
</form>

@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/jsivzzwvsphsomapw3muccbxcuiq0iuc85r87ujaj5zd4lv0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({ 
        selector:'textarea.tinymce', 
        plugins: 'preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        height : "480",
        relative_urls: false
    });
</script>
<x-keywords-script />
@endpush
