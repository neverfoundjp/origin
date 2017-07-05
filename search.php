<?php get_header(); ?>

<div class="content-area">
  <main class="site-main" role="main">
<?php if (have_posts()) : ?>
    <div class="page-header">
      <h1 class="page-title"><?php echo esc_html('「'. get_search_query(). '」の検索結果'); ?></h1>
    </div><!-- .page-header -->

  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/content', 'search'); ?>
  <?php endwhile; ?>

    <?php the_posts_navigation(); ?>

<?php else : ?>
    <?php get_template_part('template-parts/content', 'none'); ?>

<?php endif; ?>
  </main><!-- /.site-main -->
</div><!-- /.content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
