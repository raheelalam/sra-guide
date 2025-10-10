(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {

		let totalRows = $('.yugabyte-consumption-models .yb-cm').attr('data-col');
		totalRows = totalRows - 1;
		$('.yugabyte-consumption-models tbody tr:not(.heading-row)').each(function () {
			let trow = $(this);
			let tbody = $(this).parent('tbody');
			let totalCheck = 0;
			let totalCross = 0;
			$(this).find('td:not(:first-child)').each(function () {
				let tdClass = $(this).attr('class');
				if (tdClass === 'td-check') {
					totalCheck++
				}
				if (tdClass === 'td-cross') {
					totalCross++
				}
			});
			if (totalCross === totalRows || totalCheck === totalRows) {
				$(trow).addClass('same-row');
			} else {
				$(trow).addClass('diff-row');
				$(tbody).addClass('diff-tbody');
			}
		});

		$('.differences-menu .check-btn').click(function () {
			$('.differences-menu').toggleClass('active');
			$('.yugabyte-consumption-models').toggleClass('show-difference');
		});
	});

	document.querySelector('.yugabyte-consumption-models table').style.marginTop = '-' + document.querySelector('.float-menu').clientHeight + 'px';
	function floatingMenu() {
		const sectionWidth = document.querySelector('.yugabyte-consumption-models ').clientWidth;
		const sectionContWidth = document.querySelector('.yugabyte-consumption-models .container').clientWidth;
		if (sectionWidth && sectionContWidth) {
			document.querySelector('.float-menu').style.marginRight = -(sectionWidth - sectionContWidth) / 4 + 'px';
		}
	}
	function highlightActiveLink() {
		const headings = document.querySelectorAll('td.heading');
		const section = document.querySelector('.yugabyte-consumption-models').offsetTop;
		const sidebarLinks = document.querySelectorAll('.float-menu li');
		headings.forEach((heading) => {
			if (heading) {
				const headingOffsetTop = heading.offsetTop;
				const scrollPosition = window.scrollY || window.pageYOffset;
				if (scrollPosition >= headingOffsetTop + section - 150) {
					const activeId = heading?.childNodes[1]?.getAttribute('id');
					const correspondingLink = document.querySelector(`.float-menu a[href="#${activeId}"]`);
					if (correspondingLink && correspondingLink.childNodes[0].innerHTML) {
						document.querySelector('.float-menu .active-heading').innerHTML = correspondingLink.childNodes[0].innerHTML;
					}
					sidebarLinks.forEach(li => li.classList.remove('active'));
					if (correspondingLink) {
						correspondingLink.parentNode.classList.add('active');
					}
				}
			}
		});
	}

	window.addEventListener('resize', floatingMenu);
	window.addEventListener('scroll', highlightActiveLink);
	highlightActiveLink();
	floatingMenu();
}());
