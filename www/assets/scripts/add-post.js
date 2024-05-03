{
  const imageFilePicker = document.getElementById('image-file-picker');
  imageFilePicker.addEventListener('change', handleFileSelect, false);

  function chooseImageFile() {
    imageFilePicker.click();
  }

  const imageBlobs = [];

  const postForm = document.getElementById('add-post-form');
  postForm.addEventListener('submit', async function (event) {
    event.preventDefault();
    const formdata = new FormData(postForm);
    for (let i = 0; i < imageBlobs.length; i++) {
      formdata.append('image[]', imageBlobs[i], 'image' + i + '.webp');
    }
    formdata.append(
      'specs',
      '{"cpu":"Intel i5 7600k","gpu":"PNY RTX 4090 SUPER","motherboard":"MSI B450 Tomahawk Max","ram":"Corsair LPX 32 GB DDR5-6400","psu":"Corsair RM750x","storage":["Curcial P1 1TB NVMe SSD","Seagate Barracuda 2TB HDD"],"case":"Fractal Design Meshify C"}'
    );
    const response = await fetch('/add-post', {
      method: 'POST',
      body: formdata,
    });
    const responseText = await response.text();
    if (responseText.includes('/post/')) {
      window.location.href = responseText;
    }
  });
  async function handleFileSelect(event) {
    if (imageBlobs.length >= 10) {
      alert('You can only upload 10 images.');
      return;
    }
    let imageFile = event.target.files[0];
    if (imageFile == null || imageFile == undefined) {
      return;
    }

    let compressedImage = await compressImage(imageFile);
    if (compressedImage == null) {
      return;
    }
    imageBlobs.push(compressedImage);
    if (imageBlobs.length >= 10) {
      const imagePickerButton = document.getElementById('image-picker-button');
      imagePickerButton.style.display = 'none';
    }
    addImagePreview(compressedImage);
  }

  function addImagePreview(imageFile) {
    const imagePreviewContainer = document.getElementById('image-container');
    const imagePreview = document.createElement('div');
    imagePreview.className = 'image-preview';
    const imagePreviewImage = document.createElement('img');
    const imagePreviewCloseButton = document.createElement('div');
    imagePreviewCloseButton.className = 'image-preview-close-button';
    imagePreviewCloseButton.innerHTML = `<span class="material-symbols-rounded">close</span>`;
    imagePreview.appendChild(imagePreviewCloseButton);

    imagePreviewImage.className = 'image-preview-image';
    imagePreviewImage.src = URL.createObjectURL(imageFile);
    imagePreviewContainer.appendChild(imagePreview);
    imagePreview.appendChild(imagePreviewImage);
    imagePreviewCloseButton.addEventListener('click', function () {
      imageBlobs.splice(imageBlobs.indexOf(imageFile), 1);
      imagePreview.remove();
      let imagePickerButton = document.getElementById('image-picker-button');
      imagePickerButton.style.display = 'block';
    });
    imagePreview.addEventListener('onmouseenter', function () {
      imagePreviewCloseButton.style.display = 'block';
      console.log('mouse over');
    });
    imagePreview.addEventListener('onmouseout', function () {
      imagePreviewCloseButton.style.display = 'none';
    });
  }

  async function compressImage(imageFile) {
    let imageBlob = await convertToWebp(imageFile, 1.0);
    quality = 0.9;

    while (imageBlob.size > 1000000 && quality > 0.5)
      imageBlob = await convertToWebp(imageFile, quality);

    if (imageBlob.size > 1000000) {
      alert('Image is too large. Please choose a smaller one.');
      return null;
    } else return imageBlob;
  }

  function convertToWebp(imageFile, quality) {
    return new Promise((resolve) => {
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');
      const img = new Image();

      img.addEventListener('load', () => {
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0);
        canvas.toBlob(resolve, 'image/webp', quality);
      });

      img.src = URL.createObjectURL(imageFile);
    });
  }
}
