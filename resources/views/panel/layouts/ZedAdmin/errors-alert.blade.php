@if ($errors->all())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger mb-2">
            {{ $error }}
        </div>
    @endforeach
@endif