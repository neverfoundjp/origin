<?php get_header(); ?>

<div class="content-area">
  <main class="site-main" role="main">

<?php if (have_posts()) : ?>
    <div class="page-header">
      <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
    </div><!-- .page-header -->

  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/content'); ?>
  <?php endwhile; ?>
    <?php the_posts_navigation(); ?>
<?php else : ?>
    <?php get_template_part('template-parts/content', 'none'); ?>
<?php endif; ?>

  </main><!-- /.site-main -->
</div><!-- /.content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
