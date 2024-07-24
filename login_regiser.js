document.addEventListener('DOMContentLoaded', function () {
    const signUpButton = document.getElementById('register');
    const signInButton = document.getElementById('login');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', function () {
        container.classList.add('active');
        container.classList.remove('active-sign-in');
    });

    signInButton.addEventListener('click', function () {
        container.classList.remove('active');
        container.classList.add('active-sign-in');
    });

    const eyeRegisterIcon = document.getElementById('eye');
    const passwordRegisterInput = document.querySelector('.sign-up input[type="password"]');
    const eyeLoginIcon = document.getElementById('eye');
    const passwordLoginInput = document.querySelector('.sign-in input[type="password"]');

    eyeRegisterIcon.addEventListener('click', function () {
        togglePasswordVisibility(passwordRegisterInput, eyeRegisterIcon);
    });

    eyeLoginIcon.addEventListener('click', function () {
        togglePasswordVisibility(passwordLoginInput, eyeLoginIcon);
    });
});

function togglePasswordVisibility(inputField, eyeIcon) {
    if (inputField.type === 'password') {
        inputField.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    } else {
        inputField.type = 'password';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }
}

function validateInput() {
    let inputField = document.getElementById('phone_number');
    let inputValue = inputField.value;

    // Remove any characters other than alphanumeric
    inputValue = inputValue.replace(/[^0-9]/g, '');

    // Convert letters to uppercase
    inputValue = inputValue.toUpperCase();

    // Update the input field value
    inputField.value = inputValue;
}

const eyeLoginIcon = document.getElementById('eye-login');
const passwordLoginInput = document.querySelector('.sign-in input[type="password"]');

eyeLoginIcon.addEventListener('click', function () {
    togglePasswordVisibility(passwordLoginInput, eyeLoginIcon);
});
