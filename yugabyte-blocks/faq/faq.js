(function () {
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('yb-faq-q')) {
      var faqItem = event.target.closest('.yb-faq-item');

      if (faqItem.classList.contains('open')) {
        faqItem.classList.remove('open');
      } else {
        var openFaqItem = document.querySelector('.yb-faq-item.open');
        if (openFaqItem) {
          openFaqItem.classList.remove('open');
        }
        faqItem.classList.add('open');
      }
    }
  });
}());