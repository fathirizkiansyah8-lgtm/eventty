document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // ELEMENT
    // =========================

    const resetForm =
        document.getElementById("resetPasswordForm");

    const newPasswordInput =
        document.getElementById("new_password");

    const newConfirmPasswordInput =
        document.getElementById(
            "new_password_confirmation"
        );

    const toggleNewPassword =
        document.getElementById("toggleNewPassword");

    const toggleNewConfirmPassword =
        document.getElementById(
            "toggleNewConfirmPassword"
        );

    const newPasswordError =
        document.getElementById("newPasswordError");

    const newPasswordConfirmationError =
        document.getElementById(
            "newPasswordConfirmationError"
        );


    // =========================
    // SHOW / HIDE PASSWORD
    // =========================

    function setupPasswordToggle(button, input) {

        if (!button || !input) {
            return;
        }

        button.addEventListener("click", function () {

            if (input.type === "password") {

                input.type = "text";

                button.textContent = "🙈";

                button.setAttribute(
                    "aria-label",
                    "Sembunyikan password"
                );

            } else {

                input.type = "password";

                button.textContent = "👁";

                button.setAttribute(
                    "aria-label",
                    "Tampilkan password"
                );

            }

        });

    }


    setupPasswordToggle(
        toggleNewPassword,
        newPasswordInput
    );

    setupPasswordToggle(
        toggleNewConfirmPassword,
        newConfirmPasswordInput
    );


    // =========================
    // HAPUS ERROR SAAT MENGETIK
    // =========================

    if (newPasswordInput) {

        newPasswordInput.addEventListener(
            "input",
            function () {

                newPasswordError.textContent = "";

                this.style.borderColor = "";

            }
        );

    }


    if (newConfirmPasswordInput) {

        newConfirmPasswordInput.addEventListener(
            "input",
            function () {

                newPasswordConfirmationError
                    .textContent = "";

                this.style.borderColor = "";

            }
        );

    }


    // =========================
    // SUBMIT RESET PASSWORD
    // =========================

    if (resetForm) {

        resetForm.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                const password =
                    newPasswordInput.value;

                const confirmation =
                    newConfirmPasswordInput.value;


                // =========================
                // RESET ERROR
                // =========================

                newPasswordError.textContent = "";

                newPasswordConfirmationError
                    .textContent = "";

                newPasswordInput.style.borderColor = "";

                newConfirmPasswordInput.style.borderColor = "";


                let valid = true;
                let firstErrorField = null;


                // =========================
                // PASSWORD KOSONG
                // =========================

                if (password.trim() === "") {

                    newPasswordError.textContent =
                        "Password baru wajib diisi.";

                    newPasswordInput.style.borderColor =
                        "#dc2626";

                    valid = false;

                    firstErrorField =
                        newPasswordInput;

                }


                // =========================
                // MINIMAL 8 KARAKTER
                // =========================

                else if (password.length < 8) {

                    newPasswordError.textContent =
                        "Password minimal 8 karakter.";

                    newPasswordInput.style.borderColor =
                        "#dc2626";

                    valid = false;

                    firstErrorField =
                        newPasswordInput;

                }


                // =========================
                // KONFIRMASI KOSONG
                // =========================

                if (confirmation.trim() === "") {

                    newPasswordConfirmationError
                        .textContent =
                        "Konfirmasi password wajib diisi.";

                    newConfirmPasswordInput.style.borderColor =
                        "#dc2626";

                    valid = false;

                    if (!firstErrorField) {

                        firstErrorField =
                            newConfirmPasswordInput;

                    }

                }


                // =========================
                // PASSWORD TIDAK SAMA
                // =========================

                else if (password !== confirmation) {

                    newPasswordConfirmationError
                        .textContent =
                        "Password dan konfirmasi password tidak cocok.";

                    newConfirmPasswordInput.style.borderColor =
                        "#dc2626";

                    valid = false;

                    if (!firstErrorField) {

                        firstErrorField =
                            newConfirmPasswordInput;

                    }

                }


                // =========================
                // JIKA ERROR
                // =========================

                if (!valid) {

                    if (firstErrorField) {
                        firstErrorField.focus();
                    }

                    return;

                }


                // =========================
                // BERHASIL
                // =========================

                newPasswordInput.style.borderColor =
                    "#22c55e";

                newConfirmPasswordInput.style.borderColor =
                    "#22c55e";


                /*
                 * Untuk sementara:
                 * setelah password valid,
                 * kembali ke halaman login.
                 */

                window.location.href = "/login";

            }
        );

    }

});