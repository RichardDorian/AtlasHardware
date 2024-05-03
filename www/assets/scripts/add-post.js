{
  // Get the image file picker element and add a change event listener to it
  const imageFilePicker = document.getElementById('image-file-picker');
  imageFilePicker.addEventListener('change', handleFileSelect, false);

  // Function to trigger the image file picker click event
  function chooseImageFile() {
    imageFilePicker.click();
  }

  // Array to store the selected image blobs
  const imageBlobs = [];

  // Get the post form element and add a submit event listener to it
  const postForm = document.getElementById('add-post-form');
  postForm.addEventListener('submit', async function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Create a new FormData object from the form data
    const formdata = new FormData(postForm);

    // Append the selected image blobs to the form data
    for (let i = 0; i < imageBlobs.length; i++) {
      formdata.append('image[]', imageBlobs[i], 'image' + i + '.webp');
    }

    // Append the specs object to the form data as a JSON string
    formdata.append(
      'specs',
      JSON.stringify({
        cpu: formdata.get('cpu'),
        gpu: formdata.get('gpu'),
        motherboard: formdata.get('motherboard'),
        psu: formdata.get('psu'),
        ram: formdata.get('ram'),
        storage: [formdata.get('storage'), formdata.get('storage2')],
        case: formdata.get('case'),
      })
    );

    // Delete the individual spec fields from the form data
    for (const spec of [
      'cpu',
      'gpu',
      'motherboard',
      'psu',
      'ram',
      'storage1',
      'storage2',
      'storage',
      'case',
    ]) {
      formdata.delete(spec);
    }

    // Send a POST request to the server to add the new post
    const response = await fetch('/add-post', {
      method: 'POST',
      body: formdata,
    });

    // Get the response text and redirect the user to the new post page if successful
    const responseText = await response.text();
    if (responseText.includes('/post/')) {
      window.location.href = responseText;
    }
  });

  /**
   * Handle the image file select event
   * @param {Event} event - the file select event
   */
  async function handleFileSelect(event) {
    // Check if the maximum number of images has been reached
    if (imageBlobs.length >= 10) {
      alert('You can only upload 10 images.');
      return;
    }

    // Get the selected image file
    let imageFile = event.target.files[0];
    if (imageFile == null || imageFile == undefined) {
      return;
    }

    // Compress the image file and add it to the imageBlobs array
    let compressedImage = await compressImage(imageFile);
    if (compressedImage == null) {
      return;
    }
    imageBlobs.push(compressedImage);

    // Hide the image picker button if the maximum number of images has been reached
    if (imageBlobs.length >= 10) {
      const imagePickerButton = document.getElementById('image-picker-button');
      imagePickerButton.style.display = 'none';
    }

    // Add a preview of the selected image to the page
    addImagePreview(compressedImage);
  }

  /**
   * Add a preview of the selected image to the page
   * @param {Blob} imageFile - the selected image file
   */
  function addImagePreview(imageFile) {
    // Create a new div element to hold the image preview
    const imagePreviewContainer = document.getElementById('image-container');
    const imagePreview = document.createElement('div');
    imagePreview.className = 'image-preview';

    // Create a close button for the image preview
    const imagePreviewCloseButton = document.createElement('div');
    imagePreviewCloseButton.className = 'image-preview-close-button';
    imagePreviewCloseButton.innerHTML = `<span class="material-symbols-rounded">close</span>`;
    imagePreview.appendChild(imagePreviewCloseButton);

    // Create an image element for the preview
    const imagePreviewImage = document.createElement('img');
    imagePreviewImage.className = 'image-preview-image';
    imagePreviewImage.src = URL.createObjectURL(imageFile);

    // Add the image preview to the page
    imagePreviewContainer.appendChild(imagePreview);
    imagePreview.appendChild(imagePreviewImage);

    // Add a click event listener to the close button to remove the image preview and blob from the array
    imagePreviewCloseButton.addEventListener('click', function () {
      imageBlobs.splice(imageBlobs.indexOf(imageFile), 1);
      imagePreview.remove();
      let imagePickerButton = document.getElementById('image-picker-button');
      imagePickerButton.style.display = 'block';
    });

    // Add mouseenter and mouseout event listeners to show/hide the close button
    imagePreview.addEventListener('mouseenter', function () {
      imagePreviewCloseButton.style.display = 'block';
    });
    imagePreview.addEventListener('mouseleave', function () {
      imagePreviewCloseButton.style.display = 'none';
    });
  }

  /**
   * Compress an image file and convert it to webp format
   * @param {File} imageFile - the image file to compress
   * @param {number} quality - the initial quality of the compressed image
   * @returns {Promise<Blob>} - a promise that resolves to the compressed image blob
   */
  async function compressImage(imageFile, quality = 0.9) {
    // Convert the image file to webp format and set the initial quality
    let imageBlob = await convertToWebp(imageFile, quality);

    // Compress the image further if it is too large
    while (imageBlob.size > 1000000 && quality > 0.5) {
      imageBlob = await convertToWebp(imageFile, quality);
    }

    // Check if the image is still too large and return null if it is
    if (imageBlob.size > 1000000) {
      alert('Image is too large. Please choose a smaller one.');
      return null;
    } else {
      return imageBlob;
    }
  }

  /**
   * Convert an image file to webp format
   * @param {File} imageFile - the image file to convert
   * @param {number} quality - the quality of the converted image
   * @returns {Promise<Blob>} - a promise that resolves to the converted image blob
   */
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
