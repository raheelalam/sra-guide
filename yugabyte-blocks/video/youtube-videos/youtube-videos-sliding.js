(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js', 'BODY', 'jquery', function () {
		$(document).on('click', '.sliding .nav button:not(.disabled)', function () {
			var $container = $('.sliding .vid-items');
			var boxWidth = $('.sliding .vid-items .vid-item:first-child').outerWidth(true);
			var currentScroll = $container.scrollLeft();
			var maxScroll = $container[0].scrollWidth - $container.outerWidth();
			var newScroll = $(this).hasClass('next') ? currentScroll + boxWidth : currentScroll - boxWidth;

			$container.animate({
				scrollLeft: newScroll
			}, 300);
			$('.sliding .nav .prev').toggleClass('disabled', newScroll <= 0);
			$('.sliding .nav .next').toggleClass('disabled', newScroll >= maxScroll);
		});
	});
}());
