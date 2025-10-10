(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
      $('.our-community img').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
      });

      var oc_owl = $('.our-community');
      oc_owl.owlCarousel({
        lazyLoad: true,
        loop: false,
        autoWidth: true,
        dots: false,
        nav: true,
        navText: ['',''],
      });

    });
  });
}());