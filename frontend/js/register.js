document.getElementById("registerForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("name");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirmPassword");

  let isValid = true;

  // Name validation
  if (name.value.trim().length < 3) {
    name.classList.add("is-invalid");
    isValid = false;
  } else {
    name.classList.remove("is-invalid");
  }

  // Email validation
  if (!email.value.includes("@") || !email.value.includes(".")) {
    email.classList.add("is-invalid");
    isValid = false;
  } else {
    email.classList.remove("is-invalid");
  }

  // Password validation
  if (password.value.length < 6) {
    password.classList.add("is-invalid");
    isValid = false;
  } else {
    password.classList.remove("is-invalid");
  }

  // Confirm password
  if (confirmPassword.value !== password.value || confirmPassword.value === "") {
    confirmPassword.classList.add("is-invalid");
    isValid = false;
  } else {
    confirmPassword.classList.remove("is-invalid");
  }

  if (isValid) {
    alert("Registration successful! 🌸");
  }
});
