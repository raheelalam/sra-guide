(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js', 'BODY', 'jquery', function () {
		yugabyteLoadJs('//js.hsforms.net/forms/embed/v2.js', 'HEAD', 'hubspot-form', function () {
			var hubspotFormArea = document.querySelector('.hubspot-form-area');
			var hubspotFormID = '';
			if (hubspotFormArea) {
				hubspotFormID = hubspotFormArea.getAttribute('data-id');
			}

			if (hubspotFormID === '') {
				return;
			}

			hbspt.forms.create({
				region: 'na1',
				portalId: '19913802',
				formId: hubspotFormID,
				target: '.hubspot-form-area',
				css: '',
				onFormReady: function ($form) {
					yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/src/utm-hubspot-form.js', 'HEAD', 'hubspot-form', function () { });
					$form.find('.hs-button').addClass('yb--link-black cta-button-small');

					// Select the select box
					var countrySelect = document.querySelector('.form-content-area .right-form-area .hs-fieldtype-select .input select');
					countrySelect.addEventListener('focus', function () {
						this.closest('.input').classList.add('focus-field');
						if (countrySelect.classList.contains('error')) {
							countrySelect.closest('.input').classList.add('invalid-error');
						} else {
							countrySelect.closest('.input').classList.remove('invalid-error');
						}
					});

					if (countrySelect) {
						countrySelect.addEventListener('blur', function () {
							this.closest('.input').classList.remove('focus-field');
							setTimeout(function () {
								if (countrySelect.classList.contains('error')) {
									countrySelect.closest('.input').classList.add('invalid-error');
								} else {
									countrySelect.closest('.input').classList.remove('invalid-error');
								}
							}, 300);
						});

						var from_submit = document.querySelector('.actions .hs-button');
						from_submit.addEventListener('click', function () {
							setTimeout(function () {
								if (countrySelect.classList.contains('error')) {
									countrySelect.closest('.input').classList.add('invalid-error');
								} else {
									countrySelect.closest('.input').classList.remove('invalid-error');
								}
							}, 300);
						});
					}
				},
				onFormSubmit: function () {
					var cookieName = $('.form-content-area').data('cookie');
					var footerNote = document.querySelector('.footer-note');

					if (cookieName) {
						document.cookie = cookieName + '=1; path=/; secure';
						location.reload();
					} else if (footerNote) {
						footerNote.style.display = 'none';
					}
				}
			});
		});
	});
}());
