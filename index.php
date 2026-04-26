<?php
declare(strict_types=1);

get_header();
?>
<main class="site-main container" id="main">
  <?php if (have_posts()) : ?>
    <div class="card-grid">
      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content-card'); ?>
      <?php endwhile; ?>
    </div>
    <nav class="pagination" aria-label="<?php esc_attr_e('페이지 탐색', 'marketory'); ?>">
      <?php
      the_posts_pagination([
          'mid_size'  => 2,
          'prev_text' => '&lsaquo;',
          'next_text' => '&rsaquo;',
      ]);
      ?>
    </nav>
  <?php else : ?>
    <p><?php esc_html_e('게시글이 없습니다.', 'marketory'); ?></p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
