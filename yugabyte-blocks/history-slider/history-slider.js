(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.yb-history-slide-right img').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
      });

      var h_owl = $('.yb-history-slider-items');
      h_owl.owlCarousel({
        lazyLoad: true,
        loop: true,
        autoplay: false,
        autoplayHoverPause: true,
        autoWidth: false,
        mouseDrag : false,
        dots: true,
        dotsData: true,
        dotsText: ['',''],
        nav: true,
        navText: ['',''],
        items: 1
      });
      
      $(window).scroll(function() {
       if($('.yb-sec:not(.theme-ai-page) .autoplay-data').hasClass('come-in') && !$('.yb-sec:not(.theme-ai-page) .autoplay-data').hasClass('played')){
         $('.autoplay-data').addClass('played');
           h_owl.trigger("play.owl.autoplay");
       }
      });

      updateNavText({ item: { index: 0, count: h_owl.find('.owl-item').length } });

      h_owl.on('changed.owl.carousel', function (event) {
        updateNavText(event);
      });

      $(window).on('resize', function () {
        updateNavText({ item: { index: 0, count: h_owl.find('.owl-item').length } });
      });
	  
      $('.yb-sec:not(.theme-ai-page) .yb-history-slider-items .owl-dot').on('click', function() {
        // Get the index of the clicked dot
        var dotIndex = $(this).index();

        // Go to the corresponding slide
        $('.yb-history-slider-items').trigger('to.owl.carousel', [dotIndex]); // 300 is the slide transition duration in milliseconds
       $('.yb-history-slider-items').trigger('stop.owl.autoplay');
       $('.yb-history-slider-items').trigger('play.owl.autoplay', [5000]); // Adjust the autoplay timeout as needed (in milliseconds)
      });

      $('.yb-sec.theme-ai-page .yb-history-slider-items .owl-dot').on('click', function() {
        var dotIndex = $(this).index();
        $('.yb-sec.theme-ai-page  .yb-history-slider-items').trigger('to.owl.carousel', [dotIndex]);

      });

      function updateNavText(event) {
        if(event.page){
          var currentIndex = event.page.index + 1;
          var totalSlides = event.page.count;
        }else{
          var owlDotElements = document.querySelectorAll('.yb-history-slider-items .owl-dot');
          var owlDotCount = owlDotElements.length;
          var currentIndex = event.item.index + 1;
          var totalSlides = owlDotCount;
        }
        var text = currentIndex + '/' + totalSlides;
        $('.yb-history-slide-text').remove();
        $('.yb-history-slider-items .owl-next').before('<div class="yb-history-slide-text">' + text + '</div>');
      }

    });
  });
}());