(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js', 'BODY', 'jquery', function () {

		$('.filter-event .toggle').click(function () {
			$(this).parent('div').toggleClass('open');
		});

		/*-hide non related posts*/
		$('.filter-inner span').click(function () {
			activetxt = $(this).parent('div').siblings('.active').text();
			current = $(this).text();
			dataTarget = $(this).parent('div').parent('div').attr('data-target');

			$(this).parent('div').siblings('.active').text(current);

			if ($(this).is(':first-child')) {
				$('.upcoming-event-cards>a.' + dataTarget + '-hide').removeClass(dataTarget + '-hide');

				// update current Events text
				currentReg = $('.filter-event .filter-regions .active').text();
				currentTyp = $('.filter-event .filter-types .active').text();
				if (currentReg == 'All Regions' && currentTyp == 'All Types') {
					var totalEvents = $('.upcoming-event-cards > a').length;
					$('.total-events').html(totalEvents + ' EVENTS');
					if ($('.upcoming-event-cards > a').length > 6) {
						$('.yb-upcoming-events .cta.text-center').removeClass('hidden');
					}
					$('.upcoming-event-cards >a').slice(6).addClass('temp-hide');
				} else {
					var currentEvent = $('.upcoming-event-cards > a:not([class*="-hide"])').length;
					if (currentEvent == 0) {
						$('.total-events').html('No Event found');
					} else if (currentEvent == 1) {
						$('.total-events').html('1 EVENT');
					} else {
						$('.total-events').html(currentEvent + ' EVENTS');
					}
				}

			}

			else if (activetxt != current) {
				$('.upcoming-event-cards>a').removeClass(dataTarget + '-hide');
				$('.upcoming-event-cards>a:not([' + dataTarget + '])').addClass(dataTarget + '-hide');

				$('.upcoming-event-cards>a').removeClass('temp-hide');
				$('.yb-upcoming-events .cta.text-center').addClass('hidden');

				$('.upcoming-event-cards>a').each(function () {
					if ($(this).attr(dataTarget) && $(this).attr(dataTarget).indexOf(current) === -1) {
						$(this).addClass(dataTarget + '-hide');
					}
				});

				// update current Events text
				var currentEvent = $('.upcoming-event-cards > a:not([class*="-hide"])').length;
				if (currentEvent == 0) {
					$('.total-events').html('No Event found');
				} else if (currentEvent == 1) {
					$('.total-events').html('1 EVENT');
				} else {
					$('.total-events').html(currentEvent + ' EVENTS');
				}
			}

			$('.filter-event>div.open').removeClass('open');
		});
		/*-hide non related posts*/

		/*--reset--*/
		$('#event-reset').click(function () {
			$('.filter-event>div').each(function () {
				targets = $(this).attr('data-target');
				resetTXT = $(this).find('.filter-inner>span:first-child').text();
				$(this).children('.active').text(resetTXT);
				$('.upcoming-event-cards a').removeClass(targets + '-hide');
				var totalEvents = $('.upcoming-event-cards > a').length;
				$('.total-events').html(totalEvents + ' EVENTS');
				if ($('.upcoming-event-cards > a').length > 6) {
					$('.yb-upcoming-events .cta.text-center').removeClass('hidden');
				}
				$('.upcoming-event-cards >a').slice(6).addClass('temp-hide');
			});
		});
		/*--reset--*/

		$('.yb-upcoming-events .cta a').click(function () {
			$('.upcoming-event-cards>a').removeClass('temp-hide');
			$('.yb-upcoming-events .cta.text-center').addClass('hidden');
		});
		/*--explore all --*/
	});
}());
