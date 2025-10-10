(function () {
  let isSmallScreen = window.innerWidth < 767;
  let isScrolling = false;
  function checkElementPosition() {
    let elements = document.querySelectorAll(".copy-card-flip");
    elements.forEach(function(element) {
      let elementPosition = element.getBoundingClientRect().top;
      if (elementPosition >= -70 && elementPosition <= 300) {
        element.classList.add("active");
      } else {
        element.classList.remove("active");
      }
    });
  }
  if (isSmallScreen) {
    checkElementPosition();
  }
  window.addEventListener("resize", function() {
    isSmallScreen = window.innerWidth < 767;
    if (isSmallScreen) {
      checkElementPosition();
    } else {
      document.querySelectorAll(".copy-card-flip").forEach(function(element) {
        element.classList.remove("active");
      });
    }
  });
  window.addEventListener("scroll", function() {
    if (!isScrolling) {
      isScrolling = true;
      setTimeout(function() {
        checkElementPosition();
        isScrolling = false;
      }, 300);
    }
  });
}());