/**
 * Property Gallery Navigation
 * Handles thumbnail clicks and gallery navigation
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        var $thumbnails = $('.thumbnail-item');
        var $mainGallery = $('.property-main-gallery');
        var $galleryDots = $('.gallery-dot');
        var $prevBtn = $('.gallery-nav-btn.prev-btn');
        var $nextBtn = $('.gallery-nav-btn.next-btn');
        var currentIndex = 0;
        var totalImages = $thumbnails.length;
        var imagesPerSlide = 2;
        var totalSlides = Math.ceil(totalImages / imagesPerSlide);
        
        // Thumbnail click handler
        $thumbnails.on('click', function() {
            var index = $(this).data('index');
            if (typeof index !== 'undefined') {
                currentIndex = parseInt(index);
                updateGallery();
            }
        });
        
        // Previous button
        $prevBtn.on('click', function() {
            if (currentIndex > 0) {
                currentIndex -= imagesPerSlide;
                if (currentIndex < 0) currentIndex = 0;
                updateGallery();
            }
        });
        
        // Next button
        $nextBtn.on('click', function() {
            if (currentIndex < totalImages - imagesPerSlide) {
                currentIndex += imagesPerSlide;
                if (currentIndex >= totalImages) currentIndex = totalImages - imagesPerSlide;
                updateGallery();
            }
        });
        
        // Dot navigation
        $galleryDots.on('click', function() {
            var slide = $(this).data('slide');
            if (typeof slide !== 'undefined') {
                currentIndex = parseInt(slide) * imagesPerSlide;
                updateGallery();
            }
        });
        
        // Update gallery display
        function updateGallery() {
            // Update thumbnails
            $thumbnails.removeClass('active');
            $thumbnails.each(function() {
                var index = $(this).data('index');
                if (index === currentIndex || index === currentIndex + 1) {
                    $(this).addClass('active');
                }
            });
            
            // Update dots
            var currentSlide = Math.floor(currentIndex / imagesPerSlide);
            $galleryDots.removeClass('active');
            $galleryDots.each(function() {
                var slide = $(this).data('slide');
                if (parseInt(slide) === currentSlide) {
                    $(this).addClass('active');
                }
            });
            
            // Update main gallery images
            // Note: This would require AJAX or pre-loaded images
            // For now, we'll just update the active states
        }
        
        // Initialize
        if (totalImages > 0) {
            updateGallery();
        }
    });
    
})(jQuery);

