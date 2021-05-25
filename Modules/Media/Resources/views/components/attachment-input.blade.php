<div class="card">
    <div class="card-header flex">
        <label class='mt-2'>{{('Attachments')}}</label>

        <button type='button' class="btn ml-4" onclick='addNewAttachment()'>{{__('Add new')}}</button> 
    </div>

    <div class="card-body" id='attachment_area' index='0'>
        
    </div>
</div>
<script>
    if (typeof inputId === undefined) { let inputId = ''; }

    let createAttachmentDiv = (id, current = '') => {
        return `
        <div id='attachment_${id}_div' class='form-group bg-light p-2'>
            <label>{{_('Attachment')}} ${id + 1}</label>
            <div class="flex flex-row overflow-hidden">
                <input type="file" class="form-control p-2 rounded-none	" name="inputs[]" multiple="multiple" id="attachment_${id}_input" onchange="fileUploadChange(this)">
                    
                <button class="btn btn-danger mt-2 rounded-none	" onclick='$("#attachment_${id}_div").remove()' type="button" >X</button>
            </div>
            <div id='attachment_files'>
                ${current != '' ? 
                `
                <span class='badge badge-info ml-1'>${current}</span>
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
        attachment_files.append(`<span id='${fileId}' class='badge badge-info ml-1'> <div class="spinner-border spinner-border-sm text-light" role="status"> <span class="sr-only">Loading...</span> </div></span>`);

        let formData = new FormData();
        let request = new XMLHttpRequest();

        formData.set('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.set('file', file);
        request.open('POST', '/panel/media/upload/attachments');
        request.send(formData);

        request.onload = function() {
            if (request.status == 200) {
                $("#" + fileId).html(file.name);
                attachment_files.append(`<input type='hidden' name='attachments[]' value='${request.responseText}'>`);
            }
            else { $("#" + fileId).html(`Error@${request.status} : ${file.name}`); }
        }
    }
</script>