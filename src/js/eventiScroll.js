document.addEventListener("DOMContentLoaded", function () {
    if (sessionStorage.getItem("scrollY") !== null) {
        window.scrollTo(0, parseInt(sessionStorage.getItem("scrollY"), 10));
        sessionStorage.removeItem("scrollY"); 
    }

    const form = document.querySelector("form.formCalendario");
    form.addEventListener("submit", function () {
        sessionStorage.setItem("scrollY", window.scrollY);
    });
});
