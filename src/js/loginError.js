document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  const error = params.get("error");

  if (error) {
    const div = document.createElement("div");
    div.textContent = decodeURIComponent(error);
    div.style.color = "red";
    // Dove vuoi mostrarlo? Per esempio sopra il form:
    const form = document.querySelector("form");
    form.parentNode.insertBefore(div, form);
  }
});
