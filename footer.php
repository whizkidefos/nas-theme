</main>

<!-- FOOTER -->
<footer class="nas-footer">

    <!-- Newsletter Section -->
    <div class="nas-footer-newsletter">
        <div class="container">
            <div class="nas-nl-inner">
                <div class="nas-nl-text">
                    <div class="section-label">Stay Connected</div>
                    <h3 class="nas-nl-title">The <span>Pyrate's</span> Dispatch</h3>
                    <p>Subscribe for the latest from NAS — news, events, and communiqués from the high seas of justice.</p>
                </div>
                <form class="nas-nl-form" id="nasNewsletterForm" novalidate>
                    <div class="nas-nl-input-wrap">
                        <input type="email" name="email" placeholder="Enter your email address" required class="nas-nl-input" autocomplete="email">
                        <button type="submit" class="btn btn-primary nas-nl-btn">
                            <span>Subscribe</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </button>
                    </div>
                    <div class="nas-form-message" id="nasNLMessage"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Nav Grid -->
    <div class="nas-footer-main">
        <div class="container">
            <div class="nas-footer-grid">

                <!-- Brand -->
                <div class="nas-footer-brand">
                    <?php echo nas_get_svg_skull(80, '#FFDD00'); ?>
                    <div class="nas-footer-brand-text">
                        <div class="nas-footer-brand-name">National Association of Seadogs</div>
                        <div class="nas-footer-brand-sub">Pyrates Confraternity</div>
                        <div class="nas-footer-brand-motto">Non Nobis Solum</div>
                    </div>
                    <p class="nas-footer-brand-desc">Since 1952, fighting for a just and egalitarian society. Wherever we find ourselves, we are committed to being the first when the community needs a hand.</p>
                    <div class="nas-footer-social">
                        <?php echo nas_social_links('nas-footer-social-link'); ?>
                    </div>
                </div>

                <!-- About Menu -->
                <div class="nas-footer-col">
                    <h4 class="nas-footer-col-title">About Us</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-about',
                        'container'      => false,
                        'menu_class'     => 'nas-footer-menu',
                        'fallback_cb'    => function() { ?>
                            <ul class="nas-footer-menu">
                                <li><a href="<?php echo home_url('/history'); ?>">History</a></li>
                                <li><a href="<?php echo home_url('/history#philosophy'); ?>">Philosophy</a></li>
                                <li><a href="<?php echo home_url('/history#structure'); ?>">Structure of NAS</a></li>
                                <li><a href="<?php echo home_url('/skull-and-crossbones'); ?>">Skull & X-Bones</a></li>
                                <li><a href="<?php echo home_url('/countries'); ?>">Countries</a></li>
                            </ul>
                        <?php }
                    ]);
                    ?>
                </div>

                <!-- Missions Menu -->
                <div class="nas-footer-col">
                    <h4 class="nas-footer-col-title">Our Missions</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-missions',
                        'container'      => false,
                        'menu_class'     => 'nas-footer-menu',
                        'fallback_cb'    => function() { ?>
                            <ul class="nas-footer-menu">
                                <li><a href="#">Medical Mission</a></li>
                                <li><a href="#">Citizens' Summit</a></li>
                                <li><a href="#">Street Kids</a></li>
                                <li><a href="#">Charity Red Ball</a></li>
                                <li><a href="<?php echo home_url('/projects'); ?>">All Projects</a></li>
                            </ul>
                        <?php }
                    ]);
                    ?>
                </div>

                <!-- News Menu -->
                <div class="nas-footer-col">
                    <h4 class="nas-footer-col-title">News & Events</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-news',
                        'container'      => false,
                        'menu_class'     => 'nas-footer-menu',
                        'fallback_cb'    => function() {
                            $cats = get_categories(['number'=>8]);
                            echo '<ul class="nas-footer-menu">';
                            foreach ($cats as $cat) {
                                echo '<li><a href="'.get_category_link($cat->term_id).'">'.esc_html($cat->name).'</a></li>';
                            }
                            echo '</ul>';
                        }
                    ]);
                    ?>
                </div>

            </div><!-- end nas-footer-grid -->
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="nas-footer-bottom">
        <div class="container nas-footer-bottom-inner">
            <p class="nas-footer-copy">
                &copy;<?php echo date('Y'); ?> National Association of Seadogs. All Rights Reserved.
                <span class="nas-footer-sep">•</span>
                <a href="<?php echo home_url('/join'); ?>">Join Us</a>
                <span class="nas-footer-sep">•</span>
                <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a>
            </p>
            <div class="nas-footer-bottom-logo">
                <?php echo nas_get_svg_skull(30,'rgba(255,221,0,0.3)'); ?>
                <span>NAS · Pyrates Confraternity · Est. 1952</span>
            </div>
        </div>
    </div>

</footer>

<!-- ============================================================
     NAS CHATBOT WIDGET
     ============================================================ -->
<div class="nas-chatbot-wrapper" id="nasChatbot">

    <!-- Toggle Button -->
    <button class="nas-chatbot-toggle" id="nasChatbotToggle" aria-label="Chat with NAS Assistant" aria-expanded="false">
        <div class="nas-chatbot-toggle-inner">
            <div class="nas-chatbot-pulse"></div>
            <div class="nas-chatbot-toggle-icon nas-chatbot-icon-open">
                <?php echo nas_get_svg_skull(28,'#FFDD00'); ?>
            </div>
            <div class="nas-chatbot-toggle-icon nas-chatbot-icon-close" style="display:none">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFDD00" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </div>
        </div>
    </button>

    <!-- Chat Window -->
    <div class="nas-chatbot-window" id="nasChatbotWindow" style="display:none">
        <div class="nas-chatbot-header">
            <div class="nas-chatbot-header-info">
                <div class="nas-chatbot-avatar"><?php echo nas_get_svg_skull(24,'#FFDD00'); ?></div>
                <div>
                    <div class="nas-chatbot-name">The Seatiger</div>
                    <div class="nas-chatbot-status">
                        <span class="nas-chatbot-dot"></span> NAS AI Assistant
                    </div>
                </div>
            </div>
            <button class="nas-chatbot-minimize" id="nasChatbotClose" aria-label="Close chat">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="nas-chatbot-messages" id="nasChatMessages">
            <div class="nas-chatbot-msg nas-msg-bot">
                <div class="nas-chatbot-msg-avatar"><?php echo nas_get_svg_skull(18,'#FFDD00'); ?></div>
                <div class="nas-chatbot-bubble">
                    Ahoy! I'm <strong>The Seatiger</strong>, the NAS virtual assistant. Ask me anything about the National Association of Seadogs — our history, how to join, our decks worldwide, or our projects. ⚓
                </div>
            </div>
        </div>

        <div class="nas-chatbot-input-area">
            <div class="nas-chatbot-quick-btns" id="nasQuickBtns">
                <button class="nas-quick-btn" data-msg="How do I join NAS?">How to join?</button>
                <button class="nas-quick-btn" data-msg="Tell me about NAS history">History</button>
                <button class="nas-quick-btn" data-msg="What is the ITT process?">ITT Process</button>
            </div>
            <div class="nas-chatbot-input-row">
                <input type="text" id="nasChatInput" class="nas-chatbot-input" placeholder="Ask about NAS..." maxlength="500" autocomplete="off">
                <button class="nas-chatbot-send" id="nasChatSend" aria-label="Send">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    </div>

</div>

<?php wp_footer(); ?>
</body>
</html>
