// Function to validate password
function validatePassword(password) {
    // Regular expression to match password requirements
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    // Check if password matches the regex
    if (passwordRegex.test(password)) {
        return true;
    } else {
        return false;
    }
}

// Function to display error message
function displayErrorMessage(message) {
    document.getElementById('password-error').innerHTML = message;
}

// Function to clear error message
function clearErrorMessage() {
    document.getElementById('password-error').innerHTML = '';
}

// Event listener for password input
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    if (validatePassword(password)) {
        clearErrorMessage();
    } else {
        displayErrorMessage('Password must be at least 8 characters, include one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).');
    }
});

// Event listener for form submission
document.getElementById('register-form').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    if (!validatePassword(password)) {
        event.preventDefault();
        displayErrorMessage('Password does not meet the requirements.');
    }
});
