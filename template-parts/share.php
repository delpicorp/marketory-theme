<?php
declare(strict_types=1);

$share_url   = rawurlencode((string) get_permalink());
$share_title = rawurlencode((string) get_the_title());
?>
<div class="share-buttons">
  <p class="share-label"><?php esc_html_e('공유하기', 'marketory'); ?></p>

  <!-- Twitter / X -->
  <a class="share-btn share-twitter"
     href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title); ?>"
     rel="noopener" target="_blank"
     aria-label="<?php esc_attr_e('X(트위터) 공유', 'marketory'); ?>">
    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
      <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
    </svg>
    <span class="btn-label">X</span>
  </a>

  <!-- Facebook -->
  <a class="share-btn share-facebook"
     href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $share_url); ?>"
     rel="noopener" target="_blank"
     aria-label="<?php esc_attr_e('페이스북 공유', 'marketory'); ?>">
    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
      <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.313 0 2.686.235 2.686.235v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
    </svg>
    <span class="btn-label">Facebook</span>
  </a>

  <!-- Line -->
  <a class="share-btn share-line"
     href="<?php echo esc_url('https://social-plugins.line.me/lineit/share?url=' . $share_url); ?>"
     rel="noopener" target="_blank"
     aria-label="<?php esc_attr_e('라인 공유', 'marketory'); ?>">
    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
      <path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.627-.63h2.386c.349 0 .63.285.63.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.105.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.627-.63.349 0 .631.285.631.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.281.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/>
    </svg>
    <span class="btn-label">Line</span>
  </a>

  <!-- Copy URL -->
  <button class="share-btn share-copy"
          type="button"
          data-url="<?php echo esc_attr((string) get_permalink()); ?>"
          aria-label="<?php esc_attr_e('링크 복사', 'marketory'); ?>">
    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
      <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
    </svg>
    <span class="btn-label"><?php esc_html_e('링크 복사', 'marketory'); ?></span>
  </button>
</div>
