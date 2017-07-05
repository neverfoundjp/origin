<?php get_header(); ?>

<div class="content-area">
  <main class="site-main" role="main">
    <div class="page-header">
      <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
    </div><!-- .page-header -->

<?php if (have_posts()) : ?>
    <div class="news-archive">
      <ul>
  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/news_item'); ?>
  <?php endwhile; ?>
      </ul>
    </div>
  <?php echo origin_paginate_links(); ?>

<?php endif; ?>

  </main><!-- /.site-main -->
</div><!-- /.content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

