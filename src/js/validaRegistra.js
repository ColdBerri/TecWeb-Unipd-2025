document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);

    if (params.get("errore") === "utente_esiste") {
      const form = document.getElementById("registration-form");
    
      const node = document.createElement("span");
      node.className = "erroreForm";
      node.setAttribute("role", "alert");
      node.setAttribute("aria-live", "assertive");
      node.textContent = "Utente già registrato";
      form.prepend(node);
    
    } else if (params.get("errore") === "password_diverse") {
      const form = document.getElementById("registration-form");
    
      const node = document.createElement("span");
      node.className = "erroreForm";
      node.setAttribute("role", "alert");
      node.setAttribute("aria-live", "assertive");
      node.textContent = "Le password non coincidono";
      form.prepend(node);
    }
  
});