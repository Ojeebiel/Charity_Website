const fileInput = document.getElementById("fileInput");
const fileNameDisplay = document.getElementById("fileName");

fileInput.addEventListener("change", function() {
    if (fileInput.files.length > 0) {
    fileNameDisplay.textContent = fileInput.files[0].name;
    } else {
    fileNameDisplay.textContent = "";
    }
});
