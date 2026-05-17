<?php
/**
 * NAS Theme — functions.php
 * National Association of Seadogs (Pyrates Confraternity)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'NAS_THEME_VERSION', '1.0.0' );
define( 'NAS_THEME_DIR', get_template_directory() );
define( 'NAS_THEME_URI', get_template_directory_uri() );

function nas_asset_version( $relative_path ) {
    $file_path = NAS_THEME_DIR . '/' . ltrim( $relative_path, '/' );
    if ( file_exists( $file_path ) ) {
        return (string) filemtime( $file_path );
    }
    return NAS_THEME_VERSION;
}

// ============================================================
// THEME SETUP
// ============================================================
function nas_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height' => 80, 'width' => 300,
        'flex-height' => true, 'flex-width' => true,
    ]);
    add_theme_support( 'menus' );

    register_nav_menus([
        'primary'     => __( 'Primary Navigation', 'nas-theme' ),
        'footer-about'  => __( 'Footer — About Us', 'nas-theme' ),
        'footer-missions' => __( 'Footer — Our Missions', 'nas-theme' ),
        'footer-news'   => __( 'Footer — News & Events', 'nas-theme' ),
    ]);

    add_image_size( 'nas-hero', 1920, 900, true );
    add_image_size( 'nas-card', 600, 400, true );
    add_image_size( 'nas-thumb', 300, 200, true );
}
add_action( 'after_setup_theme', 'nas_theme_setup' );

// ============================================================
// ENQUEUE SCRIPTS & STYLES
// ============================================================
function nas_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style( 'nas-fonts',
        'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Barlow+Condensed:wght@300;400;600;700&display=swap',
        [], null
    );

    // Theme base stylesheet (style.css — CSS variables, resets, base styles)
    wp_enqueue_style(
        'nas-base',
        get_stylesheet_uri(),
        ['nas-fonts'],
        nas_asset_version( 'style.css' )
    );

    // Main component stylesheet
    wp_enqueue_style(
        'nas-main',
        NAS_THEME_URI . '/assets/css/main.css',
        ['nas-base'],
        nas_asset_version( 'assets/css/main.css' )
    );

    // Main JS
    wp_enqueue_script(
        'nas-main',
        NAS_THEME_URI . '/assets/js/main.js',
        [],
        nas_asset_version( 'assets/js/main.js' ),
        true
    );
    wp_enqueue_script(
        'nas-chatbot',
        NAS_THEME_URI . '/assets/js/chatbot.js',
        ['nas-main'],
        nas_asset_version( 'assets/js/chatbot.js' ),
        true
    );

    wp_localize_script( 'nas-main', 'NAS', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'nas_nonce' ),
        'siteUrl'   => get_site_url(),
        'themeUri'  => NAS_THEME_URI,
    ]);
}
add_action( 'wp_enqueue_scripts', 'nas_enqueue_assets' );

// Admin styles
function nas_admin_assets( $hook ) {
    wp_enqueue_style(
        'nas-admin',
        NAS_THEME_URI . '/assets/css/admin.css',
        [],
        nas_asset_version( 'assets/css/admin.css' )
    );
    wp_enqueue_script(
        'nas-admin',
        NAS_THEME_URI . '/assets/js/admin.js',
        ['jquery'],
        nas_asset_version( 'assets/js/admin.js' ),
        true
    );
    wp_localize_script( 'nas-admin', 'NAS_Admin', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'nas_admin_nonce' ),
    ]);
}
add_action( 'admin_enqueue_scripts', 'nas_admin_assets' );

// Login screen styles
function nas_login_assets() {
    wp_enqueue_style( 'nas-fonts',
        'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Barlow+Condensed:wght@300;400;600;700&display=swap',
        [], null
    );

    wp_enqueue_style(
        'nas-login',
        NAS_THEME_URI . '/assets/css/login.css',
        [ 'nas-fonts' ],
        nas_asset_version( 'assets/css/login.css' )
    );
}
add_action( 'login_enqueue_scripts', 'nas_login_assets' );

function nas_login_logo_url() {
    return home_url( '/' );
}
add_filter( 'login_headerurl', 'nas_login_logo_url' );

function nas_login_logo_title() {
    return get_bloginfo( 'name' ) . ' - National Association of Seadogs';
}
add_filter( 'login_headertext', 'nas_login_logo_title' );

// ============================================================
// CUSTOM POST TYPES
// ============================================================
function nas_register_cpts() {

    // PROJECTS CPT
    register_post_type( 'nas_project', [
        'labels' => [
            'name'          => 'Projects',
            'singular_name' => 'Project',
            'add_new_item'  => 'Add New Project',
            'edit_item'     => 'Edit Project',
            'menu_name'     => 'Projects',
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-flag',
        'menu_position' => 5,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'rewrite'       => [ 'slug' => 'projects' ],
        'show_in_rest'  => true,
    ]);
    register_taxonomy( 'project_category', 'nas_project', [
        'labels'        => [ 'name' => 'Project Categories', 'singular_name' => 'Project Category' ],
        'hierarchical'  => true,
        'show_in_rest'  => true,
        'rewrite'       => [ 'slug' => 'project-category' ],
    ]);

    // DECKS CPT
    register_post_type( 'nas_deck', [
        'labels' => [
            'name'          => 'Decks',
            'singular_name' => 'Deck',
            'add_new_item'  => 'Add New Deck',
            'edit_item'     => 'Edit Deck',
            'menu_name'     => 'Decks',
        ],
        'public'        => true,
        'has_archive'   => false,
        'menu_icon'     => 'dashicons-location-alt',
        'menu_position' => 6,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'rewrite'       => [ 'slug' => 'decks' ],
        'show_in_rest'  => true,
    ]);
    register_taxonomy( 'deck_country', 'nas_deck', [
        'labels'       => [ 'name' => 'Countries', 'singular_name' => 'Country' ],
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'country' ],
    ]);
}
add_action( 'init', 'nas_register_cpts' );

// Blog categories for News & Events
function nas_register_news_categories() {
    if ( ! term_exists( 'Press Releases', 'category' ) )      wp_insert_term( 'Press Releases',   'category' );
    if ( ! term_exists( 'Public Articles', 'category' ) )     wp_insert_term( 'Public Articles',  'category' );
    if ( ! term_exists( 'Seminars & Lectures', 'category' ) ) wp_insert_term( 'Seminars & Lectures', 'category' );
    if ( ! term_exists( 'NAS in the News', 'category' ) )     wp_insert_term( 'NAS in the News',  'category' );
}
add_action( 'init', 'nas_register_news_categories' );

// ============================================================
// THEME OPTIONS (Customizer)
// ============================================================
function nas_customizer( $wp_customize ) {

    $wp_customize->add_panel( 'nas_options', [
        'title'    => 'NAS Theme Options',
        'priority' => 200,
    ]);

    // Social Media
    $wp_customize->add_section( 'nas_social', [
        'title' => 'Social Media', 'panel' => 'nas_options',
    ]);
    foreach ( [ 'facebook' => 'Facebook URL', 'twitter' => 'X (Twitter) URL', 'instagram' => 'Instagram URL' ] as $key => $label ) {
        $wp_customize->add_setting( "nas_$key" );
        $wp_customize->add_control( "nas_$key", [ 'label' => $label, 'section' => 'nas_social', 'type' => 'url' ] );
    }

    // Hero
    $wp_customize->add_section( 'nas_hero', [ 'title' => 'Hero Section', 'panel' => 'nas_options' ] );
    foreach ( [
        'nas_hero_title'    => [ 'label' => 'Hero Title',    'type' => 'text' ],
        'nas_hero_subtitle' => [ 'label' => 'Hero Subtitle', 'type' => 'textarea' ],
        'nas_hero_btn_text' => [ 'label' => 'CTA Button Text', 'type' => 'text' ],
        'nas_hero_btn_url'  => [ 'label' => 'CTA Button URL', 'type' => 'url' ],
    ] as $key => $args ) {
        $wp_customize->add_setting( $key );
        $wp_customize->add_control( $key, array_merge( $args, [ 'section' => 'nas_hero' ] ) );
    }

    // Newsletter
    $wp_customize->add_section( 'nas_newsletter', [ 'title' => 'Newsletter Settings', 'panel' => 'nas_options' ] );
    $wp_customize->add_setting( 'nas_newsletter_email' );
    $wp_customize->add_control( 'nas_newsletter_email', [
        'label' => 'Newsletter Notification Email', 'section' => 'nas_newsletter', 'type' => 'email',
    ]);

    // Contact notification
    $wp_customize->add_section( 'nas_contact', [ 'title' => 'Contact & Notifications', 'panel' => 'nas_options' ] );
    $wp_customize->add_setting( 'nas_contact_email' );
    $wp_customize->add_control( 'nas_contact_email', [
        'label' => 'Contact Form Notification Email', 'section' => 'nas_contact', 'type' => 'email',
    ]);
}
add_action( 'customize_register', 'nas_customizer' );

// ============================================================
// MEMBERSHIP APPLICATION SETTINGS
// ============================================================
function nas_add_membership_settings_page() {
    add_options_page(
        'Membership Application', 'Membership Settings',
        'manage_options', 'nas-membership',
        'nas_membership_settings_page'
    );
}
add_action( 'admin_menu', 'nas_add_membership_settings_page' );

function nas_membership_settings_page() {
    if ( isset($_POST['nas_membership_save']) && check_admin_referer('nas_membership_nonce') ) {
        update_option( 'nas_app_open',        sanitize_text_field($_POST['nas_app_open'] ?? '') );
        update_option( 'nas_app_close',       sanitize_text_field($_POST['nas_app_close'] ?? '') );
        update_option( 'nas_app_closed_msg',  wp_kses_post($_POST['nas_app_closed_msg'] ?? '') );
        update_option( 'nas_app_upcoming_msg',wp_kses_post($_POST['nas_app_upcoming_msg'] ?? '') );
        update_option( 'nas_app_notify_email',sanitize_email($_POST['nas_app_notify_email'] ?? '') );
        echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
    }
    $open        = get_option('nas_app_open', '');
    $close       = get_option('nas_app_close', '');
    $closed_msg  = get_option('nas_app_closed_msg', 'Applications are currently closed. Please check back later.');
    $upcoming    = get_option('nas_app_upcoming_msg', 'Applications will open on {date}. Stay tuned!');
    $notify      = get_option('nas_app_notify_email', get_option('admin_email'));
    ?>
    <div class="wrap nas-admin-wrap">
        <h1>⚓ Membership Application Settings</h1>
        <form method="post">
            <?php wp_nonce_field('nas_membership_nonce'); ?>
            <table class="form-table">
                <tr><th>Application Open Date</th><td><input type="datetime-local" name="nas_app_open" value="<?php echo esc_attr($open); ?>" class="regular-text"></td></tr>
                <tr><th>Application Close Date</th><td><input type="datetime-local" name="nas_app_close" value="<?php echo esc_attr($close); ?>" class="regular-text"></td></tr>
                <tr><th>Closed Message</th><td><textarea name="nas_app_closed_msg" rows="4" class="large-text"><?php echo esc_textarea($closed_msg); ?></textarea><p class="description">Shown when applications are closed.</p></td></tr>
                <tr><th>Upcoming Message</th><td><textarea name="nas_app_upcoming_msg" rows="4" class="large-text"><?php echo esc_textarea($upcoming); ?></textarea><p class="description">Use {date} and {time} as placeholders.</p></td></tr>
                <tr><th>Notification Email</th><td><input type="email" name="nas_app_notify_email" value="<?php echo esc_attr($notify); ?>" class="regular-text"></td></tr>
            </table>
            <input type="hidden" name="nas_membership_save" value="1">
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <?php
}

function nas_is_application_open() {
    $open  = get_option('nas_app_open', '');
    $close = get_option('nas_app_close', '');
    if ( empty($open) || empty($close) ) return false;
    $now   = current_time('timestamp');
    $start = strtotime($open);
    $end   = strtotime($close);
    return ( $now >= $start && $now <= $end );
}

function nas_application_status() {
    $open  = get_option('nas_app_open', '');
    $close = get_option('nas_app_close', '');
    $now   = current_time('timestamp');
    if ( empty($open) ) return 'no_dates';
    $start = strtotime($open);
    $end   = strtotime($close);
    if ( $now < $start ) return 'upcoming';
    if ( $now > $end )   return 'closed';
    return 'open';
}

// ============================================================
// AJAX: JOIN US APPLICATION FORM
// ============================================================
add_action( 'wp_ajax_nas_submit_application',        'nas_handle_application' );
add_action( 'wp_ajax_nopriv_nas_submit_application', 'nas_handle_application' );

function nas_handle_application() {
    check_ajax_referer( 'nas_nonce', 'nonce' );

    if ( ! nas_is_application_open() ) {
        wp_send_json_error(['message' => 'Applications are not currently open.']);
    }

    $required = ['first_name','last_name','email','phone','date_of_birth','nationality','occupation','education','motivation'];
    foreach ( $required as $field ) {
        if ( empty($_POST[$field]) ) {
            wp_send_json_error(['message' => 'Please fill all required fields.']);
        }
    }

    global $wpdb;
    $table = $wpdb->prefix . 'nas_applications';

    $window_id = nas_get_current_window_id();

    $data = [
        'first_name'   => sanitize_text_field($_POST['first_name']),
        'last_name'    => sanitize_text_field($_POST['last_name']),
        'email'        => sanitize_email($_POST['email']),
        'phone'        => sanitize_text_field($_POST['phone']),
        'date_of_birth'=> sanitize_text_field($_POST['date_of_birth']),
        'nationality'  => sanitize_text_field($_POST['nationality']),
        'occupation'   => sanitize_text_field($_POST['occupation']),
        'education'    => sanitize_text_field($_POST['education']),
        'deck_interest'=> sanitize_text_field($_POST['deck_interest'] ?? ''),
        'motivation'   => sanitize_textarea_field($_POST['motivation']),
        'referral'     => sanitize_text_field($_POST['referral'] ?? ''),
        'window_id'    => $window_id,
        'submitted_at' => current_time('mysql'),
        'ip_address'   => $_SERVER['REMOTE_ADDR'] ?? '',
        'status'       => 'pending',
    ];

    $wpdb->insert( $table, $data );
    $app_id = $wpdb->insert_id;

    // Send notification
    $notify_email = get_option('nas_app_notify_email', get_option('admin_email'));
    $subject = '[NAS] New Application — ' . $data['first_name'] . ' ' . $data['last_name'];
    $message  = "A new membership application has been submitted.\n\n";
    $message .= "Name: {$data['first_name']} {$data['last_name']}\n";
    $message .= "Email: {$data['email']}\n";
    $message .= "Phone: {$data['phone']}\n";
    $message .= "Nationality: {$data['nationality']}\n";
    $message .= "Occupation: {$data['occupation']}\n";
    $message .= "Deck of Interest: {$data['deck_interest']}\n\n";
    $message .= "Motivation:\n{$data['motivation']}\n\n";
    $message .= admin_url('admin.php?page=nas-applications&app_id=' . $app_id);
    wp_mail( $notify_email, $subject, $message );

    // Confirmation to applicant
    $conf_subject = 'Your NAS Application Has Been Received';
    $conf_message = "Dear {$data['first_name']},\n\nThank you for applying to join the National Association of Seadogs (Pyrates Confraternity).\n\nYour application has been received and will be reviewed by our team. We will be in touch with you shortly.\n\nThe Seatiger.\nNational Association of Seadogs";
    wp_mail( $data['email'], $conf_subject, $conf_message );

    wp_send_json_success(['message' => 'Your application has been submitted successfully. You will receive a confirmation email shortly.']);
}

function nas_get_current_window_id() {
    $open  = get_option('nas_app_open', '');
    $close = get_option('nas_app_close', '');
    return md5( $open . '|' . $close );
}

// ============================================================
// AJAX: CONTACT FORM
// ============================================================
add_action( 'wp_ajax_nas_contact_form',        'nas_handle_contact' );
add_action( 'wp_ajax_nopriv_nas_contact_form', 'nas_handle_contact' );

function nas_handle_contact() {
    check_ajax_referer( 'nas_nonce', 'nonce' );

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if ( empty($name) || empty($email) || empty($message) ) {
        wp_send_json_error(['message' => 'Please fill all required fields.']);
    }

    global $wpdb;
    $wpdb->insert( $wpdb->prefix . 'nas_contacts', [
        'name'         => $name,
        'email'        => $email,
        'subject'      => $subject,
        'message'      => $message,
        'submitted_at' => current_time('mysql'),
        'ip_address'   => $_SERVER['REMOTE_ADDR'] ?? '',
    ]);

    $notify = get_theme_mod('nas_contact_email', get_option('admin_email'));
    wp_mail( $notify, "[NAS Contact] $subject", "From: $name <$email>\n\n$message" );

    wp_send_json_success(['message' => 'Your message has been sent. We will respond shortly.']);
}

// ============================================================
// AJAX: NEWSLETTER
// ============================================================
add_action( 'wp_ajax_nas_newsletter',        'nas_handle_newsletter' );
add_action( 'wp_ajax_nopriv_nas_newsletter', 'nas_handle_newsletter' );

function nas_handle_newsletter() {
    check_ajax_referer( 'nas_nonce', 'nonce' );
    $email = sanitize_email($_POST['email'] ?? '');
    if ( ! is_email($email) ) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }

    global $wpdb;
    $exists = $wpdb->get_var( $wpdb->prepare(
        "SELECT id FROM {$wpdb->prefix}nas_newsletter WHERE email = %s", $email
    ));
    if ( $exists ) {
        wp_send_json_error(['message' => 'You are already subscribed to our newsletter.']);
    }

    $wpdb->insert( $wpdb->prefix . 'nas_newsletter', [
        'email'        => $email,
        'subscribed_at'=> current_time('mysql'),
        'status'       => 'active',
    ]);

    $notify = get_theme_mod('nas_newsletter_email', get_option('admin_email'));
    wp_mail( $notify, '[NAS] New Newsletter Subscriber', "New subscriber: $email" );

    wp_send_json_success(['message' => 'You have been subscribed successfully. Welcome aboard, Pyrate!']);
}

// ============================================================
// AJAX: CHATBOT
// ============================================================
add_action( 'wp_ajax_nas_chatbot',        'nas_handle_chatbot' );
add_action( 'wp_ajax_nopriv_nas_chatbot', 'nas_handle_chatbot' );

function nas_handle_chatbot() {
    check_ajax_referer( 'nas_nonce', 'nonce' );
    $user_msg = sanitize_textarea_field($_POST['message'] ?? '');
    if ( empty($user_msg) ) {
        wp_send_json_error(['message' => 'Empty message.']);
    }

    $knowledge = nas_get_chatbot_knowledge();
    $history   = json_decode(stripslashes($_POST['history'] ?? '[]'), true);

    // Simple keyword-matching response engine
    $response  = nas_chatbot_respond($user_msg, $knowledge, $history);

    wp_send_json_success(['reply' => $response]);
}

function nas_get_chatbot_knowledge() {
    $knowledge = get_option('nas_chatbot_knowledge', '');
    if ( empty($knowledge) ) {
        $knowledge = nas_default_chatbot_knowledge();
    }
    return $knowledge;
}

function nas_default_chatbot_knowledge() {
    return "NAS KNOWLEDGE BASE\n\nFounded: 1952 at University College Ibadan (now University of Ibadan), Nigeria.\nFounders: Wole Soyinka and six others, collectively known as the 'Magnificent Seven'.\nFull name: National Association of Seadogs (Pyrates Confraternity).\nAbbreviation: NAS or PC.\nMotto: Non Nobis Solum (Not for us alone).\nColors: Red and Gold (Yellow).\nSymbol: Skull and crossed bones.\nHeadquarters: Nigeria, with decks worldwide.\nDecks: Local branches are called Decks. Examples include Saxon Deck (Manchester), Zero Meridian (London).\nMission: Pursuit of a just and egalitarian society. Anti-corruption, human rights, and social justice.\nActivities: Medical missions, street kids programs, charity events, citizens' summits.\nMembership: By invitation/application during open intake windows.\nITT: Intake and Training Team — the interview and onboarding process.\nWebsite: https://www.nas-int.org\nSocial media: @NASPC1952 on Facebook and X.";
}

function nas_chatbot_respond($user_msg, $knowledge, $history) {
    $msg = strtolower($user_msg);

    // Pattern → response map
    $patterns = [
        ['found|start|begin|origin|history|1952|ibadan|soyinka','NAS was founded in 1952 at University College Ibadan, Nigeria, by Wole Soyinka and six others known as the "Magnificent Seven." The association was born out of a desire to fight for justice and equality in Nigerian society and beyond.'],
        ['motto|non nobis', 'Our motto is <strong>Non Nobis Solum</strong> — Latin for "Not for us alone." It encapsulates our commitment to service beyond self.'],
        ['member|join|apply|application|intake', 'Membership in NAS is by invitation and application during open intake windows. Visit our <a href="/join">Join Us</a> page to learn more and apply when applications are open.'],
        ['deck|branch|chapter|london|manchester|uk|nigeria|australia', 'Decks are NAS branches around the world. For example, Saxon Deck (Manchester, UK), Zero Meridian (London, UK), and many others across Nigeria, USA, Australia, and more. See our <a href="/countries">Countries</a> page for details.'],
        ['itt|interview|intake process|training', 'ITT (Intake and Training Team) is our structured interview and onboarding process for prospective members. It includes quizzes, interviews, and orientation. Access is restricted and by invitation.'],
        ['color|colour|red|gold|yellow', 'The official colours of NAS are Red (#96050D) and Gold/Yellow (#FFDD00) — bold, proud colours that represent our courage and legacy.'],
        ['skull|crossbones|symbol|logo', 'The skull and crossed bones is the iconic symbol of NAS, representing our fearlessness and commitment to truth. It features prominently in our emblem alongside the anchor.'],
        ['project|mission|charity|medical|street kids', 'NAS runs several impactful projects worldwide, including medical missions, support for street children, citizens\' summits, and the Charity Red Ball. These are led by our various decks.'],
        ['wole soyinka|soyinka|magnificent seven|founders', 'NAS was co-founded by Nobel laureate Wole Soyinka along with six others known collectively as the "Magnificent Seven" in 1952. They set out to build a fraternity rooted in justice and intellectual courage.'],
        ['contact|reach|email|phone|address', 'You can reach us through our <a href="/contact">Contact page</a>. You may also connect with us on social media @NASPC1952 on X and Facebook.'],
        ['news|event|press|article|lecture', 'Our <a href="/news-events">News & Events</a> section contains press releases, public articles, seminar papers, and NAS in the News updates. Stay informed!'],
        ['social|facebook|twitter|instagram|x', 'Find us on social media: Facebook and X at @NASPC1952.'],
    ];

    foreach ($patterns as [$pattern, $reply]) {
        if (preg_match("/($pattern)/i", $msg)) {
            return $reply;
        }
    }

    // Default fallback
    $defaults = [
        "I\'m the NAS Chatbot, here to help you learn about the National Association of Seadogs (Pyrates Confraternity). Try asking about our history, how to join, our decks, projects, or the ITT process.",
        "That\'s a great question! For detailed information, please visit <a href='/history'>our History page</a> or browse our site. I can help with questions about NAS history, membership, decks, and projects.",
        "Ahoy! I\'m here to help with questions about NAS. You can ask me about our founding, membership process, our decks worldwide, or our community projects.",
    ];

    return $defaults[array_rand($defaults)];
}

// ============================================================
// CREATE DATABASE TABLES ON ACTIVATION
// ============================================================
function nas_create_tables() {
    global $wpdb;
    $charset = $wpdb->get_charset_collate();

    $sql = [];

    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}nas_applications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(200) NOT NULL,
        phone VARCHAR(50),
        date_of_birth VARCHAR(20),
        nationality VARCHAR(100),
        occupation VARCHAR(200),
        education VARCHAR(200),
        deck_interest VARCHAR(200),
        motivation TEXT,
        referral VARCHAR(200),
        window_id VARCHAR(64),
        status VARCHAR(50) DEFAULT 'pending',
        notes TEXT,
        ip_address VARCHAR(50),
        submitted_at DATETIME,
        INDEX (window_id), INDEX (status), INDEX (email)
    ) $charset;";

    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}nas_contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        email VARCHAR(200) NOT NULL,
        subject VARCHAR(300),
        message TEXT,
        ip_address VARCHAR(50),
        submitted_at DATETIME,
        status VARCHAR(50) DEFAULT 'unread'
    ) $charset;";

    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}nas_newsletter (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(200) NOT NULL UNIQUE,
        subscribed_at DATETIME,
        status VARCHAR(50) DEFAULT 'active'
    ) $charset;";

    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}nas_itt_questions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category VARCHAR(100),
        question TEXT,
        answer TEXT,
        sort_order INT DEFAULT 0,
        active TINYINT DEFAULT 1
    ) $charset;";

    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}nas_itt_quizzes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question TEXT,
        option_a VARCHAR(300),
        option_b VARCHAR(300),
        option_c VARCHAR(300),
        option_d VARCHAR(300),
        correct_option CHAR(1),
        explanation TEXT,
        sort_order INT DEFAULT 0,
        active TINYINT DEFAULT 1
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    foreach ($sql as $query) {
        dbDelta($query);
    }
}
add_action('after_switch_theme', 'nas_create_tables');
// Also run on init in case tables are missing
add_action('init', function() {
    if (!get_option('nas_tables_created_v1')) {
        nas_create_tables();
        update_option('nas_tables_created_v1', true);
    }
});

// ============================================================
// ADMIN MENUS
// ============================================================
function nas_admin_menus() {
    add_menu_page( '⚓ NAS Admin', 'NAS', 'manage_options', 'nas-dashboard',
        'nas_dashboard_page', 'dashicons-tide', 3 );

    add_submenu_page('nas-dashboard', 'Applications', 'Applications',
        'manage_options', 'nas-applications', 'nas_applications_page');

    add_submenu_page('nas-dashboard', 'ITT', 'ITT',
        'manage_options', 'nas-itt', 'nas_itt_page');

    add_submenu_page('nas-dashboard', 'Newsletter', 'Newsletter',
        'manage_options', 'nas-newsletter', 'nas_newsletter_page');

    add_submenu_page('nas-dashboard', 'Contacts', 'Contacts',
        'manage_options', 'nas-contacts', 'nas_contacts_page');

    add_submenu_page('nas-dashboard', 'Chatbot Training', 'Chatbot',
        'manage_options', 'nas-chatbot', 'nas_chatbot_admin_page');
}
add_action('admin_menu', 'nas_admin_menus');

// ============================================================
// ADMIN PAGE: DASHBOARD
// ============================================================
function nas_dashboard_page() {
    global $wpdb;
    $apps       = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}nas_applications WHERE status='pending'");
    $contacts   = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}nas_contacts WHERE status='unread'");
    $subscribers= $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}nas_newsletter WHERE status='active'");
    $status     = nas_application_status();
    $open       = get_option('nas_app_open','N/A');
    $close      = get_option('nas_app_close','N/A');
    ?>
    <div class="wrap nas-admin-wrap">
        <div class="nas-admin-header">
            <h1>⚓ NAS Admin Dashboard</h1>
            <p class="nas-admin-sub">National Association of Seadogs — Pyrates Confraternity</p>
        </div>
        <div class="nas-stat-grid">
            <div class="nas-stat-card">
                <div class="nas-stat-num"><?php echo $apps; ?></div>
                <div class="nas-stat-label">Pending Applications</div>
                <a href="?page=nas-applications" class="nas-stat-link">View All →</a>
            </div>
            <div class="nas-stat-card">
                <div class="nas-stat-num"><?php echo $contacts; ?></div>
                <div class="nas-stat-label">Unread Messages</div>
                <a href="?page=nas-contacts" class="nas-stat-link">View All →</a>
            </div>
            <div class="nas-stat-card">
                <div class="nas-stat-num"><?php echo $subscribers; ?></div>
                <div class="nas-stat-label">Newsletter Subscribers</div>
                <a href="?page=nas-newsletter" class="nas-stat-link">View All →</a>
            </div>
            <div class="nas-stat-card <?php echo $status === 'open' ? 'nas-stat-green' : 'nas-stat-red'; ?>">
                <div class="nas-stat-num"><?php echo ucfirst($status); ?></div>
                <div class="nas-stat-label">Application Window</div>
                <a href="<?php echo admin_url('options-general.php?page=nas-membership'); ?>" class="nas-stat-link">Manage →</a>
            </div>
        </div>
        <div class="nas-info-row">
            <div class="nas-info-box">
                <h3>Application Window</h3>
                <p><strong>Opens:</strong> <?php echo $open; ?></p>
                <p><strong>Closes:</strong> <?php echo $close; ?></p>
                <a href="<?php echo admin_url('options-general.php?page=nas-membership'); ?>" class="button button-primary">Update Settings</a>
            </div>
            <div class="nas-info-box">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="<?php echo admin_url('post-new.php?post_type=nas_project'); ?>">+ Add Project</a></li>
                    <li><a href="<?php echo admin_url('post-new.php?post_type=nas_deck'); ?>">+ Add Deck</a></li>
                    <li><a href="<?php echo admin_url('post-new.php'); ?>">+ New Post</a></li>
                    <li><a href="?page=nas-chatbot">Train Chatbot</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php
}

// ============================================================
// ADMIN PAGE: APPLICATIONS
// ============================================================
function nas_applications_page() {
    global $wpdb;

    // Handle status update
    if ( isset($_POST['nas_update_app']) && check_admin_referer('nas_app_nonce') ) {
        $wpdb->update(
            $wpdb->prefix . 'nas_applications',
            ['status' => sanitize_text_field($_POST['status']), 'notes' => sanitize_textarea_field($_POST['notes'] ?? '')],
            ['id' => intval($_POST['app_id'])]
        );
        echo '<div class="notice notice-success"><p>Application updated.</p></div>';
    }

    // Handle broadcast email
    if ( isset($_POST['nas_broadcast']) && check_admin_referer('nas_broadcast_nonce') ) {
        $window_id = sanitize_text_field($_POST['window_id'] ?? '');
        $emails    = $wpdb->get_col( $wpdb->prepare(
            "SELECT email FROM {$wpdb->prefix}nas_applications WHERE window_id = %s", $window_id
        ));
        $bsubject  = sanitize_text_field($_POST['broadcast_subject']);
        $bmessage  = wp_kses_post($_POST['broadcast_message']);
        $sent = 0;
        foreach ($emails as $em) { if (wp_mail($em, $bsubject, $bmessage)) $sent++; }
        echo "<div class='notice notice-success'><p>Broadcast sent to $sent applicants.</p></div>";
    }

    // View single
    $view_id = intval($_GET['app_id'] ?? 0);
    if ($view_id) {
        $app = $wpdb->get_row( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}nas_applications WHERE id=%d", $view_id) );
        if ($app) {
            nas_render_single_application($app);
            return;
        }
    }

    $status_filter = sanitize_text_field($_GET['status_filter'] ?? '');
    $window_filter = sanitize_text_field($_GET['window_filter'] ?? '');

    $where = '1=1';
    if ($status_filter) $where .= $wpdb->prepare(' AND status=%s', $status_filter);
    if ($window_filter) $where .= $wpdb->prepare(' AND window_id=%s', $window_filter);

    $apps = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}nas_applications WHERE $where ORDER BY submitted_at DESC");
    $windows = $wpdb->get_col("SELECT DISTINCT window_id FROM {$wpdb->prefix}nas_applications");

    ?>
    <div class="wrap nas-admin-wrap">
        <div class="nas-admin-header">
            <h1>📋 Applications</h1>
        </div>

        <div class="nas-filter-bar">
            <form method="get">
                <input type="hidden" name="page" value="nas-applications">
                <select name="status_filter">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php selected($status_filter,'pending'); ?>>Pending</option>
                    <option value="approved" <?php selected($status_filter,'approved'); ?>>Approved</option>
                    <option value="rejected" <?php selected($status_filter,'rejected'); ?>>Rejected</option>
                    <option value="interview" <?php selected($status_filter,'interview'); ?>>Interview</option>
                </select>
                <select name="window_filter">
                    <option value="">All Windows</option>
                    <?php foreach ($windows as $w): ?>
                    <option value="<?php echo esc_attr($w); ?>" <?php selected($window_filter,$w); ?>><?php echo substr($w,0,12).'...'; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="button">Filter</button>
            </form>
        </div>

        <?php if ($window_filter): ?>
        <div class="nas-broadcast-box">
            <h3>📢 Broadcast to Window Applicants</h3>
            <form method="post">
                <?php wp_nonce_field('nas_broadcast_nonce'); ?>
                <input type="hidden" name="window_id" value="<?php echo esc_attr($window_filter); ?>">
                <input type="text" name="broadcast_subject" placeholder="Email Subject" class="regular-text" required>
                <br><br>
                <textarea name="broadcast_message" rows="6" class="large-text" placeholder="Email message..." required></textarea>
                <br><br>
                <input type="submit" name="nas_broadcast" value="Send Broadcast" class="button button-primary">
            </form>
        </div>
        <?php endif; ?>

        <table class="wp-list-table widefat fixed nas-table">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Nationality</th><th>Deck Interest</th><th>Date</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($apps as $app): ?>
                <tr>
                    <td>#<?php echo $app->id; ?></td>
                    <td><?php echo esc_html($app->first_name.' '.$app->last_name); ?></td>
                    <td><?php echo esc_html($app->email); ?></td>
                    <td><?php echo esc_html($app->nationality); ?></td>
                    <td><?php echo esc_html($app->deck_interest); ?></td>
                    <td><?php echo esc_html($app->submitted_at); ?></td>
                    <td><span class="nas-badge nas-badge-<?php echo esc_attr($app->status); ?>"><?php echo ucfirst($app->status); ?></span></td>
                    <td><a href="?page=nas-applications&app_id=<?php echo $app->id; ?>" class="button button-small">View</a></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($apps)): ?><tr><td colspan="8" style="text-align:center">No applications found.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function nas_render_single_application($app) { ?>
    <div class="wrap nas-admin-wrap">
        <h1>Application #<?php echo $app->id; ?> — <?php echo esc_html($app->first_name.' '.$app->last_name); ?></h1>
        <a href="?page=nas-applications" class="button">← Back to All</a>
        <div class="nas-app-detail-grid">
            <div class="nas-app-detail-card">
                <h3>Personal Information</h3>
                <table class="nas-detail-table">
                    <tr><th>Full Name</th><td><?php echo esc_html($app->first_name.' '.$app->last_name); ?></td></tr>
                    <tr><th>Email</th><td><a href="mailto:<?php echo esc_attr($app->email); ?>"><?php echo esc_html($app->email); ?></a></td></tr>
                    <tr><th>Phone</th><td><?php echo esc_html($app->phone); ?></td></tr>
                    <tr><th>Date of Birth</th><td><?php echo esc_html($app->date_of_birth); ?></td></tr>
                    <tr><th>Nationality</th><td><?php echo esc_html($app->nationality); ?></td></tr>
                    <tr><th>Occupation</th><td><?php echo esc_html($app->occupation); ?></td></tr>
                    <tr><th>Education</th><td><?php echo esc_html($app->education); ?></td></tr>
                    <tr><th>Deck Interest</th><td><?php echo esc_html($app->deck_interest); ?></td></tr>
                    <tr><th>Referral</th><td><?php echo esc_html($app->referral); ?></td></tr>
                    <tr><th>Submitted</th><td><?php echo esc_html($app->submitted_at); ?></td></tr>
                    <tr><th>IP Address</th><td><?php echo esc_html($app->ip_address); ?></td></tr>
                </table>
                <h3>Motivation Statement</h3>
                <div class="nas-motivation-text"><?php echo nl2br(esc_html($app->motivation)); ?></div>
            </div>
            <div class="nas-app-detail-card">
                <h3>Update Status</h3>
                <form method="post">
                    <?php wp_nonce_field('nas_app_nonce'); ?>
                    <input type="hidden" name="app_id" value="<?php echo $app->id; ?>">
                    <select name="status" class="regular-text">
                        <option value="pending" <?php selected($app->status,'pending'); ?>>Pending</option>
                        <option value="interview" <?php selected($app->status,'interview'); ?>>Invite to Interview</option>
                        <option value="approved" <?php selected($app->status,'approved'); ?>>Approved</option>
                        <option value="rejected" <?php selected($app->status,'rejected'); ?>>Rejected</option>
                    </select>
                    <br><br>
                    <textarea name="notes" rows="6" class="large-text" placeholder="Admin notes..."><?php echo esc_textarea($app->notes ?? ''); ?></textarea>
                    <br><br>
                    <input type="submit" name="nas_update_app" value="Update Application" class="button button-primary">
                </form>
            </div>
        </div>
    </div>
<?php }

// ============================================================
// ADMIN PAGE: ITT
// ============================================================
function nas_itt_page() {
    global $wpdb;

    // Save ITT Settings
    if ( isset($_POST['save_itt_settings']) && check_admin_referer('nas_itt_nonce') ) {
        update_option('nas_itt_password', sanitize_text_field($_POST['itt_password']));
        update_option('nas_itt_intro', wp_kses_post($_POST['itt_intro']));
        update_option('nas_itt_intake_info', wp_kses_post($_POST['itt_intake_info']));
        echo '<div class="notice notice-success"><p>ITT settings saved.</p></div>';
    }

    // Add Question
    if ( isset($_POST['add_question']) && check_admin_referer('nas_itt_nonce') ) {
        $wpdb->insert($wpdb->prefix.'nas_itt_questions', [
            'category'   => sanitize_text_field($_POST['q_category']),
            'question'   => sanitize_textarea_field($_POST['q_question']),
            'answer'     => wp_kses_post($_POST['q_answer']),
            'sort_order' => intval($_POST['q_order'] ?? 0),
            'active'     => 1,
        ]);
        echo '<div class="notice notice-success"><p>Question added.</p></div>';
    }

    // Add Quiz Item
    if ( isset($_POST['add_quiz']) && check_admin_referer('nas_itt_nonce') ) {
        $wpdb->insert($wpdb->prefix.'nas_itt_quizzes', [
            'question'       => sanitize_textarea_field($_POST['quiz_question']),
            'option_a'       => sanitize_text_field($_POST['quiz_a']),
            'option_b'       => sanitize_text_field($_POST['quiz_b']),
            'option_c'       => sanitize_text_field($_POST['quiz_c']),
            'option_d'       => sanitize_text_field($_POST['quiz_d']),
            'correct_option' => sanitize_text_field($_POST['quiz_correct']),
            'explanation'    => sanitize_textarea_field($_POST['quiz_explanation'] ?? ''),
            'sort_order'     => intval($_POST['quiz_order'] ?? 0),
            'active'         => 1,
        ]);
        echo '<div class="notice notice-success"><p>Quiz question added.</p></div>';
    }

    // Delete items
    if ( isset($_GET['delete_q']) ) { $wpdb->delete($wpdb->prefix.'nas_itt_questions',['id'=>intval($_GET['delete_q'])]); }
    if ( isset($_GET['delete_quiz']) ) { $wpdb->delete($wpdb->prefix.'nas_itt_quizzes',['id'=>intval($_GET['delete_quiz'])]); }

    $questions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}nas_itt_questions ORDER BY sort_order ASC");
    $quizzes   = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}nas_itt_quizzes ORDER BY sort_order ASC");
    $itt_pass  = get_option('nas_itt_password','');
    $itt_intro = get_option('nas_itt_intro','');
    $intake    = get_option('nas_itt_intake_info','');

    ?>
    <div class="wrap nas-admin-wrap">
        <div class="nas-admin-header">
            <h1>🔱 ITT — Interview & Training</h1>
            <p>Manage the <a href="<?php echo site_url('/itt'); ?>" target="_blank">/itt</a> page content.</p>
        </div>

        <div class="nas-tabs">
            <button class="nas-tab active" data-tab="settings">Settings</button>
            <button class="nas-tab" data-tab="questions">Interview Questions</button>
            <button class="nas-tab" data-tab="quiz">Quiz</button>
        </div>

        <div class="nas-tab-content active" id="tab-settings">
            <form method="post">
                <?php wp_nonce_field('nas_itt_nonce'); ?>
                <table class="form-table">
                    <tr><th>Page Password</th><td><input type="text" name="itt_password" value="<?php echo esc_attr($itt_pass); ?>" class="regular-text"><p class="description">Password required to access /itt page.</p></td></tr>
                    <tr><th>Page Introduction</th><td><?php wp_editor($itt_intro,'itt_intro',['textarea_name'=>'itt_intro','rows'=>6]); ?></td></tr>
                    <tr><th>Intake Information</th><td><?php wp_editor($intake,'itt_intake_info',['textarea_name'=>'itt_intake_info','rows'=>10]); ?></td></tr>
                </table>
                <input type="submit" name="save_itt_settings" value="Save ITT Settings" class="button button-primary">
            </form>
        </div>

        <div class="nas-tab-content" id="tab-questions">
            <h3>Add Interview Question</h3>
            <form method="post">
                <?php wp_nonce_field('nas_itt_nonce'); ?>
                <table class="form-table">
                    <tr><th>Category</th><td><input type="text" name="q_category" class="regular-text" placeholder="e.g. History, Philosophy"></td></tr>
                    <tr><th>Question</th><td><textarea name="q_question" rows="3" class="large-text" required></textarea></td></tr>
                    <tr><th>Model Answer</th><td><?php wp_editor('','q_answer',['textarea_name'=>'q_answer','rows'=>5]); ?></td></tr>
                    <tr><th>Sort Order</th><td><input type="number" name="q_order" value="0" style="width:80px"></td></tr>
                </table>
                <input type="submit" name="add_question" value="Add Question" class="button button-primary">
            </form>

            <h3 style="margin-top:32px">Existing Questions (<?php echo count($questions); ?>)</h3>
            <table class="wp-list-table widefat fixed nas-table">
                <thead><tr><th>ID</th><th>Category</th><th>Question</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach ($questions as $q): ?>
                    <tr>
                        <td><?php echo $q->id; ?></td>
                        <td><?php echo esc_html($q->category); ?></td>
                        <td><?php echo esc_html(substr($q->question,0,100)).'...'; ?></td>
                        <td><a href="?page=nas-itt&delete_q=<?php echo $q->id; ?>" onclick="return confirm('Delete this question?')" class="button button-small">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="nas-tab-content" id="tab-quiz">
            <h3>Add Quiz Question</h3>
            <form method="post">
                <?php wp_nonce_field('nas_itt_nonce'); ?>
                <table class="form-table">
                    <tr><th>Question</th><td><textarea name="quiz_question" rows="3" class="large-text" required></textarea></td></tr>
                    <tr><th>Option A</th><td><input type="text" name="quiz_a" class="large-text"></td></tr>
                    <tr><th>Option B</th><td><input type="text" name="quiz_b" class="large-text"></td></tr>
                    <tr><th>Option C</th><td><input type="text" name="quiz_c" class="large-text"></td></tr>
                    <tr><th>Option D</th><td><input type="text" name="quiz_d" class="large-text"></td></tr>
                    <tr><th>Correct Answer</th><td>
                        <select name="quiz_correct">
                            <option value="A">A</option><option value="B">B</option>
                            <option value="C">C</option><option value="D">D</option>
                        </select>
                    </td></tr>
                    <tr><th>Explanation</th><td><textarea name="quiz_explanation" rows="3" class="large-text"></textarea></td></tr>
                    <tr><th>Sort Order</th><td><input type="number" name="quiz_order" value="0" style="width:80px"></td></tr>
                </table>
                <input type="submit" name="add_quiz" value="Add Quiz Question" class="button button-primary">
            </form>

            <h3 style="margin-top:32px">Quiz Questions (<?php echo count($quizzes); ?>)</h3>
            <table class="wp-list-table widefat fixed nas-table">
                <thead><tr><th>ID</th><th>Question</th><th>Correct</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach ($quizzes as $q): ?>
                    <tr>
                        <td><?php echo $q->id; ?></td>
                        <td><?php echo esc_html(substr($q->question,0,100)).'...'; ?></td>
                        <td><?php echo esc_html($q->correct_option); ?></td>
                        <td><a href="?page=nas-itt&delete_quiz=<?php echo $q->id; ?>" onclick="return confirm('Delete?')" class="button button-small">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

// ============================================================
// ADMIN PAGE: NEWSLETTER
// ============================================================
function nas_newsletter_page() {
    global $wpdb;

    if ( isset($_POST['send_newsletter']) && check_admin_referer('nas_nl_nonce') ) {
        $subject = sanitize_text_field($_POST['nl_subject']);
        $message = wp_kses_post($_POST['nl_message']);
        $subs    = $wpdb->get_col("SELECT email FROM {$wpdb->prefix}nas_newsletter WHERE status='active'");
        $sent = 0;
        foreach ($subs as $em) { if (wp_mail($em, $subject, $message)) $sent++; }
        echo "<div class='notice notice-success'><p>Newsletter sent to $sent subscribers.</p></div>";
    }

    if ( isset($_GET['unsub']) ) {
        $wpdb->update($wpdb->prefix.'nas_newsletter',['status'=>'unsubscribed'],['id'=>intval($_GET['unsub'])]);
    }

    $subs = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}nas_newsletter ORDER BY subscribed_at DESC");
    $total_active = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}nas_newsletter WHERE status='active'");
    ?>
    <div class="wrap nas-admin-wrap">
        <h1>📰 Newsletter</h1>
        <p><strong><?php echo $total_active; ?></strong> active subscribers</p>

        <div class="nas-nl-compose">
            <h3>Send Newsletter</h3>
            <form method="post">
                <?php wp_nonce_field('nas_nl_nonce'); ?>
                <input type="text" name="nl_subject" placeholder="Email Subject" class="large-text" required>
                <br><br>
                <?php wp_editor('','nl_message',['textarea_name'=>'nl_message','rows'=>12]); ?>
                <br>
                <input type="submit" name="send_newsletter" value="Send to All Subscribers" class="button button-primary" onclick="return confirm('Send to all <?php echo $total_active; ?> active subscribers?')">
            </form>
        </div>

        <h3 style="margin-top:32px">Subscribers</h3>
        <table class="wp-list-table widefat fixed nas-table">
            <thead><tr><th>Email</th><th>Subscribed</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            <?php foreach ($subs as $s): ?>
                <tr>
                    <td><?php echo esc_html($s->email); ?></td>
                    <td><?php echo esc_html($s->subscribed_at); ?></td>
                    <td><?php echo ucfirst($s->status); ?></td>
                    <td><?php if ($s->status==='active'): ?><a href="?page=nas-newsletter&unsub=<?php echo $s->id; ?>" class="button button-small">Unsubscribe</a><?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// ============================================================
// ADMIN PAGE: CONTACTS
// ============================================================
function nas_contacts_page() {
    global $wpdb;

    if ( isset($_GET['mark_read']) ) {
        $wpdb->update($wpdb->prefix.'nas_contacts',['status'=>'read'],['id'=>intval($_GET['mark_read'])]);
    }

    $contacts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}nas_contacts ORDER BY submitted_at DESC");
    ?>
    <div class="wrap nas-admin-wrap">
        <h1>✉️ Contact Messages</h1>
        <table class="wp-list-table widefat fixed nas-table">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            <?php foreach ($contacts as $c): ?>
                <tr class="<?php echo $c->status==='unread' ? 'nas-row-unread' : ''; ?>">
                    <td>#<?php echo $c->id; ?></td>
                    <td><?php echo esc_html($c->name); ?></td>
                    <td><a href="mailto:<?php echo esc_attr($c->email); ?>"><?php echo esc_html($c->email); ?></a></td>
                    <td><?php echo esc_html($c->subject); ?></td>
                    <td><?php echo esc_html($c->submitted_at); ?></td>
                    <td><span class="nas-badge nas-badge-<?php echo esc_attr($c->status); ?>"><?php echo ucfirst($c->status); ?></span></td>
                    <td>
                        <?php if ($c->status==='unread'): ?>
                        <a href="?page=nas-contacts&mark_read=<?php echo $c->id; ?>" class="button button-small">Mark Read</a>
                        <?php endif; ?>
                        <button onclick="document.getElementById('msg-<?php echo $c->id; ?>').style.display='block'" class="button button-small">View</button>
                    </td>
                </tr>
                <tr id="msg-<?php echo $c->id; ?>" style="display:none">
                    <td colspan="7" class="nas-msg-body"><?php echo nl2br(esc_html($c->message)); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// ============================================================
// ADMIN PAGE: CHATBOT TRAINING
// ============================================================
function nas_chatbot_admin_page() {
    if ( isset($_POST['save_chatbot']) && check_admin_referer('nas_chatbot_nonce') ) {
        update_option('nas_chatbot_knowledge', wp_kses_post($_POST['chatbot_knowledge']));
        echo '<div class="notice notice-success"><p>Chatbot knowledge base updated.</p></div>';
    }
    $knowledge = get_option('nas_chatbot_knowledge', nas_default_chatbot_knowledge());
    ?>
    <div class="wrap nas-admin-wrap">
        <h1>🤖 Chatbot Training</h1>
        <p>Edit the knowledge base text below. The chatbot uses keyword matching against this content. Write clearly and include all topics you want the bot to answer.</p>
        <form method="post">
            <?php wp_nonce_field('nas_chatbot_nonce'); ?>
            <textarea name="chatbot_knowledge" rows="30" class="large-text" style="font-family:monospace;font-size:13px"><?php echo esc_textarea($knowledge); ?></textarea>
            <br><br>
            <input type="submit" name="save_chatbot" value="Save Knowledge Base" class="button button-primary">
            <button type="button" class="button" onclick="if(confirm('Reset to defaults?')){document.querySelector('[name=chatbot_knowledge]').value=<?php echo json_encode(nas_default_chatbot_knowledge()); ?>}">Reset to Defaults</button>
        </form>
    </div>
    <?php
}

// ============================================================
// META BOXES FOR CPTs
// ============================================================
function nas_add_meta_boxes() {
    add_meta_box('nas_project_meta', '⚓ Project Details', 'nas_project_meta_box', 'nas_project', 'normal', 'high');
    add_meta_box('nas_deck_meta',    '⚓ Deck Details',    'nas_deck_meta_box',    'nas_deck',    'normal', 'high');
}
add_action('add_meta_boxes', 'nas_add_meta_boxes');

function nas_project_meta_box($post) {
    wp_nonce_field('nas_project_meta', 'nas_project_nonce');
    $featured = get_post_meta($post->ID, '_nas_featured', true);
    $country  = get_post_meta($post->ID, '_nas_project_country', true);
    $status   = get_post_meta($post->ID, '_nas_project_status', true);
    $year     = get_post_meta($post->ID, '_nas_project_year', true);
    $link     = get_post_meta($post->ID, '_nas_project_link', true);
    ?>
    <table class="form-table">
        <tr><th>Featured on Homepage</th><td><input type="checkbox" name="nas_featured" value="1" <?php checked($featured,'1'); ?>></td></tr>
        <tr><th>Country / Location</th><td><input type="text" name="nas_project_country" value="<?php echo esc_attr($country); ?>" class="regular-text"></td></tr>
        <tr><th>Status</th><td>
            <select name="nas_project_status">
                <option value="ongoing" <?php selected($status,'ongoing'); ?>>Ongoing</option>
                <option value="completed" <?php selected($status,'completed'); ?>>Completed</option>
                <option value="upcoming" <?php selected($status,'upcoming'); ?>>Upcoming</option>
            </select>
        </td></tr>
        <tr><th>Year</th><td><input type="number" name="nas_project_year" value="<?php echo esc_attr($year); ?>" style="width:100px"></td></tr>
        <tr><th>External Link</th><td><input type="url" name="nas_project_link" value="<?php echo esc_attr($link); ?>" class="large-text"></td></tr>
    </table>
    <?php
}

function nas_deck_meta_box($post) {
    wp_nonce_field('nas_deck_meta', 'nas_deck_nonce');
    $deck_name = get_post_meta($post->ID, '_nas_deck_name', true);
    $city      = get_post_meta($post->ID, '_nas_deck_city', true);
    $address   = get_post_meta($post->ID, '_nas_deck_address', true);
    $email     = get_post_meta($post->ID, '_nas_deck_email', true);
    $phone     = get_post_meta($post->ID, '_nas_deck_phone', true);
    $founded   = get_post_meta($post->ID, '_nas_deck_founded', true);
    $flag_url  = get_post_meta($post->ID, '_nas_deck_flag', true);
    ?>
    <table class="form-table">
        <tr><th>Deck Name</th><td><input type="text" name="nas_deck_name" value="<?php echo esc_attr($deck_name); ?>" class="regular-text" placeholder="e.g. Saxon, Zero Meridian"></td></tr>
        <tr><th>City / Region</th><td><input type="text" name="nas_deck_city" value="<?php echo esc_attr($city); ?>" class="regular-text"></td></tr>
        <tr><th>Address</th><td><textarea name="nas_deck_address" rows="3" class="large-text"><?php echo esc_textarea($address); ?></textarea></td></tr>
        <tr><th>Email</th><td><input type="email" name="nas_deck_email" value="<?php echo esc_attr($email); ?>" class="regular-text"></td></tr>
        <tr><th>Phone</th><td><input type="text" name="nas_deck_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text"></td></tr>
        <tr><th>Year Founded</th><td><input type="number" name="nas_deck_founded" value="<?php echo esc_attr($founded); ?>" style="width:100px"></td></tr>
        <tr><th>Flag Image URL</th><td><input type="url" name="nas_deck_flag" value="<?php echo esc_attr($flag_url); ?>" class="large-text"></td></tr>
    </table>
    <?php
}

function nas_save_meta_boxes($post_id) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

    if ( isset($_POST['nas_project_nonce']) && wp_verify_nonce($_POST['nas_project_nonce'],'nas_project_meta') ) {
        update_post_meta($post_id,'_nas_featured',      isset($_POST['nas_featured']) ? '1' : '0');
        update_post_meta($post_id,'_nas_project_country',sanitize_text_field($_POST['nas_project_country'] ?? ''));
        update_post_meta($post_id,'_nas_project_status', sanitize_text_field($_POST['nas_project_status']  ?? ''));
        update_post_meta($post_id,'_nas_project_year',   intval($_POST['nas_project_year']   ?? 0));
        update_post_meta($post_id,'_nas_project_link',   esc_url_raw($_POST['nas_project_link'] ?? ''));
    }

    if ( isset($_POST['nas_deck_nonce']) && wp_verify_nonce($_POST['nas_deck_nonce'],'nas_deck_meta') ) {
        foreach (['deck_name','deck_city','deck_address','deck_email','deck_phone','deck_founded','deck_flag'] as $field) {
            update_post_meta($post_id, "_nas_$field", sanitize_text_field($_POST["nas_$field"] ?? ''));
        }
    }
}
add_action('save_post','nas_save_meta_boxes');

// ============================================================
// HELPER FUNCTIONS
// ============================================================
function nas_get_svg_skull($size = 24, $color = '#FFDD00') {
    $icon_src = NAS_THEME_URI . '/assets/images/NAS_Skull_Crossed.png';
    return '<img src="' . esc_url($icon_src) . '" width="' . intval($size) . '" height="' . intval($size) . '" alt="NAS Skull and Crossed icon" class="nas-skull-icon" loading="lazy" decoding="async" style="width:' . intval($size) . 'px;height:' . intval($size) . 'px;object-fit:contain;vertical-align:middle;" />';
}

function nas_social_links($class = '') {
    $fb = get_theme_mod('nas_facebook', 'https://www.facebook.com/NASPC1952');
    $tw = get_theme_mod('nas_twitter',  'https://twitter.com/NASPC1952');
    $ig = get_theme_mod('nas_instagram','#');
    $links = '';
    if ($fb) $links .= "<a href='".esc_url($fb)."' target='_blank' rel='noopener' aria-label='Facebook' class='nas-social-link $class'><svg viewBox='0 0 24 24' fill='currentColor' width='18' height='18'><path d='M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z'/></svg></a>";
    if ($tw) $links .= "<a href='".esc_url($tw)."' target='_blank' rel='noopener' aria-label='X (Twitter)' class='nas-social-link $class'><svg viewBox='0 0 24 24' fill='currentColor' width='18' height='18'><path d='M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'/></svg></a>";
    if ($ig) $links .= "<a href='".esc_url($ig)."' target='_blank' rel='noopener' aria-label='Instagram' class='nas-social-link $class'><svg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' width='18' height='18'><rect x='2' y='2' width='20' height='20' rx='5' ry='5'/><path d='M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z'/><line x1='17.5' y1='6.5' x2='17.51' y2='6.5'/></svg></a>";
    return $links;
}

// ============================================================
// INCLUDES
// ============================================================
require_once NAS_THEME_DIR . '/inc/template-loader.php';

// ============================================================
// HELPER: READING TIME (global — used by single.php and index.php)
// ============================================================
if ( ! function_exists( 'nas_reading_time' ) ) {
    function nas_reading_time() {
        $content    = get_the_content();
        $word_count = str_word_count( strip_tags( $content ) );
        return max( 1, ceil( $word_count / 200 ) );
    }
}
