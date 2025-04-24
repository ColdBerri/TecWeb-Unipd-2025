document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registration-form");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm-password");

  // Crea il messaggio di errore una volta sola
  const errorMessage = document.createElement("div");
  errorMessage.textContent = "Le password non coincidono.";
  errorMessage.style.color = "red";
  errorMessage.style.display = "none";
  errorMessage.className = "password-error";

  // Inserisce il messaggio SOPRA il campo conferma
  confirmPassword.parentNode.insertBefore(errorMessage, confirmPassword);

  // Mostra errore se le password non coincidono al "blur"
  confirmPassword.addEventListener("blur", function () {
    if (password.value && confirmPassword.value && password.value !== confirmPassword.value) {
      errorMessage.style.display = "block";
    }
  });

  // Nasconde errore se si riseleziona il campo
  confirmPassword.addEventListener("focus", function () {
    errorMessage.style.display = "none";
  });

  // Controllo finale al submit
  form.addEventListener("submit", function (e) {
    if (password.value !== confirmPassword.value) {
      e.preventDefault();
      confirmPassword.value = "";
      confirmPassword.focus();
    }
  });
});
