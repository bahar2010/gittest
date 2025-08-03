<?php
/**
 * Template Name: Portfolio
 *
 * @package Photographer_Pro
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="main-content">
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if (get_field('portfolio_subtitle')) : ?>
                <p class="page-subtitle"><?php echo esc_html(get_field('portfolio_subtitle')); ?></p>
            <?php endif; ?>
        </header>

        <!-- Portfolio Filter -->
        <div class="portfolio-filter">
            <button class="filter-btn active" data-filter="all">All</button>
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'portfolio_category',
                'hide_empty' => true,
            ));
            
            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    echo '<button class="filter-btn" data-filter="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</button>';
                }
            }
            ?>
        </div>

        <!-- Portfolio Grid -->
        <div class="portfolio-grid" id="portfolio-grid">
            <?php
            $portfolio_query = new WP_Query(array(
                'post_type' => 'portfolio',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($portfolio_query->have_posts()) :
                while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                    $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                    $category_classes = '';
                    if ($categories && !is_wp_error($categories)) {
                        foreach ($categories as $category) {
                            $category_classes .= ' ' . $category->slug;
                        }
                    }
                    
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'portfolio-thumbnail');
                    if (!$image) {
                        $image = get_template_directory_uri() . '/assets/images/portfolio-placeholder.jpg';
                    }
            ?>
                    <div class="portfolio-item<?php echo esc_attr($category_classes); ?>" data-categories="<?php echo esc_attr($category_classes); ?>">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        <div class="portfolio-overlay">
                            <h3><?php echo esc_html(get_the_title()); ?></h3>
                            <?php if ($categories && !is_wp_error($categories)) : ?>
                                <p><?php echo esc_html($categories[0]->name); ?></p>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="portfolio-link">View Details</a>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="no-portfolio">
                    <p>No portfolio items found. Please add some portfolio items to see them here.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Portfolio Pagination -->
        <?php if ($portfolio_query->max_num_pages > 1) : ?>
            <div class="portfolio-pagination">
                <?php
                echo paginate_links(array(
                    'total' => $portfolio_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
/* Portfolio Filter Styles */
.portfolio-filter {
    text-align: center;
    margin-bottom: 3rem;
}

.filter-btn {
    background: transparent;
    border: 2px solid #007acc;
    color: #007acc;
    padding: 10px 20px;
    margin: 0 5px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.filter-btn:hover,
.filter-btn.active {
    background: #007acc;
    color: white;
}

/* Portfolio Grid Styles */
.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.portfolio-item {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    opacity: 1;
    transform: scale(1);
}

.portfolio-item.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

.portfolio-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.portfolio-item img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.portfolio-item:hover img {
    transform: scale(1.05);
}

.portfolio-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 2rem 1.5rem 1.5rem;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.portfolio-item:hover .portfolio-overlay {
    transform: translateY(0);
}

.portfolio-overlay h3 {
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.portfolio-overlay p {
    color: rgba(255,255,255,0.8);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.portfolio-link {
    color: white;
    text-decoration: none;
    font-weight: 500;
    border-bottom: 1px solid white;
    transition: border-color 0.3s ease;
}

.portfolio-link:hover {
    border-bottom-color: #007acc;
}

/* Page Header Styles */
.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-title {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.page-subtitle {
    font-size: 1.2rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

/* Pagination Styles */
.portfolio-pagination {
    text-align: center;
    margin-top: 3rem;
}

.portfolio-pagination .page-numbers {
    display: inline-block;
    padding: 10px 15px;
    margin: 0 5px;
    background: #f8f9fa;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
    transition: background 0.3s ease;
}

.portfolio-pagination .page-numbers:hover,
.portfolio-pagination .page-numbers.current {
    background: #007acc;
    color: white;
}

/* No Portfolio Items */
.no-portfolio {
    text-align: center;
    padding: 4rem 2rem;
    color: #666;
}

/* Responsive Design */
@media (max-width: 768px) {
    .portfolio-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-btn {
        margin: 5px;
        font-size: 0.9rem;
        padding: 8px 16px;
    }
    
    .page-title {
        font-size: 2.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter portfolio items
            portfolioItems.forEach(item => {
                if (filter === 'all' || item.classList.contains(filter)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });
    });
    
    // Add loading animation to portfolio items
    portfolioItems.forEach((item, index) => {
        item.style.animationDelay = (index * 0.1) + 's';
        item.classList.add('loading');
    });
});
</script>

<?php get_footer(); ?>