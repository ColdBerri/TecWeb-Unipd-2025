// Attendi che il DOM sia completamente caricato
document.addEventListener("DOMContentLoaded", function () {
    // Seleziona il form e i campi con gli stessi id del tuo HTML
    const form = document.getElementById("registration-form");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");
  
    form.addEventListener("submit", function (e) {
      // Se le password NON coincidono, blocchi l'invio
      if (password.value !== confirmPassword.value) {
        e.preventDefault();
        alert("Le password non coincidono!");
        password.style.border = "2px solid red";
        confirmPassword.style.border = "2px solid red";
      }
    });
  });
  
