document.addEventListener('DOMContentLoaded', () => {
    const cartButtons = document.querySelectorAll('.number');

    cartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    });

    function addToCart(event) {
        const productElement = event.target.closest('.single-pro-details');
        const product = {
            name: productElement.querySelector('h4').textContent,
            price: productElement.querySelector('h2').textContent,
            quantity: productElement.querySelector('#quantity').value,
            image: document.querySelector('.single-pro-image img').src
        };

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push(product);
        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Item added to cart!');
    }
});
