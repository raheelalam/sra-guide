(function () {
	var techNavIcons = document.querySelectorAll('.yb-beyond-tech-nav i');
	var techSlides = document.querySelectorAll('.yb-beyond-tech-slides > div');

	techNavIcons.forEach(function (icon, index) {
		icon.addEventListener('click', function () {
			document.querySelector('.yb-beyond-tech-slides > div.active').classList.remove('active');
			document.querySelector('.yb-beyond-tech-nav i.active').classList.remove('active');

			icon.classList.add('active');
			techSlides[index].classList.add('active');
		});
	});

	const activeStop = document.querySelector('.yugabyte-beyond-tech-section .section-right');
	if (activeStop) {
		activeStop.addEventListener('mouseover', () => {
			activeStop.classList.add('mouseOver');
		});
		activeStop.addEventListener('mouseout', () => {
			activeStop.classList.remove('mouseOver');
		});
	}

	let timeout;
	techSlides.forEach((div, index) => {
		div.addEventListener('mouseenter', (event) => {
			timeout = setTimeout(() => {
				if (!event.target.classList.contains('active')) {
					techSlides.forEach((div) => div.classList.remove('active'));
					div.classList.add('active');
					techNavIcons.forEach((i) => i.classList.remove('active'));
					techNavIcons[index].classList.add('active');
				}
			}, 100);
		});
	});

	function isMobile() {
		return window.innerWidth <= 767;
	}

	var timeoutId = null;

	function handleTimer() {
		if (isMobile()) {
			if (timeoutId) {
				clearTimeout(timeoutId);
			}

			timeoutId = setTimeout(() => {
				const container = document.querySelector('.yb-beyond-tech-slides');
				const children = Array.from(container.querySelectorAll('div'));

				let atLeastOneActive = false;

				children.forEach((child) => {
					const childRect = child.getBoundingClientRect();
					const childTopRelativeToScreen = childRect.top;

					if (childTopRelativeToScreen < 325) {
						if (childTopRelativeToScreen > 50) {
							child.classList.add('active');
							atLeastOneActive = true;
						} else {
							child.classList.remove('active');
						}
					} else {
						child.classList.remove('active');
					}
				});

				if (!atLeastOneActive) {
					if (children.length > 0) {
						children[0].classList.add('active');
					}
				}

				timeoutId = null;
			}, 200);
		}
		else {
			setTimeout(() => {
				var techareaa = document.querySelector('.yugabyte-beyond-tech-section .section-right');
				if (!techareaa.classList.contains('paused') && !techareaa.classList.contains('mouseOver')) {
					document.querySelector('.yugabyte-beyond-tech-section .section-right').classList.add('paused');
					const activeIndex = Array.from(techSlides).findIndex((slide) => slide.classList.contains('active'));

					if (activeIndex !== -1) {
						techSlides.forEach((div) => div.classList.remove('active'));
						techNavIcons.forEach((i) => i.classList.remove('active'));

						const nextIndex = (activeIndex + 1) % techSlides.length;

						techSlides[nextIndex].classList.add('active');
						techNavIcons[nextIndex].classList.add('active');
					}
					setTimeout(function () {
						techareaa.classList.remove('paused');
						handleTimer(); // Call the function recursively after the interval
					}, 3900);
				} else {
					handleTimer(); // Call the function recursively after the interval
				}
			}, 4000);
		}
	}
	handleTimer();
	if (document.querySelector('body').classList.contains('page-template-cascaded-content-blocks')) {
		var siteInner = document.querySelector('#site-inner');
		siteInner.addEventListener('scroll', handleTimer);
	} else {
		window.addEventListener('scroll', handleTimer);
	}
})();
