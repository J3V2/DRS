import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    const dateTimePicker = document.getElementById("dateTimePicker");
    if (dateTimePicker) {
        dateTimePicker.addEventListener("change", function (event) {
            console.log(event.target.value);
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".dropbtn").addEventListener("click", function () {
        const dropdownContent = document.querySelector(".dropdown-content");
        dropdownContent.classList.toggle("hidden");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const notificationIcon = document.querySelector(".notification-btn");
    const dropdownMenu = document.getElementById("notif");

    if (notificationIcon && dropdownMenu) {
        notificationIcon.addEventListener("click", function () {
            dropdownMenu.classList.toggle("hidden");
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const notificationButton = document.querySelector(".notification-button");
    const notificationDropdown = notificationButton.nextElementSibling;
    const notificationDot =
        notificationButton.querySelector(".notification-dot");

    notificationButton.addEventListener("click", function () {
        notificationDropdown.classList.toggle("hidden");
        notificationDot.style.display =
            notificationDot.style.display === "none" ? "block" : "none";
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("add");

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});
