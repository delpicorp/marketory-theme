<?php
declare(strict_types=1);

define('MARKETORY_VERSION', '1.0.0');
define('MARKETORY_DIR', get_template_directory());
define('MARKETORY_URI', get_template_directory_uri());

require MARKETORY_DIR . '/inc/dequeue-gutenberg.php';
require MARKETORY_DIR . '/inc/enqueue.php';
require MARKETORY_DIR . '/inc/meta-fields.php';
require MARKETORY_DIR . '/inc/schema.php';
require MARKETORY_DIR . '/inc/seo.php';

function marketory_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus(['primary' => __('Primary Menu', 'marketory')]);
}
add_action('after_setup_theme', 'marketory_setup');

function marketory_reading_time(int $post_id = 0): int {
    $post_id = $post_id ?: (int) get_the_ID();
    $content = (string) get_post_field('post_content', $post_id);
    $text    = wp_strip_all_tags($content);
    // Korean chars / 500 + English words / 200, minimum 1 minute
    $chars = mb_strlen((string) preg_replace('/[a-zA-Z0-9\s]/', '', $text));
    $words = str_word_count($text);
    return max(1, (int) ceil($chars / 500 + $words / 200));
}

add_action('wp_head', function (): void {
    if (is_single()) {
        $id    = (int) get_the_ID();
        $views = (int) get_post_meta($id, '_post_views', true);
        update_post_meta($id, '_post_views', $views + 1);
    }
}, 1);
