<?php get_header(); the_post(); $cats = get_the_category(); $cat = $cats[0] ?? null; ?>

<article class="nas-single-article" itemscope itemtype="http://schema.org/Article">

    <div class="nas-single-hero">
        <?php if ( has_post_thumbnail() ): ?>
        <div class="nas-single-hero-img"><?php the_post_thumbnail( 'nas-hero', ['itemprop'=>'image'] ); ?></div>
        <div class="nas-single-hero-overlay"></div>
        <?php endif; ?>
        <div class="container nas-single-hero-content">
            <?php if ( $cat ): ?>
            <a href="<?php echo get_category_link( $cat->term_id ); ?>" class="nas-single-cat"><?php echo esc_html( $cat->name ); ?></a>
            <?php endif; ?>
            <h1 class="nas-single-title" itemprop="headline"><?php the_title(); ?></h1>
            <div class="nas-single-meta">
                <time itemprop="datePublished" datetime="<?php the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                <span class="nas-meta-sep">·</span>
                <span><?php echo nas_reading_time(); ?> min read</span>
                <span class="nas-meta-sep">·</span>
                <span class="nas-post-editorial"><?php echo nas_get_svg_skull(14,'#FFDD00'); ?> The Editorial Team</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="nas-single-body">
            <div class="nas-single-content" itemprop="articleBody">
                <?php the_content(); ?>
                <?php
                wp_link_pages([
                    'before' => '<div class="nas-page-links"><span>Pages:</span>',
                    'after'  => '</div>',
                ]);
                ?>
            </div>

            <footer class="nas-single-footer">
                <div class="nas-single-tags">
                    <?php the_tags( '<span class="nas-tag">', '</span><span class="nas-tag">', '</span>' ); ?>
                </div>
                <div class="nas-single-share">
                    <span style="font-family:var(--font-ui);font-size:11px;color:var(--nas-gray);text-transform:uppercase;letter-spacing:0.1em">Share:</span>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" class="nas-share-btn">X</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="nas-share-btn">Facebook</a>
                </div>
            </footer>

            <nav class="nas-post-nav" aria-label="Post navigation">
                <div class="nas-prev-post">
                    <?php $prev = get_previous_post(); if ( $prev ): ?>
                    <span>← Previous</span>
                    <a href="<?php echo get_permalink( $prev ); ?>"><?php echo get_the_title( $prev ); ?></a>
                    <?php endif; ?>
                </div>
                <div class="nas-next-post">
                    <?php $next = get_next_post(); if ( $next ): ?>
                    <span>Next →</span>
                    <a href="<?php echo get_permalink( $next ); ?>"><?php echo get_the_title( $next ); ?></a>
                    <?php endif; ?>
                </div>
            </nav>

            <?php if ( comments_open() || get_comments_number() ): ?>
            <div class="nas-single-comments" style="margin-top:60px;padding-top:40px;border-top:var(--border-red)">
                <?php comments_template(); ?>
            </div>
            <?php endif; ?>

        </div>
    </div>

</article>

<?php get_footer(); ?>
