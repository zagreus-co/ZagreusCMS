<div class='{{ $parent }} mb-3'>
    <div class="{{ $child }}">
        <label>{{__('Keywords')}}</label>
        
        <select class="{{ $inputClass }}" name='keywords[]' id='keyword_inputs' multiple="multiple">
            @if (isset($current) && count($current) > 0)
                @foreach ($current as $keyword)
                    <option selected>{{ $keyword }}</option>
                @endforeach
            @else
            <option>{{__('Zagreus Company')}}</option>
            <option>{{__('Zagreus Developers')}}</option>
            <option>ZagreusCMS</option>
            @endif
        </select>

    </div>
</div>