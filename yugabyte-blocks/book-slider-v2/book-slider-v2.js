(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.yb-book-slide-right img').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
      });
      
      var b_owl = $('.yb-book-slider-v2-items');
      b_owl.owlCarousel({
        lazyLoad: true,
        loop: false,
        autoplay: false,
        autoWidth: false,
        mouseDrag : false,
        dots: true,
        dotsText: ['',''],
        nav: true,
        navText: ['',''],
        items: 1,
      });

      var currentHeight = $('.yb-book-slider-v2-item:first-child .section-head').innerHeight();
          currentHeight += 60;
          $('.yb-book-slider-v2-items .owl-nav').css('top', currentHeight + 'px');

      updateNavText({ item: { index: 0, count: b_owl.find('.owl-item').length } });

      b_owl.on('changed.owl.carousel', function (event) {
        updateNavText(event);
        setTimeout(function() {
          var currentHeight = $('.yb-book-slider-v2-items .owl-item.active .section-head').innerHeight();
          currentHeight += 60;
          $('.yb-book-slider-v2-items .owl-nav').css('top', currentHeight + 'px');
        }, 50);
      });

      $(window).on('resize', function () {
        updateNavText({ item: { index: 0, count: b_owl.find('.owl-item').length } });
      });

      function updateNavText(event) {
        var currentIndex = event.item.index + 1;
        var totalSlides = event.item.count;
        var text = currentIndex + '/' + totalSlides;
        $('.yb-book-slide-text').remove();
        $('.owl-next').before('<div class="yb-book-slide-text">' + text + '</div>');
      }
      
    });
  });
}());