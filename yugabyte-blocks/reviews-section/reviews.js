(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=5', 'BODY', 'jquery', function () {
    $(document).ready(function () {
      if ($('.yb-reviews-items .yb-review-item:not(.open)').length > 0) {
        $('.load-more.hidden').removeClass('hidden');
      }
      $('.load-more a').click(function () {
        $('.load-more').addClass('loading');
        setTimeout(function () {
          $('.yb-reviews-items .yb-review-item:not(.open)').prev().nextAll().filter(':lt(2)').addClass('open');
        }, 500);
        setTimeout(function () {
          $('.load-more').removeClass('loading');
          if ($('.yb-reviews-items .yb-review-item:not(.open)').length < 1) {
            $('.load-more').addClass('hidden');
          }
        }, 700);
      });
    });

    function g2Reviews(sidebarWidget) {
      var g2Div = document.createElement('div');
      g2Div.id = 'g2-widget-container';
      g2Div.style.marginBottom = '32px';
      g2Div.innerHTML = '<a href="https://www.g2.com/products/yugabytedb/reviews?utm_source=review-widget" title="Read reviews of YugabyteDB on G2" target="_blank" rel="noopener"><img class="full-width" style="max-width: 200px" alt="Read YugabyteDB reviews on G2" src="https://www.g2.com/products/yugabytedb/widgets/stars?color=white&amp;type=read" /></a>';
      sidebarWidget.append(g2Div);
      (function (a, b, c, d) {
        window.fetch('https://www.g2.com/products/yugabytedb/rating_schema.json').then(function (e) {
          return e.json()
        }).then(function (f) {
          c = a.createElement(b);
          c.type = 'application/ld+json';
          c.text = JSON.stringify(f);
          d = a.getElementsByTagName(b)[0];
          d.parentNode.insertBefore(c, d);
        });
      })(document, 'script');
    }

    var g2sidebarWidget = document.getElementsByClassName('g2-review-widget');
    var sidebarWidgetg2 = g2sidebarWidget[0];
    g2Reviews(sidebarWidgetg2);
  });
}());