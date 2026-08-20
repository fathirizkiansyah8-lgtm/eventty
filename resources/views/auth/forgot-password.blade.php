<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Lupa Password - Eventty</title>

    @vite(['resources/css/auth/forgot-password.css'])

</head>

<body>

    <main class="forgot-page">

        <!-- =========================
             VISUAL SEKOLAH
        ========================== -->

        <section class="forgot-visual">

            <img
                src="{{ asset('images/ilustrasi-logo.png') }}"
                alt="Ilustrasi Sekolah"
            >

            <div class="forgot-visual-text">

                <h1>
                    Lupa Password?
                </h1>

                <p>
                    Jangan khawatir. Masukkan NIS akunmu
                    untuk melanjutkan proses pemulihan akun.
                </p>

            </div>

        </section>


        <!-- =========================
             FORGOT CARD
        ========================== -->

        <section class="forgot-card">

            <div class="forgot-logo">

                <img
                    src="{{ asset('images/logo.jpeg') }}"
                    alt="Logo Eventty"
                >

            </div>


            <h2>
                Lupa Password
            </h2>

            <p class="forgot-subtitle">
                Masukkan NIS untuk melanjutkan.
            </p>


            <form
                id="forgotPasswordForm"
                novalidate
            >

                <div class="forgot-form-group">

                    <label for="forgotNis">
                        NIS
                    </label>

                    <input
                        type="text"
                        id="forgotNis"
                        name="nis"
                        maxlength="5"
                        inputmode="numeric"
                        placeholder="Masukkan 5 angka NIS"
                    >

                    <small
                        id="forgotNisError"
                        class="forgot-field-error"
                    ></small>

                </div>


                <button
                    type="submit"
                    class="forgot-button"
                >
                    Lanjutkan
                    <span>→</span>
                </button>

            </form>


            <p class="forgot-login-text">

                Ingat password?

                <a href="{{ url('/login') }}">
                    Kembali ke Login
                </a>

            </p>

        </section>

    </main>


    @vite(['resources/js/auth/forgot-password.js'])

</body>

</html>