(function () {
	// Load OWL Form lazy load.
	var allItems = document.querySelectorAll('.yb-success-stories .yb-ss-v2.owl-carousel');
	if (allItems && allItems.length > 0) {
		yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
			yugabyteLoadStyle('/wp-content/themes/yugabyte/assets/css/owl.carousel-custom.min.css?v=1', 'BODY');
			yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/owl.carousel.min.js?a=2', 'BODY', 'owljs', function () {
				$('.yb-ss-v2.owl-carousel img').each(function () {
					$(this).attr('src', $(this).attr('data-src'));
				});
				$('.yb-ss-v2.owl-carousel').owlCarousel({
					lazyLoad: true,
					loop: false,
					dots: false,
					autoplay: false,
					autoWidth: true,
					nav: true,
					navText: [
						'',
						''
					]
				});
			});
		});
	}
})();
