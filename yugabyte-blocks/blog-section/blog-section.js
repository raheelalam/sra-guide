(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.yb-blog-cards img').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
      });
      $('.yb-blog-cards').owlCarousel({
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
            items: 3
          },
          700: {
            items: 3
          },
          1000: {
            items: 3
          }
        }
      });
    });
  });
}());