@extends(panelLayout())

@section('content')
<form action="{{ route('module.blog.categories.update', $category->id) }}" method="post" class="grid grid-cols-1 md:grid-cols-12 gap-4">
@csrf
@method('PATCH')
<div class="col-span-12"> @panelView('errors-alert') </div>

<div class="col-span-12 md:col-span-8">
    <div class="card" x-data="{tab: '{{config('app.locale')}}'}">
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
                <input type="text" name='{{$locale}}[title]' value='{{ old($locale.".title", $category->title) }}' class="form-control">
            </div>

            <div class='mt-3' x-data="{ generate: false }">
                <div class="form-group" x-show='generate == false'>
                    <label for="slug">{{__('Slug')}}</label>
                    <input type="text" name='{{$locale}}[slug]' value='{{ old($locale.".slug", $category->slug) }}' class="form-control">
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" @click='generate = !generate' name='{{$locale}}[generate_slug]' value='{{ $category->slug }}' class="form-check-input">
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
<div class="col-span-12 md:col-span-4">

    <div class="card">
        <div class="card-body">

            <div class="form-group mb-4">
                <label>{{__('Parent')}}</label>
                <select name="parent_id" class="form-control">
                    <option value="0" {{ $category->parent_id == 0 ? 'selected' : '' }} >{{__('None')}}</option>
                    @foreach(\Modules\Blog\Entities\Category::where('id', '!=', $category->id)->get() as $_category)
                        <option value="{{ $_category->id }}" {{ $category->parent_id == $_category->id ? 'selected' : '' }} >{{ $_category->title }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="card-footer">
            <button type='submit' class="btn btn-primary">{{__('Update')}}</button>
        </div>
</div>
</div>
</form>
@endsection
