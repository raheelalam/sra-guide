(function () {
  const tabs = document.querySelectorAll('.yb-sample-app-tabs .tab');
  const contents = document.querySelectorAll('.yb-sample-app-window  .content');

  tabs.forEach((current) => {
    current.addEventListener("click", () => {
      const dataValue = current.dataset.tab;
      const indexVal = dataValue - 1;
      tabs.forEach(tab => tab.classList.remove('active'));
      contents.forEach(contents => contents.classList.remove('active'));
      current.classList.add('active');
      contents[indexVal].classList.add('active');
    });
  });

}());