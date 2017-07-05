<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <section class="entry-header">
    <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
  </section><!-- .entry-header -->

  <section class="entry-excerpt">
    <?php the_excerpt(); ?>
  </section><!-- .entry-excerpt -->
</article><!-- #post-## -->
