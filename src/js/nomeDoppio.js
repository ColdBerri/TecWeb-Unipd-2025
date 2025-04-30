document.addEventListener("DOMContentLoaded", function () {
    const erroreDiv = document.getElementById("errore-server");
  
    if (erroreDiv) {
      const messaggio = erroreDiv.dataset.messaggio;
  
      if (messaggio) {
        const div = document.createElement("div");
        div.textContent = decodeURIComponent(messaggio);
        div.style.color = "red";
        div.setAttribute("role", "alert");
        div.setAttribute("aria-live", "polite");
  
        const form = document.querySelector("form");
        form.parentNode.insertBefore(div, form);
      }
    }
  });
  