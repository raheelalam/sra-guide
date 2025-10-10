(function () {
	yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jQuery', function () {
		yugabyteLoadJs('//js.hsforms.net/forms/embed/v2.js', 'HEAD', 'hubspot-form', function () {
			var hubspot_form_id = document.querySelector('.hubspot-form-area');
			if (hubspot_form_id) {
				hubspot_form_id = hubspot_form_id.getAttribute('data-id');
			}

			hbspt.forms.create({
				region: 'na1',
				portalId: '19913802',
				formId: hubspot_form_id,
				target: '.hubspot-form-area',
				css: '',
				onFormReady: function ($form) {
					yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/src/utm-hubspot-form.js', 'HEAD', 'hubspot-form', function () { });

					//Schedule a demo form custom validation
					$form.find('.hs-button').addClass('yb--link-black cta-button-small');

					// Select the select box
					var countrySelect = document.querySelector('.sec-form-with-content .right-form-area .hs-fieldtype-select .input select');
					countrySelect.addEventListener('focus', function () {
						this.closest('.input').classList.add('focus-field');
						if (countrySelect.classList.contains('error')) {
							countrySelect.closest('.input').classList.add('invalid-error');
						} else {
							countrySelect.closest('.input').classList.remove('invalid-error');
						}
					});

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
				},
				 onFormSubmit: function ($form) {
					document.querySelector('.footer-note').style.display = 'none';
				}
				
			});

			if (hubspot_form_id === '1d74a3a7-c687-4fd2-a51d-72a1ec54ac8d') {
				var _demoFormData;
				window.addEventListener('message', function (event) {
					if (!event.data || event.data.type !== 'hsFormCallback') {
						return;
					}
					var formEvent = event.data;
					if (formEvent.eventName === 'onFormSubmit' && !!formEvent.data && formEvent.data.length > 0) {
						_demoFormData = {};
						for (var i = 0, len = formEvent.data.length; i < len; i++) {
							var item = formEvent.data[i];
							if (!!item.name && !!item.value && item.value !== '') {
								_demoFormData[item.name] = item.value;
							}
						}
					} else if (formEvent.eventName === 'onFormSubmitted' && !!_demoFormData && Object.keys(_demoFormData).length > 0) {
						drift.api.collectFormData(_demoFormData, {
							campaignId: 2658681,
							followupUrl: 'https://info.yugabyte.com/thank-you',
						});
					}
				});
			}
		});
	});
}());
