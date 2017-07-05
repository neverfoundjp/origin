<div class="breadcrumbs">
  <div class="container">
    <ol>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo esc_html(home_url('/')) ?>/">HOME</a>
      </li>
<?php if (is_page()) :  // 固定ページの場合 ?>
  <?php if($post -> post_parent != 0) : ?>
      <?php $ancestors = array_reverse(get_post_ancestors($post->ID)); ?>
    <?php foreach($ancestors as $ancestor) : ?>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo get_permalink($ancestor); ?>" itemprop="url"><span itemprop="title"><?php echo get_the_title($ancestor); ?></span></a>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <span itemprop="title"><?php echo get_the_title(); ?></span>
      </li>
<?php elseif (is_archive()) :  // アーカイブページの場合 ?>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <span itemprop="title"><?php echo esc_html(get_post_type_object(get_post_type())->label); ?></span>
      </li>
<?php elseif (is_single()) :  // 単独記事の場合 ?>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo esc_html(get_post_type_archive_link($post->post_type)); ?>" itemprop="url"><span itemprop="title"><?php echo esc_html(get_post_type_object(get_post_type())->label); ?></span></a>
      </li>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <span itemprop="title"><?php echo get_the_title(); ?></span>
      </li>
<?php endif; ?>
    </ol>
  </div>
</div>
