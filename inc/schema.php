<?php
declare(strict_types=1);

add_action('wp_head', 'marketory_schema_output', 5);

function marketory_schema_output(): void {
    if (!is_single()) {
        return;
    }

    $post_id = (int) get_the_ID();
    $post    = get_post($post_id);
    if (!$post) {
        return;
    }

    $site_name  = (string) get_bloginfo('name');
    $site_url   = home_url('/');
    $post_url   = (string) get_permalink($post_id);
    $title      = (string) get_the_title($post_id);
    $pub_date   = (string) get_the_date('c', $post_id);
    $mod_date   = (string) get_the_modified_date('c', $post_id);
    $thumb_url  = (string) (get_the_post_thumbnail_url($post_id, 'large') ?: '');
    $author_id  = (int) $post->post_author;
    $author     = (string) get_the_author_meta('display_name', $author_id);

    $summary_raw  = (string) get_post_meta($post_id, '_marketory_summary', true);
    $keywords_raw = (string) get_post_meta($post_id, '_marketory_keywords', true);
    $faq_raw      = (string) get_post_meta($post_id, '_marketory_faq', true);

    $description = $summary_raw ?: (string) wp_trim_words(wp_strip_all_tags($post->post_content), 50);

    $article = [
        '@type'         => 'Article',
        '@id'           => $post_url . '#article',
        'headline'      => $title,
        'description'   => $description,
        'url'           => $post_url,
        'datePublished' => $pub_date,
        'dateModified'  => $mod_date,
        'author'        => ['@type' => 'Person', 'name' => $author],
        'publisher'     => ['@type' => 'Organization', 'name' => $site_name, 'url' => $site_url],
        'inLanguage'    => 'ko-KR',
        'isPartOf'      => ['@id' => $site_url . '#website'],
    ];

    if ($thumb_url) {
        $article['image'] = ['@type' => 'ImageObject', 'url' => $thumb_url];
    }
    if ($keywords_raw) {
        $article['keywords'] = array_map('trim', explode(',', $keywords_raw));
    }

    $categories = get_the_category($post_id);
    $bc_items   = [
        ['@type' => 'ListItem', 'position' => 1, 'name' => $site_name, 'item' => $site_url],
    ];
    $pos = 2;
    if (!empty($categories)) {
        $cat        = $categories[0];
        $bc_items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $cat->name, 'item' => get_category_link($cat->term_id)];
    }
    $bc_items[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => $title, 'item' => $post_url];

    $graph = [
        ['@type' => 'WebSite', '@id' => $site_url . '#website', 'url' => $site_url, 'name' => $site_name],
        $article,
        ['@type' => 'BreadcrumbList', '@id' => $post_url . '#breadcrumb', 'itemListElement' => $bc_items],
    ];

    if ($faq_raw) {
        $faq_data = json_decode($faq_raw, true);
        if (is_array($faq_data) && !empty($faq_data)) {
            $entities = array_filter(array_map(function ($item) {
                $q = sanitize_text_field($item['q'] ?? '');
                $a = sanitize_textarea_field($item['a'] ?? '');
                if (!$q || !$a) {
                    return null;
                }
                return ['@type' => 'Question', 'name' => $q, 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a]];
            }, $faq_data));
            if (!empty($entities)) {
                $graph[] = ['@type' => 'FAQPage', 'mainEntity' => array_values($entities)];
            }
        }
    }

    $schema = ['@context' => 'https://schema.org', '@graph' => $graph];
    echo '<script type="application/ld+json">'
        . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        . '</script>' . "\n";
}
