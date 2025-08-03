<?php get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Section with Slider -->
    <section class="hero-section">
        <div class="hero-slider">
            <?php
            // Get slider images from custom field or default images
            $slider_images = get_field('hero_slider_images') ?: array();
            if (empty($slider_images)) {
                // Default slider images
                $slider_images = array(
                    array('image' => get_template_directory_uri() . '/assets/images/slide1.jpg', 'title' => 'Capturing Life\'s Moments', 'subtitle' => 'Professional Photography Services'),
                    array('image' => get_template_directory_uri() . '/assets/images/slide2.jpg', 'title' => 'Wedding Photography', 'subtitle' => 'Making Your Special Day Unforgettable'),
                    array('image' => get_template_directory_uri() . '/assets/images/slide3.jpg', 'title' => 'Portrait Sessions', 'subtitle' => 'Professional Portraits That Tell Your Story')
                );
            }
            
            foreach ($slider_images as $index => $slide) :
            ?>
                <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                     style="background-image: url('<?php echo esc_url($slide['image']); ?>')">
                    <div class="slide-content">
                        <h1><?php echo esc_html($slide['title']); ?></h1>
                        <p><?php echo esc_html($slide['subtitle']); ?></p>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('portfolio'))); ?>" class="btn">View Portfolio</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Slider Navigation -->
        <div class="slider-nav">
            <?php for ($i = 0; $i < count($slider_images); $i++) : ?>
                <div class="slider-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
            <?php endfor; ?>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <!-- About Section -->
        <section class="about-section">
            <div class="about-image">
                <?php 
                $about_image = get_field('about_image') ?: get_template_directory_uri() . '/assets/images/photographer.jpg';
                ?>
                <img src="<?php echo esc_url($about_image); ?>" alt="Photographer">
            </div>
            <div class="about-content">
                <h2><?php echo get_field('about_title') ?: 'About Me'; ?></h2>
                <?php echo get_field('about_content') ?: '<p>I am a passionate photographer with over 10 years of experience capturing life\'s most precious moments. From weddings to portraits, I strive to create images that tell your unique story.</p>'; ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="btn btn-secondary">Learn More</a>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <h2 class="section-title"><?php echo get_field('services_title') ?: 'My Services'; ?></h2>
            <div class="services-grid">
                <?php
                $services = get_field('services') ?: array(
                    array('icon' => '📸', 'title' => 'Wedding Photography', 'description' => 'Capture your special day with beautiful, timeless images'),
                    array('icon' => '👤', 'title' => 'Portrait Sessions', 'description' => 'Professional portraits for individuals and families'),
                    array('icon' => '🎉', 'title' => 'Event Photography', 'description' => 'Corporate events, parties, and special occasions'),
                    array('icon' => '🌅', 'title' => 'Landscape Photography', 'description' => 'Stunning nature and landscape photography')
                );
                
                foreach ($services as $service) :
                ?>
                    <div class="service-card">
                        <div class="service-icon"><?php echo $service['icon']; ?></div>
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Featured Portfolio -->
        <section class="featured-portfolio">
            <h2 class="section-title"><?php echo get_field('portfolio_title') ?: 'Featured Work'; ?></h2>
            <div class="portfolio-grid">
                <?php
                // Get featured portfolio items
                $portfolio_query = new WP_Query(array(
                    'post_type' => 'portfolio',
                    'posts_per_page' => 6,
                    'meta_query' => array(
                        array(
                            'key' => 'featured',
                            'value' => '1',
                            'compare' => '='
                        )
                    )
                ));
                
                if ($portfolio_query->have_posts()) :
                    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        $image = get_field('portfolio_image') ?: get_the_post_thumbnail_url();
                ?>
                        <div class="portfolio-item">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                            <div class="portfolio-overlay">
                                <h3><?php echo esc_html(get_the_title()); ?></h3>
                                <p><?php echo esc_html(get_field('portfolio_category')); ?></p>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Default portfolio items
                    $default_portfolio = array(
                        array('title' => 'Wedding Collection', 'category' => 'Wedding', 'image' => get_template_directory_uri() . '/assets/images/portfolio1.jpg'),
                        array('title' => 'Portrait Session', 'category' => 'Portrait', 'image' => get_template_directory_uri() . '/assets/images/portfolio2.jpg'),
                        array('title' => 'Nature Photography', 'category' => 'Landscape', 'image' => get_template_directory_uri() . '/assets/images/portfolio3.jpg'),
                        array('title' => 'Event Coverage', 'category' => 'Event', 'image' => get_template_directory_uri() . '/assets/images/portfolio4.jpg'),
                        array('title' => 'Family Session', 'category' => 'Family', 'image' => get_template_directory_uri() . '/assets/images/portfolio5.jpg'),
                        array('title' => 'Corporate Event', 'category' => 'Corporate', 'image' => get_template_directory_uri() . '/assets/images/portfolio6.jpg')
                    );
                    
                    foreach ($default_portfolio as $item) :
                ?>
                        <div class="portfolio-item">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                            <div class="portfolio-overlay">
                                <h3><?php echo esc_html($item['title']); ?></h3>
                                <p><?php echo esc_html($item['category']); ?></p>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div class="text-center" style="margin-top: 3rem;">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('portfolio'))); ?>" class="btn">View All Work</a>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="testimonials">
            <div class="main-content">
                <h2 class="section-title text-center"><?php echo get_field('testimonials_title') ?: 'What Clients Say'; ?></h2>
                <div class="testimonial">
                    <?php
                    $testimonials = get_field('testimonials') ?: array(
                        array('quote' => 'Amazing work! The wedding photos are absolutely stunning and captured our special day perfectly.', 'author' => 'Sarah & John'),
                        array('quote' => 'Professional, creative, and easy to work with. Highly recommend for any photography needs.', 'author' => 'Mike Johnson'),
                        array('quote' => 'The family portraits turned out better than we could have imagined. Thank you!', 'author' => 'The Williams Family')
                    );
                    
                    $current_testimonial = $testimonials[array_rand($testimonials)];
                    ?>
                    <blockquote><?php echo esc_html($current_testimonial['quote']); ?></blockquote>
                    <div class="testimonial-author">— <?php echo esc_html($current_testimonial['author']); ?></div>
                </div>
            </div>
        </section>

        <!-- Contact CTA -->
        <section class="contact-cta">
            <div class="text-center">
                <h2><?php echo get_field('contact_title') ?: 'Ready to Capture Your Story?'; ?></h2>
                <p><?php echo get_field('contact_subtitle') ?: 'Let\'s work together to create beautiful memories that will last a lifetime.'; ?></p>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn">Get In Touch</a>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>