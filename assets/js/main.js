/**
 * Photographer Pro Theme - Main JavaScript
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        
        // Initialize all functions
        initHeroSlider();
        initPortfolioLightbox();
        initSmoothScrolling();
        initHeaderScroll();
        initContactForm();
        initPortfolioFilter();
        initAnimations();
        
    });

    /**
     * Hero Slider Functionality
     */
    function initHeroSlider() {
        const $slider = $('.hero-slider');
        const $slides = $('.slide');
        const $dots = $('.slider-dot');
        let currentSlide = 0;
        let slideInterval;

        if ($slides.length === 0) return;

        function showSlide(index) {
            $slides.removeClass('active');
            $dots.removeClass('active');
            
            $slides.eq(index).addClass('active');
            $dots.eq(index).addClass('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % $slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + $slides.length) % $slides.length;
            showSlide(currentSlide);
        }

        // Auto-advance slides
        function startAutoSlide() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        // Click navigation
        $dots.on('click', function() {
            const index = $(this).data('slide');
            currentSlide = index;
            showSlide(currentSlide);
            stopAutoSlide();
            startAutoSlide();
        });

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (e.keyCode === 37) { // Left arrow
                prevSlide();
                stopAutoSlide();
                startAutoSlide();
            } else if (e.keyCode === 39) { // Right arrow
                nextSlide();
                stopAutoSlide();
                startAutoSlide();
            }
        });

        // Pause on hover
        $slider.hover(
            function() { stopAutoSlide(); },
            function() { startAutoSlide(); }
        );

        // Start auto-slide
        startAutoSlide();
    }

    /**
     * Portfolio Lightbox
     */
    function initPortfolioLightbox() {
        const $lightbox = $('#lightbox');
        const $lightboxImg = $('#lightbox-img');
        const $closeBtn = $('.lightbox-close');

        // Open lightbox
        $(document).on('click', '.portfolio-item img', function(e) {
            e.preventDefault();
            const src = $(this).attr('src');
            const alt = $(this).attr('alt');
            
            $lightboxImg.attr('src', src).attr('alt', alt);
            $lightbox.addClass('active');
            $('body').addClass('lightbox-open');
        });

        // Close lightbox
        function closeLightbox() {
            $lightbox.removeClass('active');
            $('body').removeClass('lightbox-open');
        }

        $closeBtn.on('click', closeLightbox);
        $lightbox.on('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Close with escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // Escape key
                closeLightbox();
            }
        });
    }

    /**
     * Smooth Scrolling
     */
    function initSmoothScrolling() {
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });
    }

    /**
     * Header Scroll Effect
     */
    function initHeaderScroll() {
        const $header = $('.site-header');
        let lastScroll = 0;

        $(window).on('scroll', function() {
            const currentScroll = $(this).scrollTop();
            
            if (currentScroll > 100) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }

            // Hide/show header on scroll
            if (currentScroll > lastScroll && currentScroll > 200) {
                $header.addClass('header-hidden');
            } else {
                $header.removeClass('header-hidden');
            }

            lastScroll = currentScroll;
        });
    }

    /**
     * Contact Form Handling
     */
    function initContactForm() {
        const $form = $('.contact-form');
        
        if ($form.length === 0) return;

        $form.on('submit', function(e) {
            e.preventDefault();
            
            const $submitBtn = $(this).find('button[type="submit"]');
            const originalText = $submitBtn.text();
            
            // Show loading state
            $submitBtn.text('Sending...').prop('disabled', true);
            
            // Get form data
            const formData = new FormData(this);
            formData.append('action', 'handle_contact_form');
            
            // Send AJAX request
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showMessage('Thank you! Your message has been sent successfully.', 'success');
                        $form[0].reset();
                    } else {
                        showMessage('Sorry, there was an error sending your message. Please try again.', 'error');
                    }
                },
                error: function() {
                    showMessage('Sorry, there was an error sending your message. Please try again.', 'error');
                },
                complete: function() {
                    $submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });

        function showMessage(message, type) {
            // Remove existing messages
            $('.form-message').remove();
            
            // Create new message
            const $message = $('<div>')
                .addClass(`form-message ${type}`)
                .text(message);
            
            // Insert before form
            $form.prepend($message);
            
            // Remove after 5 seconds
            setTimeout(function() {
                $message.fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        }
    }

    /**
     * Portfolio Filter
     */
    function initPortfolioFilter() {
        const $filterBtns = $('.filter-btn');
        const $portfolioItems = $('.portfolio-item');
        
        if ($filterBtns.length === 0) return;

        $filterBtns.on('click', function() {
            const filter = $(this).data('filter');
            
            // Update active button
            $filterBtns.removeClass('active');
            $(this).addClass('active');
            
            // Filter items
            $portfolioItems.each(function() {
                const $item = $(this);
                const categories = $item.data('categories');
                
                if (filter === 'all' || categories.includes(filter)) {
                    $item.removeClass('hidden').addClass('loading');
                } else {
                    $item.addClass('hidden');
                }
            });
        });
    }

    /**
     * Animations
     */
    function initAnimations() {
        // Intersection Observer for animations
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            // Observe elements for animation
            $('.portfolio-item, .service-card, .about-section, .testimonial').each(function() {
                observer.observe(this);
            });
        }

        // Add loading animation to portfolio items
        $('.portfolio-item').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });
    }

    /**
     * Utility Functions
     */
    
    // Debounce function
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Throttle function
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Lazy loading for images
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            $('img[data-src]').each(function() {
                imageObserver.observe(this);
            });
        }
    }

    // Initialize lazy loading
    initLazyLoading();

    // Resize handler
    $(window).on('resize', debounce(function() {
        // Handle responsive adjustments
        if ($(window).width() < 768) {
            $('.portfolio-grid').removeClass('masonry');
        } else {
            $('.portfolio-grid').addClass('masonry');
        }
    }, 250));

})(jQuery);