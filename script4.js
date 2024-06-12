const categoryItems = document.querySelectorAll('.category-item');
const categoryContents = document.querySelectorAll('.category-content');

categoryItems.forEach((item) => {
  item.addEventListener('click', function () {
    const selectedCategory = this.getAttribute('data-category');

    // Hide all category contents
    categoryContents.forEach((content) => {
      content.classList.remove('show');
    });

    // Show the selected category content
    const selectedContent = document.querySelector(
      `.category-content[data-category="${selectedCategory}"]`
    );
    selectedContent.classList.add('show');
  });
});




// Function to handle category item click
function handleCategoryClick(event) {
  const selectedCategory = event.target.dataset.category;
  categoryItems.forEach((item) => {
    item.classList.remove('active');
  });
  event.target.classList.add('active');
  showCategoryContent(selectedCategory);
}

// Add event listeners to category items
categoryItems.forEach((item) => {
  item.addEventListener('click', handleCategoryClick);
});

// Function to show the next category content
function showNextCategory() {
  const currentCategory = document.querySelector('.category-content.active');
  const nextCategory = currentCategory.nextElementSibling || categoryContent[0];
  const selectedCategory = nextCategory.getAttribute('id');
  showCategoryContent(selectedCategory);
  updateCategoryItemActive(selectedCategory);
}

// Function to show the previous category content
function showPreviousCategory() {
  const currentCategory = document.querySelector('.category-content.active');
  const previousCategory = currentCategory.previousElementSibling || categoryContent[categoryContent.length - 1];
  const selectedCategory = previousCategory.getAttribute('id');
  showCategoryContent(selectedCategory);
  updateCategoryItemActive(selectedCategory);
}

// Function to update active class on category item
function updateCategoryItemActive(selectedCategory) {
  categoryItems.forEach((item) => {
    item.classList.remove('active');
    if (item.dataset.category === selectedCategory) {
      item.classList.add('active');
    }
  });
}

// Add event listeners to the arrow buttons
arrowLeft.addEventListener('click', showPreviousCategory);
arrowRight.addEventListener('click', showNextCategory);
