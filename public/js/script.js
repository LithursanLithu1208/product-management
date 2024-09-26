

// too add row 

document.addEventListener('DOMContentLoaded', function () {
    let rowIndex = 1; // Initialize with the first row index

    document.getElementById('add-row').addEventListener('click', function () {
        rowIndex++; 

        // Create a new row element
        const newRow = document.createElement('tr');
        newRow.id = `row-${rowIndex}`;

        newRow.innerHTML = `
            <td>
                <input type="number" class="form-control no-border" name="price[]" step="0.01" required>
            </td>
            <td>
                <input type="number" class="form-control no-border" name="weight[]" step="0.01" required>
            </td>
            <td>
                <input type="number" class="form-control no-border" name="qty_of_box[]" required>
            </td>
        `;

        // Append the new row to the table body
        document.querySelector('#productTable tbody').appendChild(newRow);
    });
});


// for uplode image in add product

document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('mainImage');
    const mainImagePreview = document.getElementById('mainImagePreview');
    
    mainImage.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mainImagePreview.src = e.target.result;
                mainImagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            mainImagePreview.style.display = 'none';
        }
    });

    const smallImages = document.querySelectorAll('input[name="small_images[]"]');
    const smallImagePreviews = [
        document.getElementById('smallImagePreview1'),
        document.getElementById('smallImagePreview2'),
        document.getElementById('smallImagePreview3')
    ];

    smallImages.forEach((input, index) => {
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    smallImagePreviews[index].src = e.target.result;
                    smallImagePreviews[index].style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                smallImagePreviews[index].style.display = 'none';
            }
        });
    });

});



document.querySelectorAll('input[id^="smallImage"]').forEach(input => {
    input.addEventListener('change', function(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            // Adjust the image preview ID based on the input ID
            const fileInputId = fileInput.id;
            const imagePreviewId = fileInputId.replace('smallImage', 'smallImagePreview').replace('New', 'New');
            const imageElement = document.getElementById(imagePreviewId);

            if (imageElement) {
                imageElement.src = e.target.result;
                imageElement.style.display = 'block'; // Show the image
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
});


function previewMainImage(event) {
    const image = document.getElementById('image');
    const preview = document.getElementById('mainImagePreview');
    
    if (image.files && image.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(image.files[0]);
    }
}

function deleteImage(imageId, imageType, productId) {
    console.log("Deleting image with ID:", imageId);

    var imageElement = document.getElementById(imageId);
    console.log("Image element:", imageElement);

    if (imageElement && imageElement.style.display !== 'none') {
        if (imageElement.src) {
            imageElement.removeAttribute('src');
            imageElement.style.display = 'none';

            var deleteButton = imageElement.nextElementSibling;
            if (deleteButton) {
                deleteButton.style.display = 'none';
            }

            
            fetch('/delete-image', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    image_id: imageId,
                    image_type: imageType,
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Image deleted successfully.');
                } else {
                    console.error('Image deletion failed.');
                }
            })
            .catch(error => {
                console.error('Error occurred while deleting image:', error);
            });
        } else {
            console.error("Image source is missing. Skipping deletion.");
        }
    } else {
        console.error("Image element is hidden or not found. Skipping deletion.");
    }
}

function confirmDelete() {
    return confirm('Are you sure you want to delete this category?');
}


document.addEventListener('DOMContentLoaded', function() {
    var fileInput = document.getElementById('category_image');
    var preview = document.getElementById('category_image_preview');
    var uploadIcon = document.querySelector('.category-upload-icon');

    // Trigger the file input click when the upload icon is clicked
    uploadIcon.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Show the image preview
        };

        if (file) {
            reader.readAsDataURL(file); // Convert the file to a base64 URL
        }
    });
})

function previewMainImage(event) {
    const image = document.getElementById('image');
    const preview = document.getElementById('mainImagePreview');
    
    if (image.files && image.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(image.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const addRowButton = document.getElementById('add-row');
    const tableBody = document.getElementById('product-attributes');

    addRowButton.addEventListener('click', function () {
        // Create a new row element
        const newRow = document.createElement('tr');

        // Create the new row's HTML content
        newRow.innerHTML = `
            <td>
                <input type="number" class="form-control" name="price[]" step="0.01" required>
            </td>
            <td>
                <input type="number" class="form-control" name="weight[]" step="0.01" required>
            </td>
            <td>
                <input type="number" class="form-control" name="qty_of_box[]" required>
            </td>
        `;

        // Append the new row to the table body
        tableBody.appendChild(newRow);
    });
});

// Ensure the script runs only after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    function deleteImage(previewId, deleteId) {
        const imageElement = document.getElementById(previewId);
        const deleteButton = document.getElementById(deleteId);

        if (imageElement) {
            imageElement.src = '';
            imageElement.style.display = 'none'; // Hide the image
        }

        if (deleteButton) {
            deleteButton.style.display = 'none'; // Hide the delete button
        }

        // Show the upload button if needed
        const uploadButton = deleteButton.nextElementSibling;
        if (uploadButton) {
            uploadButton.style.display = 'block';
        }
    }

    function handleImageUpload(inputId, previewId, deleteId) {
        const inputElement = document.getElementById(inputId);
        const previewElement = document.getElementById(previewId);
        const deleteButton = document.getElementById(deleteId);

        inputElement.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewElement.src = e.target.result;
                    previewElement.style.display = 'block';
                    if (deleteButton) {
                        deleteButton.style.display = 'block'; // Show the delete button
                    }
                };
                reader.readAsDataURL(file);
            } else {
                previewElement.style.display = 'none';
                if (deleteButton) {
                    deleteButton.style.display = 'none'; // Hide the delete button
                }
            }
        });
    }

    // Initialize main image upload
    const { mainImage, smallImages } = window.imageData;
    handleImageUpload(mainImage.inputId, mainImage.previewId, mainImage.deleteId);

    // Initialize small image uploads
    smallImages.forEach(image => {
        handleImageUpload(image.inputId, image.previewId, image.deleteId);
    });
});

// add product



// add chategory

document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const imageUpload = document.getElementById('imageUpload');
    const closeBtn = document.querySelector('.close-btn');
    const originalContent = uploadArea.innerHTML;
    let isImageClosed = true; 

    uploadArea.addEventListener('click', function(e) {
        if (isImageClosed) {
            e.preventDefault(); 
            imageUpload.click();
        }
    });

    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image">`;
                uploadArea.appendChild(closeBtn);
                closeBtn.style.display = 'block';
                isImageClosed = false;
            }
            reader.readAsDataURL(file);
        }
    });

    closeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        uploadArea.innerHTML = originalContent;
        uploadArea.appendChild(closeBtn);
        closeBtn.style.display = 'none';
        imageUpload.value = '';
        isImageClosed = true;
    });
});

// edit cotegray




document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const imageUpload = document.getElementById('imageUpload');
    const closeBtn = document.querySelector('.close-btn');
    const originalContent = uploadArea.innerHTML;
    let isImageClosed = true; // Start with true to allow initial upload

    uploadArea.addEventListener('click', function(e) {
        if (isImageClosed) {
            e.preventDefault(); // Prevent any default action
            imageUpload.click();
        }
    });

    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image">`;
                uploadArea.appendChild(closeBtn);
                closeBtn.style.display = 'block';
                isImageClosed = false;
            }
            reader.readAsDataURL(file);
        }
    });

    closeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        uploadArea.innerHTML = originalContent;
        uploadArea.appendChild(closeBtn);
        closeBtn.style.display = 'none';
        imageUpload.value = '';
        isImageClosed = true;
    });
});

// add slider
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const imageUpload = document.getElementById('imageUpload');
    const closeBtn = document.querySelector('.close-btn');
    const originalContent = uploadArea.innerHTML;
    let isImageClosed = true; // Start with true to allow initial upload

    uploadArea.addEventListener('click', function(e) {
        if (isImageClosed) {
            e.preventDefault(); // Prevent any default action
            imageUpload.click();
        }
    });

    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image">`;
                uploadArea.appendChild(closeBtn);
                closeBtn.style.display = 'block';
                isImageClosed = false;
            }
            reader.readAsDataURL(file);
        }
    });
});

