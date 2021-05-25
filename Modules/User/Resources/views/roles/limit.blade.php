@extends('panel::layouts.app', ['title'=> 'مدیریت دسترسی های گروه'])

@section('content')
<form action="" method="post" class='container-fluid'>
    @csrf

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">دسته بندی های قابل استفاده</div>
            <div class="card-body">
                <select name="categories[]" class='form-control' multiple='multiple'>
                    @foreach(\Modules\Blog\Entities\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ $role->accessList()->whereAccessableType(get_class($category))->whereAccessableId($category->id)->first() ? "selected" : "" }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <button type="submit" class='btn btn-warning'>ثبت محدودیت ها</button>
</form>
@endsection

@section('script')
<script>
    // $('#permissions_select').select2();
</script>
@endsection