<?php
/**
 * The template for displaying single album posts
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <!-- Album Header -->
        <section class="page-header">
            <div class="container">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <p class="page-description"><?php echo get_the_excerpt(); ?></p>
                <div class="album-meta-header" style="margin-top: 20px; display: flex; gap: 30px; justify-content: center; color: rgba(255,255,255,0.8);">
                    <?php 
                    $photo_count = get_post_meta(get_the_ID(), 'photo_count', true);
                    $album_date = get_post_meta(get_the_ID(), 'album_date', true);
                    if ($photo_count) : ?>
                        <span><i class="fas fa-camera"></i> <?php echo esc_html($photo_count); ?> Photos</span>
                    <?php endif; ?>
                    <span><i class="fas fa-calendar"></i> <?php echo get_the_date('F j, Y'); ?></span>
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'album_category');
                    if ($categories && !is_wp_error($categories)) :
                        foreach ($categories as $category) : ?>
                            <span><i class="fas fa-tag"></i> <?php echo esc_html($category->name); ?></span>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </section>

        <!-- Album Content -->
        <section class="album-content" style="padding: 80px 0;">
            <div class="container">
                <?php if (get_the_content()) : ?>
                    <div class="album-description" style="max-width: 800px; margin: 0 auto 60px; text-align: center; font-size: 1.1rem; line-height: 1.8; color: #666;">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

                <!-- Photo Gallery -->
                <div class="album-gallery">
                    <?php
                    // Check if we have gallery images in post content
                    $gallery_shortcode = get_post_gallery(get_the_ID(), false);
                    
                    if ($gallery_shortcode) :
                        // Extract image IDs from gallery shortcode
                        $gallery_ids = explode(',', $gallery_shortcode['ids']);
                        ?>
                        <div class="photo-grid">
                            <?php foreach ($gallery_ids as $image_id) :
                                $image_url = wp_get_attachment_image_url($image_id, 'large');
                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                $image_caption = wp_get_attachment_caption($image_id);
                                ?>
                                <div class="photo-item">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                    <div class="photo-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                    <?php if ($image_caption) : ?>
                                        <div class="photo-info">
                                            <h4><?php echo esc_html($image_caption); ?></h4>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else :
                        // Default demo photos for albums
                        $demo_photos = array(
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo1.jpg',
                                'title' => 'Beautiful Moment 1',
                                'caption' => 'Capturing the essence of natural beauty'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo2.jpg',
                                'title' => 'Beautiful Moment 2',
                                'caption' => 'A perfect portrait session'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo3.jpg',
                                'title' => 'Beautiful Moment 3',
                                'caption' => 'Artistic composition and lighting'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo4.jpg',
                                'title' => 'Beautiful Moment 4',
                                'caption' => 'Candid moments captured perfectly'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo5.jpg',
                                'title' => 'Beautiful Moment 5',
                                'caption' => 'Professional photography at its finest'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo6.jpg',
                                'title' => 'Beautiful Moment 6',
                                'caption' => 'Emotional storytelling through imagery'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo7.jpg',
                                'title' => 'Beautiful Moment 7',
                                'caption' => 'Creative angles and perspectives'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo8.jpg',
                                'title' => 'Beautiful Moment 8',
                                'caption' => 'Timeless memories preserved forever'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo9.jpg',
                                'title' => 'Beautiful Moment 9',
                                'caption' => 'Expert use of natural lighting'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo10.jpg',
                                'title' => 'Beautiful Moment 10',
                                'caption' => 'Stunning composition and color'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo11.jpg',
                                'title' => 'Beautiful Moment 11',
                                'caption' => 'Authentic emotions captured'
                            ),
                            array(
                                'image' => get_template_directory_uri() . '/assets/images/gallery/photo12.jpg',
                                'title' => 'Beautiful Moment 12',
                                'caption' => 'Professional portrait excellence'
                            )
                        );
                        ?>
                        <div class="photo-grid">
                            <?php foreach ($demo_photos as $photo) : ?>
                                <div class="photo-item">
                                    <img src="<?php echo esc_url($photo['image']); ?>" alt="<?php echo esc_attr($photo['title']); ?>">
                                    <div class="photo-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                    <div class="photo-info">
                                        <h4><?php echo esc_html($photo['title']); ?></h4>
                                        <p><?php echo esc_html($photo['caption']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Album Navigation -->
                <div class="album-navigation" style="margin-top: 80px; padding-top: 40px; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                    <div class="nav-previous">
                        <?php
                        $prev_post = get_previous_post();
                        if ($prev_post) : ?>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                <i class="fas fa-arrow-left"></i>
                                <span>
                                    <small>Previous Album</small><br>
                                    <strong><?php echo esc_html($prev_post->post_title); ?></strong>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="nav-center">
                        <a href="<?php echo get_permalink(get_page_by_path('albums')); ?>" class="cta-button">
                            <i class="fas fa-th"></i> All Albums
                        </a>
                    </div>

                    <div class="nav-next">
                        <?php
                        $next_post = get_next_post();
                        if ($next_post) : ?>
                            <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                <span>
                                    <small>Next Album</small><br>
                                    <strong><?php echo esc_html($next_post->post_title); ?></strong>
                                </span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Albums -->
        <?php
        $related_albums = new WP_Query(array(
            'post_type' => 'album',
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand'
        ));

        if ($related_albums->have_posts()) : ?>
            <section class="related-albums" style="padding: 80px 0; background: #f8f9fa;">
                <div class="container">
                    <h2 class="section-title">Related Albums</h2>
                    <div class="albums-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
                        <?php while ($related_albums->have_posts()) : $related_albums->the_post();
                            $album_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            if (!$album_image) {
                                $album_image = get_template_directory_uri() . '/assets/images/default-album.jpg';
                            }
                            ?>
                            <div class="album-card">
                                <div class="album-image" style="background-image: url('<?php echo esc_url($album_image); ?>')">
                                    <div class="album-overlay">
                                        <a href="<?php the_permalink(); ?>" class="view-album">View Album</a>
                                    </div>
                                </div>
                                <div class="album-info">
                                    <h3 class="album-title"><?php the_title(); ?></h3>
                                    <p class="album-description"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Contact CTA -->
        <section class="contact-cta" style="background: linear-gradient(135deg, #2c3e50, #e74c3c); padding: 80px 0; text-align: center; color: white;">
            <div class="container">
                <h2 style="font-size: 2.5rem; margin-bottom: 20px; font-weight: 300;">Interested in a Session?</h2>
                <p style="font-size: 1.2rem; margin-bottom: 30px; opacity: 0.9;">Let's create beautiful memories together. Get in touch to discuss your photography needs.</p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>" class="cta-button">Get In Touch</a>
                    <a href="<?php echo get_permalink(get_page_by_path('albums')); ?>" class="cta-button" style="background: transparent; border: 2px solid white;">View More Albums</a>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<style>
/* Album-specific styles */
.album-meta-header span {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #e74c3c;
}

.nav-link small {
    color: #888;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.nav-link strong {
    font-size: 1rem;
    font-weight: 600;
}

.nav-next {
    text-align: right;
}

.photo-info p {
    margin: 5px 0 0;
    font-size: 0.9rem;
    opacity: 0.8;
}

.album-gallery {
    margin-bottom: 40px;
}

@media (max-width: 768px) {
    .album-meta-header {
        flex-direction: column;
        gap: 15px !important;
    }
    
    .album-navigation {
        flex-direction: column;
        gap: 30px;
        text-align: center;
    }
    
    .nav-next,
    .nav-previous {
        text-align: center !important;
    }
    
    .nav-link {
        justify-content: center;
    }
}

/* Enhanced lightbox styles for album view */
.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 15px 20px;
    cursor: pointer;
    font-size: 20px;
    transition: background 0.3s ease;
}

.lightbox-nav:hover {
    background: rgba(0,0,0,0.7);
}

.lightbox-prev {
    left: 20px;
}

.lightbox-next {
    right: 20px;
}

.lightbox-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    background: rgba(0,0,0,0.5);
    padding: 10px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
}
</style>

<script>
// Enhanced lightbox functionality for albums
document.addEventListener('DOMContentLoaded', function() {
    const photoItems = document.querySelectorAll('.photo-item');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    let currentPhotoIndex = 0;
    let photoList = [];

    // Build photo list
    photoItems.forEach((item, index) => {
        const img = item.querySelector('img');
        if (img) {
            photoList.push({
                src: img.src,
                alt: img.alt
            });
            
            item.addEventListener('click', function() {
                currentPhotoIndex = index;
                showLightbox();
            });
        }
    });

    function showLightbox() {
        if (photoList.length > 0) {
            lightboxImage.src = photoList[currentPhotoIndex].src;
            lightboxImage.alt = photoList[currentPhotoIndex].alt;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Add navigation if more than one photo
            if (photoList.length > 1) {
                addLightboxNavigation();
            }
        }
    }

    function addLightboxNavigation() {
        // Remove existing navigation
        const existingNav = lightbox.querySelectorAll('.lightbox-nav, .lightbox-counter');
        existingNav.forEach(el => el.remove());

        const lightboxContent = lightbox.querySelector('.lightbox-content');
        
        // Add previous button
        const prevBtn = document.createElement('button');
        prevBtn.className = 'lightbox-nav lightbox-prev';
        prevBtn.innerHTML = '‹';
        prevBtn.addEventListener('click', previousPhoto);
        lightboxContent.appendChild(prevBtn);

        // Add next button
        const nextBtn = document.createElement('button');
        nextBtn.className = 'lightbox-nav lightbox-next';
        nextBtn.innerHTML = '›';
        nextBtn.addEventListener('click', nextPhoto);
        lightboxContent.appendChild(nextBtn);

        // Add counter
        const counter = document.createElement('div');
        counter.className = 'lightbox-counter';
        counter.textContent = `${currentPhotoIndex + 1} / ${photoList.length}`;
        lightboxContent.appendChild(counter);
    }

    function nextPhoto() {
        currentPhotoIndex = (currentPhotoIndex + 1) % photoList.length;
        updateLightbox();
    }

    function previousPhoto() {
        currentPhotoIndex = (currentPhotoIndex - 1 + photoList.length) % photoList.length;
        updateLightbox();
    }

    function updateLightbox() {
        lightboxImage.src = photoList[currentPhotoIndex].src;
        lightboxImage.alt = photoList[currentPhotoIndex].alt;
        
        const counter = lightbox.querySelector('.lightbox-counter');
        if (counter) {
            counter.textContent = `${currentPhotoIndex + 1} / ${photoList.length}`;
        }
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (lightbox.classList.contains('active')) {
            switch(e.key) {
                case 'ArrowLeft':
                    previousPhoto();
                    break;
                case 'ArrowRight':
                    nextPhoto();
                    break;
                case 'Escape':
                    lightbox.classList.remove('active');
                    document.body.style.overflow = '';
                    break;
            }
        }
    });
});
</script>

<?php get_footer(); ?>