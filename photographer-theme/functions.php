<?php
/**
 * Photographer Pro functions and definitions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function photographer_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'photographer-theme'),
        'footer'  => esc_html__('Footer Menu', 'photographer-theme'),
    ));

    // Add image sizes
    add_image_size('album-thumbnail', 400, 300, true);
    add_image_size('gallery-large', 1200, 800, true);
    add_image_size('portfolio-grid', 600, 600, true);
}
add_action('after_setup_theme', 'photographer_theme_setup');

/**
 * Enqueue scripts and styles
 */
function photographer_theme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('photographer-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue JavaScript
    wp_enqueue_script('photographer-theme-script', get_template_directory_uri() . '/js/theme.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('photographer-theme-script', 'photographer_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('photographer_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'photographer_theme_scripts');

/**
 * Register widget areas
 */
function photographer_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget 1', 'photographer-theme'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'photographer-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget 2', 'photographer-theme'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here.', 'photographer-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'photographer_theme_widgets_init');

/**
 * Register Album Custom Post Type
 */
function photographer_register_album_post_type() {
    $labels = array(
        'name'                  => _x('Albums', 'Post Type General Name', 'photographer-theme'),
        'singular_name'         => _x('Album', 'Post Type Singular Name', 'photographer-theme'),
        'menu_name'             => __('Photo Albums', 'photographer-theme'),
        'name_admin_bar'        => __('Album', 'photographer-theme'),
        'archives'              => __('Album Archives', 'photographer-theme'),
        'attributes'            => __('Album Attributes', 'photographer-theme'),
        'parent_item_colon'     => __('Parent Album:', 'photographer-theme'),
        'all_items'             => __('All Albums', 'photographer-theme'),
        'add_new_item'          => __('Add New Album', 'photographer-theme'),
        'add_new'               => __('Add New', 'photographer-theme'),
        'new_item'              => __('New Album', 'photographer-theme'),
        'edit_item'             => __('Edit Album', 'photographer-theme'),
        'update_item'           => __('Update Album', 'photographer-theme'),
        'view_item'             => __('View Album', 'photographer-theme'),
        'view_items'            => __('View Albums', 'photographer-theme'),
        'search_items'          => __('Search Album', 'photographer-theme'),
    );

    $args = array(
        'label'                 => __('Album', 'photographer-theme'),
        'description'           => __('Photography Albums', 'photographer-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'taxonomies'            => array('album_category'),
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
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('album', $args);
}
add_action('init', 'photographer_register_album_post_type', 0);

/**
 * Register Album Category Taxonomy
 */
function photographer_register_album_taxonomy() {
    $labels = array(
        'name'                       => _x('Album Categories', 'Taxonomy General Name', 'photographer-theme'),
        'singular_name'              => _x('Album Category', 'Taxonomy Singular Name', 'photographer-theme'),
        'menu_name'                  => __('Categories', 'photographer-theme'),
        'all_items'                  => __('All Categories', 'photographer-theme'),
        'parent_item'                => __('Parent Category', 'photographer-theme'),
        'parent_item_colon'          => __('Parent Category:', 'photographer-theme'),
        'new_item_name'              => __('New Category Name', 'photographer-theme'),
        'add_new_item'               => __('Add New Category', 'photographer-theme'),
        'edit_item'                  => __('Edit Category', 'photographer-theme'),
        'update_item'                => __('Update Category', 'photographer-theme'),
        'view_item'                  => __('View Category', 'photographer-theme'),
        'separate_items_with_commas' => __('Separate categories with commas', 'photographer-theme'),
        'add_or_remove_items'        => __('Add or remove categories', 'photographer-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'photographer-theme'),
        'popular_items'              => __('Popular Categories', 'photographer-theme'),
        'search_items'               => __('Search Categories', 'photographer-theme'),
        'not_found'                  => __('Not Found', 'photographer-theme'),
        'no_terms'                   => __('No categories', 'photographer-theme'),
        'items_list'                 => __('Categories list', 'photographer-theme'),
        'items_list_navigation'      => __('Categories list navigation', 'photographer-theme'),
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

    register_taxonomy('album_category', array('album'), $args);
}
add_action('init', 'photographer_register_album_taxonomy', 0);

/**
 * Customizer additions
 */
function photographer_theme_customize_register($wp_customize) {
    
    // Add Photography Settings Panel
    $wp_customize->add_panel('photographer_settings', array(
        'title'       => __('Photography Settings', 'photographer-theme'),
        'description' => __('Customize your photography website settings', 'photographer-theme'),
        'priority'    => 30,
    ));

    // Homepage Settings Section
    $wp_customize->add_section('homepage_settings', array(
        'title'    => __('Homepage Settings', 'photographer-theme'),
        'priority' => 30,
        'panel'    => 'photographer_settings',
    ));

    // About Section Title
    $wp_customize->add_setting('about_title', array(
        'default'           => 'About the Artist',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('about_title', array(
        'label'    => __('About Section Title', 'photographer-theme'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    // About Description
    $wp_customize->add_setting('about_description', array(
        'default'           => 'Welcome to my world of photography...',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('about_description', array(
        'label'    => __('About Description', 'photographer-theme'),
        'section'  => 'homepage_settings',
        'type'     => 'textarea',
    ));

    // About Second Description
    $wp_customize->add_setting('about_description_2', array(
        'default'           => 'My approach combines artistic vision...',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('about_description_2', array(
        'label'    => __('About Second Description', 'photographer-theme'),
        'section'  => 'homepage_settings',
        'type'     => 'textarea',
    ));

    // About Image
    $wp_customize->add_setting('about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'about_image', array(
        'label'    => __('About Section Image', 'photographer-theme'),
        'section'  => 'homepage_settings',
    )));

    // Portfolio Section Title
    $wp_customize->add_setting('portfolio_title', array(
        'default'           => 'Featured Albums',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('portfolio_title', array(
        'label'    => __('Portfolio Section Title', 'photographer-theme'),
        'section'  => 'homepage_settings',
        'type'     => 'text',
    ));

    // Contact Information Section
    $wp_customize->add_section('contact_info', array(
        'title'    => __('Contact Information', 'photographer-theme'),
        'priority' => 40,
        'panel'    => 'photographer_settings',
    ));

    // Contact Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email', array(
        'label'    => __('Contact Email', 'photographer-theme'),
        'section'  => 'contact_info',
        'type'     => 'email',
    ));

    // Contact Phone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_phone', array(
        'label'    => __('Contact Phone', 'photographer-theme'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));

    // Contact Address
    $wp_customize->add_setting('contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('contact_address', array(
        'label'    => __('Contact Address', 'photographer-theme'),
        'section'  => 'contact_info',
        'type'     => 'textarea',
    ));

    // Social Media Section
    $wp_customize->add_section('social_media', array(
        'title'    => __('Social Media Links', 'photographer-theme'),
        'priority' => 50,
        'panel'    => 'photographer_settings',
    ));

    // Instagram URL
    $wp_customize->add_setting('instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('instagram_url', array(
        'label'    => __('Instagram URL', 'photographer-theme'),
        'section'  => 'social_media',
        'type'     => 'url',
    ));

    // Facebook URL
    $wp_customize->add_setting('facebook_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('facebook_url', array(
        'label'    => __('Facebook URL', 'photographer-theme'),
        'section'  => 'social_media',
        'type'     => 'url',
    ));

    // Twitter URL
    $wp_customize->add_setting('twitter_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('twitter_url', array(
        'label'    => __('Twitter URL', 'photographer-theme'),
        'section'  => 'social_media',
        'type'     => 'url',
    ));

    // Pinterest URL
    $wp_customize->add_setting('pinterest_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('pinterest_url', array(
        'label'    => __('Pinterest URL', 'photographer-theme'),
        'section'  => 'social_media',
        'type'     => 'url',
    ));

    // LinkedIn URL
    $wp_customize->add_setting('linkedin_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('linkedin_url', array(
        'label'    => __('LinkedIn URL', 'photographer-theme'),
        'section'  => 'social_media',
        'type'     => 'url',
    ));

    // Footer Settings Section
    $wp_customize->add_section('footer_settings', array(
        'title'    => __('Footer Settings', 'photographer-theme'),
        'priority' => 60,
        'panel'    => 'photographer_settings',
    ));

    // Footer Description
    $wp_customize->add_setting('footer_description', array(
        'default'           => 'Professional photographer specializing in capturing life\'s most precious moments.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('footer_description', array(
        'label'    => __('Footer Description', 'photographer-theme'),
        'section'  => 'footer_settings',
        'type'     => 'textarea',
    ));

    // Copyright Text
    $wp_customize->add_setting('copyright_text', array(
        'default'           => 'All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('copyright_text', array(
        'label'    => __('Copyright Text', 'photographer-theme'),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ));

    // Albums Page Settings
    $wp_customize->add_section('albums_page_settings', array(
        'title'    => __('Albums Page Settings', 'photographer-theme'),
        'priority' => 70,
        'panel'    => 'photographer_settings',
    ));

    // Albums Page Title
    $wp_customize->add_setting('albums_page_title', array(
        'default'           => 'Photo Albums',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('albums_page_title', array(
        'label'    => __('Albums Page Title', 'photographer-theme'),
        'section'  => 'albums_page_settings',
        'type'     => 'text',
    ));

    // Albums Page Description
    $wp_customize->add_setting('albums_page_description', array(
        'default'           => 'Explore our collection of carefully curated photo albums.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('albums_page_description', array(
        'label'    => __('Albums Page Description', 'photographer-theme'),
        'section'  => 'albums_page_settings',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'photographer_theme_customize_register');

/**
 * Add custom fields to album posts
 */
function photographer_add_album_meta_boxes() {
    add_meta_box(
        'album-details',
        __('Album Details', 'photographer-theme'),
        'photographer_album_details_callback',
        'album',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'photographer_add_album_meta_boxes');

function photographer_album_details_callback($post) {
    wp_nonce_field('photographer_album_details', 'photographer_album_details_nonce');
    
    $featured = get_post_meta($post->ID, 'featured', true);
    $photo_count = get_post_meta($post->ID, 'photo_count', true);
    $album_date = get_post_meta($post->ID, 'album_date', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="featured">Featured Album</label></th>';
    echo '<td><input type="checkbox" id="featured" name="featured" value="yes"' . checked($featured, 'yes', false) . ' /> Check to feature this album on homepage</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="photo_count">Number of Photos</label></th>';
    echo '<td><input type="number" id="photo_count" name="photo_count" value="' . esc_attr($photo_count) . '" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="album_date">Album Date</label></th>';
    echo '<td><input type="date" id="album_date" name="album_date" value="' . esc_attr($album_date) . '" /></td>';
    echo '</tr>';
    echo '</table>';
}

function photographer_save_album_details($post_id) {
    if (!isset($_POST['photographer_album_details_nonce']) || !wp_verify_nonce($_POST['photographer_album_details_nonce'], 'photographer_album_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['featured'])) {
        update_post_meta($post_id, 'featured', sanitize_text_field($_POST['featured']));
    } else {
        delete_post_meta($post_id, 'featured');
    }

    if (isset($_POST['photo_count'])) {
        update_post_meta($post_id, 'photo_count', sanitize_text_field($_POST['photo_count']));
    }

    if (isset($_POST['album_date'])) {
        update_post_meta($post_id, 'album_date', sanitize_text_field($_POST['album_date']));
    }
}
add_action('save_post', 'photographer_save_album_details');

/**
 * Flush rewrite rules on theme activation
 */
function photographer_theme_activation() {
    photographer_register_album_post_type();
    photographer_register_album_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'photographer_theme_activation');

/**
 * Add admin styles
 */
function photographer_admin_styles() {
    echo '<style>
        .form-table th { width: 200px; }
        .form-table td input[type="text"], 
        .form-table td input[type="number"], 
        .form-table td input[type="date"] { width: 300px; }
    </style>';
}
add_action('admin_head', 'photographer_admin_styles');

/**
 * Create sample content on theme activation
 */
function photographer_create_sample_content() {
    // Create Albums page
    $albums_page = get_page_by_path('albums');
    if (!$albums_page) {
        $albums_page_id = wp_insert_post(array(
            'post_title'   => 'Albums',
            'post_content' => 'This is the albums page where all photography albums are displayed.',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'albums',
            'page_template' => 'page-albums.php'
        ));
    }

    // Create About page
    $about_page = get_page_by_path('about');
    if (!$about_page) {
        wp_insert_post(array(
            'post_title'   => 'About',
            'post_content' => 'Welcome to my photography portfolio. I am passionate about capturing life\'s most beautiful moments.',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'about'
        ));
    }

    // Create Contact page
    $contact_page = get_page_by_path('contact');
    if (!$contact_page) {
        wp_insert_post(array(
            'post_title'   => 'Contact',
            'post_content' => 'Get in touch to discuss your photography needs.',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'contact'
        ));
    }
}
add_action('after_switch_theme', 'photographer_create_sample_content');

/**
 * Custom excerpt length
 */
function photographer_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'photographer_excerpt_length');

/**
 * Custom excerpt more
 */
function photographer_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'photographer_excerpt_more');

/**
 * Load theme textdomain
 */
function photographer_theme_load_textdomain() {
    load_theme_textdomain('photographer-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'photographer_theme_load_textdomain');

?>