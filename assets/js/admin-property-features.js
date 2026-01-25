/**
 * Property Features - Dynamic Field Display
 * Shows/hides feature fields and adds "Add More Feature" functionality
 */
(function($) {
    'use strict';
    
    // Function to initialize feature fields
    function initFeatureFields() {
        var $featuresContainer = $('.acf-field[data-name="property_feature_1"]').closest('.acf-fields');
        
        if ($featuresContainer.length === 0) {
            return;
        }
        
        // Find all feature fields (Feature 1-10)
        var $featureFields = $('.acf-field[data-name^="property_feature_"]');
        var visibleCount = 1; // Start with Feature 1 visible
        
        // Initially hide all feature fields except Feature 1
        $featureFields.each(function(index) {
            var $field = $(this);
            var fieldName = $field.data('name');
            var fieldNumber = fieldName.replace('property_feature_', '');
            
            if (fieldNumber === '1') {
                // Feature 1 is always visible
                $field.show();
                visibleCount = 1;
            } else {
                // Check if field has a value
                var $input = $field.find('input[type="text"]');
                if ($input.length && $input.val().trim() !== '') {
                    // Field has value, show it
                    $field.show();
                    visibleCount = parseInt(fieldNumber);
                } else {
                    // Field is empty, hide it
                    $field.hide();
                }
            }
        });
        
        // Add "Add More Feature" button after the last visible feature field
        function updateAddButton() {
            // Remove existing button
            $('.add-more-feature-btn').remove();
            
            // Find the last visible feature field
            var $lastVisibleField = null;
            var maxVisibleNumber = 0;
            
            $featureFields.each(function() {
                var $field = $(this);
                if ($field.is(':visible')) {
                    var fieldName = $field.data('name');
                    var fieldNumber = parseInt(fieldName.replace('property_feature_', ''));
                    if (fieldNumber > maxVisibleNumber) {
                        maxVisibleNumber = fieldNumber;
                        $lastVisibleField = $field;
                    }
                }
            });
            
            // If we have a last visible field and it's not Feature 10, add the button
            if ($lastVisibleField && maxVisibleNumber < 10) {
                var $button = $('<button type="button" class="button add-more-feature-btn" style="margin-top: 10px; margin-left: 0;">Add More Feature</button>');
                
                $button.on('click', function(e) {
                    e.preventDefault();
                    
                    // Find the next hidden field
                    var nextFieldNumber = maxVisibleNumber + 1;
                    var $nextField = $('.acf-field[data-name="property_feature_' + nextFieldNumber + '"]');
                    
                    if ($nextField.length) {
                        // Show the next field
                        $nextField.slideDown(300);
                        
                        // Focus on the input
                        setTimeout(function() {
                            $nextField.find('input[type="text"]').focus();
                        }, 350);
                        
                        // Update button position
                        updateAddButton();
                    }
                });
                
                // Insert button after the last visible field
                $lastVisibleField.after($('<div class="acf-field"></div>').append($button));
            }
        }
        
        // Initialize button
        updateAddButton();
        
        // Update button when fields are shown/hidden
        $featureFields.on('change', 'input[type="text"]', function() {
            var $field = $(this).closest('.acf-field');
            if ($(this).val().trim() === '' && $field.data('name') !== 'property_feature_1') {
                // If field becomes empty and it's not Feature 1, we could hide it
                // But for now, we'll keep it visible once it's been shown
            }
            updateAddButton();
        });
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        initFeatureFields();
    });
    
    // Re-initialize after ACF fields are loaded
    if (typeof acf !== 'undefined') {
        acf.addAction('ready', function() {
            setTimeout(initFeatureFields, 100);
        });
        
        acf.addAction('append_field', function(field) {
            if (field.get('name') && field.get('name').indexOf('property_feature_') !== -1) {
                setTimeout(initFeatureFields, 100);
            }
        });
    }
    
})(jQuery);

