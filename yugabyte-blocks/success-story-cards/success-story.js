(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
		$('.filter-story .toggle').click(function () {
			$(this).parent('div').toggleClass('open');
		});

		/*-hide non related posts*/
		$('.filter-inner span').click(function () {
			activetxt = $(this).parent('div').siblings('.active').text();
			current = $(this).text();
			dataTarget = $(this).parent('div').parent('div').attr('data-target');

			$(this).parent('div').siblings('.active').text(current);

			if ($(this).is(':first-child')) {
				$('.story-cards>a.' + dataTarget + '-hide').removeClass(dataTarget + '-hide');

				// update current stories text
				currentInd = $('.filter-story .filter-industries .active').text();
				currentFea = $('.filter-story .filter-features .active').text();
				if (currentInd == 'All Industries' && currentFea == 'All Features') {
					$('.yb-success-story .cta.text-center.hidden').removeClass('hidden');
					$('.story-cards >a').slice(12).addClass('temp-hide');
				}
			}

			else if (activetxt != current) {
				$('.story-cards > a').removeClass(dataTarget + '-hide');

				$('.story-cards > a').removeClass('temp-hide');
				$('.yb-success-story .cta.text-center').addClass('hidden');

				$('.story-cards > a').each(function () {
					if ($(this).attr(dataTarget) && $(this).attr(dataTarget).indexOf(current) === -1) {
						$(this).addClass(dataTarget + '-hide');
					}
				});
			}

			$('.filter-story>div.open').removeClass('open');
		});
		/*-hide non related posts*/

		/*--reset--*/
		$('#story-reset').click(function () {
			$('.filter-story > div').each(function () {
				var resetTXT = $(this).find('.filter-inner > span:first-child').text();
				var targets = $(this).attr('data-target');

				$(this).children('.active').text(resetTXT);
				$('.story-cards a').removeClass(targets + '-hide');

				$('.yb-success-story .cta.text-center.hidden').removeClass('hidden');
				$('.story-cards >a').slice(12).addClass('temp-hide');
			});
		});
		/*--reset--*/

		/*--explore all --*/
		$('.yb-success-story .cta a').click(function () {
			$('.story-cards > a').removeClass('temp-hide');
			$('.yb-success-story .cta.text-center').addClass('hidden');
		});
		/*--explore all --*/
	});
})();
