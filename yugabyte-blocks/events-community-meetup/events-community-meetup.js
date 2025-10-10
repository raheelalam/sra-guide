(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js', 'BODY', 'jquery', function () {
    
    if($('.yb-emc-card.temp-hide').length){
     $('.yb-events-community-meetup .cta.hidden').removeClass('hidden');
    }
    
    $('.yb-events-community-meetup .load-more').click(function(){
      $('.yb-emc-card.temp-hide:lt(6)').removeClass('temp-hide');
      
      if ($('.yb-emc-card.temp-hide').length === 0) {
        $('.yb-events-community-meetup .cta').addClass('hidden');
      }
    });
    
  });
}());