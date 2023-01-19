const fileInput = document.getElementById("image");
fileInput.addEventListener("change", function() {
    const fileInputContainer = document.getElementById("image-file-input");
    const fileInputText = document.getElementById("file-input-text");
    const userImageSrc = URL.createObjectURL(fileInput.files[0]);

    fileInputContainer.style.background = `url('${userImageSrc}') no-repeat center`;
    fileInputText.innerText = "";
});