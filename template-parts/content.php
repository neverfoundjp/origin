<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <section class="entry-header">
    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
  </section><!-- .entry-header -->

<?php if (is_single()) : ?>
<?php
/**
* TinyMCEのスタイルと実際の画面表示を合わせたい場合は .wp-editor にスタイルを適用
* @link https://torounit.com/blog/2013/12/03/1668/
*/
?>
  <section class="entry-content wp-editor">
    <?php the_content(); ?>
  </section><!-- .entry-content -->

<?php else : ?>
  <section class="entry-content">
    <?php the_content(); ?>
  </section><!-- .entry-content -->

<?php endif; ?>
  <section class="entry-footer">
    <?php mysinglepages(wp_link_pages('before=""&after=""&echo=0')); ?>
  </section><!-- /.entry-footer -->
</article><!-- #post-## -->
