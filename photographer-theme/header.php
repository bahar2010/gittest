<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="site-branding">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        if ($custom_logo_id) :
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            ?>
                            <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" style="height: 40px; width: auto;">
                        <?php else : ?>
                            <?php echo get_theme_mod('site_title', get_bloginfo('name')); ?>
                        <?php endif; ?>
                    </a>
                </div>

                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'photographer_theme_default_menu',
                    ));
                    ?>
                </nav>

                <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <?php
    // Default navigation menu if no menu is set
    function photographer_theme_default_menu() {
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
        echo '<li><a href="' . esc_url(home_url('/albums/')) . '">Albums</a></li>';
        echo '<li><a href="' . esc_url(home_url('/about/')) . '">About</a></li>';
        echo '<li><a href="' . esc_url(home_url('/services/')) . '">Services</a></li>';
        echo '<li><a href="' . esc_url(home_url('/contact/')) . '">Contact</a></li>';
        echo '</ul>';
    }
    ?>