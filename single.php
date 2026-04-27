<?php
declare(strict_types=1);

get_header();

if (!have_posts()) {
    get_footer();
    return;
}

the_post();
$post_id     = (int) get_the_ID();
$categories  = get_the_category($post_id);
$primary_cat = $categories[0] ?? null;
$reading_min = marketory_reading_time($post_id);
$summary     = (string) get_post_meta($post_id, '_marketory_summary', true);
$tags        = get_the_tags($post_id);
?>

<article class="post-single" id="post-<?php echo esc_attr((string) $post_id); ?>" <?php post_class(''); ?>>

  <!-- BREADCRUMB -->
  <nav class="breadcrumb container" aria-label="<?php esc_attr_e('경로 탐색', 'marketory'); ?>">
    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('홈', 'marketory'); ?></a>
    <?php if ($primary_cat) : ?>
      <span class="breadcrumb-sep" aria-hidden="true">›</span>
      <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>">
        <?php echo esc_html($primary_cat->name); ?>
      </a>
    <?php endif; ?>
  </nav>

  <!-- POST HEADER -->
  <header class="post-header container">
    <?php if ($primary_cat) : ?>
      <a class="post-category" href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>">
        <?php echo esc_html($primary_cat->name); ?>
      </a>
    <?php endif; ?>
    <h1 class="post-title"><?php the_title(); ?></h1>
    <div class="post-meta">
      <time datetime="<?php echo esc_attr((string) get_the_date('c', $post_id)); ?>">
        <?php echo esc_html((string) get_the_date('Y.m.d', $post_id)); ?>
      </time>
      <span class="meta-sep" aria-hidden="true">·</span>
      <span class="reading-time">
        <?php echo esc_html(sprintf(__('%d분 읽기', 'marketory'), $reading_min)); ?>
      </span>
    </div>
  </header>

  <!-- 3-COLUMN LAYOUT -->
  <div class="post-layout container">

    <!-- LEFT: TOC (auto-built by JS) -->
    <aside class="col-toc" aria-label="<?php esc_attr_e('목차', 'marketory'); ?>">
      <div class="toc-sticky">
        <p class="toc-heading"><?php esc_html_e('목차', 'marketory'); ?></p>
        <nav class="toc-nav" id="toc-nav" aria-label="<?php esc_attr_e('본문 목차', 'marketory'); ?>"></nav>
      </div>
    </aside>

    <!-- CENTER: MAIN CONTENT -->
    <div class="col-main">
      <?php if (has_post_thumbnail()) : ?>
        <figure class="post-thumbnail">
          <?php the_post_thumbnail('large', ['loading' => 'eager', 'fetchpriority' => 'high']); ?>
        </figure>
      <?php endif; ?>

      <?php if ($summary) : ?>
        <div class="summary-box" role="region" aria-label="<?php esc_attr_e('요약', 'marketory'); ?>">
          <p class="summary-label"><?php esc_html_e('이 글 요약', 'marketory'); ?></p>
          <p class="summary-text"><?php echo esc_html($summary); ?></p>
        </div>
      <?php endif; ?>

      <div class="post-content" id="post-content">
        <?php the_content(); ?>
      </div>

      <?php if ($tags) : ?>
        <div class="post-tags" aria-label="<?php esc_attr_e('태그', 'marketory'); ?>">
          <?php foreach ($tags as $tag) : ?>
            <a class="tag" href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
              #<?php echo esc_html($tag->name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php get_template_part('template-parts/author-box'); ?>
    </div>

    <!-- RIGHT: SIDEBAR (desktop only, hidden on mobile) -->
    <aside class="col-sidebar" aria-label="<?php esc_attr_e('공유 및 추천', 'marketory'); ?>">
      <div class="sidebar-sticky">
        <?php get_template_part('template-parts/share'); ?>
        <div class="sidebar-cta">
          <p class="cta-text"><?php esc_html_e('매일 유용한 정보를 받아보세요', 'marketory'); ?></p>
          <a class="cta-btn" href="#subscribe"><?php esc_html_e('구독하기', 'marketory'); ?></a>
        </div>
      </div>
    </aside>

  </div><!-- .post-layout -->

  <!-- SHARE (mobile only, outside grid so it follows col-main then col-toc) -->
  <div class="share-mobile container">
    <?php get_template_part('template-parts/share'); ?>
  </div>

  <!-- RELATED POSTS -->
  <?php if ($primary_cat) :
      $related = new WP_Query([
          'cat'            => $primary_cat->term_id,
          'posts_per_page' => 3,
          'post__not_in'   => [$post_id],
          'orderby'        => 'date',
          'order'          => 'DESC',
          'no_found_rows'  => true,
      ]);
      if ($related->have_posts()) :
  ?>
  <section class="posts-grid container" aria-labelledby="related-heading">
    <h2 class="section-heading" id="related-heading"><?php esc_html_e('관련 콘텐츠', 'marketory'); ?></h2>
    <div class="card-grid">
      <?php while ($related->have_posts()) : $related->the_post(); ?>
        <?php get_template_part('template-parts/content-card'); ?>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>
  <?php endif; endif; ?>

  <!-- POPULAR POSTS -->
  <?php
  $popular = new WP_Query([
      'posts_per_page' => 3,
      'post__not_in'   => [$post_id],
      'meta_key'       => '_post_views',
      'orderby'        => 'meta_value_num',
      'order'          => 'DESC',
      'no_found_rows'  => true,
  ]);
  if ($popular->have_posts()) :
  ?>
  <section class="posts-grid container" aria-labelledby="popular-heading">
    <h2 class="section-heading" id="popular-heading"><?php esc_html_e('인기 콘텐츠', 'marketory'); ?></h2>
    <div class="card-grid">
      <?php while ($popular->have_posts()) : $popular->the_post(); ?>
        <?php get_template_part('template-parts/content-card'); ?>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- PREV / NEXT NAV -->
  <nav class="post-nav container" aria-label="<?php esc_attr_e('이전/다음 글', 'marketory'); ?>">
    <div class="post-nav-prev">
      <?php $prev = get_previous_post(); if ($prev) : ?>
        <span class="nav-label"><?php esc_html_e('이전 글', 'marketory'); ?></span>
        <a href="<?php echo esc_url((string) get_permalink($prev->ID)); ?>">
          <?php echo esc_html((string) get_the_title($prev->ID)); ?>
        </a>
      <?php endif; ?>
    </div>
    <div class="post-nav-next">
      <?php $next = get_next_post(); if ($next) : ?>
        <span class="nav-label"><?php esc_html_e('다음 글', 'marketory'); ?></span>
        <a href="<?php echo esc_url((string) get_permalink($next->ID)); ?>">
          <?php echo esc_html((string) get_the_title($next->ID)); ?>
        </a>
      <?php endif; ?>
    </div>
  </nav>

</article>

<?php get_footer(); ?>
