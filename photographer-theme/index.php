<?php
/**
 * The main template file for Photographer Pro theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Slider Section -->
    <section class="hero-slider">
        <div class="slider-container">
            <?php
            // Get featured images from WordPress media library or custom posts
            $slider_images = array(
                array(
                    'image' => get_template_directory_uri() . '/assets/images/slide1.jpg',
                    'title' => 'Capturing Life\'s Beautiful Moments',
                    'description' => 'Professional photography that tells your unique story',
                    'button_text' => 'View Portfolio',
                    'button_link' => '#portfolio'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/slide2.jpg',
                    'title' => 'Wedding Photography',
                    'description' => 'Preserving your special day with artistic elegance',
                    'button_text' => 'Wedding Gallery',
                    'button_link' => '/albums/weddings'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/slide3.jpg',
                    'title' => 'Portrait Sessions',
                    'description' => 'Professional portraits that capture your essence',
                    'button_text' => 'Book Session',
                    'button_link' => '/contact'
                )
            );

            foreach ($slider_images as $index => $slide) : ?>
                <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                     style="background-image: url('<?php echo esc_url($slide['image']); ?>')">
                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h1 class="slide-title"><?php echo esc_html($slide['title']); ?></h1>
                            <p class="slide-description"><?php echo esc_html($slide['description']); ?></p>
                            <a href="<?php echo esc_url($slide['button_link']); ?>" class="cta-button">
                                <?php echo esc_html($slide['button_text']); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Slider Navigation -->
            <div class="slider-nav">
                <?php foreach ($slider_images as $index => $slide) : ?>
                    <span class="nav-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                          data-slide="<?php echo $index; ?>"></span>
                <?php endforeach; ?>
            </div>

            <!-- Slider Arrows -->
            <div class="slider-arrows prev-arrow" id="prevSlide">&#8249;</div>
            <div class="slider-arrows next-arrow" id="nextSlide">&#8250;</div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2><?php echo get_theme_mod('about_title', 'About the Artist'); ?></h2>
                    <p><?php echo get_theme_mod('about_description', 'Welcome to my world of photography. I am passionate about capturing life\'s most precious moments and turning them into timeless memories. With over 10 years of experience, I specialize in wedding, portrait, and lifestyle photography.'); ?></p>
                    <p><?php echo get_theme_mod('about_description_2', 'My approach combines artistic vision with technical expertise to create images that not only look beautiful but also tell meaningful stories. Every shoot is a unique collaboration between photographer and subject.'); ?></p>
                    <a href="<?php echo get_permalink(get_page_by_path('about')); ?>" class="cta-button">Learn More</a>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_theme_mod('about_image', get_template_directory_uri() . '/assets/images/about.jpg'); ?>" 
                         alt="<?php echo get_theme_mod('about_title', 'About the Artist'); ?>">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Albums Section -->
    <section class="featured-albums" id="portfolio">
        <div class="container">
            <h2 class="section-title"><?php echo get_theme_mod('portfolio_title', 'Featured Albums'); ?></h2>
            <div class="albums-grid">
                <?php
                // Query for portfolio/album posts
                $featured_albums = new WP_Query(array(
                    'post_type' => 'album',
                    'posts_per_page' => 6,
                    'meta_key' => 'featured',
                    'meta_value' => 'yes'
                ));

                if ($featured_albums->have_posts()) :
                    while ($featured_albums->have_posts()) : $featured_albums->the_post();
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
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Default albums if no custom post type exists
                    $default_albums = array(
                        array(
                            'title' => 'Wedding Photography',
                            'description' => 'Elegant and romantic wedding moments captured with artistic flair.',
                            'image' => get_template_directory_uri() . '/assets/images/wedding-album.jpg',
                            'link' => '/albums/weddings'
                        ),
                        array(
                            'title' => 'Portrait Sessions',
                            'description' => 'Professional portraits that showcase personality and character.',
                            'image' => get_template_directory_uri() . '/assets/images/portrait-album.jpg',
                            'link' => '/albums/portraits'
                        ),
                        array(
                            'title' => 'Nature & Landscapes',
                            'description' => 'Breathtaking natural scenes and outdoor photography.',
                            'image' => get_template_directory_uri() . '/assets/images/nature-album.jpg',
                            'link' => '/albums/nature'
                        ),
                        array(
                            'title' => 'Event Photography',
                            'description' => 'Corporate events, parties, and special celebrations.',
                            'image' => get_template_directory_uri() . '/assets/images/event-album.jpg',
                            'link' => '/albums/events'
                        ),
                        array(
                            'title' => 'Street Photography',
                            'description' => 'Candid moments and urban life captured in the moment.',
                            'image' => get_template_directory_uri() . '/assets/images/street-album.jpg',
                            'link' => '/albums/street'
                        ),
                        array(
                            'title' => 'Family Sessions',
                            'description' => 'Heartwarming family moments and connections.',
                            'image' => get_template_directory_uri() . '/assets/images/family-album.jpg',
                            'link' => '/albums/family'
                        )
                    );

                    foreach ($default_albums as $album) : ?>
                        <div class="album-card">
                            <div class="album-image" style="background-image: url('<?php echo esc_url($album['image']); ?>')">
                                <div class="album-overlay">
                                    <a href="<?php echo esc_url($album['link']); ?>" class="view-album">View Album</a>
                                </div>
                            </div>
                            <div class="album-info">
                                <h3 class="album-title"><?php echo esc_html($album['title']); ?></h3>
                                <p class="album-description"><?php echo esc_html($album['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Contact CTA Section -->
    <section class="contact-cta" style="background: linear-gradient(135deg, #2c3e50, #e74c3c); padding: 80px 0; text-align: center; color: white;">
        <div class="container">
            <h2 style="font-size: 2.5rem; margin-bottom: 20px; font-weight: 300;">Ready to Create Something Beautiful?</h2>
            <p style="font-size: 1.2rem; margin-bottom: 30px; opacity: 0.9;">Let's discuss your photography needs and bring your vision to life.</p>
            <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>" class="cta-button">Get In Touch</a>
        </div>
    </section>
</main>

<?php get_footer(); ?>