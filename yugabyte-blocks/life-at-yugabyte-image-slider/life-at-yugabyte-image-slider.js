(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $number = 0
      $('.lay-slider img').each(function () {
        $number++;
        if($number < 5){
          $(this).attr('src', $(this).attr('data-src'));
        }else{
          return false;
        }
      });

      
      function owl_life_int(){
        if ($(window).width() < 992) {
          $('.lay-slider').owlCarousel('destroy');
        }else{
          $('.lay-slider').owlCarousel({
            lazyLoad: true,
            margin:24,
            loop: false,
            dots: false,
            autoplay: false,
            autoWidth: true,
            nav: true,
            navText: ['',''],
            items: 1,
          });
          $('.lay-slider img').each(function () {
            $(this).attr('src', $(this).attr('data-src')).removeAttr('loading');
            
          });
        }
      }
      
      owl_life_int();
      $(window).on('resize', function () {
        owl_life_int();
      });
      $(window).on('load', function () {
        owl_life_int();
      });

    });
  });
}());