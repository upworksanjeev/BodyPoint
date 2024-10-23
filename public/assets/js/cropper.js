
document.addEventListener('DOMContentLoaded', function() {
    let cropper;

    $('#profile_img').on('change', function (event) {
        const files = event.target.files;
        if (files && files.length > 0) {
            $('.profile_image').append('<div class="mt-2"><img id="image" src="" style="max-width: 100%; display: none;" /></div><div class="mt-4"><h3>Cropped Image:</h3><img id="croppedImage" src="" style="max-width: 100%;" /></div>').last();
            const reader = new FileReader();
            reader.onload = function (e) {
                const image = document.getElementById('image');
                image.src = e.target.result;
                image.style.display = 'block';
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 16 / 16,
                    viewMode: 1,
                    crop: updateCroppedImage,
                });
            };
            reader.readAsDataURL(files[0]);
        }
    });

    function updateCroppedImage() {
        const canvas = cropper.getCroppedCanvas();
        const croppedImage = document.getElementById('croppedImage');
        croppedImage.src = canvas.toDataURL();

        const newWidth = canvas.width;
        const newHeight = canvas.height;

        const resizedCanvas = document.createElement('canvas');
        resizedCanvas.width = newWidth;
        resizedCanvas.height = newHeight;

        const ctx = resizedCanvas.getContext('2d');
        ctx.drawImage(canvas, 0, 0, newWidth, newHeight);

        croppedImage.src = resizedCanvas.toDataURL();
    }

    $(document).on('click','#profile-update-next-btn',function () {
        const files = $('#profile_img')[0].files;
        console.log(files);
        if (files && files.length > 0) {
            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob(async (blob) => {
                const file = new File([blob], 'cropped_image.png', {
                    type: 'image/png',
                    lastModified: Date.now()
                });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                const fileInput = document.getElementById('profile_img');
                fileInput.files = dataTransfer.files;
            });
        }
    });

});
