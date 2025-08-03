<?php
/**
 * The template for displaying album archive pages
 *
 * @package Photography_Portfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="album-header">
        <div class="container">
            <h1 class="page-title"><?php esc_html_e( 'Photography Albums', 'photography-portfolio' ); ?></h1>
            <p class="page-description"><?php esc_html_e( 'Browse through our collection of photography albums', 'photography-portfolio' ); ?></p>
            
            <?php
            // Display album categories
            $terms = get_terms( array(
                'taxonomy' => 'album_category',
                'hide_empty' => true,
            ) );
            
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
                <div class="album-categories">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'album' ) ); ?>" class="category-filter active">
                        <?php esc_html_e( 'All', 'photography-portfolio' ); ?>
                    </a>
                    <?php foreach ( $terms as $term ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="category-filter">
                            <?php echo esc_html( $term->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <div class="gallery-grid" id="album-grid">
                <?php while ( have_posts() ) : the_post(); ?>
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
                                    <?php
                                    $gallery_images = get_post_meta( get_the_ID(), '_album_gallery_images', true );
                                    if ( $gallery_images ) {
                                        $image_count = count( explode( ',', $gallery_images ) );
                                        ?>
                                        <p class="image-count">
                                            <?php printf( _n( '%s Photo', '%s Photos', $image_count, 'photography-portfolio' ), $image_count ); ?>
                                        </p>
                                    <?php } ?>
                                    <?php if ( has_excerpt() ) : ?>
                                        <p><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php
            // Pagination
            the_posts_pagination( array(
                'mid_size' => 2,
                'prev_text' => __( '← Previous', 'photography-portfolio' ),
                'next_text' => __( 'Next →', 'photography-portfolio' ),
            ) );
            ?>
            
        <?php else : ?>
            <div class="no-results">
                <h2><?php esc_html_e( 'No Albums Found', 'photography-portfolio' ); ?></h2>
                <p><?php esc_html_e( 'It looks like there are no albums to display yet.', 'photography-portfolio' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>