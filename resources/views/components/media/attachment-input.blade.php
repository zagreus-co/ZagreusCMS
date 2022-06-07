<div class="card">
    <div class="card-header flex justify-between">
        <label class='mt-2'>{{('Attachments')}}</label>

        <button type='button' class="btn btn-sm btn-light" onclick='addNewAttachment()'>{{__('Add new')}}</button> 
    </div>

    <div class="card-body" id='attachment_area' index='0'>
        
    </div>
</div>
@push('scripts')
<script>
    if (typeof inputId === undefined) { let inputId = ''; }

    let createAttachmentDiv = (id, current = '') => {
        return `
        <div id='attachment_${id}_div' class='form-group bg-gray-50 p-2'>
            <label>{{__('Attachment')}} ${id + 1}</label>
            <div class="flex flex-row items-center overflow-hidden">
                <input type="file" class="bg-white form-control p-1 rounded-none" name="inputs[]" multiple="multiple" id="attachment_${id}_input" onchange="fileUploadChange(this)">
                    
                <button class="btn btn-danger py-2 px-4 rounded-none" onclick='$("#attachment_${id}_div").remove()' type="button" >X</button>
            </div>
            <div id='attachment_files'>
                ${current != '' ? 
                `
                <span class='bg-blue-400 text-white py-1 px-3 rounded-md ml-1 mt-2'>${current}</span>
                <input type='hidden' name='attachments[]' value='${current}'>
                ` 
                : ``}
            </div>
        </div>`;
    }

    let addNewAttachment = (current = '') => {
        let area = $('#attachment_area')
        let id = parseInt($('#attachment_area').attr('index'))
        area.append(createAttachmentDiv(id, current));
        $('#attachment_area').attr('index', id + 1)
    }

    @if (gettype($current) == 'array') @foreach ($current as $attachment) addNewAttachment("{{ $attachment }}"); @endforeach @endif

    let fileUploadChange = (self) => {
        let id = $(self).parent().parent().attr('id').replace('attachment_', '').replace('_div', '');
        let attachment_files = $(self).parent().parent().find("#attachment_files");
        attachment_files.html('');
        for (i = 0; i < self.files.length ; i++) {
            submitAttachmentUpload(self, self.files[i]);
        }
    }
    
    let submitAttachmentUpload = (self, file) => {
        let fileId = 's_' + Math.floor(Date.now() / 1000) + '-' + Math.floor(Math.random() * 1000000);
        let attachment_files = $(self).parent().parent().find("#attachment_files");
        attachment_files.append(`<span id='${fileId}' class='bg-blue-400 opacity-50 text-white py-1 px-3 rounded-md ml-1 mt-2'> Uploading ... </span>`);

        let formData = new FormData();
        let request = new XMLHttpRequest();

        formData.set('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.set('file', file);
        request.open('POST', '{{ route("panel.media.admin_upload") }}');
        request.send(formData);

        request.onload = function() {
            if (request.status == 200) {
                $("#" + fileId).html(file.name);
                $("#" + fileId).toggleClass('opacity-50');
                attachment_files.append(`<input type='hidden' name='attachments[]' value='${request.responseText}'>`);
            }
            else { $("#" + fileId).html(`Error@${request.status} : ${file.name}`); }
        }
    }
</script>
@endpush