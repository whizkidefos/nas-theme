<?php get_header(); ?>

<div class="nas-page-hero nas-page-hero-sm">
    <div class="nas-page-hero-overlay"></div>
    <div class="container nas-page-hero-content">
        <div class="section-label">Search Results</div>
        <h1 class="nas-page-hero-title">
            <?php printf( 'Results for: <span>%s</span>', esc_html( get_search_query() ) ); ?>
        </h1>
        <p class="nas-page-hero-sub"><?php echo $wp_query->found_posts; ?> result<?php echo $wp_query->found_posts !== 1 ? 's' : ''; ?> found.</p>
    </div>
</div>

<section class="nas-section">
    <div class="container">
        <?php get_search_form(); ?>
        <div class="nas-posts-grid" style="margin-top:40px">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                $cats = get_the_category(); $cat = $cats[0] ?? null; ?>
            <article class="nas-post-card">
                <div class="nas-post-card-img">
                    <?php if ( has_post_thumbnail() ): the_post_thumbnail('nas-card',['class'=>'nas-post-thumb']); else: ?>
                    <div class="nas-post-placeholder"><?php echo nas_get_svg_skull(40,'rgba(255,221,0,0.1)'); ?></div>
                    <?php endif; ?>
                    <?php if ($cat): ?><a href="<?php echo get_category_link($cat->term_id); ?>" class="nas-post-cat"><?php echo esc_html($cat->name); ?></a><?php endif; ?>
                </div>
                <div class="nas-post-card-body">
                    <div class="nas-post-meta"><span><?php echo get_the_date(); ?></span></div>
                    <h2 class="nas-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p class="nas-post-excerpt"><?php echo wp_trim_words(get_the_excerpt(),22); ?></p>
                    <a href="<?php the_permalink(); ?>" class="nas-post-link">Read More →</a>
                </div>
            </article>
            <?php endwhile; else: ?>
            <div class="nas-empty-state" style="grid-column:1/-1">
                <div><?php echo nas_get_svg_skull(60,'rgba(255,221,0,0.15)'); ?></div>
                <h3 style="color:var(--nas-gold);margin:16px 0 8px">No results found</h3>
                <p>No posts matched your search for "<?php echo esc_html(get_search_query()); ?>". Try different keywords.</p>
            </div>
            <?php endif; ?>
        </div>
        <div class="nas-pagination"><?php echo paginate_links(['prev_text'=>'← Previous','next_text'=>'Next →']); ?></div>
    </div>
</section>

<?php get_footer(); ?>
