(function () {
	var _formData;

	/**
	 * Lateload Hubspot form.
	 */
	function lateloadHubspotForm() {
		var formId;
		var script = document.createElement('script');

		if (document.querySelector('.yb-contact-form') && !document.querySelector('.yb-contact-form').classList.contains('loaded')) {
			document.querySelector('.yb-contact-form').classList.add('loaded');
			formId = document.querySelector('.yb-contact-form').getAttribute('data-form-id');

			script = document.createElement('script');
			script.type = 'text/javascript';
			script.src = '//js.hsforms.net/forms/v2.js';

			document.head.appendChild(script);
			script.onload = function () {
				hbspt.forms.create({
					region: 'na1',
					portalId: '19913802',
					formId: formId,
					submitButtonClass: 'yb-input-button',
					target: '.yb-contact-form',
					onFormReady: function () {
						var script = document.createElement('script');

						script.type = 'text/javascript';
						script.src = '/wp-content/themes/yugabyte/assets/js/utm-hubspot-form.min.js';
						const selectElement = document.querySelector('.yb-contact-form form .field.hs-fieldtype-select[class*="chat_about"] select');
						const firstOption = selectElement.querySelector('option:first-child');
						firstOption.textContent = 'Chat About*';
					},
					css: '',
				});
			}
		}
	}

	setTimeout(lateloadHubspotForm, 15000);
	document.addEventListener('scroll', lateloadHubspotForm);
	document.querySelector('body').addEventListener('mouseover', lateloadHubspotForm);

	window.addEventListener('message', function (event) {
		if (!event.data || event.data.type !== 'hsFormCallback') {
			return;
		}
		var formEvent = event.data;
		if (formEvent.eventName === 'onFormSubmit' && !!formEvent.data && formEvent.data.length > 0) {
			_formData = {};
			for (var i = 0, len = formEvent.data.length; i < len; i++) {
				var item = formEvent.data[i];
				if (!!item.name && !!item.value && item.value !== '') {
					_formData[item.name] = item.value;
				}
			}
		} else if (formEvent.eventName === 'onFormSubmitted' && !!_formData && Object.keys(_formData).length > 0) {
			drift.api.collectFormData(_formData, {
				campaignId: 2660236,
				followupUrl: 'https://info.yugabyte.com/thank-you',
			});
		}
	});
})();
