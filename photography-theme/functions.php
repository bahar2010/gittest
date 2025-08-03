<?php
/**
 * Photography Portfolio functions and definitions
 *
 * @package Photography_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Theme setup
 */
function photography_portfolio_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    
    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );
    
    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );
    
    // Add custom image sizes
    add_image_size( 'gallery-thumb', 400, 400, true );
    add_image_size( 'slider-image', 1920, 1080, true );
    add_image_size( 'album-cover', 600, 400, true );
    
    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'photography-portfolio' ),
        'footer' => esc_html__( 'Footer Menu', 'photography-portfolio' ),
    ) );
    
    // Switch default core markup to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    
    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );
    
    // Add support for core custom logo.
    add_theme_support( 'custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ) );
    
    // Add support for wide alignment
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'photography_portfolio_setup' );

/**
 * Enqueue scripts and styles.
 */
function photography_portfolio_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style( 'photography-portfolio-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap', array(), null );
    
    // Enqueue theme stylesheet
    wp_enqueue_style( 'photography-portfolio-style', get_stylesheet_uri(), array(), '1.0.0' );
    
    // Enqueue Font Awesome for icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
    
    // Enqueue theme scripts
    wp_enqueue_script( 'photography-portfolio-slider', get_template_directory_uri() . '/assets/js/slider.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'photography-portfolio-gallery', get_template_directory_uri() . '/assets/js/gallery.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'photography-portfolio-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true );
    
    // Localize script for AJAX
    wp_localize_script( 'photography-portfolio-main', 'photography_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'photography_nonce' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'photography_portfolio_scripts' );

/**
 * Register widget area.
 */
function photography_portfolio_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'photography-portfolio' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'photography-portfolio' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area', 'photography-portfolio' ),
        'id'            => 'footer-widgets',
        'description'   => esc_html__( 'Add footer widgets here.', 'photography-portfolio' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'photography_portfolio_widgets_init' );

/**
 * Register Custom Post Type for Albums
 */
function photography_portfolio_register_album_cpt() {
    $labels = array(
        'name'                  => _x( 'Albums', 'Post Type General Name', 'photography-portfolio' ),
        'singular_name'         => _x( 'Album', 'Post Type Singular Name', 'photography-portfolio' ),
        'menu_name'             => __( 'Albums', 'photography-portfolio' ),
        'name_admin_bar'        => __( 'Album', 'photography-portfolio' ),
        'archives'              => __( 'Album Archives', 'photography-portfolio' ),
        'attributes'            => __( 'Album Attributes', 'photography-portfolio' ),
        'parent_item_colon'     => __( 'Parent Album:', 'photography-portfolio' ),
        'all_items'             => __( 'All Albums', 'photography-portfolio' ),
        'add_new_item'          => __( 'Add New Album', 'photography-portfolio' ),
        'add_new'               => __( 'Add New', 'photography-portfolio' ),
        'new_item'              => __( 'New Album', 'photography-portfolio' ),
        'edit_item'             => __( 'Edit Album', 'photography-portfolio' ),
        'update_item'           => __( 'Update Album', 'photography-portfolio' ),
        'view_item'             => __( 'View Album', 'photography-portfolio' ),
        'view_items'            => __( 'View Albums', 'photography-portfolio' ),
        'search_items'          => __( 'Search Album', 'photography-portfolio' ),
        'not_found'             => __( 'Not found', 'photography-portfolio' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'photography-portfolio' ),
        'featured_image'        => __( 'Album Cover Image', 'photography-portfolio' ),
        'set_featured_image'    => __( 'Set album cover image', 'photography-portfolio' ),
        'remove_featured_image' => __( 'Remove album cover image', 'photography-portfolio' ),
        'use_featured_image'    => __( 'Use as album cover image', 'photography-portfolio' ),
    );
    
    $args = array(
        'label'                 => __( 'Album', 'photography-portfolio' ),
        'description'           => __( 'Photo Albums', 'photography-portfolio' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-gallery',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    
    register_post_type( 'album', $args );
}
add_action( 'init', 'photography_portfolio_register_album_cpt', 0 );

/**
 * Register Custom Taxonomy for Album Categories
 */
function photography_portfolio_register_album_category() {
    $labels = array(
        'name'                       => _x( 'Album Categories', 'Taxonomy General Name', 'photography-portfolio' ),
        'singular_name'              => _x( 'Album Category', 'Taxonomy Singular Name', 'photography-portfolio' ),
        'menu_name'                  => __( 'Categories', 'photography-portfolio' ),
        'all_items'                  => __( 'All Categories', 'photography-portfolio' ),
        'parent_item'                => __( 'Parent Category', 'photography-portfolio' ),
        'parent_item_colon'          => __( 'Parent Category:', 'photography-portfolio' ),
        'new_item_name'              => __( 'New Category Name', 'photography-portfolio' ),
        'add_new_item'               => __( 'Add New Category', 'photography-portfolio' ),
        'edit_item'                  => __( 'Edit Category', 'photography-portfolio' ),
        'update_item'                => __( 'Update Category', 'photography-portfolio' ),
        'view_item'                  => __( 'View Category', 'photography-portfolio' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'photography-portfolio' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'photography-portfolio' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'photography-portfolio' ),
        'popular_items'              => __( 'Popular Categories', 'photography-portfolio' ),
        'search_items'               => __( 'Search Categories', 'photography-portfolio' ),
        'not_found'                  => __( 'Not Found', 'photography-portfolio' ),
        'no_terms'                   => __( 'No categories', 'photography-portfolio' ),
        'items_list'                 => __( 'Categories list', 'photography-portfolio' ),
        'items_list_navigation'      => __( 'Categories list navigation', 'photography-portfolio' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    
    register_taxonomy( 'album_category', array( 'album' ), $args );
}
add_action( 'init', 'photography_portfolio_register_album_category', 0 );

/**
 * Add Meta Box for Album Gallery
 */
function photography_portfolio_add_gallery_meta_box() {
    add_meta_box(
        'album_gallery',
        __( 'Album Gallery', 'photography-portfolio' ),
        'photography_portfolio_gallery_meta_box_callback',
        'album',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'photography_portfolio_add_gallery_meta_box' );

/**
 * Gallery Meta Box Callback
 */
function photography_portfolio_gallery_meta_box_callback( $post ) {
    wp_nonce_field( 'photography_portfolio_save_gallery_meta', 'photography_portfolio_gallery_nonce' );
    
    $gallery_images = get_post_meta( $post->ID, '_album_gallery_images', true );
    ?>
    <div id="album-gallery-container">
        <ul id="album-gallery-list">
            <?php
            if ( $gallery_images ) {
                $gallery_images = explode( ',', $gallery_images );
                foreach ( $gallery_images as $image_id ) {
                    $image_url = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                    if ( $image_url ) {
                        echo '<li class="gallery-image" data-image-id="' . esc_attr( $image_id ) . '">';
                        echo '<img src="' . esc_url( $image_url[0] ) . '" />';
                        echo '<a href="#" class="remove-image">×</a>';
                        echo '</li>';
                    }
                }
            }
            ?>
        </ul>
        <input type="hidden" id="album-gallery-ids" name="album_gallery_images" value="<?php echo esc_attr( $gallery_images ? implode( ',', $gallery_images ) : '' ); ?>" />
        <button type="button" class="button button-primary" id="add-gallery-images"><?php _e( 'Add Images', 'photography-portfolio' ); ?></button>
    </div>
    
    <style>
        #album-gallery-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin: 20px 0;
            padding: 0;
            list-style: none;
        }
        .gallery-image {
            position: relative;
            border: 2px solid #ddd;
            padding: 5px;
            background: #fff;
        }
        .gallery-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #ff0000;
            color: #fff;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 50%;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: '<?php _e( 'Select Images for Gallery', 'photography-portfolio' ); ?>',
                button: {
                    text: '<?php _e( 'Add to Gallery', 'photography-portfolio' ); ?>'
                },
                multiple: true
            });
            
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                var imageIds = $('#album-gallery-ids').val() ? $('#album-gallery-ids').val().split(',') : [];
                
                attachments.forEach(function(attachment) {
                    if (imageIds.indexOf(attachment.id.toString()) === -1) {
                        imageIds.push(attachment.id);
                        
                        var html = '<li class="gallery-image" data-image-id="' + attachment.id + '">';
                        html += '<img src="' + attachment.sizes.thumbnail.url + '" />';
                        html += '<a href="#" class="remove-image">×</a>';
                        html += '</li>';
                        
                        $('#album-gallery-list').append(html);
                    }
                });
                
                $('#album-gallery-ids').val(imageIds.join(','));
            });
            
            frame.open();
        });
        
        $(document).on('click', '.remove-image', function(e) {
            e.preventDefault();
            
            var imageId = $(this).parent().data('image-id');
            var imageIds = $('#album-gallery-ids').val().split(',');
            var index = imageIds.indexOf(imageId.toString());
            
            if (index > -1) {
                imageIds.splice(index, 1);
            }
            
            $('#album-gallery-ids').val(imageIds.join(','));
            $(this).parent().remove();
        });
        
        // Make gallery sortable
        $('#album-gallery-list').sortable({
            update: function(event, ui) {
                var imageIds = [];
                $('#album-gallery-list li').each(function() {
                    imageIds.push($(this).data('image-id'));
                });
                $('#album-gallery-ids').val(imageIds.join(','));
            }
        });
    });
    </script>
    <?php
}

/**
 * Save Gallery Meta Box
 */
function photography_portfolio_save_gallery_meta( $post_id ) {
    if ( ! isset( $_POST['photography_portfolio_gallery_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['photography_portfolio_gallery_nonce'], 'photography_portfolio_save_gallery_meta' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['album_gallery_images'] ) ) {
        update_post_meta( $post_id, '_album_gallery_images', sanitize_text_field( $_POST['album_gallery_images'] ) );
    }
}
add_action( 'save_post_album', 'photography_portfolio_save_gallery_meta' );

/**
 * Customizer settings
 */
function photography_portfolio_customize_register( $wp_customize ) {
    // Add Photography Settings Section
    $wp_customize->add_section( 'photography_settings', array(
        'title'      => __( 'Photography Settings', 'photography-portfolio' ),
        'priority'   => 30,
    ) );
    
    // Homepage Slider Images
    for ( $i = 1; $i <= 5; $i++ ) {
        $wp_customize->add_setting( 'slider_image_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'slider_image_' . $i, array(
            'label'    => sprintf( __( 'Slider Image %d', 'photography-portfolio' ), $i ),
            'section'  => 'photography_settings',
            'settings' => 'slider_image_' . $i,
        ) ) );
        
        $wp_customize->add_setting( 'slider_title_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        
        $wp_customize->add_control( 'slider_title_' . $i, array(
            'label'    => sprintf( __( 'Slider Title %d', 'photography-portfolio' ), $i ),
            'section'  => 'photography_settings',
            'settings' => 'slider_title_' . $i,
            'type'     => 'text',
        ) );
        
        $wp_customize->add_setting( 'slider_description_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );
        
        $wp_customize->add_control( 'slider_description_' . $i, array(
            'label'    => sprintf( __( 'Slider Description %d', 'photography-portfolio' ), $i ),
            'section'  => 'photography_settings',
            'settings' => 'slider_description_' . $i,
            'type'     => 'textarea',
        ) );
    }
    
    // Social Media Links
    $social_networks = array(
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'twitter' => 'Twitter',
        'youtube' => 'YouTube',
        'pinterest' => 'Pinterest',
        'linkedin' => 'LinkedIn',
    );
    
    foreach ( $social_networks as $network => $label ) {
        $wp_customize->add_setting( 'social_' . $network, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'social_' . $network, array(
            'label'    => sprintf( __( '%s URL', 'photography-portfolio' ), $label ),
            'section'  => 'photography_settings',
            'settings' => 'social_' . $network,
            'type'     => 'url',
        ) );
    }
}
add_action( 'customize_register', 'photography_portfolio_customize_register' );

/**
 * Load More Albums AJAX Handler
 */
function photography_portfolio_load_more_albums() {
    check_ajax_referer( 'photography_nonce', 'nonce' );
    
    $paged = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
    
    $args = array(
        'post_type'      => 'album',
        'posts_per_page' => 6,
        'paged'          => $paged,
        'post_status'    => 'publish',
    );
    
    $albums = new WP_Query( $args );
    
    if ( $albums->have_posts() ) {
        while ( $albums->have_posts() ) {
            $albums->the_post();
            get_template_part( 'template-parts/content', 'album' );
        }
    }
    
    wp_die();
}
add_action( 'wp_ajax_load_more_albums', 'photography_portfolio_load_more_albums' );
add_action( 'wp_ajax_nopriv_load_more_albums', 'photography_portfolio_load_more_albums' );