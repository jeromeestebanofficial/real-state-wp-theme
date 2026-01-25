/**
 * Property Description Read More Functionality
 * Shows "Read More" link if description is more than 2 lines
 */
(function() {
    'use strict';
    
    function initPropertyDescriptions() {
        const descriptions = document.querySelectorAll('.property-description-wrapper');
        
        descriptions.forEach(function(wrapper) {
            const description = wrapper.querySelector('.property-description');
            const readMoreLink = wrapper.querySelector('.read-more-link');
            
            if (!description || !readMoreLink) return;
            
            // Remove existing event listeners by cloning
            const newReadMoreLink = readMoreLink.cloneNode(true);
            readMoreLink.parentNode.replaceChild(newReadMoreLink, readMoreLink);
            
            // Reset to check if we need read more
            description.classList.remove('expanded');
            newReadMoreLink.style.display = 'none';
            
            // Temporarily remove line clamp to measure full height
            const originalStyle = description.style.cssText;
            description.style.webkitLineClamp = 'none';
            description.style.display = 'block';
            
            const fullHeight = description.scrollHeight;
            
            // Restore original style
            description.style.cssText = originalStyle;
            
            // Get line height
            const lineHeight = parseFloat(window.getComputedStyle(description).lineHeight);
            const maxHeight = lineHeight * 2.1; // Slight buffer for 2 lines
            
            // Check if content exceeds 2 lines
            if (fullHeight > maxHeight) {
                newReadMoreLink.style.display = 'inline-block';
                newReadMoreLink.textContent = 'Read More';
                
                // Handle click to expand/collapse
                newReadMoreLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (description.classList.contains('expanded')) {
                        // Collapse
                        description.classList.remove('expanded');
                        newReadMoreLink.textContent = 'Read More';
                    } else {
                        // Expand
                        description.classList.add('expanded');
                        newReadMoreLink.textContent = 'Read Less';
                    }
                });
            }
        });
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPropertyDescriptions);
    } else {
        initPropertyDescriptions();
    }
    
    // Re-initialize on window resize (in case of responsive changes)
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initPropertyDescriptions, 250);
    });
    
})();

