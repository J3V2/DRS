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

// resources/js/app.js
import { PDFDocument } from "pdf-lib";
import SignaturePad from "signature_pad";
import axios from "axios";

document.getElementById("upload-form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const response = await axios.post(e.target.action, formData);
    const url = response.data.url;

    const signaturePad = new SignaturePad(
        document.getElementById("signature-pad")
    );

    document
        .getElementById("save-signature")
        .addEventListener("click", async () => {
            const signatureDataUrl = signaturePad.toDataURL();
            await axios.post(
                "/pdf/edit",
                {
                    pdf_url: url,
                    edits: [
                        { page: 0, text: "Edited Text", x: 50, y: 700 },
                        {
                            page: 0,
                            image: signatureDataUrl,
                            x: 50,
                            y: 650,
                            width: 200,
                            height: 100,
                        },
                    ],
                },
                {
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                }
            );
        });
});
