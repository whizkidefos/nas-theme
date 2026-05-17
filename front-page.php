<?php
/**
 * Front Page Template
 */
get_header();
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="nas-hero" id="nasHero">

    <!-- Background canvas for animated particles -->
    <canvas class="nas-hero-canvas" id="nasHeroCanvas"></canvas>

    <!-- Diagonal red band -->
    <div class="nas-hero-band"></div>

    <div class="container nas-hero-content">
        <div class="nas-hero-eyebrow">
            <?php echo nas_get_svg_skull(16,'#FFDD00'); ?>
            <span>National Association of Seadogs · Pyrates Confraternity · Est. 1952</span>
            <?php echo nas_get_svg_skull(16,'#FFDD00'); ?>
        </div>

        <h1 class="nas-hero-title">
            <?php echo get_theme_mod('nas_hero_title', 'Committed to <span>Justice</span> &amp; Equality'); ?>
        </h1>

        <p class="nas-hero-sub">
            <?php echo get_theme_mod('nas_hero_subtitle', 'Since 1952, we have sailed the high seas of justice, fighting for an egalitarian society. Wherever we find ourselves, we are the first to extend a hand to our community.'); ?>
        </p>

        <div class="nas-hero-actions">
            <a href="<?php echo get_theme_mod('nas_hero_btn_url', home_url('/history')); ?>" class="btn btn-gold">
                <?php echo get_theme_mod('nas_hero_btn_text', 'Our Story'); ?>
            </a>
            <a href="<?php echo home_url('/join'); ?>" class="btn btn-outline">
                Join the Brotherhood
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <!-- Stats -->
        <div class="nas-hero-stats">
            <div class="nas-hero-stat">
                <div class="nas-hero-stat-num" data-count="1952">1952</div>
                <div class="nas-hero-stat-label">Founded</div>
            </div>
            <div class="nas-hero-stat-divider"></div>
            <div class="nas-hero-stat">
                <div class="nas-hero-stat-num" data-count="70">70+</div>
                <div class="nas-hero-stat-label">Years of Service</div>
            </div>
            <div class="nas-hero-stat-divider"></div>
            <div class="nas-hero-stat">
                <div class="nas-hero-stat-num" data-count="6">6+</div>
                <div class="nas-hero-stat-label">Countries</div>
            </div>
            <div class="nas-hero-stat-divider"></div>
            <div class="nas-hero-stat">
                <div class="nas-hero-stat-num" data-count="7">7</div>
                <div class="nas-hero-stat-label">Founding Pyrates</div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="nas-hero-scroll">
        <span>Scroll</span>
        <div class="nas-hero-scroll-line"></div>
    </div>

</section>

<!-- ============================================================
     WHO WE ARE SECTION
     ============================================================ -->
<section class="nas-section nas-who-section">
    <div class="container">
        <div class="nas-who-grid">
            <div class="nas-who-image-col">
                <div class="nas-who-emblem">
                    <div class="nas-emblem-ring nas-emblem-ring-outer"></div>
                    <div class="nas-emblem-ring nas-emblem-ring-inner"></div>
                    <div class="nas-emblem-skull"><?php echo nas_get_svg_skull(120,'#FFDD00'); ?></div>
                    <div class="nas-emblem-text">NAS</div>
                </div>
                <div class="nas-who-accent-bar"></div>
            </div>
            <div class="nas-who-text-col">
                <div class="section-label">Who We Are</div>
                <h2 class="section-title">The <span>Pyrates</span> Confraternity</h2>
                <p class="nas-who-lead">Founded in 1952 at the University College Ibadan by Wole Soyinka and six others — the "Magnificent Seven" — we have championed justice, equality, and human dignity for over seven decades.</p>
                <p>The National Association of Seadogs is a non-violent, humanitarian, and progressive confraternity. Our motto, <em>Non Nobis Solum</em> — Not for us alone — defines every action we take.</p>

                <div class="nas-who-pillars">
                    <div class="nas-pillar">
                        <div class="nas-pillar-icon">⚖</div>
                        <div class="nas-pillar-text">
                            <strong>Justice</strong>
                            <span>Fighting systemic inequality at every level</span>
                        </div>
                    </div>
                    <div class="nas-pillar">
                        <div class="nas-pillar-icon">⚓</div>
                        <div class="nas-pillar-text">
                            <strong>Brotherhood</strong>
                            <span>A bond that transcends borders and generations</span>
                        </div>
                    </div>
                    <div class="nas-pillar">
                        <div class="nas-pillar-icon">✦</div>
                        <div class="nas-pillar-text">
                            <strong>Service</strong>
                            <span>Community impact through concrete action</span>
                        </div>
                    </div>
                </div>

                <a href="<?php echo home_url('/history'); ?>" class="btn btn-primary">Read Our History</a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     FEATURED PROJECTS
     ============================================================ -->
<?php
$featured_projects = new WP_Query([
    'post_type'      => 'nas_project',
    'posts_per_page' => 3,
    'meta_query'     => [['key'=>'_nas_featured','value'=>'1','compare'=>'=']],
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
if ( $featured_projects->have_posts() ):
?>
<section class="nas-section nas-projects-section">
    <div class="container">
        <div class="nas-section-header">
            <div>
                <div class="section-label">Worldwide Impact</div>
                <h2 class="section-title">Featured <span>Projects</span></h2>
            </div>
            <a href="<?php echo home_url('/projects'); ?>" class="btn btn-outline">View All Projects</a>
        </div>

        <div class="nas-projects-grid">
            <?php while ( $featured_projects->have_posts() ) : $featured_projects->the_post();
                $country = get_post_meta(get_the_ID(),'_nas_project_country',true);
                $status  = get_post_meta(get_the_ID(),'_nas_project_status',true);
                $year    = get_post_meta(get_the_ID(),'_nas_project_year',true);
            ?>
            <article class="nas-project-card">
                <div class="nas-project-card-img">
                    <?php if ( has_post_thumbnail() ):
                        the_post_thumbnail('nas-card', ['class'=>'nas-project-thumb']);
                    else: ?>
                        <div class="nas-project-placeholder"><?php echo nas_get_svg_skull(48,'rgba(255,221,0,0.2)'); ?></div>
                    <?php endif; ?>
                    <div class="nas-project-overlay"></div>
                    <?php if ($status): ?>
                    <span class="nas-project-status nas-status-<?php echo esc_attr($status); ?>"><?php echo ucfirst($status); ?></span>
                    <?php endif; ?>
                </div>
                <div class="nas-project-card-body">
                    <?php if ($country): ?>
                    <div class="nas-project-location">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?php echo esc_html($country); ?>
                        <?php if ($year): ?><span class="nas-project-year"><?php echo esc_html($year); ?></span><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="nas-project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="nas-project-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    <a href="<?php the_permalink(); ?>" class="nas-project-link">
                        Learn More <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     LATEST NEWS
     ============================================================ -->
<section class="nas-section nas-news-section">
    <div class="container">
        <div class="nas-section-header">
            <div>
                <div class="section-label">From the Deck</div>
                <h2 class="section-title">Latest <span>News</span></h2>
            </div>
            <a href="<?php echo home_url('/news-events'); ?>" class="btn btn-outline">All News</a>
        </div>

        <div class="nas-news-grid">
            <?php
            $news = new WP_Query(['post_type'=>'post','posts_per_page'=>4]);
            while ($news->have_posts()) : $news->the_post();
                $cats = get_the_category();
                $cat  = $cats[0] ?? null;
            ?>
            <article class="nas-news-card">
                <div class="nas-news-card-img">
                    <?php if (has_post_thumbnail()): the_post_thumbnail('nas-card',['class'=>'nas-news-thumb']); else: ?>
                    <div class="nas-news-placeholder"><?php echo nas_get_svg_skull(40,'rgba(255,221,0,0.15)'); ?></div>
                    <?php endif; ?>
                </div>
                <div class="nas-news-card-body">
                    <?php if ($cat): ?>
                    <a href="<?php echo get_category_link($cat->term_id); ?>" class="nas-news-cat"><?php echo esc_html($cat->name); ?></a>
                    <?php endif; ?>
                    <h3 class="nas-news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="nas-news-meta">
                        <span><?php echo get_the_date(); ?></span>
                    </div>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<!-- ============================================================
     JOIN US CTA
     ============================================================ -->
<section class="nas-section nas-cta-section">
    <div class="nas-cta-bg">
        <div class="nas-cta-pattern"></div>
    </div>
    <div class="container nas-cta-inner">
        <div class="nas-cta-skull"><?php echo nas_get_svg_skull(80,'rgba(255,221,0,0.15)'); ?></div>
        <div class="section-label text-center" style="justify-content:center">Join the Brotherhood</div>
        <h2 class="section-title text-center">Ready to <span>Sail</span> with Us?</h2>
        <p class="nas-cta-text">Membership in the National Association of Seadogs is open to individuals committed to justice, integrity, and service. If you believe in our cause, we want to hear from you.</p>
        <?php
        $status = nas_application_status();
        if ($status === 'open'):
        ?>
        <a href="<?php echo home_url('/join'); ?>" class="btn btn-gold nas-cta-btn">Apply Now — Applications Open</a>
        <?php elseif ($status === 'upcoming'):
            $open_date = get_option('nas_app_open','');
            $msg = get_option('nas_app_upcoming_msg','Applications will open on {date}.');
            $msg = str_replace(['{date}','{time}'], [date('F j, Y',strtotime($open_date)), date('g:i A',strtotime($open_date))], $msg);
        ?>
        <div class="nas-cta-msg nas-msg-upcoming"><?php echo wp_kses_post($msg); ?></div>
        <a href="<?php echo home_url('/join'); ?>" class="btn btn-outline">Learn More</a>
        <?php else:
            $msg = get_option('nas_app_closed_msg','Applications are currently closed. Please check back later.');
        ?>
        <div class="nas-cta-msg nas-msg-closed"><?php echo wp_kses_post($msg); ?></div>
        <a href="<?php echo home_url('/join'); ?>" class="btn btn-outline">Learn About Membership</a>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
