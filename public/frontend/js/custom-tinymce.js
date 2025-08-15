$(document).ready(function () {
    var removedImages = [];
    tinymce.init({
        selector: '.text-editor-img',
        height: 200,
        image_class_list: [
        {title: 'image-popup', value: 'image-popup'},
        ],
        setup: function (editor) {
            editor.on('init', function () {
                previousContent = editor.getContent(); // Store the initial content
            });
    
            // Handle content changes
            editor.on('NodeChange', function (e) {
                var currentContent = editor.getContent();
                
                // Compare the previous content with the current content to detect if an image was removed
                if (previousContent !== currentContent) {
                    // Check for removed images by comparing previousContent and currentContent
                    var previousImages = $(previousContent).find('img');
                    var currentImages = $(currentContent).find('img');
                    
                    previousImages.each(function (index, img) {
                        var src = $(img).attr('src');
                        
                        // If an image in the previous content is not in the current content, it was removed
                        if (currentImages.filter(`[src="${src}"]`).length === 0) {
                            // Image removed, handle deletion
                            $.ajax({
                                type: 'DELETE',
                                url: base_url + '/tinymce-delete-image',
                                data: { file_path: src },
                                success: function(response) {},
                                error: function(xhr) {}
                            });
                        }
                    });
                    
                    // Update previous content
                    previousContent = currentContent;
                }
            });
            
        },
        plugins:"link image",
        toolbar: "bold italic | link | image",
        menubar: false,

        image_title: true,
        automatic_uploads: true,
        images_upload_url: base_url + "/tinymce-upload-image",
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        }
    });
})