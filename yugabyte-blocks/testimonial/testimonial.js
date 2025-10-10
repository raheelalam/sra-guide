(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.testimonial img').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
      });
      /*-- arrange carosel --*/
      function wrapQuotes() {
        if ($(window).width() > 767) {
          var $quotes = $('.testimonial-wrap > .quote');
          for (var i = 0; i < $quotes.length; i += 2) {
            $quotes.slice(i, i + 2).wrapAll('<div class="quote-wrap"></div>');
          }
        } else {
          $('.quote-wrap').contents().unwrap();
        }
      }
      wrapQuotes();
      $(window).resize(function () {
        wrapQuotes();
      });
      /*-- arrange carosel --*/
      var t_owl = $('.testimonial-wrap');
      updateNavText({ item: { index: 0, count: t_owl.find('.owl-item').length } });
      t_owl.on('.testimonial changed.owl.carousel', function (event) {
        updateNavText(event);
      });
      function updateNavText(event) {
        if(event.page){
          var currentIndex = event.page.index + 1;
          var totalSlides = event.page.count;
        }
        var text = '1/4';
            text = currentIndex + '/' + totalSlides;
            if(text == 'undefined/undefined'){
              text = '1/4';
            }
        $('.yb-testimonial-text').remove();
        $('.testimonial .owl-next').before('<div class="yb-testimonial-text">' + text + '</div>');
      }
      function owl_tst_int(){
        if ($(window).width() < 991) {
          t_owl.owlCarousel('destroy');
        }else{
         t_owl.owlCarousel({
          lazyLoad: true,
          loop: true,
          autoplay: false,
          autoplayHoverPause: true,
          autoWidth: true,
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
        //updateNavText({ item: { index: 0, count: t_owl.find('.owl-item').length } });
      });
      
      $(window).scroll(function() {
        if ($(window).width() > 991) {
          if($('.testimonial').hasClass('come-in') && !$('.testimonial').hasClass('played')){
            $('.testimonial').addClass('played');
              t_owl.trigger("play.owl.autoplay");
          }
        }
      });
      
    });
  });
}());