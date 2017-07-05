<?php get_header(); ?>

<div class="content-area">
  <main class="site-main" role="main">
    <h1>home.php</h1>

    <div class="news-archive">
      <ul>
<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post();  /* pre_get_posts でクエリ変更済み */ ?>
        <?php get_template_part('template-parts/news_item'); ?>
  <?php endwhile; ?>
<?php endif; ?>
      </ul>
      <div class="news-archive-link"><a href="<?php echo esc_url(home_url('/news/')); ?>">ニュース一覧</a></div>
    </div>

  </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
