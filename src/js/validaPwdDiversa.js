document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);

    if (params.get("errore") === "password_diverse") {
        const form = document.getElementById("registration-form");

        const node = document.createElement("span");
        
        node.className = "erroreForm";
        node.setAttribute("aria-live", "assertive");
        node.textContent = "Le password non coincidono";
        form.append(node);
    }
  
});