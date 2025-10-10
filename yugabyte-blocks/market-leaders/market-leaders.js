(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
		var logo_html;
		if ($('.companies-logo').length > 0) {
			var logo_html = $('.companies-logo .logo-wrap').html();

			$('.companies-logo .logo-wrap img').removeAttr('loading');
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);
			$('.companies-logo .logo-wrap').append(logo_html);

			$('.companies-logo .logo-wrap img').each(function () {
				$(this).attr('src', $(this).attr('data-src'))
			});
		}
	});
}());
