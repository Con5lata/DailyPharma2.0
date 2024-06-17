
document.addEventListener('DOMContentLoaded', () => {
const cartButton = document.querySelector('.cart');
const productCards = document.querySelectorAll('.product-card');
const productDetails = document.querySelector('.product-details');
const shoppingCart = document.querySelector('.shopping-cart');

cartButton.addEventListener('click', () => {
productDetails.style.display = 'none';
shoppingCart.style.display = 'block';
});

productCards.forEach(card => {
card.addEventListener('click', () => {
    const productName = card.querySelector('h3').innerText;
    const productPrice = card.querySelector('p').innerText;
    const productImage = card.querySelector('img').src;

    productDetails.querySelector('h2').innerText = productName;
    productDetails.querySelector('.price').innerText = productPrice;
    productDetails.querySelector('img').src = productImage;
    productDetails.style.display = 'flex';
    shoppingCart.style.display = 'none';
});
});
});
