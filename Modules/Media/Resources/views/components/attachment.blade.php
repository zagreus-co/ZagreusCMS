<div class="card">
    <div class="card-header">پیوست ها</div>

    <div class="card-body" id='attachment_area' index='0'>
        
    </div>
    <div class="card-footer"> 
        <button type='button' class="btn btn-secondary" onclick='addNewAttachment()'>افزودن پیوست جدید</button> 
    </div>
</div>
<script>
    if (typeof inputId === undefined) { let inputId = ''; }

    let createAttachmentDiv = (id, current = '') => {
        return `<div id='attachment_${id}_div' class='form-group'>
            <label>پیوست ${id + 1}</label>
            <div class="input-group">
                <input type="text" class="form-control" name="attachments[${id}]" id="attachment_${id}_input" value="${current}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="attachment_${id}_button">انتخاب</button>
                    <button class="btn btn-outline-danger" onclick='$("#attachment_${id}_div").remove()' type="button" >X</button>
                </div>
            </div>
        </div>`;
    }

    let addNewAttachment = (current = '') => {
        let area = $('#attachment_area')
        let id = parseInt($('#attachment_area').attr('index'))
        area.append(createAttachmentDiv(id, current));
        document.getElementById(`attachment_${id}_button`).addEventListener('click', (event) => {
            event.preventDefault();
            inputId = `attachment_${id}_input`;
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
        $('#attachment_area').attr('index', id + 1)
    }

    @if (gettype($current) == 'array') @foreach ($current as $attachment) addNewAttachment("{{ $attachment }}"); @endforeach @endif

    function fmSetLink($url) {
        document.getElementById(inputId).value = $url;
    }
</script>