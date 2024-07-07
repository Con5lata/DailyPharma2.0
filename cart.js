// cart.js

document.addEventListener('DOMContentLoaded', () => {
    const cartButtons = document.querySelectorAll('.cart');
    let cart = loadCartFromLocalStorage();

    cartButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const productElement = button.closest('.pro');
            const product = {
                name: productElement.querySelector('.des h5').innerText,
                price: productElement.querySelector('.des h4').innerText,
                image: productElement.querySelector('img').src,
                quantity: 1
            };
            addToCart(product);
            saveCartToLocalStorage();
            updateCart();
        });
    });

    function addToCart(product) {
        const existingProduct = cart.find(item => item.name === product.name);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push(product);
        }
    }

    function updateCart() {
        const cartTable = document.querySelector('#cart tbody');
        cartTable.innerHTML = '';
        cart.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><a href="#" class="remove" data-name="${product.name}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                <td><img src="${product.image}" alt=""></td>
                <td>${product.name}</td>
                <td>${product.price}</td>
                <td><input type="number" value="${product.quantity}" data-name="${product.name}" min="1"></td>
                <td>Ksh${product.quantity * parseInt(product.price.replace('Ksh', ''))}</td>
            `;
            cartTable.appendChild(row);
        });
        attachRemoveListeners();
        attachQuantityChangeListeners();
    }

    function attachRemoveListeners() {
        const removeButtons = document.querySelectorAll('.remove');
        removeButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const name = button.getAttribute('data-name');
                cart = cart.filter(product => product.name !== name);
                saveCartToLocalStorage();
                updateCart();
            });
        });
    }

    function attachQuantityChangeListeners() {
        const quantityInputs = document.querySelectorAll('input[type="number"]');
        quantityInputs.forEach(input => {
            input.addEventListener('change', (event) => {
                const name = input.getAttribute('data-name');
                const quantity = parseInt(input.value);
                const product = cart.find(item => item.name === name);
                if (product) {
                    product.quantity = quantity;
                    saveCartToLocalStorage();
                    updateCart();
                }
            });
        });
    }

    function saveCartToLocalStorage() {
        localStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    function loadCartFromLocalStorage() {
        const savedCart = localStorage.getItem('shoppingCart');
        return savedCart ? JSON.parse(savedCart) : [];
    }

    if (document.querySelector('#cart')) {
        updateCart();
    }
});
