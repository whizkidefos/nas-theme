<?php
/**
 * NAS Theme — Page Template Loader
 * Maps page slugs to template files
 */

if (!defined('ABSPATH')) exit;

// Register custom page templates
add_filter('theme_page_templates', function($templates) {
    $templates['page-templates/page-history.php']  = 'History';
    $templates['page-templates/page-countries.php']= 'Countries';
    $templates['page-templates/page-join.php']     = 'Join Us';
    $templates['page-templates/page-skull.php']    = 'Skull & Crossbones';
    $templates['page-templates/page-itt.php']      = 'ITT';
    return $templates;
});

// Load template file from subdirectory
add_filter('template_include', function($template) {
    if (is_page()) {
        $page_template = get_post_meta(get_the_ID(), '_wp_page_template', true);
        if ($page_template && $page_template !== 'default') {
            $file = get_template_directory() . '/' . $page_template;
            if (file_exists($file)) return $file;
        }
    }
    return $template;
});

// ITT page — rewrite /itt to the ITT page
add_action('init', function() {
    add_rewrite_rule('^itt/?$', 'index.php?pagename=itt', 'top');
});

// Ensure /itt page exists on theme activation
add_action('after_switch_theme', function() {
    $pages = [
        ['title'=>'Home',               'slug'=>'home',               'template'=>''],
        ['title'=>'History',            'slug'=>'history',            'template'=>'page-templates/page-history.php'],
        ['title'=>'Countries',          'slug'=>'countries',          'template'=>'page-templates/page-countries.php'],
        ['title'=>'News & Events',      'slug'=>'news-events',        'template'=>''],
        ['title'=>'Skull & Crossbones', 'slug'=>'skull-and-crossbones','template'=>'page-templates/page-skull.php'],
        ['title'=>'Join Us',            'slug'=>'join',               'template'=>'page-templates/page-join.php'],
        ['title'=>'ITT',                'slug'=>'itt',                'template'=>'page-templates/page-itt.php'],
    ];
    foreach ($pages as $page) {
        if (!get_page_by_path($page['slug'])) {
            $pid = wp_insert_post([
                'post_title'  => $page['title'],
                'post_name'   => $page['slug'],
                'post_status' => 'publish',
                'post_type'   => 'page',
            ]);
            if ($pid && $page['template']) {
                update_post_meta($pid, '_wp_page_template', $page['template']);
            }
        }
    }
    flush_rewrite_rules();
});
