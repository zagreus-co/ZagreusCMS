@extends(panelLayout())

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <button class="btn-success ml-auto" type="button" id="button-image">View medias</button>
        </div>
        <div class="card-body">
            
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });
</script>
@endpush