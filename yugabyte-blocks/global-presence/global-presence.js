(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    /*
    $('.yb-location').click(function(){
      var country = $(this).attr('data-country');
      var center = $(this).attr('data-center');
      $('.yb-location-point').removeClass('active');
      $('.yb-location-point[data-country="'+country+'"][data-center="'+center+'"]').addClass('active');
    });
    */
    $('.yb-location-point').click(function(){
      $('.yb-location-point').removeClass('active');
      $(this).addClass('active');
    });
    $('.yb-gp-content, .yb-gp-map svg, .yb-gp .section-head, .yb-gp-slider, .yb-sec:not(.yb-gp), #masthead, footer').click(function(){
      $('.yb-location-point.active').removeClass('active');
    });
  });
}());