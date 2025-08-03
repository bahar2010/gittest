    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo get_theme_mod('footer_title_1', 'About'); ?></h3>
                    <p><?php echo get_theme_mod('footer_description', 'Professional photographer specializing in capturing life\'s most precious moments. Creating timeless memories through artistic vision and technical expertise.'); ?></p>
                    <div class="social-links">
                        <?php if (get_theme_mod('instagram_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('facebook_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-facebook"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('twitter_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('pinterest_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('pinterest_url')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('linkedin_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>" target="_blank" rel="noopener">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3><?php echo get_theme_mod('footer_title_2', 'Quick Links'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'fallback_cb'    => 'photographer_theme_footer_menu',
                    ));
                    ?>
                </div>
                
                <div class="footer-section">
                    <h3><?php echo get_theme_mod('footer_title_3', 'Contact Info'); ?></h3>
                    <?php if (get_theme_mod('contact_email')) : ?>
                        <p><i class="fas fa-envelope"></i> <?php echo esc_html(get_theme_mod('contact_email')); ?></p>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('contact_phone')) : ?>
                        <p><i class="fas fa-phone"></i> <?php echo esc_html(get_theme_mod('contact_phone')); ?></p>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('contact_address')) : ?>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html(get_theme_mod('contact_address')); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="footer-section">
                    <h3><?php echo get_theme_mod('footer_title_4', 'Services'); ?></h3>
                    <p>Wedding Photography</p>
                    <p>Portrait Sessions</p>
                    <p>Event Photography</p>
                    <p>Commercial Photography</p>
                    <p>Photo Editing</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo get_theme_mod('copyright_text', 'All rights reserved.'); ?></p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<!-- Lightbox for gallery images -->
<div class="lightbox" id="lightbox">
    <div class="lightbox-content">
        <span class="lightbox-close" id="lightboxClose">&times;</span>
        <img src="" alt="" id="lightboxImage">
    </div>
</div>

<?php wp_footer(); ?>

<script>
// Slider functionality
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const navDots = document.querySelectorAll('.nav-dot');
    const prevArrow = document.getElementById('prevSlide');
    const nextArrow = document.getElementById('nextSlide');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        navDots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        currentSlide = index;
    }

    function nextSlide() {
        showSlide((currentSlide + 1) % slides.length);
    }

    function prevSlide() {
        showSlide((currentSlide - 1 + slides.length) % slides.length);
    }

    function startSlideshow() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopSlideshow() {
        clearInterval(slideInterval);
    }

    // Event listeners
    if (nextArrow) {
        nextArrow.addEventListener('click', () => {
            stopSlideshow();
            nextSlide();
            startSlideshow();
        });
    }

    if (prevArrow) {
        prevArrow.addEventListener('click', () => {
            stopSlideshow();
            prevSlide();
            startSlideshow();
        });
    }

    navDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            stopSlideshow();
            showSlide(index);
            startSlideshow();
        });
    });

    // Start automatic slideshow
    if (slides.length > 1) {
        startSlideshow();
        
        // Pause on hover
        const slider = document.querySelector('.hero-slider');
        if (slider) {
            slider.addEventListener('mouseenter', stopSlideshow);
            slider.addEventListener('mouseleave', startSlideshow);
        }
    }

    // Mobile menu toggle
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const navigation = document.querySelector('.main-navigation');
    
    if (mobileToggle && navigation) {
        mobileToggle.addEventListener('click', function() {
            navigation.classList.toggle('active');
            this.setAttribute('aria-expanded', navigation.classList.contains('active'));
        });
    }

    // Lightbox functionality
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxClose = document.getElementById('lightboxClose');
    const photoItems = document.querySelectorAll('.photo-item');

    photoItems.forEach(item => {
        item.addEventListener('click', function() {
            const img = this.querySelector('img');
            if (img) {
                lightboxImage.src = img.src;
                lightboxImage.alt = img.alt;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close lightbox with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) {
            closeLightbox();
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

</body>
</html>

<?php
// Default footer menu
function photographer_theme_footer_menu() {
    echo '<ul class="footer-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/albums/')) . '">Albums</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">Contact</a></li>';
    echo '<li><a href="' . esc_url(home_url('/privacy-policy/')) . '">Privacy Policy</a></li>';
    echo '</ul>';
}
?>