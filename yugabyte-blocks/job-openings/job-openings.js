(function () {
	// Load OWL Form lazy load.
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
		if (!$('body').hasClass('jobs-load')) {
			$.ajax({
				type: 'POST',
				url: '/wp-admin/admin-ajax.php',
				data: {
					'action': 'careers_job_filters' // This is the name of the AJAX method called in WordPress.
				},
				success: function (result) {
					$('.job-openings .jobs').append(result);
				}
			});
			$('body').addClass('jobs-load');
		}

		/*
		 * Career Page:: Locations, Departments Filter.
		 */
		var getURLParameter2 = {};
		// Get Query string Values in a Url.
		getURLParameter2.url = function (name) {
			return decodeURIComponent((new RegExp("[?|&]" + name + "=" + "([^&;]+?)(&|#|;|$)").exec(location.search) || [null, ""])[1].replace(/\+/g, "%20")) || null;
		};

		$('.inpage-link').click(function () {
			$('html,body').animate({
				scrollTop: $('#listing').offset().top
			},
				2000);
		});

		/*** Career Page:: Locations, Departments Filter the content. ***/
		$(document).on('change', '.jobs_filter_wrap select', function () {
			var df = $('.lever-jobs-filter-teams').val();
			var lf = $('.lever-jobs-filter-locations').val();

			if (!$('.lever-jobs-filter-teams').val()) {
				df = 'all';
			}

			if (!$('.lever-jobs-filter-locations').val()) {
				lf = 'all';
			}

			if ($(this).hasClass('lever-jobs-filter-teams')) {
				window.history.pushState('', '', '/careers/?department=' + df);
			}

			if (lf !== 'all' && df !== 'all') {
				$('#lever_jobs_cont .lever-job').hide();
				$('#lever-clear-filters').show();
				$('#lever_jobs_cont .lever-job[data-department-id="' + df + '"][data-office="' + lf + '"]').show();
			} else if (lf === 'all' && df !== 'all') {
				$('#lever_jobs_cont .lever-job').hide();
				$('#lever-clear-filters').show();
				$('#lever_jobs_cont .lever-job[data-department-id="' + df + '"]').show();
			} else if (lf !== 'all' && df === 'all') {
				$('#lever_jobs_cont .lever-job').hide();
				$('#lever-clear-filters').show();
				$('#lever_jobs_cont .lever-job[data-office="' + lf + '"]').show();
			} else {
				$('#lever_jobs_cont .lever-job').show();
				$('#lever-clear-filters').hide();
			}

			if ($('#lever_jobs_cont .lever-job:visible').length < 1) {
				$('#jobs_list .no-result-found').show();
				$('#lever_jobs_cont .lever-job').hide();
			} else {
				$('#jobs_list .no-result-found').hide();
			}

			var visibleCount = $('#lever_jobs_cont .lever-job:visible').length;
			$('.jobs_filter_wrap .open-jobs').html(visibleCount + ' Openings');
		});

		if (getURLParameter2.url('department')) {
			setTimeout(function () {
				if (getURLParameter2.url('department') !== 'all') {
					$('.lever-jobs-filter-teams').val(getURLParameter2.url('department')).change();
				}
			}, 1000);
		}
		$(document).on('click', '#lever-clear-filters', function () {
			$('.lever-jobs-filter-teams').val('all').change();
			$('.lever-jobs-filter-locations').val('all').change();
			$('#lever-clear-filters').hide();
		});

		/*-----------------------------------------------------------------#
		#  End Career Page:: Locations, Departments Filter
		#-----------------------------------------------------------------*/
	});
}());
