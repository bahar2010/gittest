<?php
/**
 * Template Name: Albums Page
 * The template for displaying the albums/gallery page
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title"><?php echo get_theme_mod('albums_page_title', 'Photo Albums'); ?></h1>
            <p class="page-description"><?php echo get_theme_mod('albums_page_description', 'Explore our collection of carefully curated photo albums showcasing different styles and moments.'); ?></p>
        </div>
    </section>

    <!-- Gallery Container -->
    <section class="gallery-container">
        <div class="container">
            <?php
            // Check if we have album posts
            $albums_query = new WP_Query(array(
                'post_type' => 'album',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC'
            ));

            if ($albums_query->have_posts()) : ?>
                <div class="albums-grid">
                    <?php while ($albums_query->have_posts()) : $albums_query->the_post();
                        $album_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        if (!$album_image) {
                            $album_image = get_template_directory_uri() . '/assets/images/default-album.jpg';
                        }
                        $photo_count = get_post_meta(get_the_ID(), 'photo_count', true);
                        if (!$photo_count) $photo_count = '12';
                        ?>
                        <div class="album-card">
                            <div class="album-image" style="background-image: url('<?php echo esc_url($album_image); ?>')">
                                <div class="album-overlay">
                                    <a href="<?php the_permalink(); ?>" class="view-album">
                                        <i class="fas fa-images"></i> View Album
                                    </a>
                                </div>
                            </div>
                            <div class="album-info">
                                <h3 class="album-title"><?php the_title(); ?></h3>
                                <p class="album-description"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <div class="album-meta">
                                    <span class="photo-count"><i class="fas fa-camera"></i> <?php echo esc_html($photo_count); ?> Photos</span>
                                    <span class="album-date"><i class="fas fa-calendar"></i> <?php echo get_the_date('M Y'); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else :
                    // Default albums if no custom post type exists
                    $default_albums = array(
                        array(
                            'title' => 'Wedding Photography',
                            'description' => 'Elegant and romantic wedding moments captured with artistic flair. From intimate ceremonies to grand celebrations.',
                            'image' => get_template_directory_uri() . '/assets/images/wedding-album.jpg',
                            'link' => '#',
                            'count' => '45',
                            'date' => 'Dec 2023'
                        ),
                        array(
                            'title' => 'Portrait Sessions',
                            'description' => 'Professional portraits that showcase personality and character. Individual and group portrait sessions.',
                            'image' => get_template_directory_uri() . '/assets/images/portrait-album.jpg',
                            'link' => '#',
                            'count' => '32',
                            'date' => 'Nov 2023'
                        ),
                        array(
                            'title' => 'Nature & Landscapes',
                            'description' => 'Breathtaking natural scenes and outdoor photography. Capturing the beauty of the natural world.',
                            'image' => get_template_directory_uri() . '/assets/images/nature-album.jpg',
                            'link' => '#',
                            'count' => '28',
                            'date' => 'Oct 2023'
                        ),
                        array(
                            'title' => 'Event Photography',
                            'description' => 'Corporate events, parties, and special celebrations. Professional event documentation.',
                            'image' => get_template_directory_uri() . '/assets/images/event-album.jpg',
                            'link' => '#',
                            'count' => '38',
                            'date' => 'Sep 2023'
                        ),
                        array(
                            'title' => 'Street Photography',
                            'description' => 'Candid moments and urban life captured in the moment. The beauty of everyday life.',
                            'image' => get_template_directory_uri() . '/assets/images/street-album.jpg',
                            'link' => '#',
                            'count' => '24',
                            'date' => 'Aug 2023'
                        ),
                        array(
                            'title' => 'Family Sessions',
                            'description' => 'Heartwarming family moments and connections. Capturing the love and bonds between family members.',
                            'image' => get_template_directory_uri() . '/assets/images/family-album.jpg',
                            'link' => '#',
                            'count' => '41',
                            'date' => 'Jul 2023'
                        ),
                        array(
                            'title' => 'Architecture Photography',
                            'description' => 'Modern and classic architectural photography. Showcasing the beauty of design and structure.',
                            'image' => get_template_directory_uri() . '/assets/images/architecture-album.jpg',
                            'link' => '#',
                            'count' => '19',
                            'date' => 'Jun 2023'
                        ),
                        array(
                            'title' => 'Fashion Photography',
                            'description' => 'Creative fashion and lifestyle photography. Editorial and commercial fashion shoots.',
                            'image' => get_template_directory_uri() . '/assets/images/fashion-album.jpg',
                            'link' => '#',
                            'count' => '35',
                            'date' => 'May 2023'
                        ),
                        array(
                            'title' => 'Travel Photography',
                            'description' => 'Adventures and destinations from around the world. Capturing the essence of different cultures.',
                            'image' => get_template_directory_uri() . '/assets/images/travel-album.jpg',
                            'link' => '#',
                            'count' => '52',
                            'date' => 'Apr 2023'
                        )
                    );
                    ?>
                    <div class="albums-grid">
                        <?php foreach ($default_albums as $album) : ?>
                            <div class="album-card">
                                <div class="album-image" style="background-image: url('<?php echo esc_url($album['image']); ?>')">
                                    <div class="album-overlay">
                                        <a href="<?php echo esc_url($album['link']); ?>" class="view-album">
                                            <i class="fas fa-images"></i> View Album
                                        </a>
                                    </div>
                                </div>
                                <div class="album-info">
                                    <h3 class="album-title"><?php echo esc_html($album['title']); ?></h3>
                                    <p class="album-description"><?php echo esc_html($album['description']); ?></p>
                                    <div class="album-meta">
                                        <span class="photo-count"><i class="fas fa-camera"></i> <?php echo esc_html($album['count']); ?> Photos</span>
                                        <span class="album-date"><i class="fas fa-calendar"></i> <?php echo esc_html($album['date']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>
    </section>

    <!-- Sample Photo Gallery Section -->
    <section class="sample-gallery" style="padding: 80px 0; background: #f8f9fa;">
        <div class="container">
            <h2 class="section-title">Featured Photos</h2>
            <p style="text-align: center; margin-bottom: 50px; color: #666; font-size: 1.1rem;">A selection of our best work from various albums</p>
            
            <div class="photo-grid">
                <?php
                // Sample photos for demonstration
                $sample_photos = array(
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample1.jpg',
                        'title' => 'Wedding Moment',
                        'category' => 'Wedding'
                    ),
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample2.jpg',
                        'title' => 'Portrait Session',
                        'category' => 'Portrait'
                    ),
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample3.jpg',
                        'title' => 'Landscape Beauty',
                        'category' => 'Nature'
                    ),
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample4.jpg',
                        'title' => 'Family Joy',
                        'category' => 'Family'
                    ),
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample5.jpg',
                        'title' => 'Urban Life',
                        'category' => 'Street'
                    ),
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample6.jpg',
                        'title' => 'Event Celebration',
                        'category' => 'Event'
                    ),
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample7.jpg',
                        'title' => 'Fashion Style',
                        'category' => 'Fashion'
                    ),
                    array(
                        'image' => get_template_directory_uri() . '/assets/images/sample8.jpg',
                        'title' => 'Architecture Detail',
                        'category' => 'Architecture'
                    )
                );

                foreach ($sample_photos as $photo) : ?>
                    <div class="photo-item">
                        <img src="<?php echo esc_url($photo['image']); ?>" alt="<?php echo esc_attr($photo['title']); ?>">
                        <div class="photo-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                        <div class="photo-info">
                            <h4><?php echo esc_html($photo['title']); ?></h4>
                            <span class="photo-category"><?php echo esc_html($photo['category']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup Section -->
    <section class="newsletter-section" style="background: linear-gradient(135deg, #2c3e50, #e74c3c); padding: 80px 0; text-align: center; color: white;">
        <div class="container">
            <h2 style="font-size: 2.5rem; margin-bottom: 20px; font-weight: 300;">Stay Updated</h2>
            <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9;">Subscribe to get notified about new albums and photography sessions</p>
            <form class="newsletter-form" style="max-width: 500px; margin: 0 auto; display: flex; gap: 15px;">
                <input type="email" placeholder="Enter your email address" style="flex: 1; padding: 15px; border: none; border-radius: 50px; font-size: 1rem;">
                <button type="submit" class="cta-button" style="background: white; color: #2c3e50;">Subscribe</button>
            </form>
        </div>
    </section>
</main>

<style>
/* Additional styles for albums page */
.album-meta {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    font-size: 0.9rem;
    color: #888;
}

.album-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.photo-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 20px 15px 15px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.photo-item:hover .photo-info {
    transform: translateY(0);
}

.photo-info h4 {
    margin: 0 0 5px;
    font-size: 1rem;
    font-weight: 600;
}

.photo-category {
    font-size: 0.8rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.newsletter-form input {
    outline: none;
}

.newsletter-form input:focus {
    box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
}

@media (max-width: 768px) {
    .album-meta {
        flex-direction: column;
        gap: 5px;
    }
    
    .newsletter-form {
        flex-direction: column;
        gap: 15px;
    }
    
    .newsletter-form button {
        align-self: stretch;
    }
}
</style>

<?php get_footer(); ?>