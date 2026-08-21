<title>Login - Eventty</title>

@vite(['resources/css/auth/login.css'])


<main class="login-page">

    <!-- =========================================
         BACKGROUND SEKOLAH
    ========================================== -->

    <div class="school-background">
        <img
            src="{{ asset('images/ilustrasi-logo.png') }}"
            alt=""
        >
    </div>

    <div class="background-overlay"></div>


    <!-- =========================================
         THEME TOGGLE
    ========================================== -->

    <div class="theme-switch-wrapper">

        <span class="theme-icon">☀️</span>

        <label class="theme-switch">
            <input
                type="checkbox"
                id="themeToggleCheckbox"
            >

            <span class="slider"></span>
        </label>

        <span class="theme-icon">🌙</span>

    </div>


    <!-- =========================================
         LOGIN CARD
    ========================================== -->

    <section class="login-card">


        <!-- LOGO -->

        <div class="logo">

            <img
                src="{{ asset('images/logo.jpeg') }}"
                alt="Logo Eventty"
            >

        </div>


        <!-- TITLE -->

        <h1>Selamat Datang</h1>

        <p class="subtitle">
            Login untuk melanjutkan ke Eventty dan kelola
            event sekolah dengan tampilan terpusat.
        </p>


        <!-- =====================================
             LOGIN FORM
        ====================================== -->

        <form
            id="loginForm"
            method="POST"
            action="{{ url('/login') }}"
            novalidate
        >

            @csrf


            <!-- NAMA LENGKAP -->

            <div class="form-group">

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
                    class="field-error"
                    aria-live="polite"
                ></small>

            </div>


            <!-- NIS -->

            <div class="form-group">

                <label for="nis">
                    NIS
                </label>

                <input
                    type="text"
                    id="nis"
                    name="nis"
                    placeholder="Masukkan NIS"
                    autocomplete="username"
                    inputmode="numeric"
                >

                <small
                    id="nisError"
                    class="field-error"
                    aria-live="polite"
                ></small>

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                    >

                    <button
                        type="button"
                        id="togglePassword"
                        class="toggle-password"
                        aria-label="Tampilkan password"
                    >
                        👁
                    </button>

                </div>

                <small
                    id="passwordError"
                    class="field-error"
                    aria-live="polite"
                ></small>

            </div>


            <!-- =================================
                 ACTION
            ================================== -->

            <div class="form-actions">

                <div class="forgot-password">

                    <a href="{{ url('/forgot-password') }}">
                        Lupa Password?
                    </a>

                </div>


                <button
                    type="submit"
                    class="login-button"
                >

                    <span>Masuk</span>

                    <span class="button-arrow">
                        →
                    </span>

                </button>

            </div>

        </form>


        <!-- REGISTER -->

        <p class="register-text">

            Belum punya akun?

            <a href="{{ url('/register') }}">
                Daftar sekarang
            </a>

        </p>



    </section>

</main>


@vite(['resources/js/auth/login.js'])