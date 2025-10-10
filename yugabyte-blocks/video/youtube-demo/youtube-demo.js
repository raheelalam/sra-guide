(function () {
	var demoCta = document.querySelector('.demo-section .cta a');
	var demoCtaClose = document.querySelector('.demo-section .close-demo');
	var images_yvd = document.querySelectorAll('.yb-popup-vid-thumb img.skip-lazy');
	var popupVidDiv;
	var silent_check;
	var video_desktop = document.querySelector('.yb-inaction-inner.for-mobile');

	function checkAndAddClass() {
		var autoplay = -1;
		var control = 0;
		var iframe = document.createElement('iframe');
		var vidId = '';
		var yugabyteSection = document.querySelector('.yugabyte-in-action-section');

		if (yugabyteSection.classList.contains('come-in') && !yugabyteSection.classList.contains('silent-play')) {
			if (document.querySelector('.yugabyte-in-action-section .yb-popup-vid')) {
				popupVidDiv = document.querySelector('.yugabyte-in-action-section .yb-popup-vid');
			} else {
				popupVidDiv = document.querySelector('.yugabyte-in-action-section .yb-inaction-inner');
				control = 1;
			}

			if (popupVidDiv.getAttribute('data-autoplay') === 'yes') {
				autoplay = 1;
			}

			if (autoplay > -1) {
				if (document.querySelector('.yugabyte-in-action-section .yb-inaction-inner iframe')) {
					document.querySelector('.yugabyte-in-action-section .yb-inaction-inner iframe').remove();
				}
				yugabyteSection.classList.add('silent-play');
				vidId = popupVidDiv.getAttribute('data-vid');

				iframe.src = 'https://www.youtube.com/embed/' + vidId + '?autoplay=' + autoplay + '&mute=1&controls=' + control;
				iframe.allow = 'autoplay';
				iframe.title = document.querySelector('.yugabyte-in-action-section h2').textContent;
				popupVidDiv.appendChild(iframe);
			}
		}
	}

	function InAction() {
		clearTimeout(silent_check);
		silent_check = setTimeout(checkAndAddClass, 300);
	}

	function handlePopupClick() {
		var iframe = document.querySelector('.yugabyte-in-action-section iframe');
		var yugabyteSection = document.querySelector('.yugabyte-in-action-section');

		if (!yugabyteSection.classList.contains('played')) {
			yugabyteSection.classList.add('played');
			if (iframe) {
				iframe.parentNode.removeChild(iframe);
			}
		}
	}

	function closeVideo() {
		var iframe_box = document.querySelector('.yugabyte-in-action-section .for-desktop iframe');
		var videoThumbnail = document.querySelector('.demo-section .yb-popup-vid-thumb');

		document.querySelector('.demo-section').classList.remove('open');
		document.querySelector('.demo-section .close-demo').classList.remove('open');

		if (videoThumbnail) {
			iframe_box.style.opacity = 0;
			videoThumbnail.style.opacity = 1;
		}
	}

	images_yvd.forEach(function (image) {
		image.setAttribute('src', image.getAttribute('data-src'));
	});

	if (document.querySelector('body').classList.contains('page-template-cascaded-content-blocks')) {
		var siteInner = document.querySelector('#site-inner');
		if (window.innerWidth < 993 || video_desktop.classList.contains('for-desktop')) {
			siteInner.addEventListener('scroll', InAction);
		}
	} else {
		if (window.innerWidth < 993 || video_desktop.classList.contains('for-desktop')) {
			window.addEventListener('scroll', InAction);
		}
	}

	if (popupVidDiv) {
		popupVidDiv.addEventListener('click', handlePopupClick);
	}

	if (demoCta) {
		demoCta.addEventListener('click', function () {
			var demoiFrame = document.querySelector('.demo-section iframe');
			var videoThumbnail = document.querySelector('.demo-section .yb-popup-vid-thumb');

			var dataDemoValue = demoiFrame.getAttribute('data-demo');
			var dataSrcValue = demoiFrame.getAttribute('src');
			if (dataDemoValue !== dataSrcValue) {
				demoiFrame.src = dataDemoValue;
			} else {
				demoiFrame.contentWindow.postMessage('ybPlayYouTubeVideo');
			}

			demoiFrame.style.opacity = 1;
			document.querySelector('.demo-section').classList.add('open');
			document.querySelector('.demo-section .close-demo').classList.add('open');

			if (videoThumbnail) {
				videoThumbnail.style.opacity = 0;
			}
		});
	}

	if (demoCtaClose) {
		document.querySelector('.demo-section .close-demo').addEventListener('click', function () {
			document.querySelector('.demo-section iframe').contentWindow.postMessage('ybStopYouTubeVideo');
		});

		window.addEventListener('message', function (event) {
			if (event.data === 'ybYouTubeVideoEnd') {
				closeVideo();
			}
		});
	}
}());
