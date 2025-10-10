(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    (function($) {
      $(document).ready(function() {
        var interval;
        var activeClass = 1;

        function updateActiveClass() {
          $('.yb-choices-wrap').removeClass('active-1 active-2 active-3').addClass('active-' + activeClass);
        }

        function startInterval() {
          interval = setInterval(function() {
            activeClass = activeClass % 3 + 1; // Loop through 1, 2, 3
            updateActiveClass();
          }, 4000);
        }

        // Initial setup
        if ($(window).width() > 991){
          //startInterval();
        }
        
        $('.yb-choice').hover(
          function() {
            clearInterval(interval); // Pause the interval on mouseover
            activeClass = $(this).index() + 1; // Set active class based on the index of the hovered yb-choice
            updateActiveClass();
          },
          function() {
            if ($(window).width() > 991){
              //startInterval(); // Resume the interval on mouseleave
            }
          }
        );
        
        $('.yb-choice').mousemove(function (event) {
            var mouseX = event.pageX - $(this).offset().left;
            $('.choice-before').css('width', mouseX);
         
                screenW = event.pageX;
                totalW = $(window).width();
                navW = $('.yb-choices-nav').innerWidth();
                finalW = screenW-((totalW-navW)/2)-12+'px';
                finalWBar = screenW-((totalW-navW)/2)+'px';
            $('.bar-thumb').css('left', finalW);
            $('.purple-bar').css('width', finalWBar);
           
        });
        
      });
      
    }(jQuery));
  });
}());