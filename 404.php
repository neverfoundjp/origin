<?php get_header(); ?>

<div class="content-area">
  <main class="site-main" role="main">

    <section class="error-404 not-found">
      <div class="page-header">
        <h1 class="page-title">ページが見つかりませんでした。</h1>
      </div><!-- .page-header -->

      <div class="page-content">
        <p>お探しのページは移動、あるいは削除された可能性があります。</p>
        <?php get_search_form(); ?>
      </div><!-- .page-content -->
    </section><!-- .error-404 -->

  </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
