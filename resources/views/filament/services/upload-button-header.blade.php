<button
    type="button"
    class="acremann-service-upload-btn fi-btn"
    x-data
    x-on:click="
        const root = document.getElementById('service-header-image-upload');
        const input = root?.querySelector('.fi-fo-file-upload-input-ctn input[type=\'file\']');
        if (input) {
            input.click();
        }
    "
>
    Choose header image
</button>
