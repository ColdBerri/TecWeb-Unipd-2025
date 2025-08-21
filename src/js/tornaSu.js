document.addEventListener("DOMContentLoaded", function() {
    const tornaSu = document.querySelector(".tornaSU");

window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        tornaSu.classList.add("show");
    } else {
        tornaSu.classList.remove("show");
    }
});
});