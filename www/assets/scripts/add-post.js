
let imageFilePicker = document.getElementById("image-file-picker")
imageFilePicker.addEventListener("change", handleFileSelect, false)

function chooseImageFile() {
    imageFilePicker.click()
}

let imageBlobs = []

let postForm = document.getElementById("add-post-form")
postForm.addEventListener("submit", async function(event) {
    event.preventDefault()
    formdata = new FormData(postForm)
    for (let i = 0; i < imageBlobs.length; i++) {
        formdata.append("image[]", imageBlobs[i], "image" + i + ".webp")
        console.log(formdata.get("image"))
    }
    formdata.append("specs", '{"cpu":"Intel i5 7600k","gpu":"PNY RTX 4090 SUPER","motherboard":"MSI B450 Tomahawk Max","ram":"Corsair LPX 32 GB DDR5-6400","psu":"Corsair RM750x","storage":["Curcial P1 1TB NVMe SSD","Seagate Barracuda 2TB HDD"],"case":"Fractal Design Meshify C"}')
    let response = await fetch("./add-post/add-post", {
        method: "POST",
        body: formdata
    })
    let responseText = await response.text()
    if (responseText.includes("/post/")) {
        window.location.href = responseText
    }

})
async function handleFileSelect(event) {
    if (imageBlobs.length >= 10) {
        alert("You can only upload 10 images.")
        return
    }
    let imageFile = event.target.files[0]
    if (imageFile == null || imageFile == undefined) {return;}

    let compressedImage = await compressImage(imageFile)
    if (compressedImage == null) {return;}
    imageBlobs.push(compressedImage)
    if (imageBlobs.length >= 10) {
        let imagePickerButton = document.getElementById("image-picker-button")
        imagePickerButton.style.display = "none"
    }
    addImagePreview(compressedImage)
}

function addImagePreview(imageFile) {
    let imagePreviewContainer = document.getElementById("image-container")
    let imagePreview = document.createElement("div")
    imagePreview.className = "image-preview"
    let imagePreviewImage = document.createElement("img")
    let imagePreviewCloseButton = document.createElement("div")
    imagePreviewCloseButton.className = "image-preview-close-button"
    imagePreviewCloseButton.innerHTML = `<span class="material-symbols-rounded">close</span>`
    imagePreview.appendChild(imagePreviewCloseButton)
    
    imagePreviewImage.className = "image-preview-image"
    imagePreviewImage.src = URL.createObjectURL(imageFile)
    imagePreviewContainer.appendChild(imagePreview)
    imagePreview.appendChild(imagePreviewImage)
    imagePreviewCloseButton.addEventListener("click", function() {
        imageBlobs.splice(imageBlobs.indexOf(imageFile), 1)
        imagePreview.remove()
        let imagePickerButton = document.getElementById("image-picker-button")
        imagePickerButton.style.display = "block"
    })
    imagePreview.addEventListener("onmouseenter", function() {
        imagePreviewCloseButton.style.display = "block";
        console.log("mouse over")
    })
    imagePreview.addEventListener("onmouseout", function() {
        imagePreviewCloseButton.style.display = "none"
    })
}



async function compressImage(imageFile) {
    let imageBlob = await convertToWebp(imageFile, 1.0)
    quality = 0.9
    while (imageBlob.size > 1000000 && quality > 0.5) {
        imageBlob = convertToWebp(imageFile, quality)
    }
    if (imageBlob.size > 1000000) {
        alert("Image is too large. Please choose a smaller image.")
        return null
    } else {
        return imageBlob
    }

}


async function convertToWebp(imageFile, quality) {
    let canvas = document.createElement("canvas")
    let ctx = canvas.getContext("2d")
    let img = new Image();
    let imgDrawn = false
    let newBlob = null
    img.onload = function() {
        canvas.width = img.width
        canvas.height = img.height
        ctx.drawImage(img, 0, 0)
        imgDrawn = true
    }
    img.src = URL.createObjectURL(imageFile)
    while (imgDrawn == false) {
        await new Promise(r => setTimeout(r, 100))
    }
    canvas.toBlob(function(blob) {
        newBlob = blob
    }, "image/webp", quality)
    while (newBlob == null) {
        await new Promise(r => setTimeout(r, 100))
    }
    return newBlob

}

