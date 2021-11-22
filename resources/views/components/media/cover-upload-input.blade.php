<div class='card mb-3'>
    <div class="card-header"><strong>{{('Post cover')}}</strong></div>
    <div class="card-body text-center">        
        <img src="{{ $current == '' ? asset('img/upload-cover.png') : $current }}" width='100%' height='128px' id='image_preview'>
    </div>

    <input type="file" id="image_input" class="hidden" name="image" value='{{ $current }}' oninput='coverUploadChange(this)'  accept="image/*">
    <input type="hidden" name="image_url" value='{{ $current }}'>

    <div class="card-footer">
        <div class="inline-block">
            <button type="button" id='coverUploadBtn' class="btn inline-block" onclick='document.querySelector("#image_input").click()'>{{__('Select file')}}</button>
            <button type="button" id='coverDeleteBtn' class="btn-danger inline-block {{ $current == '' ? 'opacity-25' : '' }}">{{__('Delete cover')}}</button>
        </div>
    </div>
</div>
@push('scripts')
<script>
    let coverUploadChange = (self) => {
        uploadCover(self, self.files[0]);
    }

    let uploadCover = (self, file) => {
        $("#coverUploadBtn").html(`...`);

        let formData = new FormData();
        let request = new XMLHttpRequest();

        formData.set('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.set('file', file);
        request.open('POST', '{{ route("panel.media.admin_upload") }}');
        request.send(formData);

        request.onload = function() {
            if (request.status == 200) {
                document.querySelector('#image_preview').src = window.URL.createObjectURL(file);
                document.querySelector('input[name=image_url]').value = request.responseText;
                document.querySelector("#coverUploadBtn").innerHTML = '{{__("Select file")}}';
                document.querySelector("#coverDeleteBtn").classList.remove("opacity-25");
            }
            else { swal(`Error@${request.status} : ${file.name}`); $("#coverUploadBtn").html('{{__("Select file")}}');  }
        }
    }

    document.querySelector("#coverDeleteBtn").addEventListener('click', () => {
        document.querySelector("#coverDeleteBtn").classList.add("opacity-25");
        document.querySelector('#image_preview').src = "{{ asset('img/upload-cover.png') }}";
        document.querySelector('input[name=image_url]').value = '';
    });
</script>
@endpush