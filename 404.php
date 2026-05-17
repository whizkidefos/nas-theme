<?php get_header(); ?>

<section class="nas-section nas-404-section">
    <div class="container">
        <div class="nas-404-num">404</div>
        <?php echo nas_get_svg_skull(80, 'rgba(255,221,0,0.2)'); ?>
        <h2>Lost at Sea, Pyrate</h2>
        <p>The page you are looking for has sailed off into uncharted waters. Let us help you find your way back.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
            <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Return Home</a>
            <a href="<?php echo home_url('/news-events'); ?>" class="btn btn-outline">Latest News</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
