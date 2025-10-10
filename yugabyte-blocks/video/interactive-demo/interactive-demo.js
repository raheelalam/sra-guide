(function () {
	let silent_check;

	function checkAndAddClass() {
		const yugabyteSection = document.querySelector('.yugabyte-in-action-section');
		if (yugabyteSection.classList.contains('come-in') && !yugabyteSection.classList.contains('silent-play')) {
			yugabyteSection.classList.add('silent-play');

			const popupVidDiv = document.querySelector('.yugabyte-in-action-section .yb-popup-vid');
			const vidId = popupVidDiv.getAttribute('data-vid');
			const h2Text = document.querySelector('.yugabyte-in-action-section h2').textContent;
			const iframe = document.createElement('iframe');
			iframe.src = 'https://www.youtube.com/embed/' + vidId + '?autoplay=1&mute=1&controls=0';
			iframe.allow = 'autoplay';
			iframe.title = h2Text;
			popupVidDiv.appendChild(iframe);
		}
	}

	function InAction() {
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

	if (document.querySelector('body').classList.contains('page-template-cascaded-content-blocks')) {
		var siteInner = document.querySelector('#site-inner');
		if (window.innerWidth < 993) {
			siteInner.addEventListener('scroll', InAction);
		}
	} else {
		if (window.innerWidth < 993) {
			window.addEventListener('scroll', InAction);
		}
	}

	const popupVidDiv = document.querySelector('.yugabyte-in-action-section .yb-popup-vid');
	if (popupVidDiv) {
		popupVidDiv.addEventListener('click', handlePopupClick);
	}

	document.querySelector('.demo-section .cta a').addEventListener("click", function () {
		document.querySelector('.demo-section').classList.add('open');
		document.querySelector('.demo-section .close-demo').classList.add('open');
	});

	document.querySelector('.demo-section .close-demo').addEventListener("click", function () {
		document.querySelector('.demo-section').classList.remove('open');
		document.querySelector('.demo-section .close-demo').classList.remove('open');
		var iframe_box = document.querySelector('.yugabyte-in-action-section .for-desktop iframe');
		iframe_box.src = '';
		setTimeout(function () {
			iframe_box.src = iframe_box.getAttribute('data-src');
		}, 100);
	});
}());
