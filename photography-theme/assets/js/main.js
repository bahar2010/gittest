/**
 * Main Theme JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Mobile menu toggle
        const $menuToggle = $('.menu-toggle');
        const $navigation = $('.main-navigation');
        const $body = $('body');
        
        $menuToggle.on('click', function() {
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !isExpanded);
            $navigation.toggleClass('toggled');
            $body.toggleClass('menu-open');
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
                $menuToggle.attr('aria-expanded', 'false');
                $navigation.removeClass('toggled');
                $body.removeClass('menu-open');
            }
        });
        
        // Sticky header on scroll
        let lastScrollTop = 0;
        const $header = $('.site-header');
        const headerHeight = $header.outerHeight();
        
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > headerHeight) {
                $header.addClass('scrolled');
                
                // Hide/show header based on scroll direction
                if (scrollTop > lastScrollTop && scrollTop > 200) {
                    // Scrolling down
                    $header.addClass('hidden');
                } else {
                    // Scrolling up
                    $header.removeClass('hidden');
                }
            } else {
                $header.removeClass('scrolled hidden');
            }
            
            lastScrollTop = scrollTop;
        });
        
        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - headerHeight
                }, 800);
            }
        });
        
        // Back to top button
        const $backToTop = $('<button class="back-to-top" aria-label="Back to top"><i class="fas fa-chevron-up"></i></button>');
        $body.append($backToTop);
        
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('visible');
            } else {
                $backToTop.removeClass('visible');
            }
        });
        
        $backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 600);
        });
        
        // Form validation
        $('.contact-form').on('submit', function(e) {
            const $form = $(this);
            let isValid = true;
            
            // Remove previous error messages
            $form.find('.error-message').remove();
            $form.find('.error').removeClass('error');
            
            // Validate required fields
            $form.find('[required]').each(function() {
                const $field = $(this);
                if (!$field.val().trim()) {
                    isValid = false;
                    $field.addClass('error');
                    $field.after('<span class="error-message">This field is required</span>');
                }
            });
            
            // Validate email
            const $email = $form.find('input[type="email"]');
            if ($email.length && $email.val()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test($email.val())) {
                    isValid = false;
                    $email.addClass('error');
                    $email.after('<span class="error-message">Please enter a valid email address</span>');
                }
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Animate elements on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            const options = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            elements.forEach(function(element) {
                observer.observe(element);
            });
        }
        
        animateOnScroll();
        
        // Preloader
        $(window).on('load', function() {
            $('.preloader').fadeOut('slow');
        });
        
        // Equal height for service items
        function equalizeHeights() {
            const $items = $('.services-grid .service-item');
            let maxHeight = 0;
            
            $items.css('height', 'auto');
            
            $items.each(function() {
                const height = $(this).outerHeight();
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });
            
            $items.css('height', maxHeight);
        }
        
        equalizeHeights();
        $(window).on('resize', equalizeHeights);
        
        // Copy to clipboard functionality for sharing
        $('.share-button').on('click', function(e) {
            e.preventDefault();
            const url = $(this).data('url') || window.location.href;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(function() {
                    showNotification('Link copied to clipboard!');
                });
            } else {
                // Fallback for older browsers
                const $temp = $('<input>');
                $body.append($temp);
                $temp.val(url).select();
                document.execCommand('copy');
                $temp.remove();
                showNotification('Link copied to clipboard!');
            }
        });
        
        // Notification system
        function showNotification(message, type = 'success') {
            const $notification = $('<div class="notification ' + type + '">' + message + '</div>');
            $body.append($notification);
            
            setTimeout(function() {
                $notification.addClass('show');
            }, 100);
            
            setTimeout(function() {
                $notification.removeClass('show');
                setTimeout(function() {
                    $notification.remove();
                }, 300);
            }, 3000);
        }
        
        // Image loading error handling
        $('img').on('error', function() {
            $(this).attr('src', 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300"%3E%3Crect width="400" height="300" fill="%23f0f0f0"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="20" fill="%23999"%3EImage not found%3C/text%3E%3C/svg%3E');
        });
    });

})(jQuery);