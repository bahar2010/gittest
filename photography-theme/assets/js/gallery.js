/**
 * Gallery and Lightbox Functionality
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Lightbox functionality
        const $lightbox = $('#lightbox');
        const $lightboxImg = $lightbox.find('img');
        const $lightboxClose = $lightbox.find('.lightbox-close');
        let currentImageIndex = 0;
        let galleryImages = [];
        
        // Initialize lightbox triggers
        function initLightbox() {
            // Collect all gallery images
            galleryImages = [];
            $('.lightbox-trigger').each(function(index) {
                const $this = $(this);
                galleryImages.push({
                    src: $this.attr('href'),
                    caption: $this.data('caption') || ''
                });
                
                // Add click handler
                $this.on('click', function(e) {
                    e.preventDefault();
                    currentImageIndex = index;
                    openLightbox(galleryImages[currentImageIndex]);
                });
            });
        }
        
        // Open lightbox with specific image
        function openLightbox(imageData) {
            $lightboxImg.attr('src', imageData.src);
            $lightboxImg.attr('alt', imageData.caption);
            $lightbox.addClass('active');
            $('body').css('overflow', 'hidden');
        }
        
        // Close lightbox
        function closeLightbox() {
            $lightbox.removeClass('active');
            $('body').css('overflow', '');
            $lightboxImg.attr('src', '');
        }
        
        // Navigate to next image
        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            openLightbox(galleryImages[currentImageIndex]);
        }
        
        // Navigate to previous image
        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            openLightbox(galleryImages[currentImageIndex]);
        }
        
        // Event listeners
        $lightboxClose.on('click', closeLightbox);
        
        $lightbox.on('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if ($lightbox.hasClass('active')) {
                switch(e.key) {
                    case 'Escape':
                        closeLightbox();
                        break;
                    case 'ArrowLeft':
                        prevImage();
                        break;
                    case 'ArrowRight':
                        nextImage();
                        break;
                }
            }
        });
        
        // Touch/swipe support for lightbox
        let touchStartX = 0;
        let touchEndX = 0;
        
        $lightbox.on('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        $lightbox.on('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleLightboxSwipe();
        });
        
        function handleLightboxSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next image
                    nextImage();
                } else {
                    // Swipe right - previous image
                    prevImage();
                }
            }
        }
        
        // Gallery grid hover effects
        $('.gallery-item').on('mouseenter', function() {
            $(this).find('.gallery-overlay').stop().fadeIn(300);
        }).on('mouseleave', function() {
            $(this).find('.gallery-overlay').stop().fadeOut(300);
        });
        
        // Masonry layout for galleries (optional)
        function initMasonry() {
            const $grid = $('.gallery-grid.masonry');
            if ($grid.length && typeof $.fn.masonry !== 'undefined') {
                $grid.masonry({
                    itemSelector: '.gallery-item',
                    columnWidth: '.gallery-item',
                    percentPosition: true,
                    gutter: 20
                });
                
                // Layout after images load
                $grid.imagesLoaded().progress(function() {
                    $grid.masonry('layout');
                });
            }
        }
        
        // Filter functionality for album categories
        $('.category-filter').on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const filterValue = $this.data('filter');
            
            // Update active state
            $('.category-filter').removeClass('active');
            $this.addClass('active');
            
            // Filter items
            if (filterValue === '*') {
                $('.gallery-item').fadeIn();
            } else {
                $('.gallery-item').each(function() {
                    const $item = $(this);
                    if ($item.hasClass(filterValue)) {
                        $item.fadeIn();
                    } else {
                        $item.fadeOut();
                    }
                });
            }
        });
        
        // Lazy loading for gallery images
        function lazyLoadImages() {
            const images = document.querySelectorAll('img[data-src]');
            const imageOptions = {
                threshold: 0,
                rootMargin: '0px 0px 50px 0px'
            };
            
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            }, imageOptions);
            
            images.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
        
        // Initialize all gallery features
        initLightbox();
        initMasonry();
        
        // Reinitialize on AJAX content load
        $(document).on('photography_content_loaded', function() {
            initLightbox();
            initMasonry();
            lazyLoadImages();
        });
        
        // Load more albums functionality
        let loadingMore = false;
        let currentPage = 1;
        
        $('#load-more-albums').on('click', function(e) {
            e.preventDefault();
            
            if (loadingMore) return;
            
            const $button = $(this);
            const $container = $('#album-grid');
            
            loadingMore = true;
            currentPage++;
            
            $button.text('Loading...');
            
            $.ajax({
                url: photography_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_albums',
                    page: currentPage,
                    nonce: photography_ajax.nonce
                },
                success: function(response) {
                    if (response) {
                        $container.append(response);
                        $(document).trigger('photography_content_loaded');
                        $button.text('Load More');
                    } else {
                        $button.text('No More Albums').prop('disabled', true);
                    }
                },
                error: function() {
                    $button.text('Error Loading Albums');
                },
                complete: function() {
                    loadingMore = false;
                }
            });
        });
    });

})(jQuery);