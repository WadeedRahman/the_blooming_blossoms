const form = document.querySelector('#signup-form');
const usernameInput = document.querySelector('#username');
const emailInput = document.querySelector('#email');
const passwordInput = document.querySelector('#password');

form.addEventListener('submit', function(event) {
  // Prevent the form from submitting
  event.preventDefault();

  // Validate the username
  if (!validateUsername(usernameInput.value)) {
    alert('Please enter a valid username (3-15 characters)');
    return;
  }

  // Validate the email
  if (!validateEmail(emailInput.value)) {
    alert('Please enter a valid email address');
    return;
  }

  // Validate the password
  if (!validatePassword(passwordInput.value)) {
    alert('Please enter a valid password (at least 8 characters long with at least one uppercase letter, one lowercase letter, and one digit)');
    return;
  }

  // Submit the form
  form.submit();
});

function validateUsername(username) {
  const regex = /^[a-zA-Z0-9_-]{3,15}$/;
  return regex.test(username);
}

function validateEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

function validatePassword(password) {
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
  return regex.test(password);
}
