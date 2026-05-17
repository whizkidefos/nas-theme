<?php get_header(); ?>

<div class="nas-page-hero">
    <div class="nas-page-hero-overlay"></div>
    <div class="container nas-page-hero-content">
        <?php if (have_posts()) : the_post(); ?>
        <h1 class="nas-page-hero-title"><?php the_title(); ?></h1>
        <?php endif; ?>
    </div>
</div>

<section class="nas-section">
    <div class="container">
        <div class="nas-page-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
