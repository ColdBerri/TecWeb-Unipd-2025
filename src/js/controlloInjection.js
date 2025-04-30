document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    if (!form) return;
  
    const inputs = form.querySelectorAll("input[type='text'], input[type='password']");
  
    const forbiddenChars = /[<>{}\[\]\\\/;'"`$]/;

    const password = form.querySelector("#password");
    const confirmPassword = form.querySelector("#confirm-password"); // Presente solo in registrazione
  
    form.addEventListener("submit", function (e) {
      let invalid = false;
  
      // Rimuove eventuali messaggi di errore precedenti
      document.querySelectorAll(".inject-error").forEach(err => err.remove());
  
      // Controlla caratteri speciali
      inputs.forEach(input => {
        const value = input.value;
        if (value.trim() !== "" && forbiddenChars.test(value)) {
          showError(input, "Carattere non valido nel campo.");
          invalid = true;
        }
      });
  
      // Controlla solo se siamo in registrazione (dove c'è #confirm-password)
      if (confirmPassword) {
        if (password.value !== confirmPassword.value) {
          showError(confirmPassword, "Le password non coincidono.");
          confirmPassword.value = "";
          confirmPassword.focus();
          invalid = true;
        }
      }
  
      if (invalid) {
        e.preventDefault(); // Blocca il submit
      }
    });
  
    function showError(input, message) {
      const error = document.createElement("div");
      error.className = "inject-error";
      error.style.color = "red";
      error.textContent = message;
      input.parentNode.insertBefore(error, input.nextSibling);
    }

  });
  