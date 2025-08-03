    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3><?php bloginfo('name'); ?></h3>
                <p><?php echo get_field('footer_description') ?: 'Professional photography services for weddings, portraits, events, and more. Capturing life\'s precious moments with creativity and passion.'; ?></p>
            </div>
            
            <div class="footer-section">
                <h3>Services</h3>
                <ul>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('services'))); ?>">Wedding Photography</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('services'))); ?>">Portrait Sessions</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('services'))); ?>">Event Photography</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('services'))); ?>">Landscape Photography</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact</h3>
                <p>
                    <?php echo get_field('contact_email') ?: 'hello@photographer.com'; ?><br>
                    <?php echo get_field('contact_phone') ?: '+1 (555) 123-4567'; ?><br>
                    <?php echo get_field('contact_address') ?: '123 Photography St, City, State 12345'; ?>
                </p>
            </div>
            
            <div class="footer-section">
                <h3>Follow Me</h3>
                <div class="social-links">
                    <?php if (get_field('social_instagram')) : ?>
                        <a href="<?php echo esc_url(get_field('social_instagram')); ?>" target="_blank" rel="noopener">Instagram</a>
                    <?php endif; ?>
                    <?php if (get_field('social_facebook')) : ?>
                        <a href="<?php echo esc_url(get_field('social_facebook')); ?>" target="_blank" rel="noopener">Facebook</a>
                    <?php endif; ?>
                    <?php if (get_field('social_twitter')) : ?>
                        <a href="<?php echo esc_url(get_field('social_twitter')); ?>" target="_blank" rel="noopener">Twitter</a>
                    <?php endif; ?>
                    <?php if (get_field('social_pinterest')) : ?>
                        <a href="<?php echo esc_url(get_field('social_pinterest')); ?>" target="_blank" rel="noopener">Pinterest</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
        </div>
    </footer>
</div><!-- #page -->

<!-- Lightbox for Gallery -->
<div class="lightbox" id="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <img src="" alt="" id="lightbox-img">
</div>

<?php wp_footer(); ?>

<script>
// Hero Slider Functionality
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 0;
    
    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }
    
    // Auto-advance slides
    setInterval(nextSlide, 5000);
    
    // Click navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    // Portfolio lightbox
    const portfolioItems = document.querySelectorAll('.portfolio-item img');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    
    portfolioItems.forEach(img => {
        img.addEventListener('click', () => {
            lightboxImg.src = img.src;
            lightboxImg.alt = img.alt;
            lightbox.classList.add('active');
        });
    });
});

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
}

// Close lightbox with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});

// Smooth scrolling for navigation links
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

// Header scroll effect
window.addEventListener('scroll', function() {
    const header = document.querySelector('.site-header');
    if (window.scrollY > 100) {
        header.style.background = 'rgba(255, 255, 255, 0.98)';
        header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
    } else {
        header.style.background = 'rgba(255, 255, 255, 0.95)';
        header.style.boxShadow = 'none';
    }
});
</script>

</body>
</html>