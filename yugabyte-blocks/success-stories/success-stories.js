(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.success-story img').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
      });
      $('.success-story').owlCarousel({
        lazyLoad: true,
        loop: false,
        dots: false,
        autoplay: false,
        autoWidth: true,
        nav: true,
        navText: [
          '<span class="prev"></span>',
          '<span class="next"></span>'
        ],
        responsive: {
          0: {
            items: 1
          },
          700: {
            items: 2
          },
          1000: {
            items: 3
          }
        }
      });
    });
  });
}());