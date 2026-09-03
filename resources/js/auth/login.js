document.addEventListener("DOMContentLoaded", function () {


    // =====================================================
    // ELEMENT
    // =====================================================

    const nameInput =
        document.getElementById("name");

    const nisInput =
        document.getElementById("nis");

    const passwordInput =
        document.getElementById("password");


    const togglePassword =
        document.getElementById("togglePassword");


    const themeToggle =
        document.getElementById("themeToggleCheckbox");


    const loginForm =
        document.getElementById("loginForm");


    const nameError =
        document.getElementById("nameError");

    const nisError =
        document.getElementById("nisError");

    const passwordError =
        document.getElementById("passwordError");


    // =====================================================
    // SHOW / HIDE PASSWORD
    // =====================================================

    if (passwordInput && togglePassword) {

        togglePassword.addEventListener(
            "click",
            function () {

                if (
                    passwordInput.type ===
                    "password"
                ) {

                    passwordInput.type =
                        "text";

                    togglePassword.textContent =
                        "🙈";

                    togglePassword.setAttribute(
                        "aria-label",
                        "Sembunyikan password"
                    );

                } else {

                    passwordInput.type =
                        "password";

                    togglePassword.textContent =
                        "👁";

                    togglePassword.setAttribute(
                        "aria-label",
                        "Tampilkan password"
                    );

                }

            }
        );

    }


    // =====================================================
    // THEME
    // =====================================================

    const savedTheme =
        localStorage.getItem("theme") ||
        "dark";


    if (savedTheme === "light") {

        document.body.setAttribute(
            "data-theme",
            "light"
        );

        if (themeToggle) {
            themeToggle.checked = true;
        }

    } else {

        document.body.setAttribute(
            "data-theme",
            "dark"
        );

        if (themeToggle) {
            themeToggle.checked = false;
        }

    }


    // =====================================================
    // CHANGE THEME
    // =====================================================

    if (themeToggle) {

        themeToggle.addEventListener(
            "change",
            function () {

                const newTheme =
                    themeToggle.checked
                        ? "light"
                        : "dark";


                document.body.setAttribute(
                    "data-theme",
                    newTheme
                );


                localStorage.setItem(
                    "theme",
                    newTheme
                );

            }
        );

    }


    // =====================================================
    // VALIDASI LOGIN
    // =====================================================

    if (
        loginForm &&
        nameInput &&
        nisInput &&
        passwordInput
    ) {


        loginForm.addEventListener(
            "submit",
            function (event) {

                const name =
                    nameInput.value.trim();

                const nis =
                    nisInput.value.trim();

                const password =
                    passwordInput.value;


                let hasError = false;


                // -----------------------------------------
                // RESET ERROR
                // -----------------------------------------

                nameError.textContent = "";

                nisError.textContent = "";

                passwordError.textContent = "";


                // -----------------------------------------
                // NAMA
                // -----------------------------------------

                if (name === "") {

                    nameError.textContent =
                        "Nama Lengkap wajib diisi.";

                    hasError = true;

                }


                // -----------------------------------------
                // NIS
                // -----------------------------------------

                if (nis === "") {

                    nisError.textContent =
                        "NIS wajib diisi.";

                    hasError = true;

                } else if (!/^\d{4,10}$/.test(nis)) {

                    nisError.textContent =
                        "NIS harus berupa angka (4-10 digit).";

                    hasError = true;

                }


                // -----------------------------------------
                // PASSWORD
                // -----------------------------------------

                if (password.trim() === "") {

                    passwordError.textContent =
                        "Password wajib diisi.";

                    hasError = true;

                } else if (password.length < 6) {

                    passwordError.textContent =
                        "Password minimal 6 karakter.";

                    hasError = true;

                }


                // -----------------------------------------
                // STOP SUBMIT jika ada error validasi
                // -----------------------------------------

                if (hasError) {

                    event.preventDefault();

                    const fields = [
                        {
                            input: nameInput,
                            error: nameError
                        },
                        {
                            input: nisInput,
                            error: nisError
                        },
                        {
                            input: passwordInput,
                            error: passwordError
                        }
                    ];

                    const firstError =
                        fields.find(
                            (field) =>
                                field.error.textContent
                        );

                    if (firstError) {
                        firstError.input.focus();
                    }

                    return;
                }

                loginForm.submit();
            }
        );


        // =================================================
        // HAPUS ERROR SAAT USER MENGETIK
        // =================================================

        [nameInput, nisInput, passwordInput]
            .forEach(function (input) {

                input.addEventListener(
                    "input",
                    function () {

                        const errorElement =
                            document.getElementById(
                                `${this.id}Error`
                            );


                        if (errorElement) {

                            errorElement.textContent =
                                "";

                        }

                    }
                );

            });

    }

});
