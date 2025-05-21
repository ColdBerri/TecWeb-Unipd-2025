document.addEventListener("DOMContentLoaded", function () {
    if (sessionStorage.getItem("scrollY") !== null) {
        window.scrollTo(0, parseInt(sessionStorage.getItem("scrollY"), 10));
        sessionStorage.removeItem("scrollY"); 
    }
    const formC = document.querySelector(".formCategorie");
    formC.addEventListener("submit", function () {
        sessionStorage.setItem("scrollY", window.scrollY);
    });
});
