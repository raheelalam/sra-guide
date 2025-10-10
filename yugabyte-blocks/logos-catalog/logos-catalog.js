(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    $('.logos-catalog-menu span').bind( 'click', function(){
      if (!$(this).hasClass('active')){
        var current = $(this).attr('data-name');
        
        $('.logos-catalog-menu span.active').removeClass('active');
        $(this).addClass('active');
        $('.cat-view').removeClass('hidden');
        
        if(current != 'all'){
          $('.cat-view:not([data-name="'+current+'"])').addClass('hidden');
          $('.cat-view').removeClass('mob-hidden');
          $('.logos-catalog-views .button-style').addClass('hidden');
        }else{
          $('.cat-view:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)):not(:nth-child(4))').addClass('mob-hidden');
          $('.logos-catalog-views .button-style').removeClass('hidden');
        }
        
        if ($(window).width() > 991) {
          $('html, body').animate({
            scrollTop: $('#catalog-views').offset().top - 160
          }, 0);
        }
      }
      
      var currentName = $(this).text();
      $('.cat-mob-menu').text(currentName);
      $('body').removeClass('open-cat-menu');
    });

    $('.cat-mob-menu').bind( 'click', function(){
        $('body').addClass('open-cat-menu');
    });

    $('.cat-mob-menu-close').bind( 'click', function(){
        $('body').removeClass('open-cat-menu');
    });
    
    $('.logos-catalog-views .button-style').bind( 'click', function(){
        $(this).addClass('hidden');
        $('.cat-view').removeClass('mob-hidden');
    });

    $(window).on('load resize', function() {
      if ($(window).width() > 991) {
        var menuHeight = $('.logos-catalog-menu').outerHeight();
        $('.logos-catalog-views').css('height', menuHeight + 'px');
      } else {
        $('.logos-catalog-views').css('height', '');
      }
    });
    
  });
}());