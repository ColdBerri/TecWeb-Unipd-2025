document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registration-form");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm-password");

  // Crea e inserisce il messaggio di errore nel DOM
  const errorMessage = document.createElement("div");
  errorMessage.textContent = "Le password non coincidono!";
  errorMessage.style.display = "none";
  errorMessage.style.color = "red"; // Solo per visibilità, toglilo se proprio niente CSS
  confirmPassword.parentNode.insertBefore(errorMessage, confirmPassword.nextSibling);

  function checkPasswords() {
    if (password.value && confirmPassword.value) {
      if (password.value !== confirmPassword.value) {
        errorMessage.style.display = "block";
      } else {
        errorMessage.style.display = "none";
      }
    } else {
      errorMessage.style.display = "none";
    }
  }

  password.addEventListener("input", checkPasswords);
  confirmPassword.addEventListener("input", checkPasswords);

  form.addEventListener("submit", function (e) {
    if (password.value !== confirmPassword.value) {
      e.preventDefault();
      errorMessage.style.display = "block";
      password.value = "";
      confirmPassword.value = "";
    }
  });
});
