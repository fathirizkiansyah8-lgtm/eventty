<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Daftar - Eventty</title>

    @vite(['resources/css/auth/register.css'])

</head>

<body>

    <main class="register-page">

        <!-- =========================
             VISUAL SEKOLAH
        ========================== -->

        <section class="register-visual">

            <img
                src="{{ asset('images/ilustrasi-logo.png') }}"
                alt="Ilustrasi Sekolah"
            >

            <div class="register-visual-text">

                <h1>
                    Gabung Bersama Eventty
                </h1>

                <p>
                    Daftarkan akunmu dan ikuti berbagai
                    kegiatan sekolah dengan mudah.
                </p>

            </div>

        </section>


        <!-- =========================
             REGISTER CARD
        ========================== -->

        <section class="register-card">

            <div class="register-logo">

                <img
                    src="{{ asset('images/logo.jpeg') }}"
                    alt="Logo Eventty"
                >

            </div>


            <h2>
                Buat Akun
            </h2>

            <p class="register-subtitle">
                Lengkapi data untuk membuat akun Eventty.
            </p>


            <form
                id="registerForm"
                novalidate
            >

                <!-- NAMA -->

                <div class="register-form-group">

                    <label for="name">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                    >

                    <small
                        id="nameError"
                        class="register-field-error"
                    ></small>

                </div>


                <!-- KELAS -->

                <div class="register-form-group">

                    <label for="class">
                        Kelas & Jurusan
                    </label>

                    <input
                        type="text"
                        id="class"
                        name="class"
                        placeholder="Contoh: XII RPL 1"
                    >

                    <small
                        id="classError"
                        class="register-field-error"
                    ></small>

                </div>


                <!-- NIS -->

                <div class="register-form-group">

                    <label for="nis">
                        NIS
                    </label>

                    <input
                        type="text"
                        id="nis"
                        name="nis"
                        maxlength="5"
                        inputmode="numeric"
                        placeholder="Masukkan 5 angka NIS"
                    >

                    <small
                        id="nisError"
                        class="register-field-error"
                    ></small>

                </div>


                <!-- PASSWORD -->

                <div class="register-form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="register-password-wrapper">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Buat password"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="register-toggle-password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    <small class="register-password-hint">
                        Password minimal 8 karakter.
                    </small>

                    <small
                        id="passwordError"
                        class="register-field-error"
                    ></small>

                </div>


                <!-- KONFIRMASI -->

                <div class="register-form-group">

                    <label for="password_confirmation">
                        Konfirmasi Password
                    </label>

                    <div class="register-password-wrapper">

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            id="toggleConfirmPassword"
                            class="register-toggle-password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    <small
                        id="confirmPasswordError"
                        class="register-field-error"
                    ></small>

                </div>


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="register-button"
                >
                    Buat Akun
                </button>

            </form>


            <p class="register-login-text">

                Sudah punya akun?

                <a href="{{ url('/login') }}">
                    Login
                </a>

            </p>

        </section>

    </main>


    @vite(['resources/js/auth/register.js'])

</body>

</html>