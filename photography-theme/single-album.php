<?php
/**
 * The template for displaying single album posts
 *
 * @package Photography_Portfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="album-header">
                <div class="container">
                    <h1 class="album-title"><?php the_title(); ?></h1>
                    
                    <div class="album-meta">
                        <span class="album-date">
                            <i class="far fa-calendar"></i>
                            <?php echo get_the_date(); ?>
                        </span>
                        
                        <?php
                        $categories = get_the_terms( get_the_ID(), 'album_category' );
                        if ( $categories && ! is_wp_error( $categories ) ) : ?>
                            <span class="album-categories">
                                <i class="far fa-folder"></i>
                                <?php
                                $category_names = array();
                                foreach ( $categories as $category ) {
                                    $category_names[] = '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
                                }
                                echo implode( ', ', $category_names );
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ( has_excerpt() || get_the_content() ) : ?>
                        <div class="album-description">
                            <?php
                            if ( has_excerpt() ) {
                                the_excerpt();
                            } else {
                                the_content();
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="container">
                <?php
                $gallery_images = get_post_meta( get_the_ID(), '_album_gallery_images', true );
                
                if ( $gallery_images ) :
                    $image_ids = explode( ',', $gallery_images );
                    ?>
                    
                    <div class="album-gallery">
                        <div class="gallery-grid album-images">
                            <?php foreach ( $image_ids as $image_id ) :
                                $image_url = wp_get_attachment_image_url( $image_id, 'large' );
                                $thumbnail_url = wp_get_attachment_image_url( $image_id, 'gallery-thumb' );
                                $image_caption = wp_get_attachment_caption( $image_id );
                                
                                if ( $image_url ) : ?>
                                    <div class="gallery-item">
                                        <a href="<?php echo esc_url( $image_url ); ?>" class="lightbox-trigger" data-caption="<?php echo esc_attr( $image_caption ); ?>">
                                            <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( $image_caption ); ?>">
                                            <div class="gallery-overlay">
                                                <div class="gallery-overlay-content">
                                                    <i class="fas fa-search-plus"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                    
                <?php else : ?>
                    <div class="no-images">
                        <p><?php esc_html_e( 'No images have been added to this album yet.', 'photography-portfolio' ); ?></p>
                    </div>
                <?php endif; ?>
                
                <!-- Album Navigation -->
                <nav class="album-navigation">
                    <div class="nav-previous">
                        <?php previous_post_link( '%link', '<i class="fas fa-chevron-left"></i> %title', true, '', 'album_category' ); ?>
                    </div>
                    <div class="nav-all">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'album' ) ); ?>">
                            <i class="fas fa-th"></i>
                            <?php esc_html_e( 'All Albums', 'photography-portfolio' ); ?>
                        </a>
                    </div>
                    <div class="nav-next">
                        <?php next_post_link( '%link', '%title <i class="fas fa-chevron-right"></i>', true, '', 'album_category' ); ?>
                    </div>
                </nav>
                
                <!-- Related Albums -->
                <?php
                $related_args = array(
                    'post_type' => 'album',
                    'posts_per_page' => 3,
                    'post__not_in' => array( get_the_ID() ),
                    'orderby' => 'rand',
                );
                
                // Get albums from same category
                if ( $categories && ! is_wp_error( $categories ) ) {
                    $category_ids = wp_list_pluck( $categories, 'term_id' );
                    $related_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'album_category',
                            'field' => 'term_id',
                            'terms' => $category_ids,
                        ),
                    );
                }
                
                $related_albums = new WP_Query( $related_args );
                
                if ( $related_albums->have_posts() ) : ?>
                    <section class="related-albums">
                        <h2><?php esc_html_e( 'Related Albums', 'photography-portfolio' ); ?></h2>
                        <div class="gallery-grid">
                            <?php while ( $related_albums->have_posts() ) : $related_albums->the_post(); ?>
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
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </section>
                <?php endif;
                wp_reset_postdata();
                ?>
            </div>
        </article>
        
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>