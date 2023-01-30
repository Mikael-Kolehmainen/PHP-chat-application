const acceptImage = document.getElementById("accept-image");
const rejectImage = document.getElementById("reject-image");

acceptImage.addEventListener("click", function() {
    camera.sendImagePathToDatabase();
});
rejectImage.addEventListener("click", function() {
    ElementDisplay.change("image-options", "none");
    camera.hideTakenImage();
    startCamera();
})