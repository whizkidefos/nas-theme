<?php
/**
 * Template Name: Skull & Crossbones Page
 */
get_header();
?>

<div class="nas-page-hero nas-page-hero-skull">
    <div class="nas-page-hero-overlay"></div>
    <div class="nas-skull-hero-bg">
        <!-- Animated skull rings -->
        <div class="nas-skull-ring nas-skull-ring-1"></div>
        <div class="nas-skull-ring nas-skull-ring-2"></div>
        <div class="nas-skull-ring nas-skull-ring-3"></div>
        <div class="nas-skull-center"><?php echo nas_get_svg_skull(160,'rgba(255,221,0,0.08)'); ?></div>
    </div>
    <div class="container nas-page-hero-content">
        <div class="section-label">The Symbol</div>
        <h1 class="nas-page-hero-title">Skull <span>&amp;</span> Cross Bones</h1>
        <p class="nas-page-hero-sub">The story behind our most iconic symbol — its history, its meaning, and its power.</p>
    </div>
</div>

<section class="nas-section">
    <div class="container">
        <div class="nas-skull-intro">
            <div class="nas-skull-display">
                <div class="nas-skull-emblem-large">
                    <div class="nas-skull-ring-display"></div>
                    <?php echo nas_get_svg_skull(200, '#FFDD00'); ?>
                </div>
                <div class="nas-skull-nas-text">NAS</div>
            </div>
            <div class="nas-skull-text">
                <div class="section-label">Our Emblem</div>
                <h2 class="section-title">The <span>Jolly Roger</span></h2>
                <?php if (have_posts()): while (have_posts()): the_post(); the_content(); endwhile; else: ?>
                <p>The skull and crossed bones — the Jolly Roger — is the universally recognised symbol of the Pyrates Confraternity. Far from representing death or danger, for NAS it symbolises fearlessness, defiance in the face of injustice, and the willingness to stand up for what is right regardless of personal cost.</p>
                <p>When the seven founders chose this emblem, they were making a bold statement: we refuse to be ordinary. We will challenge the status quo. We will not be silenced.</p>
                <p>The red circle that frames the skull represents our passion and the blood of our commitment. The golden skull itself represents intellectual courage and the light of truth. The crossed bones beneath represent the foundations upon which our brotherhood is built — unity and sacrifice.</p>
                <?php endif; ?>

                <div class="nas-skull-meanings">
                    <div class="nas-skull-meaning">
                        <div class="nas-sm-icon" style="color:var(--nas-gold)">💀</div>
                        <div>
                            <strong>The Skull</strong>
                            <span>Intellectual courage — the fearless pursuit of truth</span>
                        </div>
                    </div>
                    <div class="nas-skull-meaning">
                        <div class="nas-sm-icon">✕</div>
                        <div>
                            <strong>The Crossed Bones</strong>
                            <span>Unity and sacrifice — the foundations of brotherhood</span>
                        </div>
                    </div>
                    <div class="nas-skull-meaning">
                        <div class="nas-sm-icon" style="color:var(--nas-red)">○</div>
                        <div>
                            <strong>The Red Circle</strong>
                            <span>Passion and commitment — the fire of our cause</span>
                        </div>
                    </div>
                    <div class="nas-skull-meaning">
                        <div class="nas-sm-icon" style="color:var(--nas-gold)">⚓</div>
                        <div>
                            <strong>The Anchor</strong>
                            <span>Grounding and stability — our roots in principle</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="skull-divider">
            <div class="skull-divider-icon"><?php echo nas_get_svg_skull(20,'#FFDD00'); ?></div>
        </div>

        <div class="nas-skull-motto">
            <div class="nas-motto-giant">Non Nobis Solum</div>
            <div class="nas-motto-translate">Not for us alone</div>
        </div>

    </div>
</section>

<?php get_footer(); ?>
