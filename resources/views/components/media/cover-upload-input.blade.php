<div class='card mb-3'>
    <div class="card-header"><strong>{{('Post cover')}}</strong></div>
    <div class="card-body text-center">        
        <img src="{{ $current == '' ? asset('img/upload-cover.png') : $current }}" width='100%' height='128px' id='image_preview'>
    </div>

    <input type="file" id="image_input" class="hidden" name="image" value='{{ $current }}' oninput='coverUploadChange(this)'  accept="image/*">
    <input type="hidden" name="image_url" value='{{ $current }}'>

    <div class="card-footer">
        <div class="input-group-append">
            <button type="button" id='coverUploadButton' class="btn" onclick='document.querySelector("#image_input").click()'>{{__('Select file')}}</button>
        </div>
    </div>
</div>
@push('scripts')
<script>
    let coverUploadChange = (self) => {
        uploadCover(self, self.files[0]);
    }
    
    let uploadCover = (self, file) => {
        $("#coverUploadButton").html(`...`);

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
                $("#coverUploadButton").html('{{__("Select file")}}');
            }
            else { swal(`Error@${request.status} : ${file.name}`); $("#coverUploadButton").html('{{__("Select file")}}');  }
        }
    }
</script>
@endpush