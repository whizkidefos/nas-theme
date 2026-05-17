<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ANNOUNCEMENT BAR -->
<div class="nas-announcement-bar" id="nasAnnouncement">
    <div class="container">
        <span class="nas-announcement-icon"><?php echo nas_get_svg_skull(14,'#FFDD00'); ?></span>
        <span class="nas-announcement-text">Non Nobis Solum — Not for us alone. Fighting for justice since 1952.</span>
        <span class="nas-announcement-icon"><?php echo nas_get_svg_skull(14,'#FFDD00'); ?></span>
    </div>
    <button class="nas-announcement-close" aria-label="Close" onclick="this.parentElement.style.display='none'">×</button>
</div>

<!-- MAIN HEADER -->
<header class="nas-header" id="nasHeader">
    <div class="container-wide nas-header-inner">

        <!-- Logo -->
        <a href="<?php echo home_url('/'); ?>" class="nas-logo" aria-label="NAS Home">
            <?php if ( has_custom_logo() ):
                the_custom_logo();
            else: ?>
                <div class="nas-logo-text">
                    <div class="nas-logo-mark"><?php echo nas_get_svg_skull(56, '#FFDD00'); ?></div>
                    <div class="nas-logo-words">
                        <span class="nas-logo-main">NAS</span>
                        <span class="nas-logo-sub">Pyrates Confraternity</span>
                    </div>
                </div>
            <?php endif; ?>
        </a>

        <!-- Primary Nav -->
        <nav class="nas-nav" id="nasNav" aria-label="Primary Navigation">
            <ul class="nas-nav-list">
                <li class="<?php echo is_front_page() ? 'current' : ''; ?>">
                    <a href="<?php echo home_url('/'); ?>">Home</a>
                </li>
                <li class="<?php echo is_page('history') ? 'current' : ''; ?>">
                    <a href="<?php echo home_url('/history'); ?>">History</a>
                </li>
                <li class="<?php echo is_page('countries') ? 'current' : ''; ?>">
                    <a href="<?php echo home_url('/countries'); ?>">Countries</a>
                </li>
                <li class="has-dropdown <?php echo is_home() || is_category() || is_single() ? 'current' : ''; ?>">
                    <a href="<?php echo home_url('/news-events'); ?>">News & Events <span class="nas-nav-arrow">▾</span></a>
                    <ul class="nas-dropdown">
                        <?php
                        $cats = get_categories(['number' => 10]);
                        foreach ($cats as $cat) {
                            echo '<li><a href="'.get_category_link($cat->term_id).'">'.esc_html($cat->name).'</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="<?php echo is_page('skull-and-crossbones') ? 'current' : ''; ?>">
                    <a href="<?php echo home_url('/skull-and-crossbones'); ?>">Skull &amp; X-Bones</a>
                </li>
                <li class="<?php echo is_page('join') ? 'current' : ''; ?>">
                    <a href="<?php echo home_url('/join'); ?>" class="nas-nav-cta">Join Us</a>
                </li>
            </ul>
        </nav>

        <!-- Social & Mobile -->
        <div class="nas-header-actions">
            <div class="nas-header-social">
                <?php echo nas_social_links('nas-header-social-link'); ?>
            </div>
            <button class="nas-hamburger" id="nasHamburger" aria-label="Toggle menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>

    </div>

    <!-- Mobile Nav -->
    <div class="nas-mobile-nav" id="nasMobileNav">
        <ul class="nas-mobile-nav-list">
            <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
            <li><a href="<?php echo home_url('/history'); ?>">History</a></li>
            <li><a href="<?php echo home_url('/countries'); ?>">Countries</a></li>
            <li><a href="<?php echo home_url('/news-events'); ?>">News & Events</a></li>
            <li><a href="<?php echo home_url('/skull-and-crossbones'); ?>">Skull & X-Bones</a></li>
            <li><a href="<?php echo home_url('/join'); ?>" class="nas-mobile-nav-cta">Join Us</a></li>
        </ul>
        <div class="nas-mobile-social"><?php echo nas_social_links(); ?></div>
    </div>
</header>

<main id="nasMain">
