@extends(panelLayout())

@section('content')
<form action="{{ route('module.blog.categories.store') }}" method="post" class='grid grid-cols-12 md:grid-cols-1 gap-4'>
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
            <!--  -->
        </div>
        @endforeach
        @php \App::setLocale($defaultLocale); @endphp
    </div>
</div>
<div class="col-span-4 md:col-span-12">

    <div class="card">
        <div class="card-body">

            <div class="form-group mb-4">
                <label>{{__('Parent')}}</label>
                <select name="parent_id" class="form-control">
                    <option value="0">{{__('None')}}</option>
                    @foreach(\Modules\Blog\Entities\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="card-footer">
            <button type='submit' class="btn-success">{{__('Create')}}</button>
        </div>
</div>
</div>
</form>
@endsection
