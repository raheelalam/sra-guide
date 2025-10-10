(function () {
	var benefitTabs = document.querySelectorAll('.yb-benefit-tabs > div u');
	var benefitTabs2 = document.querySelectorAll('.yb-benefit-tabs-mob > div u');
	var benefitTabsContainers = document.querySelectorAll('.yb-benefit-tabs > div');
	var benefitTabsContainers2 = document.querySelectorAll('.yb-benefit-tabs-mob > div > div');
	var benefitImgContainers = document.querySelectorAll('.yb-benefit-img > div');

	benefitTabs.forEach(function (tab, index) {
		tab.addEventListener('click', function () {
			if (!benefitTabsContainers[index].classList.contains('active')) {
				removeBenifitActives();
				benefitTabsContainers[index].classList.add('active');
				benefitImgContainers[index].classList.add('active');
				benefitImgContainers[index].children[0].src = benefitImgContainers[index].children[0].getAttribute('data-src');

				if (document.querySelector('.in-view-sec31')) {
					document.querySelector('.in-view-sec31').classList.remove('temp-active');
				}
			}
		});
	});

	benefitTabs2.forEach(function (tab, index) {
		tab.addEventListener('click', function () {
			if (!benefitTabsContainers2[index].classList.contains('active')) {
				document.querySelector('.yb-benefit-inner').classList.add('paused-running');
				removeBenifitActives();
				benefitTabsContainers2[index].classList.add('active');
				benefitTabsContainers[index].classList.add('active');
				benefitImgContainers[index].classList.add('active');
				benefitTabsContainers2[index].children[0].src = benefitTabsContainers2[index].children[0].getAttribute('data-src');

				if (document.querySelector('.in-view-sec31')) {
					document.querySelector('.in-view-sec31').classList.remove('temp-active');
				}
			}
		});
	});

	function removeBenifitActives() {
		benefitTabsContainers.forEach(function (tab) {
			if (tab.classList.contains('active')) {
				tab.classList.remove('active');
			}
		});
		benefitImgContainers.forEach(function (tab) {
			if (tab.classList.contains('active')) {
				tab.classList.remove('active');
			}
		});
		benefitTabsContainers2.forEach(function (tab) {
			if (tab.classList.contains('active')) {
				tab.classList.remove('active');
			}
		});
	}

	/*-- Auto Slide --*/
	function intervalFunction() {
		var in_view;
		if (document.querySelector('body').classList.contains('page-template-cascaded-content-blocks')) {
			in_view = document.querySelector('.in-view-sec31 .yugabyte-benefit-section');
		} else {
			in_view = document.querySelector('.yugabyte-benefit-section');
		}
		if (in_view) {
			if (!document.querySelector('.yb-benefit-inner').classList.contains('paused-running') && in_view.classList.contains('come-in')) {
				var active_tab = document.querySelector('.yb-benefit-tabs > .active');
				if (active_tab) {
					var activeTab = document.querySelector('.yb-benefit-tabs > div.active');
					var current = Array.from(benefitTabsContainers).indexOf(activeTab) + 1;
					var last = benefitTabsContainers.length;
					var next = current + 1;
					var activeChildLeftPosition;

					if (current === last) {
						removeBenifitActives();
						benefitTabsContainers[0].classList.add('active');
						benefitTabsContainers2[0].classList.add('active');
						document.querySelector('.yb-benefit-img > div:first-child').classList.add('active');
						$('.yb-benefit-tabs-mob > div').scrollLeft(0);
					} else {
						removeBenifitActives();
						benefitTabsContainers[current].classList.add('active');
						benefitTabsContainers2[current].classList.add('active');
						document.querySelector('.yb-benefit-img > div:nth-child(' + next + ')').classList.add('active');
						document.querySelector('.yb-benefit-img > div:nth-child(' + next + ')').children[0].src = document.querySelector('.yb-benefit-img > div:nth-child(' + next + ')').children[0].getAttribute('data-src');
					}
					activeChildLeftPosition = $('.yb-benefit-tabs-mob > div > div.active').position().left;
					$('.yb-benefit-tabs-mob > div').scrollLeft(activeChildLeftPosition);
				}
				else {
					document.querySelector('.yb-benefit-tabs > div:first-child').classList.add('active');
					document.querySelector('.yb-benefit-tabs-mob > div > div:first-child').classList.add('active');
					document.querySelector('.yb-benefit-img > div:first-child').classList.add('active');
					$('.yb-benefit-tabs-mob > div').scrollLeft(0);
				}

				if (document.querySelector('.in-view-sec31')) {
					document.querySelector('.in-view-sec31').classList.remove('temp-active');
				}
			}
		} else {
			removeBenifitActives();
		}
	}

	var intervalID = setInterval(intervalFunction, 7000);
	var ybBenefitInner = document.querySelector('.yb-benefit-tabs,.yb-benefit-tabs-mob');
	var ybTeche = document.querySelector('.yugabyte-cards-section');
	ybBenefitInner.addEventListener('mouseenter', function () {
		document.querySelector('.yb-benefit-inner').classList.add('paused-running');
		clearInterval(intervalID);
	});

	ybBenefitInner.addEventListener('mouseleave', function () {
		document.querySelector('.yb-benefit-inner').classList.remove('paused-running');
		intervalID = setInterval(intervalFunction, 7000);
	});
	ybTeche.addEventListener('click', function () {
		if (document.querySelector('.yb-benefit-inner').classList.contains('paused-running')) {
			document.querySelector('.yb-benefit-inner').classList.remove('paused-running');
		}
	});
	/*-- Auto Slide --*/

	/*-- in view --*/
	var delayTime = 0;
	if (window.innerWidth < 600) {
		delayTime = 0;
	}
	var checkInView = function () {
		setTimeout(function () {
			if (document.querySelector('body').classList.contains('page-template-cascaded-content-blocks') && !document.getElementById('site-inner').classList.contains('in-view-sec31')) {
				// Remove 'active' class from specified elements
				removeBenifitActives();
			}
			else {
				var active_tab = document.querySelector('.yb-benefit-tabs > .active');
				if (!active_tab) {
					document.querySelector('.yb-benefit-tabs > div:first-child').classList.add('active');
					document.querySelector('.yb-benefit-tabs-mob > div > div:first-child').classList.add('active');
					document.querySelector('.yb-benefit-img > div:first-child').classList.add('active');
					$('.yb-benefit-tabs-mob > div').scrollLeft(0);
					clearInterval(intervalID);
					intervalID = setInterval(intervalFunction, 7000);
				}
			}
		}, delayTime);
	};

	if (document.querySelector('body').classList.contains('page-template-cascaded-content-blocks')) {
		var siteInner = document.querySelector('#site-inner');
		siteInner.addEventListener('scroll', checkInView);
	} else {
		window.addEventListener('scroll', checkInView);
	}

	checkInView();

	/*-- in view --*/

	/*--svg inline --*/
	const element = document.querySelector('.yb-benefit-img div[data-svg]');
	const svgUrl = element.getAttribute('data-svg');
	if (svgUrl && svgUrl !== '' && !element.classList.contains('svg-loaded')) {
		fetch(svgUrl)
			.then(response => {
				if (!response.ok) {
					throw new Error('Network response was not ok.');
				}
				return response.text();
			})
			.then(svgContent => {
				element.innerHTML = svgContent;
				element.classList.add('svg-loaded');
			})
			.catch(error => {
				console.error('Error fetching SVG:', error);
			});
	}
	/*--svg inline --*/
}());
