<?php
/**
 * ITT Page — Password protected interview/intake page at /itt
 * Template Name: ITT Page
 */

// Check password
$itt_pass = get_option('nas_itt_password','');
$authenticated = false;

if (!empty($itt_pass)) {
    if (isset($_POST['itt_login']) && check_admin_referer('nas_itt_login')) {
        if ($_POST['itt_password'] === $itt_pass) {
            setcookie('nas_itt_auth', md5($itt_pass . SECURE_AUTH_SALT), time() + 7200, COOKIEPATH, COOKIE_DOMAIN, is_ssl());
            $authenticated = true;
        }
    }
    if (isset($_COOKIE['nas_itt_auth']) && $_COOKIE['nas_itt_auth'] === md5($itt_pass . SECURE_AUTH_SALT)) {
        $authenticated = true;
    }
    if (current_user_can('manage_options')) {
        $authenticated = true;
    }
} else {
    // No password set — admins only
    $authenticated = current_user_can('manage_options');
}

get_header();

if (!$authenticated): ?>

<section class="nas-section nas-itt-login-section">
    <div class="container">
        <div class="nas-itt-login-wrap">
            <div class="nas-itt-login-icon"><?php echo nas_get_svg_skull(64,'#FFDD00'); ?></div>
            <h1>ITT Portal</h1>
            <p>This page is restricted to authorised NAS members only.</p>

            <?php if (isset($_POST['itt_login'])): ?>
            <div class="nas-error-msg">Incorrect password. Please try again.</div>
            <?php endif; ?>

            <form method="post" class="nas-itt-login-form">
                <?php wp_nonce_field('nas_itt_login'); ?>
                <div class="nas-form-group">
                    <label for="itt_password">Access Password</label>
                    <input type="password" id="itt_password" name="itt_password" required autocomplete="current-password" placeholder="Enter access code">
                </div>
                <button type="submit" name="itt_login" class="btn btn-primary" style="width:100%">
                    <?php echo nas_get_svg_skull(18,'#FFDD00'); ?> Gain Access
                </button>
            </form>
        </div>
    </div>
</section>

<?php else:
    global $wpdb;
    $questions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}nas_itt_questions WHERE active=1 ORDER BY sort_order ASC, category ASC");
    $quizzes   = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}nas_itt_quizzes WHERE active=1 ORDER BY sort_order ASC");
    $intro     = get_option('nas_itt_intro','');
    $intake    = get_option('nas_itt_intake_info','');

    // Group questions by category
    $q_by_cat = [];
    foreach ($questions as $q) {
        $q_by_cat[$q->category][] = $q;
    }
?>

<div class="nas-page-hero nas-page-hero-itt">
    <div class="nas-page-hero-overlay"></div>
    <div class="container nas-page-hero-content">
        <div class="section-label">Restricted Access</div>
        <h1 class="nas-page-hero-title">ITT <span>Portal</span></h1>
        <p class="nas-page-hero-sub">Intake & Training Team — Interview Resources</p>
    </div>
</div>

<section class="nas-section nas-itt-section">
    <div class="container">

        <?php if ($intro): ?>
        <div class="nas-itt-intro"><?php echo $intro; ?></div>
        <?php endif; ?>

        <div class="nas-itt-tabs">
            <button class="nas-tab active" data-tab="intake">Intake Info</button>
            <button class="nas-tab" data-tab="questions">Interview Questions</button>
            <button class="nas-tab" data-tab="quiz">Quiz</button>
        </div>

        <!-- Intake Info -->
        <div class="nas-tab-content active" id="tab-intake">
            <?php if ($intake): ?>
                <div class="nas-itt-content"><?php echo $intake; ?></div>
            <?php else: ?>
                <div class="nas-empty-state">
                    <p>No intake information has been added yet. Administrators can add this from the ITT settings panel.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Interview Questions -->
        <div class="nas-tab-content" id="tab-questions">
            <?php if (empty($questions)): ?>
            <div class="nas-empty-state"><p>No interview questions have been added yet.</p></div>
            <?php else: ?>
            <div class="nas-questions-wrap">
                <?php foreach ($q_by_cat as $cat => $qs): ?>
                <div class="nas-question-category">
                    <?php if ($cat): ?>
                    <div class="nas-q-cat-label"><?php echo esc_html($cat); ?></div>
                    <?php endif; ?>
                    <div class="nas-questions-accordion">
                        <?php foreach ($qs as $i => $q): ?>
                        <div class="nas-accordion-item">
                            <button class="nas-accordion-trigger" aria-expanded="false">
                                <span class="nas-accordion-num"><?php echo $i+1; ?></span>
                                <span class="nas-accordion-question"><?php echo esc_html($q->question); ?></span>
                                <span class="nas-accordion-arrow">▾</span>
                            </button>
                            <div class="nas-accordion-answer">
                                <?php echo wp_kses_post($q->answer); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Quiz -->
        <div class="nas-tab-content" id="tab-quiz">
            <?php if (empty($quizzes)): ?>
            <div class="nas-empty-state"><p>No quiz questions have been added yet.</p></div>
            <?php else: ?>
            <div class="nas-quiz-wrap" id="nasQuiz" data-total="<?php echo count($quizzes); ?>">
                <div class="nas-quiz-header">
                    <div class="nas-quiz-progress">
                        <div class="nas-quiz-progress-bar" id="nasQuizProgress" style="width:0%"></div>
                    </div>
                    <div class="nas-quiz-counter">Question <span id="nasQNum">1</span> of <?php echo count($quizzes); ?></div>
                </div>

                <div class="nas-quiz-questions" id="nasQuizQuestions">
                    <?php foreach ($quizzes as $i => $q): ?>
                    <div class="nas-quiz-q <?php echo $i===0?'active':''; ?>" data-index="<?php echo $i; ?>" data-correct="<?php echo esc_attr($q->correct_option); ?>">
                        <h3 class="nas-quiz-question"><?php echo esc_html($q->question); ?></h3>
                        <div class="nas-quiz-options">
                            <?php foreach (['A'=>$q->option_a,'B'=>$q->option_b,'C'=>$q->option_c,'D'=>$q->option_d] as $letter => $opt): if(empty($opt)) continue; ?>
                            <button class="nas-quiz-option" data-letter="<?php echo $letter; ?>">
                                <span class="nas-opt-letter"><?php echo $letter; ?></span>
                                <span class="nas-opt-text"><?php echo esc_html($opt); ?></span>
                            </button>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($q->explanation): ?>
                        <div class="nas-quiz-explanation" style="display:none">
                            <strong>Explanation:</strong> <?php echo esc_html($q->explanation); ?>
                        </div>
                        <?php endif; ?>
                        <div class="nas-quiz-nav">
                            <?php if ($i > 0): ?>
                            <button class="btn btn-outline nas-quiz-prev">← Previous</button>
                            <?php endif; ?>
                            <?php if ($i < count($quizzes)-1): ?>
                            <button class="btn btn-primary nas-quiz-next">Next →</button>
                            <?php else: ?>
                            <button class="btn btn-gold nas-quiz-finish">Finish Quiz</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="nas-quiz-results" id="nasQuizResults" style="display:none">
                    <div class="nas-quiz-result-icon"><?php echo nas_get_svg_skull(64,'#FFDD00'); ?></div>
                    <h2>Quiz Complete!</h2>
                    <div class="nas-quiz-score">
                        <span class="nas-score-num" id="nasQuizScore">0</span>
                        <span class="nas-score-total">/ <?php echo count($quizzes); ?></span>
                    </div>
                    <p id="nasQuizFeedback"></p>
                    <button class="btn btn-outline" id="nasQuizRetry">Try Again</button>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php endif; get_footer(); ?>
