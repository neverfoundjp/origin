<div class="content-header">
  <div class="container">
<?php if (is_post_type_archive('news')) : ?>
  <h1 class="content-header-title"><?php echo esc_html('ニュース'); ?></h1>

<?php elseif (is_singular('news')) : ?>
  <div class="content-header-title"><?php echo esc_html('ニュース'); ?></div>

<?php elseif (is_page('product') || get_ancestor_slug() == 'product') : ?>
  <h1 class="content-header-title"><?php echo esc_html('製品紹介'); ?></h1>

<?php elseif (get_ancestor_slug() == 'product') : ?>
  <div class="content-header-title"><?php echo esc_html('製品紹介'); ?></div>

<?php elseif (is_search()) : ?>
  <h1 class="content-header-title"><?php echo esc_html('サイト内検索'); ?></h1>

<?php elseif (is_page('contact') || get_ancestor_slug() == 'contact') : ?>
  <h1 class="content-header-title"><?php echo esc_html('お問い合わせ'); ?></h1>

<?php elseif (is_page()) : ?>
  <?php global $post; ?>
  <h1 class="content-header-title"><?php the_title(); ?></h1>

<?php elseif (is_404()) : ?>
  <h1 class="content-header-title"><?php echo esc_html('お探しのページが見つかりませんでした'); ?></h1>

<?php else : ?>
  <div class="content-header-title">&nbsp;</div>

<?php endif; ?>
  </div>
</div>