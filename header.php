<!DOCTYPE html>
<html lang="ja-JP">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <?php get_template_part('template-parts/tracking_code'); ?>
</head>

<body <?php body_class(); ?>>
<div class="wrapper">

  <header class="site-header">
    <div class="container">
      <div class="site-branding">
        <?php if (is_home()) : ?>
          <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
        <?php else : ?>
          <div class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></div>
        <?php endif; ?>
      </div><!-- .site-branding -->

      <nav class="site-navigation" role="navigation">
        <button id="js-menu-toggle" class="menu-toggle"><i class="fa fa-bars"></i></button>
        <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id' => 'primary-menu'
          ));
        ?>
      </nav><!-- .site-navigation -->
    </div><!-- .container -->
  </header><!-- .site-header -->

<?php if (!is_home()) : ?>
  <?php // get_template_part('template-parts/content_header'); ?>
  <?php get_template_part('template-parts/breadcrumbs'); ?>
<?php endif; ?>

  <div class="site-content">
    <div class="container">
