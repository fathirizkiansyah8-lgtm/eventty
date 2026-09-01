document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // ELEMENT
    // =========================

    const registerForm = document.getElementById("registerForm");

    const nameInput = document.getElementById("name");
    const classInput = document.getElementById("class");
    const nisInput = document.getElementById("nis");

    const passwordInput = document.getElementById("password");
    const confirmPasswordInput =
        document.getElementById("password_confirmation");

    const togglePassword =
        document.getElementById("togglePassword");

    const toggleConfirmPassword =
        document.getElementById("toggleConfirmPassword");

    const nameError =
        document.getElementById("nameError");

    const classError =
        document.getElementById("classError");

    const nisError =
        document.getElementById("nisError");

    const passwordError =
        document.getElementById("passwordError");

    const confirmPasswordError =
        document.getElementById("confirmPasswordError");


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
        togglePassword,
        passwordInput
    );

    setupPasswordToggle(
        toggleConfirmPassword,
        confirmPasswordInput
    );


    // =========================
    // NIS HANYA ANGKA
    // MAKSIMAL 5 ANGKA
    // =========================

    if (nisInput) {

        nisInput.addEventListener("input", function () {

            this.value = this.value
                .replace(/\D/g, "")
                .slice(0, 5);

            if (this.value.length > 0) {
                nisError.textContent = "";
            }

        });

    }


    // =========================
    // HILANGKAN ERROR SAAT MENGETIK
    // =========================

    function clearErrorOnInput(input, errorElement) {

        if (!input || !errorElement) {
            return;
        }

        input.addEventListener("input", function () {

            errorElement.textContent = "";

            input.style.borderColor = "";

        });

    }


    clearErrorOnInput(nameInput, nameError);
    clearErrorOnInput(classInput, classError);
    clearErrorOnInput(nisInput, nisError);
    clearErrorOnInput(passwordInput, passwordError);
    clearErrorOnInput(
        confirmPasswordInput,
        confirmPasswordError
    );


    // =========================
    // VALIDASI REGISTER
    // =========================

    if (registerForm) {

        registerForm.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                // =========================
                // NILAI INPUT
                // =========================

                const name =
                    nameInput.value.trim();

                const classValue =
                    classInput.value.trim();

                const nis =
                    nisInput.value.trim();

                const password =
                    passwordInput.value;

                const confirmation =
                    confirmPasswordInput.value;


                // =========================
                // RESET ERROR
                // =========================

                nameError.textContent = "";
                classError.textContent = "";
                nisError.textContent = "";
                passwordError.textContent = "";
                confirmPasswordError.textContent = "";

                confirmPasswordInput.style.borderColor = "";


                let valid = true;
                let firstErrorField = null;


                // =========================
                // NAMA
                // =========================

                if (name === "") {

                    nameError.textContent =
                        "Nama lengkap wajib diisi.";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField = nameInput;
                    }

                }


                // =========================
                // KELAS
                // =========================

                if (classValue === "") {

                    classError.textContent =
                        "Kelas & jurusan wajib diisi.";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField = classInput;
                    }

                }


                // =========================
                // NIS
                // =========================

                if (nis === "") {

                    nisError.textContent =
                        "NIS wajib diisi.";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField = nisInput;
                    }

                } else if (!/^\d{5}$/.test(nis)) {

                    nisError.textContent =
                        "NIS harus terdiri dari 5 angka.";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField = nisInput;
                    }

                }


                // =========================
                // PASSWORD
                // =========================

                if (password.trim() === "") {

                    passwordError.textContent =
                        "Password wajib diisi.";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField = passwordInput;
                    }

                } else if (password.length < 6) {

                    passwordError.textContent =
                        "Password minimal 6 karakter.";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField = passwordInput;
                    }

                }


                // =========================
                // KONFIRMASI PASSWORD
                // =========================

                if (confirmation.trim() === "") {

                    confirmPasswordError.textContent =
                        "Konfirmasi password wajib diisi.";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField =
                            confirmPasswordInput;
                    }

                } else if (password !== confirmation) {

                    confirmPasswordError.textContent =
                        "Password dan konfirmasi password tidak cocok.";

                    confirmPasswordInput.style.borderColor =
                        "#dc2626";

                    valid = false;

                    if (!firstErrorField) {
                        firstErrorField =
                            confirmPasswordInput;
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
                // SUBMIT KE SERVER
                // =========================

                // Loading state pada tombol
                const submitBtn = registerForm.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Memproses...';
                }

                // Submit form ke /register → data tersimpan di DB → redirect ke /login
                registerForm.submit();

            }
        );

    }

});
