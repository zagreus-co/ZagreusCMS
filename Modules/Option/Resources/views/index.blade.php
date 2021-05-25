@extends(panelLayout())

@section('content')
<div class="">
    <div class="card">
        <div class="card-body">
            @foreach(\Option::where('type', '!=', 'hidden')->orderBy('id', 'asc')->get() as $option)
                <form action='javascript:void(0)' id='option_{{$option->id}}_form' class='mt-4'>
                    <input type="hidden" name="method" value='update'>
                    <input type="hidden" name="option_id" value='{{ $option->id }}'>
                    <input type="hidden" name="name" value='{{ $option->name }}'>
                    <strong>{{ $option->name }}</strong> <small>({{ $option->tag }})</small>
                    @if ($option->type == 'text' || $option->type == 'number')
                        <input type="{{ $option->type }}" name="data" id="option_{{$option->id}}_data" value='{{ $option->data }}' class='w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring mt-2 mb-2'>
                    @elseif ($option->type == 'textarea')
                        <textarea name="data" id="option_{{$option->id}}_data" rows="6" class="w-full text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring p-3 mt-2 mb-2">{{ $option->data }}</textarea>
                    @elseif ($option->type == 'select' && isset($option->default->values))

                        <select name="data" id="option_{{$option->id}}_data" class="w-full  px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring mb-2 mt-2">
                            @foreach($option->default->values as $key => $value)
                                <option value="{{ gettype($option->default->values) == 'object' ? $key : $value }}" {{ gettype($option->default->values) == 'object' ? ($key == $option->data ? 'selected' : '') : ($value == $option->data ? 'selected' : '') }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{$option->type}}" name="data" id="option_{{$option->id}}_data" value='{{ $option->data }}' class='form-control bg-warning'>
                    @endif
        
                    <button onclick='updateOption(this, {{ $option->id }})' class="btn-shadow btn-bs-secondary mb-4">{{ _('Update') }}</button>
                    <hr>
                </form>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let updateOption = (self, id) => {
        let formData = $(`#option_${id}_form`).serializeArray().reduce((obj,item) => {
            obj[item.name] = item.value;
            return obj;
        },{});
        $(self).attr('disabled', true);

        $.ajax({
            url: '{{ route("module.options.handle") }}',
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify(formData),
            success: (data) => {
                $(self).attr('disabled', false);
                swal({icon: 'success', text: data.message});
            },
            error: (data) => {
                $(self).attr('disabled', false);
                swal(data.responseJSON.message);
            }
        })
    }
    
</script>
@endsection