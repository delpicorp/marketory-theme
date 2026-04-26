<?php
declare(strict_types=1);

$post_id     = (int) get_the_ID();
$categories  = get_the_category($post_id);
$primary_cat = $categories[0] ?? null;
$reading_min = marketory_reading_time($post_id);
?>
<article class="post-card" id="card-<?php echo esc_attr((string) $post_id); ?>">
  <?php if (has_post_thumbnail()) : ?>
    <a class="card-thumb-link" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
      <figure class="card-thumb">
        <?php the_post_thumbnail('medium_large', ['loading' => 'lazy']); ?>
      </figure>
    </a>
  <?php endif; ?>
  <div class="card-body">
    <?php if ($primary_cat) : ?>
      <a class="card-category" href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>">
        <?php echo esc_html($primary_cat->name); ?>
      </a>
    <?php endif; ?>
    <h2 class="card-title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <p class="card-excerpt">
      <?php echo esc_html(wp_trim_words((string) get_the_excerpt(), 25)); ?>
    </p>
    <div class="card-meta">
      <time datetime="<?php echo esc_attr((string) get_the_date('c', $post_id)); ?>">
        <?php echo esc_html((string) get_the_date('Y.m.d', $post_id)); ?>
      </time>
      <span aria-hidden="true">·</span>
      <span><?php echo esc_html(sprintf(__('%d분', 'marketory'), $reading_min)); ?></span>
    </div>
  </div>
</article>
