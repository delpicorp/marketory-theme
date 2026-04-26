<?php
declare(strict_types=1);

$share_url = rawurlencode((string) get_permalink());
$post_url  = (string) get_permalink();
?>
<div class="share-buttons">
  <p class="share-label"><?php esc_html_e('공유하기', 'marketory'); ?></p>

  <!-- 1. 링크 복사 -->
  <button class="share-btn share-copy"
          type="button"
          data-url="<?php echo esc_attr($post_url); ?>"
          aria-label="<?php esc_attr_e('링크 복사', 'marketory'); ?>">
    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
      <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
    </svg>
    <span class="btn-label"><?php esc_html_e('링크 복사', 'marketory'); ?></span>
  </button>

  <!-- 2. Facebook -->
  <a class="share-btn share-facebook"
     href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $share_url); ?>"
     rel="noopener" target="_blank"
     aria-label="<?php esc_attr_e('페이스북 공유', 'marketory'); ?>">
    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
      <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.313 0 2.686.235 2.686.235v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
    </svg>
    <span class="btn-label">Facebook</span>
  </a>
</div>
