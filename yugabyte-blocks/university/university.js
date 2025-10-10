(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.yb-uni-wrap img').each(function () {
        if(!$(this).attr('src') == $(this).attr('data-src')){
          $(this).attr('src', $(this).attr('data-src'));
        }
      });

      var ybuni_owl = $('.yb-uni-wrap');
      ybuni_owl.owlCarousel({
        lazyLoad: true,
        loop: false,
        autoWidth: true,
        dots: false,
        nav: true,
        navText: ['',''],
      });
      
      
      $('.yb-uni-tabs .tab').click(function(){
        if(! $(this).hasClass('active')){
          $('.yb-uni-tabs .tab.active').removeClass('active');
          $(this).addClass('active');
          var current = $(this).index()+3;
          $('.yb-uni-wrap').hide();
          $('.yb-uni-wrap:nth-child('+current+')').show();
        }
      });
      
    });
  });
}());