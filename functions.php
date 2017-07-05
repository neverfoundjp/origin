<?php
/**
* 初期設定
*/

function origin_setup() {
  add_theme_support('automatic-feed-links');
  add_theme_support('title-tag');

  // アイキャッチ画像を使用する場合は下記を有効にする（ニュースにのみ適用）
  /* add_theme_support('post-thumbnails', array('news')); */

  register_nav_menus(array(
    'primary' => esc_html('Primary'),
  ));

  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ));
}
add_action('after_setup_theme', 'origin_setup');


/**
* 画像挿入時の最大幅を指定
* @link https://spuit.tech/wordpress/directory-theme-content-width/
*/

function origin_content_width() {
  $GLOBALS['content_width'] = apply_filters('origin_content_width', 1000);
}
add_action('after_setup_theme', 'origin_content_width', 0);


/**
* スタイルシートとスクリプトを読み込む
*/
function origin_scripts() {
  wp_enqueue_style('origin-normalize', get_template_directory_uri(). '/libs/css/normalize.min.css');
  wp_enqueue_style('origin-responsive-gs-12col', get_template_directory_uri(). '/libs/css/responsive.gs.12col.custom.css');
  wp_enqueue_style('origin-fontawesome', get_template_directory_uri(). '/libs/font-awesome/css/font-awesome.min.css');
  wp_enqueue_style('origin-animate', get_template_directory_uri(). '/libs/css/animate.min.css');
  wp_enqueue_style('origin-slick-style', get_template_directory_uri(). '/libs/slick/slick.css');
  wp_enqueue_style('origin-slick-theme', get_template_directory_uri(). '/libs/slick/slick-theme.css');
  wp_enqueue_style('origin-common', get_template_directory_uri(). '/libs/css/common.css');
  wp_enqueue_style('origin-style', get_stylesheet_uri());

  wp_deregister_script('jquery'); // WordPress同梱のjQueryは読み込まない
  wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array(), '20160913', true);
  wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/libs/js/jquery.easing.1.3.js', array(), '20160913', true);
  wp_enqueue_script('origin-jquery-heightLine', get_template_directory_uri() . '/libs/js/jquery.heightLine.js', array(), '20160913', true);
  wp_enqueue_script('origin-slick', get_template_directory_uri() . '/libs/slick/slick.min.js', array(), '20160913', true);
  wp_enqueue_script('origin-ajaxzip3', '//ajaxzip3.github.io/ajaxzip3.js', array(), '20160913', true);
  wp_enqueue_script('origin-my-script', get_template_directory_uri() . '/libs/js/my-script.js', array(), '20160913', true);
}
add_action('wp_enqueue_scripts', 'origin_scripts');


/**
* ビジュアルエディタ用のCSSを読み込む
*/
add_editor_style('editor-style.css');


/**
* カスタム投稿タイプを追加
*/

function register_my_cpts() {
  $labels = array(
    "name" => 'ニュース',
    "singular_name" => 'ニュース',
    "all_items" => 'ニュース一覧',
    "add_new" => 'ニュースを追加',
    "edit_item" => 'ニュースを編集',
    "not_found" => 'ニュースが見つかりませんでした',
    "not_found_in_trash" => 'ゴミ箱内にニュースが見つかりませんでした',
  );

  $args = array(
    "label" => 'ニュース',
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => true,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array("slug" => "news", "with_front" => true),
    "query_var" => true,
    "menu_icon" => "dashicons-welcome-write-blog",
    "supports" => array("title", "editor", "thumbnail", "revisions"),
  );

  register_post_type("news", $args);
}
add_action('init', 'register_my_cpts');


/**
* カスタムタクソノミーを追加
*/

function register_my_taxes() {
  $labels = array(
    "name" => 'ニュース区分',
    "singular_name" => 'ニュース区分',
    "all_items" => 'ニュース区分一覧',
    "add_new" => 'ニュース区分を追加',
    "edit_item" => 'ニュース区分を編集',
  );

  $args = array(
    "label" => 'ニュース区分',
    "labels" => $labels,
    "public" => true,
    "hierarchical" => true,
    "label" => "ニュース区分",
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "query_var" => true,
    "rewrite" => array('slug' => 'news_cat', 'with_front' => true),
    "show_admin_column" => false,
    "show_in_rest" => false,
    "rest_base" => "",
    "show_in_quick_edit" => false,
  );
  register_taxonomy("news_cat", array("news"), $args);
}
add_action('init', 'register_my_taxes');


/**
* pre_get_posts でメインクエリを制御する
* @link http://www.tam-tam.co.jp/tipsnote/cms/post9420.html
*/

function origin_pre_get_posts( $query ) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  // ホーム画面にはニュース投稿を表示
  if ( $query->is_home() ) {
    $query->set('post_type', array('news'));
    $query->set('posts_per_page', 5);
  }
}
add_action('pre_get_posts','origin_pre_get_posts');


/**
* title-tag で出力される <title>タグをカスタマイズ
* @link http://ku41i.hateblo.jp/entry/2015/11/03/182242
*/

function origin_document_title($title) {
  // トップページはサイト名のみ
  if (is_front_page() && is_home()) {
    $title = get_bloginfo('name', 'display');
  }

  return $title;
}
add_filter('pre_get_document_title', 'origin_document_title');


/**
* body_class() で出力されるクラス名にページスラッグを追加する
* @link http://terabenote.net/archives/2079/
*/

function origin_pagename_class($classes = '') {
    if (is_page()) {
        $page = get_post(get_the_ID());
        $classes[] = 'page-' . $page->post_name;
        if ($page->post_parent) {
            $classes[] = 'parent-page-' . get_page_uri($page->post_parent);
       }
  }
  return $classes;
}
add_filter('body_class', 'origin_pagename_class');


/**
* メニューで出力されるHTMLを編集
* @link https://github.com/marioloncarek/megamenu-js
* @link http://10251.net/wordpress-remove-menu-class
*/

// メニューの<ul>要素を囲む<div>要素を削除
function origin_wp_nav_menu_args($args = '') {
  $args['container'] = false;
  return $args;
}
add_filter('wp_nav_menu_args', 'origin_wp_nav_menu_args');

// 余分なIDやclassを除去
function origin_css_attributes_filter($var) {
  // 除去したくない属性値を指定
  return is_array($var) ? array_intersect($var, array('current-menu-item','menu-item-home')) : '';
}
add_filter('nav_menu_item_id', 'origin_css_attributes_filter', 100, 1);
// add_filter('nav_menu_css_class', 'origin_css_attributes_filter', 100, 1);  // ここを有効にすると、メニューにオプションで与えたCSSクラスも除去されるので注意
add_filter('page_css_class', 'origin_css_attributes_filter', 100, 1);


/**
* ウィジェットエリアを追加
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*/

// function origin_widgets_init() {
//   register_sidebar( array(
//     'name'          => esc_html('Sidebar'),
//     'id'            => 'sidebar-1',
//     'before_widget' => '<section id="%1$s" class="widget %2$s">',
//     'after_widget'  => '</section>',
//     'before_title'  => '<h2 class="widget-title">',
//     'after_title'   => '</h2>',
//   ) );
// }
// add_action('widgets_init', 'origin_widgets_init');


/**
* 自動整形を無効にする
*
* ※一部の投稿タイプのみ自動整形を無効にしたい場合は後半のコードを使用
* @link http://buburinweb.wp.xdomain.jp/wordpress-automatic-forming-plugin
*/

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
remove_filter('the_excerpt', 'wpautop');
remove_filter('the_excerpt', 'wptexturize');

// function wpautop_filter($content) {
//   global $post;
//   $remove_filter = false;

//   $arr_types = array('page'); //自動整形を解除・無効にする投稿タイプを記述
//   $post_type = get_post_type( $post->ID );
//   if (in_array($post_type, $arr_types)) $remove_filter = true;

//   if ( $remove_filter ) {
//     remove_filter('the_content', 'wpautop');
//     remove_filter('the_excerpt', 'wpautop');
//   }
//   return $content;
// }
// add_filter('the_content', 'wpautop_filter', 9);


/**
* 「続きを読む」のカスタマイズ
* @link https://goo.gl/YMDzmW
*/

function origin_excerpt_more($more) {
  return '...';
}
add_filter('excerpt_more', 'origin_excerpt_more');


/**
* アーカイブタイトルの前に付く「アーカイブ：」「カテゴリー：」「タグ：」を除去
* @link http://cms-skill.com/tech/wordpress/entry-347.html
*/

function origin_the_archive_title($title) {
  if (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
  } elseif (is_category()) {
    $title = single_cat_title('', false);
  } elseif (is_tag()) {
    $title = single_tag_title('', false);
  }
  return $title;
}
add_filter('get_the_archive_title', origin_the_archive_title);


/**
* iframeに wrapperを追加
* @link http://nelog.jp/wordpress-iframe-responsiv
*/

function origin_wrap_iframe_in_div($the_content) {
  if (is_singular()) {
    $the_content = preg_replace('/<iframe/i', '<div class="iframe-wrapper"><iframe', $the_content);
    $the_content = preg_replace('/<\/iframe>/i', '</iframe></div>', $the_content);
  }
  return $the_content;
}
add_filter('the_content','origin_wrap_iframe_in_div');


/**
* サイト内検索実行時、ユーザーが検索したキーワードをハイライトして表示させる。
* @link http://on-ze.com/archives/1786
*/

function origin_highlight_results($text) {
  if(is_search()){
    $sr = get_query_var('s');
    $keys = explode(" ",$sr);
    $text = preg_replace('/('.implode('|', $keys) .')/iu', '<span class="search-highlight">'.$sr.'</span>', $text);
  }
  return $text;
}
add_filter('the_title', 'origin_highlight_results');
add_filter('the_content', 'origin_highlight_results');
add_filter('the_excerpt', 'origin_highlight_results');


/**
* サイト内検索実行時、入力されたテキストが空白の時はHOMEへ
* @link https://goo.gl/RXFBXe
*/

function origin_empty_search_redirect( $wp_query ) {
  if ($wp_query->is_main_query() && $wp_query->is_search && !$wp_query->is_admin) {
    $s = $wp_query->get('s');
    $s = trim($s);
    if (empty($s)) {
      wp_safe_redirect(home_url('/'));
      exit;
    }
  }
}
add_action('parse_query', 'origin_empty_search_redirect');


/**
* 投稿者アーカイブを無効化してWordPressのユーザ名を隠す
* @link http://blog.webcontent.jp/entry/no-author-archive
*/

add_filter('author_rewrite_rules', '__return_empty_array');
function origin_disable_author_archive() {
  if ($_GET['author'] || preg_match('#/author/.+#', $_SERVER['REQUEST_URI'])) {
    wp_redirect(home_url('/404.php'));
    exit;
  }
}
add_action('init', 'origin_disable_author_archive');


/**
* WordPress標準のブログカードを無効化する
* @link https://technote.space/blog/archives/782
*/

remove_filter('pre_oembed_result',  'wp_filter_pre_oembed_result');


/* 管理者メニュー */

/**
* バージョンアップ通知を管理者のみに表示。
* @link http://wpcj.net/108
*/
function origin_update_nag_admin_only() {
  if (!current_user_can('administrator')) {
    remove_action('admin_notices', 'update_nag', 3);
  }
}
add_action('admin_init', 'origin_update_nag_admin_only');


/**
* ログイン後にダッシュボードには移動せずに、他ページヘリダイレクトさせる
* @link http://www.nxworld.net/wordpress/wp-redirect-dashiboard.html
*/

function origin_redirect_dashboard() {
  if ('/wp/wp-admin/index.php' == $_SERVER['SCRIPT_NAME']) {
    wp_redirect(admin_url('edit.php?post_type=news'));
  }
}

function origin_remove_dashboard_menu() {
  remove_menu_page('index.php');
}

if (!is_super_admin()) {  // 管理者以外に適用
  add_action('admin_init', 'origin_redirect_dashboard');
  add_action('admin_menu', 'origin_remove_dashboard_menu');
}


/**
* 管理者以外がログインした際の管理画面メニューを制御する
* @link http://www.dataplan.jp/blog/wordpress/2754
*/

function origin_remove_menus() {
  remove_menu_page('upload.php');         // メディア
  remove_menu_page('edit.php?post_type=page');  // 固定ページ
  remove_menu_page('edit.php?post_type=mw-wp-form');  // MW WP Form（Menu Editorで「お問い合わせデータ」を最上位に）
  remove_menu_page('themes.php');  // 外観
  remove_menu_page('tools.php');  // ツール
  remove_submenu_page('edit.php?post_type=news', 'edit-tags.php?taxonomy=news_cat&amp;post_type=news');  // お知らせ区分
}

if (!is_super_admin()) {  // 管理者以外に適用
  add_action('admin_menu', 'origin_remove_menus');
}


/**
* 「WordPressのご利用ありがとうございます」を非表示に
* @link http://on-ze.com/archives/2422
*/

function origin_admin_footer() {
  // echo '';  // 何か表示させたい時はここに記述
}
add_filter('admin_footer_text', 'origin_admin_footer');


/**
* 投稿や固定ページの表示件数を増やす
* @link http://on-ze.com/archives/3484
*/

function origin_edit_posts_per_page ($posts_per_page) {
  return 100;
}
add_filter('edit_posts_per_page', 'origin_edit_posts_per_page');


/**
* フロントエンドでの管理バー非表示
*/

add_filter('show_admin_bar', '__return_false');


/**
* 管理バーの不要な項目を非表示に
* @link http://wpcj.net/260
*/

function origin_remove_bar_menus($wp_admin_bar) {
  $wp_admin_bar->remove_menu('view-site');    // サイト名 -> サイトを表示
  $wp_admin_bar->remove_menu('comments');     // コメント
  $wp_admin_bar->remove_menu('view');         // 投稿を表示
  $wp_admin_bar->remove_menu('archive');      // 投稿の表示（アーカイブ）
  $wp_admin_bar->remove_menu('new-content');  // 新規
  $wp_admin_bar->remove_menu('edit-profile'); // マイアカウント -> プロフィール編集
}
add_action('admin_bar_menu', 'origin_remove_bar_menus', 201);


/**
* 管理画面にスタイルシートを適用
* @link https://spuit.tech/wordpress/dashboard-font/
*/

function origin_admin_styles_load() {
  wp_enqueue_style('origin-admin-style', get_stylesheet_directory_uri() . '/admin-style.css', array(), null, 'all');
}
add_action('admin_enqueue_scripts', 'origin_admin_styles_load');


/**
* 予約投稿機能を無効に
* @link http://www.tam-tam.co.jp/tipsnote/cms/post3002.html
*/

// function origin_stop_post_status_future_func( $data, $postarr ) {
//   if ($data['post_status'] == 'future' && $postarr['post_status'] == 'publish') {
//     $data['post_status'] = 'publish';
//   }
//   return $data;
// };
// add_filter('wp_insert_post_data', 'origin_stop_post_status_future_func', 10, 2);


/**
* 固定ページの編集時にだけビジュアルエディターを使用不可能にする
* @link http://on-ze.com/archives/3102
*
* ($typenow == 'page') の箇所で他の投稿タイプにも適用可能
*/

function origin_disable_visual_editor_in_page() {
  global $typenow;
  if ($typenow == 'page' || $typenow == 'mw-wp-form') {
    // add_filter('user_can_richedit', 'origin_disable_visual_editor_filter');
    add_filter('user_can_richedit', '__return_false');
  }
}

// function origin_disable_visual_editor_filter() {
//   return false;
// }

add_action('load-post.php', 'origin_disable_visual_editor_in_page');
add_action('load-post-new.php', 'origin_disable_visual_editor_in_page');


/**
* ビジュアルエディタに備わっている余計なフィルターを無効化する
* @link http://qiita.com/jyokyoku/items/c560b0d1eacc1df61620
*/

function origin_override_mce_options($init_array) {
  global $allowedposttags;

  $init_array['valid_elements'] = '*[*]';
  $init_array['extended_valid_elements'] = '*[*]';
  $init_array['valid_children'] = '+a['. implode('|', array_keys($allowedposttags)). ']';
  $init_array['indent'] = true;
  $init_array['wpautop'] = false;
  $init_array['force_p_newlines'] = false;

  return $init_array;
}

add_filter('tiny_mce_before_init', 'origin_override_mce_options');


/**
* メディアの自動生成をやめる
* @link http://www.nxworld.net/wordpress/wp-remove-image-sizes.html
*/

function origin_remove_image_sizes($sizes) {
  unset( $sizes['thumbnail'] );
  unset( $sizes['medium'] );
  unset( $sizes['large'] );
  return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'origin_remove_image_sizes');


/**
* レスポンシブイメージ機能を停止
* @link http://strix.main.jp/?diys=disable-thumbnail
* @link http://www.nxworld.net/wordpress/wp-disable-responsive-images.html
*/

update_option('medium_large_size_w', 0);
add_filter('wp_calculate_image_srcset', '__return_false');
add_filter('wp_calculate_image_sizes', '__return_false');


/**
* メディア挿入時の不要な属性を削除して、管理画面の「添付ファイルの表示設定」も目隠しする
* @link http://www.nxworld.net/wordpress/wp-remove-image-attribute.html
*/

function origin_remove_image_attribute($html){
  // ※WordPressのレスポンシブイメージ機能を使う場合は .wp-image-xxx が必要なので、不要なclassだけ削除する
  $html = preg_replace('/(width|height)="\d*"\s/', '', $html);
  $html = preg_replace('/class=[\'"]([^\'"]+)[\'"]\s/i', '', $html);
  // $html = preg_replace('/alignnone size-full /i', '', $html);  // 不要なclassだけ削除
  $html = preg_replace('/title=[\'"]([^\'"]+)[\'"]\s/i', '', $html);
  $html = preg_replace('/<a href=".+">/', '', $html);
  $html = preg_replace('/<\/a>/', '', $html);
  $html = preg_replace('/ +\/>/', '>', $html);
  return $html;
}
add_filter('image_send_to_editor', 'origin_remove_image_attribute', 10);
add_filter('post_thumbnail_html', 'origin_remove_image_attribute', 10);

function origin_admin_css_img_custom() {
  echo '<style>.attachment-details label[data-setting="caption"], .attachment-details label[data-setting="description"], .attachment-display-settings { display: none; }</style>';
}
add_action('admin_print_styles', 'origin_admin_css_img_custom');


/**
* TinyMCEをカスタマイズ
* @link http://www.webopixel.net/wordpress/211.html
* @link http://memocarilog.info/wordpress/6374
*/

// ブロック書式
function origin_tinymce($initArray) {
  $initArray['block_formats'] = "標準=p;見出し2=h2;見出し3=h3;";
  return $initArray;
}
add_filter('tiny_mce_before_init', 'origin_tinymce');

// ボタン群1列目
function origin_tinymce_buttons($buttons){
  unset($buttons);
  $buttons = array(
    'undo',
    'redo',
    'formatselect',
    'bold',
    'bullist',
    'numlist',
    'alignleft',
    'aligncenter',
    'alignright',
    'link',
    'unlink',
    'hr',
    // 'wp_page',  // 改ページ
    // 'removeformat',
    // 'wp_adv',  // ツールバー切り替え
  );
  return $buttons;
}
add_filter('mce_buttons','origin_tinymce_buttons');

// ボタン群2列目…非表示
function origin_tinymce_buttons_2($buttons){
  unset($buttons);
  $buttons = array(
    // 'forecolor',  // テキスト色
    // 'pastetext',  // テキストとしてペースト
  );
  return $buttons;
}
add_filter('mce_buttons_2','origin_tinymce_buttons_2');


/**
* 投稿画面のカテゴリー選択部分で「新規カテゴリーを追加」と「よく使うもの」を非表示にする
* @link http://www.nxworld.net/wordpress/wp-hide-category-tabs-and-adder.html
*
* カスタムタクソノミーに対しては #xxx-tabs, #xxx-adder で非表示化
* カテゴリーのラジオボタン化などは、プラグイン「Adjust Admin Categories」で対応
*/

function hide_category_tabs_adder() {
  global $pagenow;
  global $post_type;
  if (is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php')){
    echo '<style type="text/css">
    #category-tabs, #category-adder {display:none;}
    #news_cat-tabs, #news_cat-adder {display:none;}

    .categorydiv .tabs-panel {padding: 0 !important; background: none; border: none !important;}
    </style>';
  }
}
add_action('admin_head', 'hide_category_tabs_adder');


/**
* ログイン画面の画像を変更する
*/

// function custom_login_logo() {
//   echo '<style type="text/css">h1 a { background: url('. get_template_directory_uri(). '/images/login-logo.png) 50% 50% no-repeat !important; }</style>';
// }
// add_action('login_head', 'custom_login_logo');


/**
* 投稿内でテーマフォルダの画像やPDFを呼び出すときの画像パスを短くする
* "./images/" や "./pdf/" に続けてパスを記述すると、テンプレートディレクトリ内の「images」「pdf」ディレクトリを参照する
*   - 投稿内の記述  ： <img src="./images/lorem.png" alt="">
*   - 出力されるHTML： <img src="http://example.com/wp-content/themes/theme-name/images/lorem.png" alt="">
* @link http://takayakondo.com/images-pass-theme-directory/
*/

function origin_replace_image_path($arg) {
  $content = $arg;
  $content = str_replace('"./images/', '"'. get_template_directory_uri(). '/images/', $content);
  $content = str_replace('"./pdf/', '"'. get_template_directory_uri(). '/pdf/', $content);
  return $content;
}
add_action('the_content', 'origin_replace_image_path');


/**
 * XMLサイトマップを自動生成する
 * @link https://www.surf-life.blue/532 ← タグが非表示になっているので注意！
 */

function origin_sitemap_xml() {
date_default_timezone_set('Asia/Tokyo');
$sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$sitemap .= '<url><loc>' .esc_url(home_url('/')). '</loc><lastmod>'.mysql2date("Y-m-d", get_lastpostmodified(), false).'</lastmod><changefreq>daily</changefreq><priority>1.0</priority></url>';

$args = array(
  'posts_per_page' => -1,
  'orderby' => 'modified',
  'order' => 'DESC',
  'post_type' => array('post'),
  'post_status' => 'publish'
);
$the_query = new WP_Query( $args );
while ( $the_query->have_posts() ) : $the_query->the_post();
  $sitemap .= '<url><loc>' . get_permalink( $post->ID ) . '</loc><lastmod>' .get_the_modified_date("Y-m-d"). '</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
endwhile;wp_reset_postdata();

// $cat_data = get_categories();foreach($cat_data as $value){
//   $sitemap .= '<url><loc>' . get_category_link($value) . '</loc><lastmod>' .mysql2date("Y-m-d", get_lastpostmodified(), false). '</lastmod><changefreq>weekly</changefreq><priority>0.5</priority></url>';
// }

// $tag_data = get_tags();foreach($tag_data as $value){
//   $sitemap .= '<url><loc>' . get_tag_link($value->term_id) . '</loc><lastmod>' .mysql2date("Y-m-d", get_lastpostmodified(), false). '</lastmod><changefreq>weekly</changefreq><priority>0.5</priority></url>';
// }

$sitemap .= '</urlset>' . "\n";

$fp = fopen( ABSPATH. "sitemap.xml", 'w' );
if ($fp) {
  fwrite($fp, $sitemap);
  fclose($fp);
}}

add_action( "publish_post", "origin_sitemap_xml" );
add_action( "publish_page", "origin_sitemap_xml" );


/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
/* ==================
  独自関数
================== */

/**
* 親ページのスラッグを取得
* @link http://highfivecreate.com/blog/course/tips/1890.html
*/
function get_parent_slug() {
  global $post;
  if (isset($post)) {
    if ($post->post_parent) {
      $post_data = get_post($post->post_parent);
      return $post_data->post_name;
    }
  }
}


/**
* 先祖ページ（最上の親）のスラッグを取得
* @link http://elegumi.com/benno9/get-page-parent-child-parents-children
*/
function get_ancestor_slug() {
  if (is_page()) {
    global $post;

    $count = count($post->ancestors);

    if (is_page() && isset($post) && ($count > 0)) {
      $post_ancestors = get_post_ancestors($post->ID);
      $anchestor_id = $post_ancestors[$count - 1];

      if ($anchestor_id) {
        $post_data = get_post($anchestor_id);
        return $post_data->post_name;
      }
    }
  }
}


/**
 * ページ区切りナビゲーションをBootstrap形式のタグで出力
 * @param array $args the_posts_paginationと同じ設定が使用できます。ただしtypeは'list'に固定されます。
 * @link http://wpcj.net/806
 * @link http://appakumaturi.hatenablog.com/entry/20110528/1306585716
 */

function origin_paginate_links($args = array()) {
  // 現在地を取得
  $current_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

  $navigation = '';
  // 1ページのみの場合は出力しません。
  if ($GLOBALS['wp_query']->max_num_pages > 1) {
    $args = wp_parse_args( $args, array(
      'show_all'  => true,
      /* 'mid_size'  => 1, */
      'prev_text' => esc_html('前へ'),
      'next_text' => esc_html('次へ'),
    ));
    // typeは必ずlistにします。
    $args['type'] = 'list';

    //  ページ区切りリンクを準備します。
    $links = paginate_links($args);
    if ($links) {
      // リストにBootstrapのクラス(ul.pagination)を付加します。
      $links = preg_replace(
        '#<ul class=\'page-numbers\'>#',
        '<ul class=\'page-numbers pagination\'>',
        $links);

      // 現在のページのリンクにBootstrapのクラス(li.active)を付加します。
      $links = preg_replace(
        '#<li><span class=\'page-numbers current\'#',
        '<li class=\'active\'><a href="'. $current_url. '" class=\'page-numbers current\'',  // 現在地のページにもaタグを追加
        $links);

      $links = preg_replace(
        '#</span></li>#',
        '</a></li>',
        $links);

      // 「...」などのリンクではない部分にBootstrapのクラス(li.disabled)を付加します。
      $links = preg_replace(
        '#<li><span#',
        '<li class=\'disabled\'><span',
        $links);

      // リンクを囲うタグを準備します。(変更したい場合はここを直接編集するとよいです)
      $template = '
      <nav class="navigation pagination-outer" role="navigation">
        <div class="nav-links">%1$s</div>
      </nav>';
      $navigation = sprintf($template, $links);
    }
  }

  return $navigation;
}

/**
 * サイトにBasic認証を掛ける
 * @link http://kotori-blog.com/wordpress/basic_authentication_wp/
 */

function origin_basic_auth($auth_list, $realm="Restricted Area", $failed_text="認証に失敗しました") {
  if (isset($_SERVER['PHP_AUTH_USER']) and isset($auth_list[$_SERVER['PHP_AUTH_USER']])){
    if ($auth_list[$_SERVER['PHP_AUTH_USER']] == $_SERVER['PHP_AUTH_PW']){
      return $_SERVER['PHP_AUTH_USER'];
    }
  }

  header('WWW-Authenticate: Basic realm="'.$realm.'"');
  header('HTTP/1.0 401 Unauthorized');
  header('Content-type: text/html; charset='.mb_internal_encoding());

  die($failed_text);
}