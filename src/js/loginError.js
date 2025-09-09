document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);

  if (params.get("errore") === "errore_login") {
    const login = document.getElementById("login");

    const input = document.getElementById("username");

    const node = document.createElement("span");
    node.className = "erroreForm";
    node.setAttribute("role", "alert");
    node.setAttribute("aria-live", "assertive");
    node.textContent = "Nome utente o password sbagliati, riprova";
    login.prepend(node);
    input.focus();
  }

});
