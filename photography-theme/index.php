<?php
/**
 * The main template file
 *
 * @package Photography_Portfolio
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            
            <?php if ( is_home() && ! is_front_page() ) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div class="blog-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <header class="entry-header">
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <?php echo get_the_date(); ?>
                                    </span>
                                </div>
                            </header>
                            
                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                Read More →
                            </a>
                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <?php the_posts_navigation(); ?>

        <?php else : ?>
            
            <div class="no-results">
                <h2>Nothing Found</h2>
                <p>It seems we can't find what you're looking for. Perhaps searching can help.</p>
                <?php get_search_form(); ?>
            </div>

        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>