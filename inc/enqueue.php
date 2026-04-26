<?php
declare(strict_types=1);

add_action('wp_enqueue_scripts', function (): void {
    $css  = MARKETORY_DIR . '/assets/css/main.css';
    $cver = file_exists($css) ? (string) filemtime($css) : MARKETORY_VERSION;
    wp_enqueue_style('marketory-main', MARKETORY_URI . '/assets/css/main.css', [], $cver);

    $js   = MARKETORY_DIR . '/assets/js/theme.js';
    $jver = file_exists($js) ? (string) filemtime($js) : MARKETORY_VERSION;
    wp_enqueue_script('marketory-theme', MARKETORY_URI . '/assets/js/theme.js', [], $jver, true);
});

add_action('wp_head', function (): void {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap">' . "\n";
}, 2);
