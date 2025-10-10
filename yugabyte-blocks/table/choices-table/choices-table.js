(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
		(function ($) {
			$(document).ready(function () {
				var ybCTinterval;
				var activeClass = 1;

				function updateActiveClass() {
					$('.yb-ct-wrap').removeClass('active-1 active-2 active-3 active-4').addClass('active-' + activeClass);
				}

				$('.yb-ct tbody tr td:not(:first-child), .yb-ct thead th:not(.th-label):not(:first-child)').hover(
					function () {
						clearInterval(ybCTinterval);
						activeClass = $(this).index();
						updateActiveClass();
					}
				);
			});
		}(jQuery));
	});
}());
