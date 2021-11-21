@extends(panelLayout())

@section('content')
<form action="{{ route('module.blog.posts.store') }}" method="post" class='grid grid-cols-12 md:grid-cols-1 gap-4'>
@csrf
<div class="col-span-12"> @panelView('errors-alert') </div>

<div class="col-span-8 md:col-span-12">
    <div class="card mb-3" x-data="{tab: '{{config('app.locale')}}'}">
        <div class="p-2 bg-gray-200 flex flex-nowrap overflow-x-auto">
            @foreach(locales() as $locale => $value)
                <button :class="{ 'bg-blue-400': tab == '{{$locale}}' }" @click.prevent="tab = '{{$locale}}'" class="btn btn-info inline mr-2" type='button'>{{$value}}</button>
            @endforeach
        </div>
        @php $defaultLocale = app()->getLocale(); @endphp
        @foreach(locales() as $locale => $value)
        @php \App::setLocale($locale); @endphp
        <div class="card-body" x-show="tab === '{{$locale}}'">
            <!--  -->
            <div class="form-group">
                <label>{{__('Title')}}</label>
                <input type="text" name='{{$locale}}[title]' value='{{ old($locale.".title") }}' class="form-control">
            </div>

            <div class='mt-3' x-data="{ generate: true }">
                <div class="form-group" x-show='generate == false'>
                    <label for="slug">{{__('Slug')}}</label>
                    <input type="text" name='{{$locale}}[slug]' value='{{ old($locale.".slug") }}' class="form-control">
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" @click='generate = !generate' name='{{$locale}}[generate_slug]' class="form-check-input" checked>
                        {{__('Generate automatic and SEO-Friendly slug')}}
                    </label>
                </div>
            </div>

            <div class="form-group mt-4">
                <label for="content">{{__('Content')}}</label>
                <textarea type="text" name='{{$locale}}[content]' class="tinymce">{{ old($locale.".content") }}</textarea>
            </div>
            <!--  -->
        </div>
        @endforeach
        @php \App::setLocale($defaultLocale); @endphp

    </div>

    <x-media.attachment-input />
</div>
<div class="col-span-4 md:col-span-12">

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label>{{__('Category')}}</label>
                <select name="category_id" class="form-control">
                    <option value="0">{{__('None')}}</option>
                    @foreach(\Modules\Blog\Entities\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            @php ($themeTemplates = themeTemplates())
            @if (!is_null($themeTemplates) && count($themeTemplates) > 0)
            <div class="form-group mt-4">
                <label>{{__('Template')}}</label>
                <select name="template" class="form-control">
                    <option value="null">{{__('None')}}</option>
                    @foreach($themeTemplates as $filename => $name)
                    <option value="{{ $filename }}">{{ $name ?? $filename }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-group mt-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name='can_comment' class="form-check-input" checked>
                        {{__('Allow comment')}}
                    </label>
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name='published' class="form-check-input" checked>
                        {{__('Published')}}
                    </label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type='submit' class="btn-success">{{__('Create')}}</button>
        </div>
    </div>

    <x-media.cover-upload-input />
    <x-keywords parent='card' child='card-body' inputClass='form-control'/>
</div>
</form>

@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/jsivzzwvsphsomapw3muccbxcuiq0iuc85r87ujaj5zd4lv0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector:'textarea.tinymce', plugins: 'code',height : "480"});</script>
<x-keywords-script />
@endpush