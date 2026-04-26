<?php
declare(strict_types=1);

add_action('wp_head', 'marketory_seo_tags', 3);

function marketory_seo_tags(): void {
    global $post;

    $site_name = (string) get_bloginfo('name');

    if (is_single() && $post) {
        $id          = $post->ID;
        $url         = (string) get_permalink($id);
        $page_title  = get_the_title($id) . ' | ' . $site_name;
        $summary     = (string) get_post_meta($id, '_marketory_summary', true);
        $description = $summary ?: (string) wp_trim_words(wp_strip_all_tags($post->post_content), 30);
        $thumb       = (string) (get_the_post_thumbnail_url($id, 'large') ?: '');

        echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
        echo '<link rel="alternate" hreflang="ko-KR" href="' . esc_url($url) . '">' . "\n";
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($page_title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
        echo '<meta property="og:locale" content="ko_KR">' . "\n";
        if ($thumb) {
            echo '<meta property="og:image" content="' . esc_url($thumb) . '">' . "\n";
        }
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($page_title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
        if ($thumb) {
            echo '<meta name="twitter:image" content="' . esc_url($thumb) . '">' . "\n";
        }
        return;
    }

    if (is_archive()) {
        $url         = (string) get_pagenum_link();
        $page_title  = get_the_archive_title() . ' | ' . $site_name;
        $description = (string) (get_the_archive_description() ?: $site_name);

        echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($page_title) . '">' . "\n";
        return;
    }

    $url = home_url('/');
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
    echo '<link rel="alternate" hreflang="ko-KR" href="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($site_name) . '">' . "\n";
}
