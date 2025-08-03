<?php
/**
 * The template for displaying the front page
 *
 * @package Photography_Portfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    
    <!-- Hero Slider -->
    <section class="hero-slider">
        <?php
        $has_slides = false;
        for ( $i = 1; $i <= 5; $i++ ) {
            $slider_image = get_theme_mod( 'slider_image_' . $i );
            if ( $slider_image ) {
                $has_slides = true;
                break;
            }
        }
        
        if ( $has_slides ) :
            for ( $i = 1; $i <= 5; $i++ ) :
                $slider_image = get_theme_mod( 'slider_image_' . $i );
                if ( $slider_image ) :
                    $slider_title = get_theme_mod( 'slider_title_' . $i );
                    $slider_description = get_theme_mod( 'slider_description_' . $i );
                    $image_url = wp_get_attachment_image_url( $slider_image, 'slider-image' );
                    ?>
                    <div class="slide<?php echo $i === 1 ? ' active' : ''; ?>">
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $slider_title ); ?>">
                        <?php if ( $slider_title || $slider_description ) : ?>
                            <div class="slide-content">
                                <?php if ( $slider_title ) : ?>
                                    <h2><?php echo esc_html( $slider_title ); ?></h2>
                                <?php endif; ?>
                                <?php if ( $slider_description ) : ?>
                                    <p><?php echo esc_html( $slider_description ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                endif;
            endfor;
            ?>
            
            <div class="slider-controls">
                <button class="slider-control" id="prev-slide">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="slider-control" id="next-slide">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        <?php else : ?>
            <!-- Default hero if no slider images -->
            <div class="slide active">
                <div class="default-hero">
                    <div class="hero-content">
                        <h1><?php bloginfo( 'name' ); ?></h1>
                        <p><?php bloginfo( 'description' ); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
    
    <!-- Featured Albums Section -->
    <section class="featured-albums">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Featured Albums', 'photography-portfolio' ); ?></h2>
                <p><?php esc_html_e( 'Explore our latest photography collections', 'photography-portfolio' ); ?></p>
            </div>
            
            <?php
            $featured_albums = new WP_Query( array(
                'post_type'      => 'album',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'meta_key'       => '_thumbnail_id',
            ) );
            
            if ( $featured_albums->have_posts() ) : ?>
                <div class="gallery-grid">
                    <?php while ( $featured_albums->have_posts() ) : $featured_albums->the_post(); ?>
                        <article class="gallery-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'album-cover' ); ?>
                                <?php else : ?>
                                    <div class="placeholder-image">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="gallery-overlay">
                                    <div class="gallery-overlay-content">
                                        <h3><?php the_title(); ?></h3>
                                        <?php if ( has_excerpt() ) : ?>
                                            <p><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <div class="section-footer">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'album' ) ); ?>" class="button">
                        <?php esc_html_e( 'View All Albums', 'photography-portfolio' ); ?>
                    </a>
                </div>
            <?php else : ?>
                <p class="no-albums"><?php esc_html_e( 'No albums found. Create your first album to showcase your photography!', 'photography-portfolio' ); ?></p>
            <?php endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="home-about">
        <div class="container">
            <div class="about-section">
                <div class="about-content">
                    <h2><?php esc_html_e( 'Capturing Moments', 'photography-portfolio' ); ?></h2>
                    <p><?php esc_html_e( 'Welcome to our photography portfolio. We specialize in capturing the beauty of life through our lens, creating timeless memories that last forever.', 'photography-portfolio' ); ?></p>
                    <p><?php esc_html_e( 'From breathtaking landscapes to intimate portraits, we bring passion and creativity to every shot.', 'photography-portfolio' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="button">
                        <?php esc_html_e( 'Learn More About Us', 'photography-portfolio' ); ?>
                    </a>
                </div>
                <div class="about-image">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/photographer.jpg' ); ?>" alt="<?php esc_attr_e( 'Photographer at work', 'photography-portfolio' ); ?>">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="home-services">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e( 'Our Services', 'photography-portfolio' ); ?></h2>
                <p><?php esc_html_e( 'Professional photography services for every occasion', 'photography-portfolio' ); ?></p>
            </div>
            
            <div class="services-grid">
                <div class="service-item">
                    <i class="fas fa-ring"></i>
                    <h3><?php esc_html_e( 'Wedding Photography', 'photography-portfolio' ); ?></h3>
                    <p><?php esc_html_e( 'Capture every precious moment of your special day with our professional wedding photography services.', 'photography-portfolio' ); ?></p>
                </div>
                
                <div class="service-item">
                    <i class="fas fa-user"></i>
                    <h3><?php esc_html_e( 'Portrait Sessions', 'photography-portfolio' ); ?></h3>
                    <p><?php esc_html_e( 'Professional portrait photography for individuals, families, and corporate headshots.', 'photography-portfolio' ); ?></p>
                </div>
                
                <div class="service-item">
                    <i class="fas fa-calendar"></i>
                    <h3><?php esc_html_e( 'Event Coverage', 'photography-portfolio' ); ?></h3>
                    <p><?php esc_html_e( 'Complete event photography coverage for corporate events, parties, and special occasions.', 'photography-portfolio' ); ?></p>
                </div>
                
                <div class="service-item">
                    <i class="fas fa-mountain"></i>
                    <h3><?php esc_html_e( 'Landscape Photography', 'photography-portfolio' ); ?></h3>
                    <p><?php esc_html_e( 'Stunning landscape and nature photography for commercial use or personal collections.', 'photography-portfolio' ); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact CTA Section -->
    <section class="home-cta">
        <div class="container">
            <div class="cta-content">
                <h2><?php esc_html_e( 'Ready to Create Something Beautiful?', 'photography-portfolio' ); ?></h2>
                <p><?php esc_html_e( 'Let\'s work together to capture your special moments', 'photography-portfolio' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="button button-white">
                    <?php esc_html_e( 'Get in Touch', 'photography-portfolio' ); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>