(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    $('.partners-menu span').bind( 'click', function(){
      if (!$(this).hasClass('active')){
        var current = $(this).attr('data-name');

        $('.partners-menu span.active').removeClass('active');
        $(this).addClass('active');
        $('.partners-view').removeClass('hidden');

        if(current != 'all'){
          $('.partners-view:not([data-name="'+current+'"])').addClass('hidden');
          $('.partners-view').removeClass('mob-hidden');
          $('.partners-views .button-style').addClass('hidden');
        }else{
          $('.partners-view:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)):not(:nth-child(4))').addClass('mob-hidden');
          $('.partners-views .button-style').removeClass('hidden');
        }

        if ($(window).width() > 991) {
          $('html, body').animate({
            scrollTop: $('#catalog-views').offset().top - 160
          }, 0);
        }
      }

      var currentName = $(this).text();
      $('.partners-mob-menu').text(currentName);
      $('body').removeClass('open-partners-menu');
    });

    $('.partners-mob-menu').bind( 'click', function(){
      $('body').addClass('open-partners-menu');
    });

    $('.partners-mob-menu-close').bind( 'click', function(){
      $('body').removeClass('open-partners-menu');
    });

    $('.partners-views .button-style').bind( 'click', function(){
      $(this).addClass('hidden');
      $('.partners-view').removeClass('mob-hidden');
    });

    $(window).on('load resize', function() {
      if ($(window).width() > 991) {
        var menuHeight = $('.partners-menu').outerHeight();
        $('.partners-views').css('height', menuHeight + 'px');
      } else {
        $('.partners-views').css('height', '');
      }
    });

  });
}());