<?php
declare(strict_types=1);

$author_id = (int) get_the_author_meta('ID');
if (!$author_id) {
    return;
}

$name   = (string) get_the_author_meta('display_name', $author_id);
$bio    = (string) get_the_author_meta('description', $author_id);
$url    = (string) get_the_author_meta('url', $author_id);
$avatar = (string) get_avatar_url($author_id, ['size' => 80]);
?>
<div class="author-box">
  <?php if ($avatar) : ?>
    <img class="author-avatar"
         src="<?php echo esc_url($avatar); ?>"
         alt="<?php echo esc_attr($name); ?>"
         width="80" height="80" loading="lazy">
  <?php endif; ?>
  <div class="author-info">
    <p class="author-name">
      <?php if ($url) : ?>
        <a href="<?php echo esc_url($url); ?>" rel="author noopener" target="_blank">
          <?php echo esc_html($name); ?>
        </a>
      <?php else : ?>
        <?php echo esc_html($name); ?>
      <?php endif; ?>
    </p>
    <?php if ($bio) : ?>
      <p class="author-bio"><?php echo esc_html($bio); ?></p>
    <?php endif; ?>
  </div>
</div>
