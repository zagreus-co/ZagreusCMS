<div class='card'>
    <div class="card-header"><strong>تصویر فعلی</strong></div>
    <div class="card-body text-center">        
        <img src="{{ $current == '' ? themeAsset('images/404-cover-image.jpg') : $current }}" width='100%' height='156px' id='image_preview'>
    </div>
    <input type="text" id="image_label" class="d-none" name="image" value='{{ $current }}' oninput='fileUploadChange(this)'>
    <div class="card-footer">
        <div class="input-group-append">
            <button class="btn btn-block btn-secondary" type="button" id="button-image">افزودن تصویر</button>
        </div>
    </div>
</div>

<script>
    if (typeof inputId === undefined) { let inputId = ''; }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'image_label';
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });
    function fmSetLink($url) {
        document.getElementById(inputId).value = $url;
        if (inputId == 'image_label')
            document.querySelector('#image_preview').setAttribute('src', $url)
    }
    
</script>