(function () {
	let silent_check;

	function checkAndAddClass() {
		const yugabyteSection = document.querySelector('.yugabyte-in-action-section');
		if (yugabyteSection.classList.contains('come-in') && !yugabyteSection.classList.contains('silent-play')) {
			var control = 0;
			var autoplay = -1;
			if (document.querySelector('.yugabyte-in-action-section .yb-popup-vid')) {
				var popupVidDiv = document.querySelector('.yugabyte-in-action-section .yb-popup-vid');
			} else {
				var popupVidDiv = document.querySelector('.yugabyte-in-action-section .yb-inaction-inner');

				control = 1;
			}

			if (popupVidDiv.getAttribute('data-autoplay') == 'yes') {
				autoplay = 1;
			}

			if (autoplay > -1) {
				if (document.querySelector('.yugabyte-in-action-section .yb-inaction-inner iframe')) {
					document.querySelector('.yugabyte-in-action-section .yb-inaction-inner iframe').remove();
				}
				yugabyteSection.classList.add('silent-play');
				const vidId = popupVidDiv.getAttribute('data-vid');
				const h2Text = document.querySelector('.yugabyte-in-action-section h2').textContent;
				const iframe = document.createElement('iframe');
				iframe.src = 'https://www.youtube.com/embed/' + vidId + '?autoplay=' + autoplay + '&mute=1&controls=' + control;
				iframe.allow = 'autoplay';
				iframe.title = h2Text;
				popupVidDiv.appendChild(iframe);
			}
		}
	}

	function InAction() {
		/*if (!document.querySelector('.yugabyte-in-action-section').classList.contains('iframe-loaded-now')) {
			var iframe_box = document.querySelector('.yugabyte-in-action-section iframe');
			iframe_box.src = iframe_box.getAttribute('data-demo');
			document.querySelector('.yugabyte-in-action-section').classList.add('iframe-loaded-now');
			iframe_box.removeAttribute('data-demo');
		}*/
		clearTimeout(silent_check);
		silent_check = setTimeout(checkAndAddClass, 300);
	}

	function handlePopupClick() {
		const yugabyteSection = document.querySelector('.yugabyte-in-action-section');

		if (!yugabyteSection.classList.contains('played')) {
			yugabyteSection.classList.add('played');
			const iframe = document.querySelector('.yugabyte-in-action-section iframe');
			if (iframe) {
				iframe.parentNode.removeChild(iframe);
			}
		}
	}
	var video_desktop = document.querySelector('.yb-inaction-inner.for-mobile');
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

	const popupVidDiv = document.querySelector('.yugabyte-in-action-section .yb-popup-vid');
	if (popupVidDiv) {
		popupVidDiv.addEventListener('click', handlePopupClick);
	}
	const demoCta = document.querySelector('.demo-section .cta a');
	const demoCtaClose = document.querySelector('.demo-section .close-demo');
	if (demoCta) {
		demoCta.addEventListener("click", function () {
			document.querySelector('.demo-section').classList.add('open');
			document.querySelector('.demo-section .close-demo').classList.add('open');
		});
	}
	if (demoCtaClose) {

		document.querySelector('.demo-section .close-demo').addEventListener("click", function () {
			document.querySelector('.demo-section').classList.remove('open');
			document.querySelector('.demo-section .close-demo').classList.remove('open');
			var iframe_box = document.querySelector('.yugabyte-in-action-section .for-desktop iframe');
			iframe_box.src = '';
			setTimeout(function () {
				iframe_box.src = iframe_box.getAttribute('data-src');
			}, 100);
		});
	}
}());
