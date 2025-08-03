<?php
/**
 * The template for displaying the footer
 *
 * @package Photography_Portfolio
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar( 'footer-widgets' ); ?>
                </div>
            <?php endif; ?>
            
            <div class="footer-bottom">
                <div class="footer-social">
                    <?php
                    $social_networks = array(
                        'facebook' => 'fab fa-facebook-f',
                        'instagram' => 'fab fa-instagram',
                        'twitter' => 'fab fa-twitter',
                        'youtube' => 'fab fa-youtube',
                        'pinterest' => 'fab fa-pinterest-p',
                        'linkedin' => 'fab fa-linkedin-in',
                    );
                    
                    foreach ( $social_networks as $network => $icon ) :
                        $url = get_theme_mod( 'social_' . $network );
                        if ( $url ) :
                            ?>
                            <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>">
                                <i class="<?php echo esc_attr( $icon ); ?>"></i>
                            </a>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </div>
                
                <?php
                if ( has_nav_menu( 'footer' ) ) :
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ) );
                endif;
                ?>
                
                <div class="site-info">
                    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. 
                    <?php esc_html_e( 'All rights reserved.', 'photography-portfolio' ); ?></p>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
    <span class="lightbox-close">&times;</span>
    <div class="lightbox-content">
        <img src="" alt="">
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>