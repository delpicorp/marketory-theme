<?php
declare(strict_types=1);

add_action('init', function (): void {
    $fields = [
        '_marketory_keywords'   => ['type' => 'string', 'desc' => 'Focus keywords, comma-separated',           'san' => 'sanitize_text_field'],
        '_marketory_summary'    => ['type' => 'string', 'desc' => 'Article summary for schema and summary box', 'san' => 'sanitize_textarea_field'],
        '_marketory_source_url' => ['type' => 'string', 'desc' => 'Original source URL for autoblog',          'san' => 'esc_url_raw'],
        '_marketory_faq'        => ['type' => 'string', 'desc' => 'FAQ JSON: [{"q":"...","a":"..."}]',          'san' => 'sanitize_textarea_field'],
    ];

    foreach ($fields as $key => $f) {
        register_post_meta('post', $key, [
            'show_in_rest'      => true,
            'single'            => true,
            'type'              => $f['type'],
            'description'       => $f['desc'],
            'sanitize_callback' => $f['san'],
            'auth_callback'     => fn() => current_user_can('edit_posts'),
        ]);
    }
});
