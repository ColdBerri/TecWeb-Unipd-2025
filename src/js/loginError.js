document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);

  if (params.get("errore") === "errore_login") {
    const login = document.getElementById("login");

    const node = document.createElement("span");
    node.className = "erroreForm";
    node.setAttribute("aria-live", "assertive");
    node.textContent = "Nome utente o password sbagliati, riprova";

    login.prepend(node);
  }

});
