/**
 * Property Thumbnail Checkbox Exclusivity
 * Ensures only one thumbnail checkbox can be selected at a time
 */
(function($) {
    'use strict';
    
    // Function to get all thumbnail checkboxes
    function getThumbnailCheckboxes() {
        // ACF field names are like: acf[field_property_image_1_thumbnail]
        // We'll search for checkboxes whose name contains both 'property_image_' and '_thumbnail'
        var $allCheckboxes = $('input[type="checkbox"]');
        var $thumbnailCheckboxes = $allCheckboxes.filter(function() {
            var name = $(this).attr('name') || '';
            return name.indexOf('property_image_') !== -1 && name.indexOf('_thumbnail') !== -1;
        });
        return $thumbnailCheckboxes;
    }
    
    // Function to handle thumbnail checkbox changes
    function handleThumbnailCheckbox() {
        var $thumbnailCheckboxes = getThumbnailCheckboxes();
        
        // Remove any existing handlers to prevent duplicates
        $thumbnailCheckboxes.off('change.thumbnailExclusive');
        
        // When any thumbnail checkbox is changed
        $thumbnailCheckboxes.on('change.thumbnailExclusive', function() {
            var $currentCheckbox = $(this);
            
            // If the current checkbox is being checked
            if ($currentCheckbox.is(':checked')) {
                // Uncheck all other thumbnail checkboxes
                var $otherCheckboxes = getThumbnailCheckboxes().not($currentCheckbox);
                $otherCheckboxes.prop('checked', false);
                
                // Trigger change event to ensure ACF updates the field value
                $otherCheckboxes.trigger('change');
            }
        });
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        handleThumbnailCheckbox();
    });
    
    // Re-initialize after ACF fields are loaded/updated (for dynamic field loading)
    if (typeof acf !== 'undefined') {
        // When ACF fields are ready
        acf.addAction('ready', function() {
            handleThumbnailCheckbox();
        });
        
        // When a true_false field is ready
        acf.addAction('ready_field/type=true_false', function(field) {
            var fieldName = field.get('name') || '';
            // Check if this is a thumbnail checkbox field
            if (fieldName.indexOf('property_image_') !== -1 && fieldName.indexOf('_thumbnail') !== -1) {
                var $checkbox = field.$el.find('input[type="checkbox"]');
                
                $checkbox.off('change.thumbnailExclusive').on('change.thumbnailExclusive', function() {
                    if ($(this).is(':checked')) {
                        // Uncheck all other thumbnail checkboxes
                        var $otherCheckboxes = getThumbnailCheckboxes().not($(this));
                        $otherCheckboxes.prop('checked', false);
                        $otherCheckboxes.trigger('change');
                    }
                });
            }
        });
    }
    
})(jQuery);

