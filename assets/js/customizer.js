/**
 * Customizer JS for live preview
 */

(function($) {
    'use strict';

    // Site title and description
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });

    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Header textcolor
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': to
                });
            }
        });
    });

    // Primary color
    wp.customize('primary_color', function(value) {
        value.bind(function(to) {
            var style = '<style id="figma-custom-theme-primary-color">a:hover, .site-title a:hover, .main-navigation a:hover { color: ' + to + '; }</style>';
            $('#figma-custom-theme-primary-color').remove();
            $('head').append(style);
        });
    });

    // Secondary color
    wp.customize('secondary_color', function(value) {
        value.bind(function(to) {
            var style = '<style id="figma-custom-theme-secondary-color">.post-meta { color: ' + to + '; }</style>';
            $('#figma-custom-theme-secondary-color').remove();
            $('head').append(style);
        });
    });

    // Footer text
    wp.customize('footer_text', function(value) {
        value.bind(function(to) {
            $('.footer-text').text(to);
        });
    });

    // Hero Section
    wp.customize('hero_title', function(value) {
        value.bind(function(to) {
            $('.hero-section .hero-title').text(to);
        });
    });

    wp.customize('hero_subtitle', function(value) {
        value.bind(function(to) {
            $('.hero-section .hero-subtitle').text(to);
        });
    });

    wp.customize('hero_button_1_text', function(value) {
        value.bind(function(to) {
            $('.hero-section .hero-actions .btn-outline').text(to);
        });
    });

    wp.customize('hero_button_2_text', function(value) {
        value.bind(function(to) {
            $('.hero-section .hero-actions .btn-primary').text(to);
        });
    });

    // Hero Stats
    for (var i = 1; i <= 3; i++) {
        (function(statNum) {
            wp.customize('hero_stat_' + statNum + '_number', function(value) {
                value.bind(function(to) {
                    $('.hero-section .stat-card:nth-child(' + statNum + ') .stat-number').text(to);
                });
            });

            wp.customize('hero_stat_' + statNum + '_label', function(value) {
                value.bind(function(to) {
                    $('.hero-section .stat-card:nth-child(' + statNum + ') .stat-label').text(to);
                });
            });
        })(i);
    }

    // Features Section
    for (var i = 1; i <= 4; i++) {
        (function(featureNum) {
            wp.customize('feature_' + featureNum + '_title', function(value) {
                value.bind(function(to) {
                    $('.features-section .feature-card:nth-child(' + featureNum + ') .feature-title').text(to);
                });
            });
        })(i);
    }

    // Properties Section
    wp.customize('homepage_properties_title', function(value) {
        value.bind(function(to) {
            $('.properties-section .section-title').text(to);
        });
    });

    wp.customize('homepage_properties_description', function(value) {
        value.bind(function(to) {
            $('.properties-section .section-description').text(to);
        });
    });
    // Properties Section
    wp.customize('properties_archive_hero_title', function(value) {
        value.bind(function(to) {
            $('.properties-hero-section .hero-title').text(to);
        });
    });

    wp.customize('properties_archive_hero_description', function(value) {
        value.bind(function(to) {
            $('.properties-hero-section .hero-description').text(to);
        });
    });
    

    wp.customize('homepage_properties_button_text', function(value) {
        value.bind(function(to) {
            $('.properties-section .section-action .btn').text(to);
        });
    });

    // Testimonials Section
    wp.customize('homepage_testimonials_title', function(value) {
        value.bind(function(to) {
            $('.testimonials-section .section-title').text(to);
        });
    });

    wp.customize('homepage_testimonials_description', function(value) {
        value.bind(function(to) {
            $('.testimonials-section .section-description').text(to);
        });
    });

    wp.customize('homepage_testimonials_button_text', function(value) {
        value.bind(function(to) {
            $('.testimonials-section .section-action .btn').text(to);
        });
    });

    // Properties Archive Page
    wp.customize('properties_archive_hero_title', function(value) {
        value.bind(function(to) {
            $('.properties-hero-section .hero-title').text(to);
        });
    });

    wp.customize('properties_archive_hero_description', function(value) {
        value.bind(function(to) {
            $('.properties-hero-section .hero-description').text(to);
        });
    });

    wp.customize('properties_archive_section_title', function(value) {
        value.bind(function(to) {
            $('.properties-listing-section .section-title').text(to);
        });
    });

    wp.customize('properties_archive_section_description', function(value) {
        value.bind(function(to) {
            $('.properties-listing-section .section-description').text(to);
        });
    });

    wp.customize('properties_archive_contact_title', function(value) {
        value.bind(function(to) {
            $('.properties-contact-section .section-title').text(to);
        });
    });

    wp.customize('properties_archive_contact_description', function(value) {
        value.bind(function(to) {
            $('.properties-contact-section .section-description').text(to);
        });
    });

    // Footer CTA
    wp.customize('footer_cta_title', function(value) {
        value.bind(function(to) {
            $('.cta-section h2').text(to);
        });
    });

    wp.customize('footer_cta_description', function(value) {
        value.bind(function(to) {
            $('.cta-section p').text(to);
        });
    });

    wp.customize('footer_cta_button_text', function(value) {
        value.bind(function(to) {
            $('.cta-section .btn').text(to);
        });
    });

})(jQuery);
