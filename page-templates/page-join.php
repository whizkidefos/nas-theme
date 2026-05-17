<?php
/**
 * Template Name: Join Us Page
 */
get_header();
$status = nas_application_status();
$open   = get_option('nas_app_open','');
$close  = get_option('nas_app_close','');
?>

<div class="nas-page-hero">
    <div class="nas-page-hero-overlay"></div>
    <div class="container nas-page-hero-content">
        <div class="section-label">Become a Pyrate</div>
        <h1 class="nas-page-hero-title">Join <span>Us</span></h1>
        <p class="nas-page-hero-sub">Join a brotherhood of men committed to justice, service, and truth. Non Nobis Solum.</p>
    </div>
</div>

<section class="nas-section">
    <div class="container">
        <div class="nas-join-grid">

            <!-- Left: Info -->
            <div class="nas-join-info">
                <div class="section-label">Membership</div>
                <h2 class="section-title">The <span>Pyrate's</span> Path</h2>

                <p>Membership in the National Association of Seadogs is not taken lightly. We seek individuals of strong character, intellectual rigour, and an unwavering commitment to justice.</p>

                <div class="nas-join-steps">
                    <div class="nas-join-step">
                        <div class="nas-join-step-num">01</div>
                        <div class="nas-join-step-info">
                            <h4>Submit Application</h4>
                            <p>Complete the online application form during an open intake window.</p>
                        </div>
                    </div>
                    <div class="nas-join-step">
                        <div class="nas-join-step-num">02</div>
                        <div class="nas-join-step-info">
                            <h4>ITT Process</h4>
                            <p>Shortlisted candidates undergo the Intake and Training Team (ITT) assessment.</p>
                        </div>
                    </div>
                    <div class="nas-join-step">
                        <div class="nas-join-step-num">03</div>
                        <div class="nas-join-step-info">
                            <h4>Interview</h4>
                            <p>Selected candidates attend a formal interview with NAS leadership.</p>
                        </div>
                    </div>
                    <div class="nas-join-step">
                        <div class="nas-join-step-num">04</div>
                        <div class="nas-join-step-info">
                            <h4>Induction</h4>
                            <p>Successful candidates are formally inducted into the Brotherhood.</p>
                        </div>
                    </div>
                </div>

                <div class="nas-join-requirements">
                    <h3>Requirements</h3>
                    <ul>
                        <li>Must be 18 years of age or older</li>
                        <li>University-level education or equivalent</li>
                        <li>Commitment to NAS values and mission</li>
                        <li>Demonstrated integrity and character</li>
                        <li>Strong recommendation from existing member</li>
                    </ul>
                </div>
            </div>

            <!-- Right: Form or Status Message -->
            <div class="nas-join-form-col">

                <?php if ($status === 'open'): ?>

                <div class="nas-join-form-wrap">
                    <div class="nas-form-header">
                        <div class="nas-form-header-icon"><?php echo nas_get_svg_skull(36,'#FFDD00'); ?></div>
                        <div>
                            <h3>Application Form</h3>
                            <p class="nas-form-deadline">Closes: <?php echo date('F j, Y g:i A', strtotime($close)); ?></p>
                        </div>
                    </div>

                    <form class="nas-application-form" id="nasApplicationForm" novalidate>
                        <div class="nas-form-row">
                            <div class="nas-form-group">
                                <label for="first_name">First Name *</label>
                                <input type="text" id="first_name" name="first_name" required autocomplete="given-name">
                            </div>
                            <div class="nas-form-group">
                                <label for="last_name">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" required autocomplete="family-name">
                            </div>
                        </div>
                        <div class="nas-form-row">
                            <div class="nas-form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required autocomplete="email">
                            </div>
                            <div class="nas-form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" required autocomplete="tel">
                            </div>
                        </div>
                        <div class="nas-form-row">
                            <div class="nas-form-group">
                                <label for="date_of_birth">Date of Birth *</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" required>
                            </div>
                            <div class="nas-form-group">
                                <label for="nationality">Nationality *</label>
                                <input type="text" id="nationality" name="nationality" required>
                            </div>
                        </div>
                        <div class="nas-form-group">
                            <label for="occupation">Occupation / Profession *</label>
                            <input type="text" id="occupation" name="occupation" required>
                        </div>
                        <div class="nas-form-group">
                            <label for="education">Highest Level of Education *</label>
                            <select id="education" name="education" required>
                                <option value="">Select...</option>
                                <option>Bachelor's Degree</option>
                                <option>Master's Degree</option>
                                <option>Doctorate (PhD)</option>
                                <option>Professional Qualification</option>
                                <option>Other University Degree</option>
                            </select>
                        </div>
                        <div class="nas-form-group">
                            <label for="deck_interest">Deck of Interest</label>
                            <select id="deck_interest" name="deck_interest">
                                <option value="">Select a Deck (optional)</option>
                                <?php
                                $decks = new WP_Query(['post_type'=>'nas_deck','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC']);
                                while ($decks->have_posts()): $decks->the_post();
                                    $deck_name = get_post_meta(get_the_ID(),'_nas_deck_name',true);
                                    $label = $deck_name ? get_the_title().' ('.$deck_name.' Deck)' : get_the_title();
                                    echo '<option>'.esc_html($label).'</option>';
                                endwhile; wp_reset_postdata();
                                ?>
                            </select>
                        </div>
                        <div class="nas-form-group">
                            <label for="referral">Referred By (Name of NAS Member, if applicable)</label>
                            <input type="text" id="referral" name="referral">
                        </div>
                        <div class="nas-form-group">
                            <label for="motivation">Why do you want to join NAS? *</label>
                            <textarea id="motivation" name="motivation" rows="6" required placeholder="Tell us about yourself and what draws you to the National Association of Seadogs..."></textarea>
                        </div>

                        <div class="nas-form-consent">
                            <label class="nas-checkbox-label">
                                <input type="checkbox" id="consent" name="consent" required>
                                <span>I confirm that the information provided is accurate and that I understand and support the values and mission of the National Association of Seadogs (Pyrates Confraternity).</span>
                            </label>
                        </div>

                        <div class="nas-form-message" id="nasAppMessage"></div>

                        <button type="submit" class="btn btn-primary nas-submit-btn" id="nasAppSubmit">
                            <span class="nas-btn-text">Submit Application</span>
                            <span class="nas-btn-loading" style="display:none">Submitting...</span>
                        </button>
                    </form>
                </div>

                <?php elseif ($status === 'upcoming'):
                    $msg = get_option('nas_app_upcoming_msg','Applications will open on {date}.');
                    $msg = str_replace(
                        ['{date}','{time}'],
                        [date('F j, Y', strtotime($open)), date('g:i A', strtotime($open))],
                        $msg
                    );
                ?>

                <div class="nas-join-status-card nas-status-upcoming">
                    <div class="nas-status-icon"><?php echo nas_get_svg_skull(60,'#FFDD00'); ?></div>
                    <h3>Applications Opening Soon</h3>
                    <div class="nas-status-msg"><?php echo wp_kses_post($msg); ?></div>
                    <div class="nas-countdown" data-target="<?php echo esc_attr($open); ?>" id="nasCountdown">
                        <div class="nas-count-unit"><span class="nas-count-num" id="countDays">--</span><span class="nas-count-label">Days</span></div>
                        <div class="nas-count-unit"><span class="nas-count-num" id="countHours">--</span><span class="nas-count-label">Hours</span></div>
                        <div class="nas-count-unit"><span class="nas-count-num" id="countMins">--</span><span class="nas-count-label">Minutes</span></div>
                        <div class="nas-count-unit"><span class="nas-count-num" id="countSecs">--</span><span class="nas-count-label">Seconds</span></div>
                    </div>
                    <p>Subscribe to our newsletter to be notified when applications open.</p>
                </div>

                <?php else:
                    $msg = get_option('nas_app_closed_msg','Applications are currently closed. Please check back later.');
                ?>

                <div class="nas-join-status-card nas-status-closed">
                    <div class="nas-status-icon"><?php echo nas_get_svg_skull(60,'rgba(255,221,0,0.5)'); ?></div>
                    <h3>Applications Closed</h3>
                    <div class="nas-status-msg"><?php echo wp_kses_post($msg); ?></div>
                    <p>Stay connected via our newsletter and social media to be the first to know when the next intake window opens.</p>
                    <div class="nas-mini-newsletter">
                        <form id="nasJoinNL" novalidate>
                            <div class="nas-nl-input-wrap">
                                <input type="email" name="email" placeholder="Your email address" class="nas-nl-input">
                                <button type="submit" class="btn btn-gold">Notify Me</button>
                            </div>
                            <div class="nas-form-message" id="nasJoinNLMsg"></div>
                        </form>
                    </div>
                </div>

                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
