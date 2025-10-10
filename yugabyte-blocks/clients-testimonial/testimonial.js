(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.c-testimonial-wrap img').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
      });
      var ct_owl = $('.c-testimonial-wrap');
      updateNavText({ item: { index: 0, count: ct_owl.find('.owl-item').length } });
      ct_owl.on('.c-testimonial-wrap changed.owl.carousel', function (event) {
        updateNavText(event);
      });
      function updateNavText(event) {
        if(event.page){
          var currentIndex = event.page.index + 1;
          var totalSlides = event.page.count;
        }
        var text = '1/5';
            text = currentIndex + '/' + totalSlides;
            if(text == 'undefined/undefined'){
              text = '1/5';
            }
        $('.yb-c-testimonial-text').remove();
        $('.c-testimonial-wrap .owl-next').before('<div class="yb-c-testimonial-text">' + text + '</div>');
      }
      function owl_tst_int(){
        if ($(window).width() < 767) {
          ct_owl.owlCarousel('destroy');
        }else{
         ct_owl.owlCarousel({
          lazyLoad: true,
          loop: true,
          autoplay: false,
          autoplayTimeout: 8000,
          autoplayHoverPause: true,
          autoWidth: false,
          dots: true,
          dotsData: false,
          dotsText: ['',''],
          nav: true,
          navText: ['',''],
          items: 1,
        });
        }
      }
      owl_tst_int();
      $(window).on('resize', function () {
        owl_tst_int();
        //updateNavText({ item: { index: 0, count: ct_owl.find('.owl-item').length } });
      });
      
      $(window).scroll(function() {
        if ($(window).width() > 767) {
          if($('.yb-client-testimonial').hasClass('come-in') && !$('.yb-client-testimonial').hasClass('played')){
            $('.yb-client-testimonial').addClass('played');
              ct_owl.trigger("play.owl.autoplay");
          }
        }
      });
      
    });
  });
}());