document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);

  if (params.get("errore") === "errore_login") {
    const msg = document.createElement("div");
    msg.textContent = "Nome utente o password sbagliati, Riprova";
    msg.style.color = "red";
    msg.style.margin = "0.5em 0";

    const usernameLabel = document.querySelector('label[for="username"]');

    // Inserisce il messaggio sopra il label "Username"
    if (usernameLabel) {
      usernameLabel.parentNode.insertBefore(msg, usernameLabel);
    }

    // Pulizia dell'URL
    params.delete("errore");
    const newUrl = window.location.pathname +
                   (params.toString() ? "?" + params.toString() : "");
    window.history.replaceState({}, "", newUrl);

    // Reset del form
    const form = document.getElementById("regForm");
    if (form) form.reset();
  }
});
