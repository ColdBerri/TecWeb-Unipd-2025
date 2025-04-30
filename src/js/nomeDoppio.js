document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
  
    if (params.get("errore") === "utente_esiste") {
      const msg = document.createElement("div");
      msg.textContent = "Questo nome utente è già in uso.";
      msg.style.color = "red";
      msg.style.margin = "0.5em 0";
  
      const usernameField = document.getElementById("username");
      if (usernameField) {
        usernameField.parentNode.insertBefore(msg, usernameField);
      } else {
        const form = document.getElementById("regForm");
        if (form) {
          form.insertBefore(msg, form.firstChild);
        } else {
          document.body.insertBefore(msg, document.body.firstChild);
        }
      }
  
      params.delete("errore");
      const newUrl = window.location.pathname +
                     (params.toString() ? "?" + params.toString() : "");
      window.history.replaceState({}, "", newUrl);
  
      const form = document.getElementById("regForm");
      if (form) form.reset();
    }
  });
  