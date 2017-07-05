<?php get_header(); ?>

<div class="content-area">
  <main class="site-main" role="main">
<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/content'); ?>
<?php endwhile; ?>
  </main><!-- /.site-main -->
</div><!-- /.content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
