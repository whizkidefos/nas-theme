<?php
/**
 * Template Name: History Page
 * Combines: About NAS, Philosophy, Structure
 */
get_header();
?>

<div class="nas-page-hero nas-page-hero-history">
    <div class="nas-page-hero-overlay"></div>
    <div class="container nas-page-hero-content">
        <div class="section-label">Est. 1952</div>
        <h1 class="nas-page-hero-title">Our <span>History</span></h1>
        <p class="nas-page-hero-sub">From University College Ibadan to the world — seven decades of justice, service, and brotherhood.</p>
    </div>
    <nav class="nas-history-nav" aria-label="History sections">
        <a href="#our-story" class="nas-history-nav-link">Our Story</a>
        <a href="#philosophy" class="nas-history-nav-link">Philosophy</a>
        <a href="#structure" class="nas-history-nav-link">Structure</a>
    </nav>
</div>

<!-- OUR STORY -->
<section class="nas-section" id="our-story">
    <div class="container">
        <div class="nas-history-grid">
            <div class="nas-history-sidebar">
                <div class="nas-history-card">
                    <div class="nas-hcard-icon"><?php echo nas_get_svg_skull(40,'#FFDD00'); ?></div>
                    <div class="nas-hcard-year">1952</div>
                    <div class="nas-hcard-label">Year Founded</div>
                </div>
                <div class="nas-history-card">
                    <div class="nas-hcard-icon">⚓</div>
                    <div class="nas-hcard-year">7</div>
                    <div class="nas-hcard-label">Founding Pyrates</div>
                </div>
                <div class="nas-history-card">
                    <div class="nas-hcard-icon">🌍</div>
                    <div class="nas-hcard-year">6+</div>
                    <div class="nas-hcard-label">Countries</div>
                </div>
            </div>

            <div class="nas-history-body">
                <div class="section-label">Our Story</div>
                <h2 class="section-title">The Birth of a <span>Brotherhood</span></h2>

                <div class="nas-history-content">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; else: ?>
                    <p class="nas-drop-cap">The National Association of Seadogs (Pyrates Confraternity) was founded in 1952 at the University College Ibadan, Nigeria, by Wole Soyinka and six others who came to be known as the "Magnificent Seven." In an era of colonial rule and social inequality, these young men dared to imagine a different world — one built on justice, truth, and brotherhood.</p>

                    <p>What began as a bold declaration against conformity and oppression grew into an international organisation with decks (branches) spanning Nigeria, the United Kingdom, the United States, Australia, and beyond.</p>

                    <div class="nas-quote-block">
                        <div class="nas-quote-bar"></div>
                        <blockquote>"We are committed to the attainment of a just and egalitarian society."</blockquote>
                        <cite>— NAS Mission Statement</cite>
                    </div>

                    <p>The Pyrates Confraternity has remained steadfastly non-violent throughout its history, distinguishing itself from other confraternities by its intellectual roots and its commitment to community service. From medical missions to the fight against corruption, NAS has consistently stood on the side of the people.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TIMELINE -->
<section class="nas-section nas-timeline-section">
    <div class="container">
        <div class="section-label text-center" style="justify-content:center">Milestones</div>
        <h2 class="section-title text-center">A Legacy <span>Across Decades</span></h2>

        <div class="nas-timeline">
            <?php
            $events = [
                ['1952','Foundation','The Magnificent Seven found NAS at University College Ibadan. Wole Soyinka is among the founding members.'],
                ['1960s','Expansion','NAS grows across Nigerian universities, championing student rights and national unity during a turbulent era.'],
                ['1970s','International','NAS decks begin forming internationally in the United Kingdom, United States, and beyond.'],
                ['1980s','Reform','In response to campus violence, NAS reaffirms its non-violent identity and humanitarian mission.'],
                ['1990s','Community','Medical missions, street kids programmes, and the Citizens\' Summit become hallmarks of NAS\'s service work.'],
                ['2000s','Global Reach','NAS continues to expand globally, with decks in Australia and Japan joining the brotherhood.'],
                ['2020s','Today','NAS stands as a global voice for justice, human rights, and egalitarianism across 6+ countries.'],
            ];
            foreach ($events as $i => $ev):
            ?>
            <div class="nas-timeline-item <?php echo $i % 2 === 0 ? 'nas-timeline-left' : 'nas-timeline-right'; ?>">
                <div class="nas-timeline-content">
                    <div class="nas-timeline-year"><?php echo esc_html($ev[0]); ?></div>
                    <h3 class="nas-timeline-title"><?php echo esc_html($ev[1]); ?></h3>
                    <p><?php echo esc_html($ev[2]); ?></p>
                </div>
                <div class="nas-timeline-dot"><?php echo nas_get_svg_skull(16,'#FFDD00'); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PHILOSOPHY -->
<section class="nas-section nas-philosophy-section" id="philosophy">
    <div class="container">
        <div class="section-label text-center" style="justify-content:center">Our Beliefs</div>
        <h2 class="section-title text-center">The Pyrate <span>Philosophy</span></h2>

        <div class="nas-philosophy-motto">
            <div class="nas-motto-text">Non Nobis Solum</div>
            <div class="nas-motto-translation">Not for us alone</div>
        </div>

        <div class="nas-philosophy-grid">
            <?php
            $tenets = [
                ['⚖', 'Justice', 'We believe in equal rights for all persons, regardless of origin, faith, or circumstance. Justice is not a privilege — it is a human right.'],
                ['🔱', 'Non-Violence', 'NAS strictly upholds non-violence. We engage through advocacy, intellect, and peaceful action — never through force or intimidation.'],
                ['✦', 'Integrity', 'We hold ourselves to the highest personal and professional standards. Our word is our bond, on and off the deck.'],
                ['🌊', 'Brotherhood', 'Once a Pyrate, always a Pyrate. Our bonds transcend geography, generation, and circumstance.'],
                ['🌍', 'Service', 'We exist not for ourselves, but for our communities. Every Seadog is called to serve wherever they find themselves.'],
                ['💡', 'Enlightenment', 'Born in the academy, NAS champions intellectual freedom, education, and the pursuit of truth in all forms.'],
            ];
            foreach ($tenets as $t):
            ?>
            <div class="nas-tenet-card">
                <div class="nas-tenet-icon"><?php echo $t[0]; ?></div>
                <h3 class="nas-tenet-title"><?php echo esc_html($t[1]); ?></h3>
                <p><?php echo esc_html($t[2]); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- STRUCTURE -->
<section class="nas-section" id="structure">
    <div class="container">
        <div class="section-label text-center" style="justify-content:center">Organisation</div>
        <h2 class="section-title text-center">Structure <span>of NAS</span></h2>

        <div class="nas-structure-grid">
            <div class="nas-structure-level nas-structure-top">
                <div class="nas-structure-badge">Supreme</div>
                <h3>The NAS Capoon</h3>
                <p>National Capoon (President) — the supreme head of the association, leading from the National Deck.</p>
            </div>
            <div class="nas-structure-connector"></div>
            <div class="nas-structure-row">
                <div class="nas-structure-level">
                    <div class="nas-structure-badge">National</div>
                    <h3>National Deck</h3>
                    <p>The governing body of NAS, overseeing all national operations and policy.</p>
                </div>
                <div class="nas-structure-level">
                    <div class="nas-structure-badge">Zonal</div>
                    <h3>Zonal Decks</h3>
                    <p>Coordinate activities across regions and countries, bridging national HQ and local decks.</p>
                </div>
                <div class="nas-structure-level">
                    <div class="nas-structure-badge">Local</div>
                    <h3>Local Decks</h3>
                    <p>Individual city/chapter branches (e.g., Saxon — Manchester; Zero Meridian — London).</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
