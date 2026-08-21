<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reset Password - Eventty</title>

    @vite(['resources/css/auth/reset-password.css'])

</head>

<body>

    <main class="reset-page">

        <!-- =========================
             VISUAL SEKOLAH
        ========================== -->

        <section class="reset-visual">

            <img
                src="{{ asset('images/ilustrasi-logo.png') }}"
                alt="Ilustrasi Sekolah"
            >

            <div class="reset-visual-text">

                <h1>
                    Buat Password Baru
                </h1>

                <p>
                    Buat password baru untuk kembali
                    menggunakan akun Eventty.
                </p>

            </div>

        </section>


        <!-- =========================
             RESET CARD
        ========================== -->

        <section class="reset-card">

            <div class="reset-logo">

                <img
                    src="{{ asset('images/logo.jpeg') }}"
                    alt="Logo Eventty"
                >

            </div>


            <h2>
                Reset Password
            </h2>

            <p class="reset-subtitle">
                Masukkan password baru untuk akunmu.
            </p>


            <form
                id="resetPasswordForm"
                novalidate
            >

                <!-- PASSWORD BARU -->

                <div class="reset-form-group">

                    <label for="new_password">
                        Password Baru
                    </label>

                    <div class="reset-password-wrapper">

                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            placeholder="Buat password baru"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            id="toggleNewPassword"
                            class="reset-toggle-password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    <small class="reset-password-hint">
                        Password minimal 8 karakter.
                    </small>

                    <small
                        id="newPasswordError"
                        class="reset-field-error"
                    ></small>

                </div>


                <!-- KONFIRMASI -->

                <div class="reset-form-group">

                    <label for="new_password_confirmation">
                        Konfirmasi Password
                    </label>

                    <div class="reset-password-wrapper">

                        <input
                            type="password"
                            id="new_password_confirmation"
                            name="new_password_confirmation"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            id="toggleNewConfirmPassword"
                            class="reset-toggle-password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    <small
                        id="newPasswordConfirmationError"
                        class="reset-field-error"
                    ></small>

                </div>


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="reset-button"
                >
                    Simpan Password
                </button>

            </form>


            <p class="reset-login-text">

                Ingat password?

                <a href="{{ url('/login') }}">
                    Kembali ke Login
                </a>

            </p>

        </section>

    </main>


    @vite(['resources/js/auth/reset-password.js'])

</body>

</html>