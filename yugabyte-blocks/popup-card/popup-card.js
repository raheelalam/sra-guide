/*-- Add Vid Popup --*/
let vidPopupAdded = false;

function addVidPopup() {
  if (!vidPopupAdded) {
    var vidPopup = document.querySelector('#vid-popup');
    if (!vidPopup) {
      var newDiv = document.createElement('div');
      newDiv.id = 'vid-popup';
      newDiv.innerHTML = '<span class="close-vid"></span><div class="vid-container "><span class="close-vid"></span><div class="vid-box card-popup-box"></div></div>';
      document.body.appendChild(newDiv);
    }
    vidPopupAdded = true;
  }
}

addVidPopup();
/*-- Add Vid Popup --*/

/*--close Vid popup--*/
function handleVidClose(event) {
  const target = event.target;
  if (target.classList.contains('close-vid') || target.parentElement.classList.contains('close-vid')) {
    document.body.classList.add('closing-vid');
    setTimeout(() => {
      document.body.classList.remove('show-vid');
      document.querySelector('.vid-box iframe').remove();
      document.body.classList.remove('closing-vid');
    }, 200);
  }
}

document.body.addEventListener('click', handleVidClose);
/*--close Vid popup--*/

/*--play vid--*/
function showVid(event) {
  const iframe = document.createElement('iframe');
  const target = event.target;
  const vidBox = document.querySelector('.vid-box');
  const videoId = target.getAttribute('data-popup');

  document.body.classList.add('show-vid');

  iframe.src = videoId;
  iframe.setAttribute('allowfullscreen', '');
  iframe.setAttribute('allow', 'autoplay');

  vidBox.innerHTML = '';
  vidBox.appendChild(iframe);
}

var vidElements = document.querySelectorAll('[data-popup]');
vidElements.forEach((element) => {
  element.addEventListener('click', showVid);
});
