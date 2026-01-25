/**
 * Main JavaScript file for Figma Custom Theme
 */

(function($) {
    'use strict';

    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.main-navigation').toggleClass('active');
        $('body').toggleClass('menu-open');
        
        // Update aria-expanded attribute
        var expanded = $(this).attr('aria-expanded') === 'true';
        $(this).attr('aria-expanded', !expanded);
    });

    // Close mobile menu when clicking on a link
    $('.nav-menu a').on('click', function() {
        $('.menu-toggle').removeClass('active').attr('aria-expanded', 'false');
        $('.main-navigation').removeClass('active');
        $('body').removeClass('menu-open');
    });

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.site-header').length) {
            $('.menu-toggle').removeClass('active').attr('aria-expanded', 'false');
            $('.main-navigation').removeClass('active');
            $('body').removeClass('menu-open');
        }
    });

    // Close mobile menu when pressing Escape key
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) { // Escape key
            $('.menu-toggle').removeClass('active').attr('aria-expanded', 'false');
            $('.main-navigation').removeClass('active');
            $('body').removeClass('menu-open');
        }
    });

    // Smooth scrolling for anchor links
    $('a[href*="#"]:not([href="#"])').on('click', function(e) {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        }
    });

    // Add scroll effects to header
    $(window).on('scroll', function() {
        var scrollTop = $(window).scrollTop();
        var header = $('.site-header');
        
        if (scrollTop > 100) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
    });

    // Back to top button
    var backToTopButton = $('<button class="back-to-top" aria-label="Back to top" title="Back to top"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M7 14L12 9L17 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>');
    $('body').append(backToTopButton);

    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 500) {
            backToTopButton.fadeIn();
        } else {
            backToTopButton.fadeOut();
        }
    });

    backToTopButton.on('click', function() {
        $('html, body').animate({
            scrollTop: 0
        }, 600);
    });

    // Property card interactions
    $('.property-card').on('mouseenter', function() {
        $(this).find('.property-image img').addClass('hover-scale');
    }).on('mouseleave', function() {
        $(this).find('.property-image img').removeClass('hover-scale');
    });

    // Testimonial card animations
    $('.testimonial-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Feature card hover effects
    $('.feature-card').on('mouseenter', function() {
        $(this).find('.feature-icon').addClass('pulse');
    }).on('mouseleave', function() {
        $(this).find('.feature-icon').removeClass('pulse');
    });

    // Newsletter form submission
    $('.footer-main form, .newsletter-form').on('submit', function(e) {
        e.preventDefault();
        var email = $(this).find('input[type="email"]').val();
        
        if (email) {
            // Show success message (you would integrate with your email service here)
            alert('Thank you for subscribing! We\'ll keep you updated with our latest properties.');
            $(this).find('input[type="email"]').val('');
        }
    });

    // Initialize animations on scroll
    function initScrollAnimations() {
        $('.hero-section, .features-section, .properties-section, .testimonials-section').each(function() {
            var $this = $(this);
            var elementTop = $this.offset().top;
            var windowBottom = $(window).scrollTop() + $(window).height();
            
            if (elementTop < windowBottom - 100) {
                $this.addClass('animate-in');
            }
        });
    }

    // Run on load and scroll
    $(window).on('scroll', initScrollAnimations);
    initScrollAnimations();

    // Accessibility: Skip link focus
    $('.skip-link').on('click', function() {
        var target = $(this.hash);
        if (target.length) {
            target.attr('tabindex', '-1').focus();
        }
    });

    // Improve accessibility for keyboard navigation
    $('.btn, .nav-btn, .feature-card, .property-card, .testimonial-card').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            $(this).click();
        }
    });

    // Initialize lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Clients pagination for About page
    function initClientsPagination() {
        var $clientsGrid = $('.clients-grid');
        if ($clientsGrid.length) {
            var clientsPerPage = parseInt($clientsGrid.data('clients-per-page')) || 2;
            var totalPages = parseInt($clientsGrid.data('total-pages')) || 1;
            var currentPage = 1;
            
            function showClientsPage(page) {
                var startIndex = (page - 1) * clientsPerPage;
                var endIndex = startIndex + clientsPerPage;
                
                $clientsGrid.find('.client-card').each(function(index) {
                    var $card = $(this);
                    var cardIndex = parseInt($card.data('client-index')) || index;
                    
                    if (cardIndex >= startIndex && cardIndex < endIndex) {
                        $card.removeClass('hidden');
                    } else {
                        $card.addClass('hidden');
                    }
                });
                
                // Update pagination info
                $('.current-page').text(String(page).padStart(2, '0'));
                
                // Update button states
                $('.nav-prev').toggleClass('disabled', page <= 1).prop('disabled', page <= 1);
                $('.nav-next').toggleClass('disabled', page >= totalPages).prop('disabled', page >= totalPages);
            }
            
            $('.nav-prev').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    showClientsPage(currentPage);
                }
            });
            
            $('.nav-next').on('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    showClientsPage(currentPage);
                }
            });
        }
    }
    
    // Initialize clients pagination
    initClientsPagination();

    // Console log for theme info (development)

})(jQuery);

// Additional CSS for back to top button
const backToTopStyles = `
.back-to-top {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 3rem;
    height: 3rem;
    background: var(--color-primary);
    color: white;
    border: none;
    border-radius: var(--radius-full);
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-lg);
}

.back-to-top:hover {
    background: var(--color-primary-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-xl);
}

.back-to-top svg {
    transition: transform var(--transition-fast);
}

.back-to-top:hover svg {
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .back-to-top {
        bottom: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
    }
}
`;

// Inject styles
const styleSheet = document.createElement('style');
styleSheet.textContent = backToTopStyles;
document.head.appendChild(styleSheet);
