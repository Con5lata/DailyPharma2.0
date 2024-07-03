//Handling the overlay
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