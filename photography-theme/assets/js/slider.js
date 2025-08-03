/**
 * Hero Slider Functionality
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize slider
        const $slider = $('.hero-slider');
        const $slides = $slider.find('.slide');
        const $prevBtn = $('#prev-slide');
        const $nextBtn = $('#next-slide');
        
        if ($slides.length <= 1) {
            // Hide controls if only one slide
            $('.slider-controls').hide();
            return;
        }
        
        let currentSlide = 0;
        let isAnimating = false;
        const slideCount = $slides.length;
        
        // Auto-play settings
        let autoPlay = true;
        let autoPlayInterval;
        const autoPlayDelay = 5000; // 5 seconds
        
        // Function to show specific slide
        function showSlide(index) {
            if (isAnimating) return;
            isAnimating = true;
            
            // Hide current slide
            $slides.eq(currentSlide).removeClass('active');
            
            // Update current slide index
            currentSlide = index;
            
            // Show new slide
            $slides.eq(currentSlide).addClass('active');
            
            // Reset animation flag
            setTimeout(function() {
                isAnimating = false;
            }, 1000);
        }
        
        // Next slide function
        function nextSlide() {
            const nextIndex = (currentSlide + 1) % slideCount;
            showSlide(nextIndex);
        }
        
        // Previous slide function
        function prevSlide() {
            const prevIndex = (currentSlide - 1 + slideCount) % slideCount;
            showSlide(prevIndex);
        }
        
        // Start auto-play
        function startAutoPlay() {
            if (autoPlay) {
                autoPlayInterval = setInterval(nextSlide, autoPlayDelay);
            }
        }
        
        // Stop auto-play
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }
        
        // Event listeners
        $nextBtn.on('click', function() {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });
        
        $prevBtn.on('click', function() {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });
        
        // Pause on hover
        $slider.on('mouseenter', function() {
            stopAutoPlay();
        });
        
        $slider.on('mouseleave', function() {
            startAutoPlay();
        });
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if ($slider.is(':visible')) {
                if (e.key === 'ArrowLeft') {
                    stopAutoPlay();
                    prevSlide();
                    startAutoPlay();
                } else if (e.key === 'ArrowRight') {
                    stopAutoPlay();
                    nextSlide();
                    startAutoPlay();
                }
            }
        });
        
        // Touch/swipe support
        let touchStartX = 0;
        let touchEndX = 0;
        
        $slider.on('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        $slider.on('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                stopAutoPlay();
                if (diff > 0) {
                    // Swipe left - next slide
                    nextSlide();
                } else {
                    // Swipe right - previous slide
                    prevSlide();
                }
                startAutoPlay();
            }
        }
        
        // Start auto-play on load
        startAutoPlay();
        
        // Preload images for smooth transitions
        $slides.each(function() {
            const $img = $(this).find('img');
            if ($img.length) {
                const img = new Image();
                img.src = $img.attr('src');
            }
        });
    });

})(jQuery);