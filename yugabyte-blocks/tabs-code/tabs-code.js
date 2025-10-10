(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    (function($) {
      $(document).ready(function() {

        $('.vertical-tabs span').on('click', function () {
          const tabName = $(this).data('tab');

          $('.vertical-tabs span.active, .vt-content .vt-data.active').removeClass('active');
          $(this).addClass('active');
          $('.vertical-tabs .active-tab').text($(this).text());
          $('.vt-content .vt-data[data-tab="' + tabName + '"]').addClass('active');
          $('.vertical-tabs').removeClass('open');
        });
        
        $('.ht-data-head').on('click',function(){
          if(!$(this).hasClass('active')){
            var currentHorizontal = $(this).attr('data-name');
            // $(this).parents('.vt-data').find('.ht-data-head,.ht-data-content').removeClass('active');
            // $(this).parents('.vt-data').find('.ht-data-head[data-name="'+currentHorizontal+'"],.ht-data-content[data-name="'+currentHorizontal+'"]').addClass('active');
            $('.ht-data-head.active, .ht-data-content.active').removeClass('active');
            $('.ht-data-head[data-name="'+currentHorizontal+'"], .ht-data-content[data-name="'+currentHorizontal+'"]').addClass('active');
          }
        });

      });
    }(jQuery));

    document.querySelectorAll('.vertical-tabs .active-tab').forEach(tab => {
      tab.addEventListener('click', function() {
        this.parentElement.classList.toggle('open');
      });
    });
    // Optional: close when clicking outside
    document.addEventListener('click', function(e) {
      document.querySelectorAll('.vertical-tabs').forEach(menu => {
        if (!menu.contains(e.target)) {
          menu.classList.remove('open');
        }
      });
    });

  });
}());