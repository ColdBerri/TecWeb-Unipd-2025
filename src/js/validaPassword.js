document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registration-form");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm-password");
  const submitBtn = form.querySelector('input[type="submit"]');

  const errorMessage = document.createElement("div");
  errorMessage.textContent = "Le password non coincidono!";
  errorMessage.style.display = "none";
  errorMessage.style.color = "red";
  confirmPassword.parentNode.insertBefore(errorMessage, confirmPassword.nextSibling);

  let touched = false;

  function validaPasswords() {
    const match = password.value === confirmPassword.value;
    const filled = password.value && confirmPassword.value;

    if (!filled || !match) {
      if (touched && filled) {
        errorMessage.style.display = "block";
      }
      submitBtn.disabled = true;
    } else {
      errorMessage.style.display = "none";
      submitBtn.disabled = false;
    }
  }

  confirmPassword.addEventListener("blur", function () {
    touched = true;
    validaPasswords();
  });

  password.addEventListener("input", validaPasswords);
  confirmPassword.addEventListener("input", validaPasswords);

  form.addEventListener("submit", function (e) {
    if (password.value !== confirmPassword.value) {
      e.preventDefault();
      errorMessage.style.display = "block";
      confirmPassword.value = "";
      confirmPassword.focus();
      submitBtn.disabled = true;
    }
  });

  validaPasswords();
});
