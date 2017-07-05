<?php
  /* カスタムタクソノミーを取得（不要なら削除） */
  $terms = get_the_terms($post->ID, 'news_cat');
  if ($terms) {
    foreach($terms as $term){
      $term_slug = $term -> slug;
      $term_name = $term -> name;
    }
  }
?>

<li id="news-item-<?php the_ID(); ?>" class="news-item">
  <span class="news-item-date"><?php the_time('Y年n月j日'); ?></span>
<?php if ($term) : ?>
  <span class="news-item-cat news-item-cat-<?php echo $term_slug; ?>"><span class="label label-news-cat-<?php echo $term_slug; ?>"><?php echo $term_name; ?></span></span>
<?php endif; ?>
  <span class="news-item-title">
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
<?php if (get_field('is_ended') == '1') : ?>
    <span class="label label-ended"></span>
<?php endif; ?>
  </span>
</li>
