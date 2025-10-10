(function () {
  //Load OWL Form lazy load
  yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {

      /*- vari Height -*/

      /*- vari Height -*/
      
      function compareCarousel() {
        var checkWidth = $(window).width();
        var compare_owl = $('.yb-comparison-group.group-a');
        if (checkWidth > 992) {
          if (typeof compare_owl.data('owl.carousel') != 'undefined') {
            compare_owl.data('owl.carousel').destroy();
          }
          compare_owl.removeClass('owl-carousel');
          if(('.yb-comparison-group.group-b .fixed-item').length){
            var atItem = $('.yb-comparison-groups').attr('data-fixed')-1;
            if(atItem == 0){
              $('.yb-comparison-group.group-b .fixed-item').prependTo('.yb-comparison-group.group-a');
            }else{
              $('.yb-comparison-group.group-b .fixed-item').insertAfter('.yb-comparison-group.group-a .item:nth-child('+atItem+')');
            }
          }
        } else if (checkWidth < 992) {
          $('.fixed-item').prependTo('.yb-comparison-group.group-b');
          compare_owl.addClass('owl-carousel');
          compare_owl.owlCarousel({
            lazyLoad: true,
            loop: false,
            autoplay: false,
            autoWidth: false,
            dots: true,
            dotsText: ['',''],
            nav: false,
            navText: ['',''],
            items: 1,
          });
        }
      }
      compareCarousel();
      $(window).resize(compareCarousel);
      
    });
  });
}());