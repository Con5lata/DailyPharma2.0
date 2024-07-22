function register() {
    const username = document.getElementById('reg-username').value;
    const password = document.getElementById('reg-password').value;

    if (username && password) {
        // In a real app, send this data to the server
        localStorage.setItem('user', JSON.stringify({ username, password }));
        alert('User registered successfully!');
    } else {
        alert('Please enter a username and password.');
    }
}

function login() {
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    const storedUser = JSON.parse(localStorage.getItem('user'));

    if (storedUser && username === storedUser.username && password === storedUser.password) {
        localStorage.setItem('isLoggedIn', 'true');
        document.getElementById('user').innerText = username;
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('logout-button').style.display = 'block';
    } else {
        alert('Invalid username or password.');
    }
}

function logout() {
    localStorage.removeItem('isLoggedIn');
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'block';
    document.getElementById('logout-button').style.display = 'none';
}

window.onload = () => {
    if (localStorage.getItem('isLoggedIn') === 'true') {
        const storedUser = JSON.parse(localStorage.getItem('user'));
        document.getElementById('user').innerText = storedUser.username;
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('logout-button').style.display = 'block';
    }
};
