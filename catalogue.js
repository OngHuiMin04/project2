document.addEventListener('DOMContentLoaded', (event) => {
  initSlideshows();
});

function initSlideshows() {
  let slideshows = document.querySelectorAll('.slideshow-container');
  slideshows.forEach(slideshow => {
      showSlides(0, slideshow.id);
  });
}

let slideIndices = {};

function showSlides(index, id) {
  let slides = document.querySelectorAll(`#${id} .mySlides`);
  slideIndices[id] = index;
  if (index >= slides.length) {
      slideIndices[id] = 0;
  }
  if (index < 0) {
      slideIndices[id] = slides.length - 1;
  }
  for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = 'none';
  }
  slides[slideIndices[id]].style.display = 'block';
}

function plusSlides(n, id) {
  showSlides(slideIndices[id] + n, id);
}


