/**
 * Property Images - Dynamic Field Display
 * Shows/hides image fields and adds "Add Image" functionality
 */
(function($) {
    'use strict';
    
    // Function to initialize image fields
    function initImageFields() {
        var $imagesContainer = $('.acf-field[data-name="property_image_1"]').closest('.acf-fields');
        
        if ($imagesContainer.length === 0) {
            return;
        }
        
        // Find all image fields (Image 1-10) and their thumbnail checkboxes
        var $imageFields = $('.acf-field[data-name^="property_image_"]').filter(function() {
            var name = $(this).data('name');
            return name && name.indexOf('_thumbnail') === -1;
        });
        
        var visibleCount = 1; // Start with Image 1 visible
        
        // Initially hide all image fields except Image 1
        $imageFields.each(function(index) {
            var $field = $(this);
            var fieldName = $field.data('name');
            var fieldNumber = fieldName.replace('property_image_', '');
            
            if (fieldNumber === '1') {
                // Image 1 is always visible
                $field.show();
                // Also show its thumbnail checkbox
                var $thumbnailField = $('.acf-field[data-name="property_image_1_thumbnail"]');
                if ($thumbnailField.length) {
                    $thumbnailField.show();
                }
                visibleCount = 1;
            } else {
                // Check if field has a value (image uploaded)
                var $input = $field.find('input[type="hidden"]');
                var hasImage = false;
                
                // Check if there's an image preview or value
                if ($input.length && $input.val() !== '') {
                    hasImage = true;
                } else {
                    // Check for image preview
                    var $preview = $field.find('.acf-image-uploader .image-wrap, .acf-image-uploader img');
                    if ($preview.length) {
                        hasImage = true;
                    }
                }
                
                if (hasImage) {
                    // Field has image, show it and its thumbnail checkbox
                    $field.show();
                    var $thumbnailField = $('.acf-field[data-name="property_image_' + fieldNumber + '_thumbnail"]');
                    if ($thumbnailField.length) {
                        $thumbnailField.show();
                    }
                    visibleCount = parseInt(fieldNumber);
                } else {
                    // Field is empty, hide it and its thumbnail checkbox
                    $field.hide();
                    var $thumbnailField = $('.acf-field[data-name="property_image_' + fieldNumber + '_thumbnail"]');
                    if ($thumbnailField.length) {
                        $thumbnailField.hide();
                    }
                }
            }
        });
        
        // Add "Add Image" button after the last visible image field
        function updateAddButton() {
            // Remove existing button
            $('.add-more-image-btn').remove();
            
            // Find the last visible image field
            var $lastVisibleField = null;
            var maxVisibleNumber = 0;
            
            $imageFields.each(function() {
                var $field = $(this);
                if ($field.is(':visible')) {
                    var fieldName = $field.data('name');
                    var fieldNumber = parseInt(fieldName.replace('property_image_', ''));
                    if (fieldNumber > maxVisibleNumber) {
                        maxVisibleNumber = fieldNumber;
                        $lastVisibleField = $field;
                    }
                }
            });
            
            // If we have a last visible field and it's not Image 10, add the button
            if ($lastVisibleField && maxVisibleNumber < 10) {
                var $button = $('<button type="button" class="button add-more-image-btn" style="margin-top: 10px; margin-left: 0;">Add Image</button>');
                
                $button.on('click', function(e) {
                    e.preventDefault();
                    
                    // Find the next hidden field
                    var nextFieldNumber = maxVisibleNumber + 1;
                    var $nextImageField = $('.acf-field[data-name="property_image_' + nextFieldNumber + '"]');
                    var $nextThumbnailField = $('.acf-field[data-name="property_image_' + nextFieldNumber + '_thumbnail"]');
                    
                    if ($nextImageField.length) {
                        // Show the next image field and its thumbnail checkbox
                        $nextImageField.slideDown(300);
                        if ($nextThumbnailField.length) {
                            $nextThumbnailField.slideDown(300);
                        }
                        
                        // Update button position
                        updateAddButton();
                    }
                });
                
                // Insert button after the last visible field's thumbnail checkbox
                var $thumbnailField = $('.acf-field[data-name="property_image_' + maxVisibleNumber + '_thumbnail"]');
                if ($thumbnailField.length) {
                    $thumbnailField.after($('<div class="acf-field"></div>').append($button));
                } else {
                    $lastVisibleField.after($('<div class="acf-field"></div>').append($button));
                }
            }
        }
        
        // Initialize button
        updateAddButton();
        
        // Update button when images are uploaded/removed
        // Listen for ACF image field changes
        if (typeof acf !== 'undefined') {
            // When an image is added or removed
            $(document).on('change', '.acf-image-uploader input[type="hidden"]', function() {
                var $field = $(this).closest('.acf-field');
                var fieldName = $field.data('name');
                
                if (fieldName && fieldName.indexOf('property_image_') !== -1 && fieldName.indexOf('_thumbnail') === -1) {
                    // If image field has value, make sure it's visible
                    if ($(this).val() !== '') {
                        $field.show();
                        var fieldNumber = fieldName.replace('property_image_', '');
                        var $thumbnailField = $('.acf-field[data-name="property_image_' + fieldNumber + '_thumbnail"]');
                        if ($thumbnailField.length) {
                            $thumbnailField.show();
                        }
                    }
                    updateAddButton();
                }
            });
        }
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        initImageFields();
    });
    
    // Re-initialize after ACF fields are loaded
    if (typeof acf !== 'undefined') {
        acf.addAction('ready', function() {
            setTimeout(initImageFields, 100);
        });
        
        acf.addAction('append_field', function(field) {
            if (field.get('name') && field.get('name').indexOf('property_image_') !== -1) {
                setTimeout(initImageFields, 100);
            }
        });
        
        // Re-initialize when image is uploaded
        acf.addAction('change', function(field) {
            if (field.get('type') === 'image' && field.get('name') && field.get('name').indexOf('property_image_') !== -1) {
                setTimeout(initImageFields, 100);
            }
        });
    }
    
})(jQuery);
