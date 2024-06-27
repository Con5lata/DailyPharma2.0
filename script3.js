// Handling the overlay
function toggleOverlay() {
  var menu = document.getElementById("menu");
  var menuContent = document.getElementById("menu-content");

  if (menu.style.width === "100%") {
      menu.style.width = "0";
      menuContent.style.display = "none";
  } else {
      menu.style.width = "100%";
      menuContent.style.display = "block";
  }
}

// Function to handle window resize event
function handleResize() {
  var menu = document.getElementById("menu");
  var menuContent = document.getElementById("menu-content");

  if (window.innerWidth > 900) {
      menu.style.width = "0";
      menuContent.style.display = "none";
  }
}

// Call the handleResize function initially and on window resize
handleResize();
window.addEventListener("resize", handleResize);

// Get the necessary elements for the image slider
const slideContainer = document.querySelector('.image-slide');
const slideDescriptions = document.querySelectorAll('.image-desc');
const arrowLeft = document.querySelector('.arrow-left');
const arrowRight = document.querySelector('.arrow-right');

// Initialize the index of the active description
let activeIndex = 0;

// Show the initial active description
slideDescriptions[activeIndex].classList.add('active');

// Function to show the previous description
function showPreviousSlide() {
  slideDescriptions[activeIndex].classList.remove('active');
  activeIndex = (activeIndex - 1 + slideDescriptions.length) % slideDescriptions.length;
  slideDescriptions[activeIndex].classList.add('active');
}

// Function to show the next description
function showNextSlide() {
  slideDescriptions[activeIndex].classList.remove('active');
  activeIndex = (activeIndex + 1) % slideDescriptions.length;
  slideDescriptions[activeIndex].classList.add('active');
}

// Add event listeners to the arrow buttons
arrowLeft.addEventListener('click', showPreviousSlide);
arrowRight.addEventListener('click', showNextSlide);
