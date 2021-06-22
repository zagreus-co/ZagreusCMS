@extends(panelLayout())

@section('content')
<form action="{{ route('module.page.store') }}" method="post" class='grid grid-cols-12 md:grid-cols-1 gap-4'>
@csrf
<div class="col-span-12"> @panelView('errors-alert') </div>

<div class="col-span-8 md:col-span-12">
    <div class="card" x-data="{tab: '{{config('app.locale')}}'}">
        <div class="p-2 bg-gray-200 flex flex-nowrap overflow-x-auto">
            @foreach(locales() as $locale => $value)
                <button :class="{ 'bg-blue-400': tab == '{{$locale}}' }" @click.prevent="tab = '{{$locale}}'" class="btn btn-info inline mr-2" type='button'>{{$value}}</button>
            @endforeach
        </div>
        @php $defaultLocale = app()->getLocale(); @endphp
        @foreach(locales() as $locale => $value)
        @php \App::setLocale($locale); @endphp
        <div class="card-body" x-show="tab === '{{$locale}}'">
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
            
            <div class="form-group mt-3">
                <label for="content" class="mb-3">{{__('Content')}}</label>
                <textarea type="text" name='{{$locale}}[content]'>{{ old($locale.".content") }}</textarea>
            </div>
        </div>
        @endforeach
        @php \App::setLocale($defaultLocale); @endphp
    </div>
</div>
<div class="col-span-4 md:col-span-12">

    <div class="card">
        <div class="card-body">

            @if (themeTemplates())
            <div class="form-group mb-4">
                <label>{{__('Template')}}</label>
                <select name="template" class="form-control">
                    @foreach(themeTemplates() as $filename => $name)
                    <option value="{{ $filename }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-group mb-4">
                <label>{{__('Status')}}</label>
                <select name="published" class="form-control">
                    <option value="1">{{__('Published')}}</option>
                    <option value="0">{{__('Draft')}}</option>
                </select>
            </div>
            
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" name='display_in_header' class="form-check-input" checked>
                    {{__('Show in header')}}
                </label>
            </div>

            <div class="form-check mt-2">
                <label class="form-check-label">
                    <input type="checkbox" name='can_comment' class="form-check-input">
                    {{__('Allow to comment')}}
                </label>
            </div>
        </div>

        <div class="card-footer">
            <button type='submit' class="btn-success">{{__('Create')}}</button>
        </div>
</div>
</div>
</form>
@endsection

@section('script')
<script src="https://cdn.tiny.cloud/1/jsivzzwvsphsomapw3muccbxcuiq0iuc85r87ujaj5zd4lv0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector:'textarea', plugins: 'code',height : "480"});</script>
@endsection