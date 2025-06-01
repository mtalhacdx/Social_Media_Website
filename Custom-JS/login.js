const toggleLoginPassword = document.querySelector('.toggle-password');
const loginPasswordField = document.getElementById('loginPassword');
const loginToggleIcon = document.getElementById('loginToggleIcon');

toggleLoginPassword.addEventListener('click', function () {
  const type = loginPasswordField.type === 'password' ? 'text' : 'password';
  loginPasswordField.type = type;
  loginToggleIcon.classList.toggle('fa-eye');
  loginToggleIcon.classList.toggle('fa-eye-slash');
});