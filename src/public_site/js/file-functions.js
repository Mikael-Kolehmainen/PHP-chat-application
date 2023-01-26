const fileInput = document.getElementById("image");
fileInput.addEventListener("change", function() {
    if (isImage()) {
        changeImagePreview();
    }
});

function isImage()
{
    const imageValidation = document.getElementById("validation-msg");
    const fileExt = fileInput.files[0].name.split('.').pop();

    if (fileExt != "jpg" && fileExt != "jpeg" && fileExt != "png" && fileExt != "gif") {
        fileInput.value = "";
        imageValidation.innerText = "Please choose an image!";
        return false;
    }

    imageValidation.innerText = "";
    return true;
}

function changeImagePreview()
{
    const fileInputContainer = document.getElementById("image-file-input");
    const fileInputText = document.getElementById("file-input-text");
    const userImageSrc = URL.createObjectURL(fileInput.files[0]);

    fileInputContainer.style.background = `url('${userImageSrc}') fixed no-repeat center`;
    fileInputText.innerText = "";
}