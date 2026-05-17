<?php get_header(); ?>

<div class="nas-page-hero nas-page-hero-sm">
    <div class="nas-page-hero-overlay"></div>
    <div class="container nas-page-hero-content">
        <?php if ( is_category() ): ?>
            <div class="section-label">Category</div>
            <h1 class="nas-page-hero-title"><?php single_cat_title(); ?></h1>
            <?php if ( category_description() ): ?>
            <p class="nas-page-hero-sub"><?php echo category_description(); ?></p>
            <?php endif; ?>
        <?php elseif ( is_tag() ): ?>
            <div class="section-label">Tag</div>
            <h1 class="nas-page-hero-title"><?php single_tag_title(); ?></h1>
        <?php elseif ( is_author() ): ?>
            <div class="section-label">Author</div>
            <h1 class="nas-page-hero-title"><?php the_author(); ?></h1>
        <?php elseif ( is_date() ): ?>
            <div class="section-label">Archive</div>
            <h1 class="nas-page-hero-title"><?php echo get_the_date( 'F Y' ); ?></h1>
        <?php else: ?>
            <h1 class="nas-page-hero-title">Archives</h1>
        <?php endif; ?>
    </div>
</div>

<section class="nas-section">
    <div class="container">
        <div class="nas-blog-layout">
            <div class="nas-blog-main">
                <div class="nas-posts-grid">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                        $cats = get_the_category(); $cat = $cats[0] ?? null; ?>
                    <article class="nas-post-card">
                        <div class="nas-post-card-img">
                            <?php if ( has_post_thumbnail() ): the_post_thumbnail( 'nas-card', ['class'=>'nas-post-thumb'] ); else: ?>
                            <div class="nas-post-placeholder"><?php echo nas_get_svg_skull(40,'rgba(255,221,0,0.1)'); ?></div>
                            <?php endif; ?>
                            <?php if ($cat): ?>
                            <a href="<?php echo get_category_link($cat->term_id); ?>" class="nas-post-cat"><?php echo esc_html($cat->name); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="nas-post-card-body">
                            <div class="nas-post-meta"><span class="nas-post-date"><?php echo get_the_date(); ?></span></div>
                            <h2 class="nas-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="nas-post-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 22 ); ?></p>
                            <a href="<?php the_permalink(); ?>" class="nas-post-link">
                                Read More <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>
                    <?php endwhile; else: ?>
                    <div class="nas-empty-state">
                        <div><?php echo nas_get_svg_skull(60,'rgba(255,221,0,0.15)'); ?></div>
                        <p>No posts found in this archive.</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="nas-pagination">
                    <?php echo paginate_links(['prev_text'=>'← Previous','next_text'=>'Next →']); ?>
                </div>
            </div>
            <aside class="nas-blog-sidebar">
                <div class="nas-sidebar-widget">
                    <h4 class="nas-widget-title">Categories</h4>
                    <ul class="nas-widget-cat-list">
                        <?php foreach ( get_categories() as $cat ): ?>
                        <li><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo esc_html($cat->name); ?><span class="nas-cat-count"><?php echo $cat->count; ?></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="nas-sidebar-widget nas-sidebar-nl">
                    <div class="nas-widget-skull"><?php echo nas_get_svg_skull(32,'#FFDD00'); ?></div>
                    <h4 class="nas-widget-title">Stay Updated</h4>
                    <p>Get NAS news delivered to your inbox.</p>
                    <form id="nasArchiveNL" novalidate>
                        <input type="email" name="email" placeholder="Your email" class="nas-nl-input" required style="border-right:1px solid rgba(255,221,0,0.2);width:100%;margin-bottom:8px">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Subscribe</button>
                        <div class="nas-form-message" id="nasArchiveNLMsg"></div>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php
// Hook the archive sidebar newsletter form
add_action( 'wp_footer', function() { ?>
<script>
(function(){
  var f=document.getElementById('nasArchiveNL'); if(!f)return;
  f.addEventListener('submit',async function(e){
    e.preventDefault();
    var m=document.getElementById('nasArchiveNLMsg');
    var d=new FormData(f); d.append('action','nas_newsletter'); d.append('nonce',NAS.nonce);
    var r=await fetch(NAS.ajaxUrl,{method:'POST',body:d});
    var j=await r.json();
    m.className='nas-form-message '+(j.success?'success':'error');
    m.textContent=j.data.message;
    if(j.success)f.reset();
  });
})();
</script>
<?php });
get_footer(); ?>
