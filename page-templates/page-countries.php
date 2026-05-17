<?php
/**
 * Template Name: Countries Page
 */
get_header();
$countries = get_terms(['taxonomy'=>'deck_country','hide_empty'=>false]);
?>
<div class="nas-page-hero">
    <div class="nas-page-hero-overlay"></div>
    <div class="container nas-page-hero-content">
        <div class="section-label">Worldwide</div>
        <h1 class="nas-page-hero-title">Our <span>Countries</span></h1>
        <p class="nas-page-hero-sub">NAS operates in <?php echo count($countries); ?>+ countries. Find your local deck below.</p>
    </div>
</div>

<section class="nas-section">
    <div class="container">

        <!-- Country Filter -->
        <div class="nas-country-filter">
            <button class="nas-filter-btn active" data-filter="all">All Countries</button>
            <?php foreach ($countries as $country): ?>
            <button class="nas-filter-btn" data-filter="<?php echo esc_attr($country->slug); ?>"><?php echo esc_html($country->name); ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Decks Grid -->
        <div class="nas-decks-grid" id="nasDecksGrid">
            <?php
            $decks = new WP_Query([
                'post_type'      => 'nas_deck',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);
            while ($decks->have_posts()) : $decks->the_post();
                $deck_name = get_post_meta(get_the_ID(),'_nas_deck_name',true);
                $city      = get_post_meta(get_the_ID(),'_nas_deck_city',true);
                $address   = get_post_meta(get_the_ID(),'_nas_deck_address',true);
                $email     = get_post_meta(get_the_ID(),'_nas_deck_email',true);
                $phone     = get_post_meta(get_the_ID(),'_nas_deck_phone',true);
                $founded   = get_post_meta(get_the_ID(),'_nas_deck_founded',true);
                $deck_countries = get_the_terms(get_the_ID(),'deck_country');
                $country_slug = $deck_countries ? $deck_countries[0]->slug : '';
                $country_name = $deck_countries ? $deck_countries[0]->name : '';
            ?>
            <div class="nas-deck-card" data-country="<?php echo esc_attr($country_slug); ?>">
                <div class="nas-deck-card-header">
                    <div class="nas-deck-icon"><?php echo nas_get_svg_skull(32,'#FFDD00'); ?></div>
                    <div class="nas-deck-header-info">
                        <?php if ($deck_name): ?>
                        <div class="nas-deck-name"><?php echo esc_html($deck_name); ?> Deck</div>
                        <?php endif; ?>
                        <h3 class="nas-deck-title"><?php the_title(); ?></h3>
                        <?php if ($country_name): ?>
                        <div class="nas-deck-country"><?php echo esc_html($country_name); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="nas-deck-card-body">
                    <?php if (get_the_excerpt()): ?><p class="nas-deck-excerpt"><?php the_excerpt(); ?></p><?php endif; ?>
                    <div class="nas-deck-details">
                        <?php if ($city): ?>
                        <div class="nas-deck-detail">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo esc_html($city); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($address): ?>
                        <div class="nas-deck-detail">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?php echo esc_html($address); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($email): ?>
                        <div class="nas-deck-detail">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                        <?php endif; ?>
                        <?php if ($phone): ?>
                        <div class="nas-deck-detail">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.42 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.69a16 16 0 0 0 6.29 6.29l1.06-.75a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <?php echo esc_html($phone); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($founded): ?>
                        <div class="nas-deck-detail">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Est. <?php echo esc_html($founded); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>

            <?php if (!$decks->found_posts): ?>
            <div class="nas-empty-state">
                <div><?php echo nas_get_svg_skull(60,'rgba(255,221,0,0.2)'); ?></div>
                <p>No decks found. Add decks from the WordPress admin under <strong>Decks</strong>.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php get_footer(); ?>
