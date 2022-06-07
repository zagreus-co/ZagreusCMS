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
                        <input type="{{ $option->type }}" name="data" id="option_{{$option->id}}_data" value='{{ $option->data }}' class='form-control'>
                    @elseif ($option->type == 'textarea')
                        <textarea name="data" id="option_{{$option->id}}_data" rows="6" class="form-control">{{ $option->data }}</textarea>
                    @elseif ($option->type == 'select' && isset($option->default->values))
                        <select name="data" id="option_{{$option->id}}_data" class="form-control">
                            @foreach($option->default->values as $key => $value)
                                <option value="{{ gettype($option->default->values) == 'object' ? $key : $value }}" {{ gettype($option->default->values) == 'object' ? ($key == $option->data ? 'selected' : '') : ($value == $option->data ? 'selected' : '') }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{$option->type}}" name="data" id="option_{{$option->id}}_data" value='{{ $option->data }}' class='form-control'>
                    @endif
        
                    <button onclick='updateOption(this, {{ $option->id }})' class="btn btn-sm btn-secondary my-3">{{ __('Update') }}</button>
                    <hr>
                </form>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let updateOption = (self, id) => {
        let formData = $(`#option_${id}_form`).serializeArray().reduce((obj,item) => {
            obj[item.name] = item.value;
            return obj;
        },{});
        $(self).attr('disabled', true);

        $.ajax({
            url: '{{ route("panel.options.handle") }}',
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
@endpush