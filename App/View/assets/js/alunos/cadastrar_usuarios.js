const fileInput = document.getElementById('fileInput');
const previewImg = document.getElementById('preview');

fileInput.addEventListener('change', function () {
  const file = this.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = function (e) {
      previewImg.src = e.target.result;
    };

    reader.readAsDataURL(file);
  }
});