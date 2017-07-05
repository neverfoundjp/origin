/* ========================================
  モバイル用メニュー
======================================== */
jQuery(function($){
  $("#js-menu-toggle").on("click", function() {
    $("#primary-menu").slideToggle();
    $("#primary-menu").toggleClass("active");
  });
});

/* ========================================
  スムーススクロール
  http://kyasper.com/jquery-tips/
======================================== */
jQuery(function($){
   $('a[href^=#]').click(function() {
    var speed = 400;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;

    // メニュー固定時の高さ調整
    // if ( $("header").css("position") == "fixed" ) {
    //   position = position - 94;
    // }

    $('body,html').animate({scrollTop:position}, speed, 'swing');
    return false;
   });
});

/* ========================================
  ページ読み込み完了後に表示
  http://gimmicklog.main.jp/jquery/278/
======================================== */
$(function(){
  $("#js-mask").css("display","block");
});

$(window).load(function () { //全ての読み込みが完了したら実行
  $("#js-mask").delay(300).fadeOut(700);
});

// 2秒たったら強制的に表示
$(function(){
  setTimeout("stopload()",2000);
});

function stopload(){
  $("#js-mask").delay(300).fadeOut(700);
}

/* ========================================
  Slick
  http://cly7796.net/wp/javascript/plugin-slick/
======================================== */
$('#js-home-slider').slick({
  autoplay: true,
  autoplaySpeed: 5000,
  dots: true,
  easing: 'ease-out',
  fade: true,
  pauseOnHover:false,
  speed: 2500,
  zIndex: 9
});

/* ========================================
  Go to Top
======================================== */
$(function(){
  var topBtn = $('#js-go-to-top');
  topBtn.hide();
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      topBtn.fadeIn();
    } else {
      topBtn.fadeOut();
    }
  });
});


/* ========================================
  Search form
======================================== */
$(function() {
  $("#js-btn-search").click(function(){
    $("#js-search-area").toggleClass("is-open");

    if ($("#js-search-area").hasClass("is-open")) {
      $("#js-btn-search > i").removeClass().addClass("fa fa-times");
    } else {
      $("#js-btn-search > i").removeClass().addClass("fa fa-search");
    }
  });
});

/* ========================================
  アコーディオン
======================================== */
$(function(){
  $(".accordion-item__title").on("click", function() {
    $(this).next().slideToggle();

    if ($(this).hasClass("is-open")) {
      $(this).removeClass("is-open");
    } else {
      $(this).addClass("is-open");
    }
  });
});

/* ========================================
  heightLine
======================================== */
$(window).on('load',function() {
  $(".row--mailmag > .col").heightLine({
    minWidth: 768
  });
});

/* ========================================
  simplebox.custom.js
  http://ratiksharma.com/simplebox.js/
======================================== */
// $(function(){
//   $('.slb').simplebox();
// });

/* ========================================
  Owl Carousel
  http://owlgraphic.com/owlcarousel/
======================================== */
// $(function(){
//   $('#js-owl-carousel').owlCarousel({
//     items : 3,
//     itemsDesktop : false,
//     itemsDesktopSmall : false,
//     itemsTablet : false,
//     itemsTabletSmall : false,
//     itemsMobile : [768, 1],
//     navigation : true, //ナビゲーションの有無
//     navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
//     pagination: false,
//     autoPlay : true,
//     rewindNav : true, //最初に戻るの機能の有無
//   });
// });

/* ========================================
  スマホ用 スライドインメニュー表示
  http://memocarilog.info/jquery/7551
======================================== */
// $(function(){
//   var menu = $("#js-menu"); // スライドインするメニューを指定
//   var menuBtn = $("#js-tap-menu"); // メニューボタンを指定
//   var body = $(document.body);
//   var menuWidth = 240;

//   // メニューボタンをクリックした時の動き
//   menuBtn.on("click", function(){
//   // body に open クラスを付与する
//   body.toggleClass("open");
//     if(body.hasClass("open")){
//     // open クラスが body についていたらメニューをスライドインする
//     body.animate({"right": menuWidth}, {queue: false, duration: 300});
//     menu.animate({"right": 0}, {queue: false, duration: 300});
//     } else {
//     // open クラスが body についていなかったらスライドアウトする
//     menu.animate({"right": -menuWidth}, {queue: false, duration: 300});
//     body.animate({"right": 0}, {queue: false, duration: 300});
//     }
//   return false;
//   });
// });

/* ========================================
  レスポンシブでウィンドウサイズを変えた時だけ何かするjs
  http://qiita.com/jackotonashi/items/70d375bf92aee5046b4c
======================================== */
// $(function() {
//   var w = $(window).width();
//   var x = 768;

//   var timer = false;
//   $(window).resize(function() {
//     if (timer !== false) {
//       clearTimeout(timer);
//     }
//     timer = setTimeout(function() {
//       var w = $(window).width();
//       var x = 768;
//       var owl = $(".owl-carousel").data('owlCarousel');

//       if (w >= x) {
//         // スマホサイズ → PCサイズ
//         if ( $("body").hasClass("open") ) {
//           $("body").removeClass("open");
//         }
//         // rightプロパティを削除
//         $("body").css("right","");
//         $("#js-menu").css("right","");

//         owl.jumpTo(0);
//       } else {
//         // PCサイズ→ スマホサイズ
//         owl.jumpTo(0);
//       }
//     }, 200);
//   });
// });

// // ついでにロード時も
// $(window).load(function() {
//   var w = $(window).width();
//   var x = 768;
//   var owl = $(".owl-carousel").data('owlCarousel');

//   if (w >= x) {
//     owl.jumpTo(0);
//   } else {
//     owl.jumpTo(0);
//   }
// });


/* ========================================
  スマホの時だけtelリンクを有効にする | Tips Note
  http://www.tam-tam.co.jp/tipsnote/javascript/post3209.html
======================================== */
// var ua = navigator.userAgent;
// if(ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0){
//   $('.tel-link').each(function(){
//     if($(this).is('img')) {
//       var str = $(this).attr('alt');
//       $(this).wrap('<a href="tel:'+str.replace(/-/g,'')+'" class="tel-link"></a>');
//     } else {
//       var str = $(this).text();
//       $(this).replaceWith('<a href="tel:'+str.replace(/-/g,'')+'" class="tel-link">' + str + '</a>');
//     }
//   });
// }

