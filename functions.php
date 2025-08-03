<?php
/**
 * Photographer Pro Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function photographer_pro_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'photographer-pro'),
        'footer' => esc_html__('Footer Menu', 'photographer-pro'),
    ));
    
    // Add image sizes
    add_image_size('portfolio-thumbnail', 400, 300, true);
    add_image_size('hero-slide', 1920, 1080, true);
    add_image_size('about-image', 600, 600, true);
}
add_action('after_setup_theme', 'photographer_pro_setup');

/**
 * Enqueue scripts and styles
 */
function photographer_pro_scripts() {
    wp_enqueue_style('photographer-pro-style', get_stylesheet_uri(), array(), '1.0.0');
    
    wp_enqueue_script('photographer-pro-script', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'photographer_pro_scripts');

/**
 * Register widget areas
 */
function photographer_pro_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'photographer-pro'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'photographer-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'photographer-pro'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'photographer-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'photographer_pro_widgets_init');

/**
 * Register Custom Post Type for Portfolio
 */
function photographer_pro_portfolio_post_type() {
    $labels = array(
        'name'                  => _x('Portfolio', 'Post Type General Name', 'photographer-pro'),
        'singular_name'         => _x('Portfolio Item', 'Post Type Singular Name', 'photographer-pro'),
        'menu_name'             => __('Portfolio', 'photographer-pro'),
        'name_admin_bar'        => __('Portfolio Item', 'photographer-pro'),
        'archives'              => __('Portfolio Archives', 'photographer-pro'),
        'attributes'            => __('Portfolio Attributes', 'photographer-pro'),
        'parent_item_colon'     => __('Parent Portfolio Item:', 'photographer-pro'),
        'all_items'             => __('All Portfolio Items', 'photographer-pro'),
        'add_new_item'          => __('Add New Portfolio Item', 'photographer-pro'),
        'add_new'               => __('Add New', 'photographer-pro'),
        'new_item'              => __('New Portfolio Item', 'photographer-pro'),
        'edit_item'             => __('Edit Portfolio Item', 'photographer-pro'),
        'update_item'           => __('Update Portfolio Item', 'photographer-pro'),
        'view_item'             => __('View Portfolio Item', 'photographer-pro'),
        'view_items'            => __('View Portfolio Items', 'photographer-pro'),
        'search_items'          => __('Search Portfolio Items', 'photographer-pro'),
        'not_found'             => __('Not found', 'photographer-pro'),
        'not_found_in_trash'    => __('Not found in Trash', 'photographer-pro'),
        'featured_image'        => __('Featured Image', 'photographer-pro'),
        'set_featured_image'    => __('Set featured image', 'photographer-pro'),
        'remove_featured_image' => __('Remove featured image', 'photographer-pro'),
        'use_featured_image'    => __('Use as featured image', 'photographer-pro'),
        'insert_into_item'      => __('Insert into portfolio item', 'photographer-pro'),
        'uploaded_to_this_item' => __('Uploaded to this portfolio item', 'photographer-pro'),
        'items_list'            => __('Portfolio items list', 'photographer-pro'),
        'items_list_navigation' => __('Portfolio items list navigation', 'photographer-pro'),
        'filter_items_list'     => __('Filter portfolio items list', 'photographer-pro'),
    );
    $args = array(
        'label'                 => __('Portfolio Item', 'photographer-pro'),
        'description'           => __('Portfolio items for photographer', 'photographer-pro'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array('portfolio_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-camera',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('portfolio', $args);
}
add_action('init', 'photographer_pro_portfolio_post_type');

/**
 * Register Portfolio Category Taxonomy
 */
function photographer_pro_portfolio_taxonomy() {
    $labels = array(
        'name'              => _x('Portfolio Categories', 'taxonomy general name', 'photographer-pro'),
        'singular_name'     => _x('Portfolio Category', 'taxonomy singular name', 'photographer-pro'),
        'search_items'      => __('Search Portfolio Categories', 'photographer-pro'),
        'all_items'         => __('All Portfolio Categories', 'photographer-pro'),
        'parent_item'       => __('Parent Portfolio Category', 'photographer-pro'),
        'parent_item_colon' => __('Parent Portfolio Category:', 'photographer-pro'),
        'edit_item'         => __('Edit Portfolio Category', 'photographer-pro'),
        'update_item'       => __('Update Portfolio Category', 'photographer-pro'),
        'add_new_item'      => __('Add New Portfolio Category', 'photographer-pro'),
        'new_item_name'     => __('New Portfolio Category Name', 'photographer-pro'),
        'menu_name'         => __('Portfolio Categories', 'photographer-pro'),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio-category'),
        'show_in_rest'      => true,
    );
    register_taxonomy('portfolio_category', array('portfolio'), $args);
}
add_action('init', 'photographer_pro_portfolio_taxonomy');

/**
 * Fallback menu function
 */
function photographer_pro_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/portfolio/')) . '">Portfolio</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">Contact</a></li>';
    echo '</ul>';
}

/**
 * Customizer additions
 */
function photographer_pro_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section', 'photographer-pro'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Capturing Life\'s Moments',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'photographer-pro'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'Professional Photography Services',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'photographer-pro'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));
    
    // About Section
    $wp_customize->add_section('about_section', array(
        'title'    => __('About Section', 'photographer-pro'),
        'priority' => 35,
    ));
    
    $wp_customize->add_setting('about_title', array(
        'default'           => 'About Me',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_title', array(
        'label'   => __('About Title', 'photographer-pro'),
        'section' => 'about_section',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('about_content', array(
        'default'           => 'I am a passionate photographer with over 10 years of experience capturing life\'s most precious moments.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('about_content', array(
        'label'   => __('About Content', 'photographer-pro'),
        'section' => 'about_section',
        'type'    => 'textarea',
    ));
    
    // Contact Information
    $wp_customize->add_section('contact_section', array(
        'title'    => __('Contact Information', 'photographer-pro'),
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('contact_email', array(
        'default'           => 'hello@photographer.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label'   => __('Email Address', 'photographer-pro'),
        'section' => 'contact_section',
        'type'    => 'email',
    ));
    
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label'   => __('Phone Number', 'photographer-pro'),
        'section' => 'contact_section',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('contact_address', array(
        'default'           => '123 Photography St, City, State 12345',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_address', array(
        'label'   => __('Address', 'photographer-pro'),
        'section' => 'contact_section',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'photographer_pro_customize_register');

/**
 * Add custom meta boxes for portfolio
 */
function photographer_pro_add_meta_boxes() {
    add_meta_box(
        'portfolio_details',
        'Portfolio Details',
        'photographer_pro_portfolio_meta_box',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'photographer_pro_add_meta_boxes');

function photographer_pro_portfolio_meta_box($post) {
    wp_nonce_field('photographer_pro_save_meta_box_data', 'photographer_pro_meta_box_nonce');
    
    $featured = get_post_meta($post->ID, '_featured', true);
    $client = get_post_meta($post->ID, '_client', true);
    $date = get_post_meta($post->ID, '_date', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="featured">Featured on Homepage</label></th>';
    echo '<td><input type="checkbox" id="featured" name="featured" value="1" ' . checked($featured, '1', false) . ' /></td></tr>';
    echo '<tr><th><label for="client">Client</label></th>';
    echo '<td><input type="text" id="client" name="client" value="' . esc_attr($client) . '" /></td></tr>';
    echo '<tr><th><label for="date">Date</label></th>';
    echo '<td><input type="date" id="date" name="date" value="' . esc_attr($date) . '" /></td></tr>';
    echo '</table>';
}

function photographer_pro_save_meta_box_data($post_id) {
    if (!isset($_POST['photographer_pro_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['photographer_pro_meta_box_nonce'], 'photographer_pro_save_meta_box_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $featured = isset($_POST['featured']) ? '1' : '';
    $client = sanitize_text_field($_POST['client']);
    $date = sanitize_text_field($_POST['date']);
    
    update_post_meta($post_id, '_featured', $featured);
    update_post_meta($post_id, '_client', $client);
    update_post_meta($post_id, '_date', $date);
}
add_action('save_post', 'photographer_pro_save_meta_box_data');

/**
 * Add custom image sizes to media library
 */
function photographer_pro_custom_image_sizes($sizes) {
    $custom_sizes = array(
        'portfolio-thumbnail' => 'Portfolio Thumbnail',
        'hero-slide' => 'Hero Slide',
        'about-image' => 'About Image'
    );
    return array_merge($sizes, $custom_sizes);
}
add_filter('image_size_names_choose', 'photographer_pro_custom_image_sizes');

/**
 * Add theme support for WooCommerce
 */
function photographer_pro_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'photographer_pro_woocommerce_support');