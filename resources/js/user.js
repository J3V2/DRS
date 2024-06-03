import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".dropbtn").addEventListener("click", function () {
        const dropdownContent = document.querySelector(".dropdown-content");
        dropdownContent.classList.toggle("hidden");
    });
});
