<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <div class="container">
    <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
    <nav class="site-nav" aria-label="<?php esc_attr_e('주요 메뉴', 'marketory'); ?>">
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'menu_class'     => 'nav-list',
          'container'      => false,
          'depth'          => 1,
          'fallback_cb'    => false,
      ]);
      ?>
    </nav>
  </div>
</header>
<div class="site-body">
