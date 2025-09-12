document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);

    if (params.get("errore") === "password_diverse") {
      const form = document.getElementById("modifica-form");
    
      const node = document.createElement("span");
      node.className = "erroreForm";
      node.setAttribute("role", "alert");
      node.setAttribute("aria-live", "assertive");
      node.textContent = "Le password non coincidono";
      form.prepend(node);
    }
  
});