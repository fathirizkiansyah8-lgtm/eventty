document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // ELEMENT
    // =========================

    const forgotForm =
        document.getElementById("forgotPasswordForm");

    const nisInput =
        document.getElementById("forgotNis");

    const nisError =
        document.getElementById("forgotNisError");


    // =========================
    // NIS HANYA ANGKA
    // MAKSIMAL 5 ANGKA
    // =========================

    if (nisInput) {

        nisInput.addEventListener("input", function () {

            this.value = this.value
                .replace(/\D/g, "")
                .slice(0, 5);

            if (nisError) {
                nisError.textContent = "";
            }

            this.style.borderColor = "";

        });

    }


    // =========================
    // SUBMIT
    // =========================

    if (forgotForm) {

        forgotForm.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                const nis =
                    nisInput.value.trim();


                // =========================
                // RESET ERROR
                // =========================

                nisError.textContent = "";

                nisInput.style.borderColor = "";


                // =========================
                // NIS KOSONG
                // =========================

                if (nis === "") {

                    nisError.textContent =
                        "NIS wajib diisi.";

                    nisInput.style.borderColor =
                        "#dc2626";

                    nisInput.focus();

                    return;

                }


                // =========================
                // NIS HARUS 5 ANGKA
                // =========================

                if (!/^\d{5}$/.test(nis)) {

                    nisError.textContent =
                        "NIS harus terdiri dari 5 angka.";

                    nisInput.style.borderColor =
                        "#dc2626";

                    nisInput.focus();

                    return;

                }


                // =========================
                // VALID
                // =========================

                nisInput.style.borderColor =
                    "#22c55e";


                /*
                 * Untuk sementara kita kirim NIS
                 * ke halaman reset melalui URL.
                 *
                 * Contoh:
                 * /reset-password?nis=12345
                 */

                window.location.href =
                    "/reset-password?nis=" +
                    encodeURIComponent(nis);

            }
        );

    }

});