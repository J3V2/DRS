import "./bootstrap";

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
