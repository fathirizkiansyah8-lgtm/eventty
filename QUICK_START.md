# Quick Start - Backend Development

## ⚡ Mulai dalam 30 menit

### 1. Environment Setup (5 menit)

```bash
# Buka terminal di project directory
cd eventty

# Copy .env.example ke .env
cp .env.example .env

# Edit .env - set database config
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=eventty_db
# DB_USERNAME=root
# DB_PASSWORD=
```

### 2. Install Dependencies (10 menit)

```bash
# Install Composer dependencies
composer install

# Generate app key
php artisan key:generate

# Setup Sanctum (untuk API auth)
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 3. Database Setup (10 menit)

```bash
# Create database (di MySQL)
mysql -u root -e "CREATE DATABASE eventty_db;"

# Run migrations
php artisan migrate

# Optionally: seed database with sample data
php artisan db:seed
```

### 4. Test Server (5 menit)

```bash
# Start Laravel development server
php artisan serve

# Server will run at http://127.0.0.1:8000
```

---

## 🚀 Next Steps - Start Development

### MINGGU 1 TASK - Phase 1: Authentication & Database

**What you need to do:**

1. **Create Models & Migrations:**
   ```bash
   php artisan make:model Event -m
   php artisan make:model Registration -m
   php artisan make:model Attendance -m
   php artisan make:model Certificate -m
   php artisan make:model Notification -m
   ```

2. **Update User Model:**
   - Add `HasApiTokens` trait (from Sanctum)
   - Add `role` column
   - Add `phone`, `profile_photo_path` fields

3. **Create Controllers:**
   ```bash
   php artisan make:controller Api/AuthController
   php artisan make:controller Api/EventController
   php artisan make:controller Api/RegistrationController
   ```

4. **Setup Routes** (di `routes/api.php`):
   ```php
   // Auth routes
   Route::post('/auth/register', [AuthController::class, 'register']);
   Route::post('/auth/login', [AuthController::class, 'login']);
   
   // Protected routes (require token)
   Route::middleware('auth:sanctum')->group(function () {
       Route::post('/auth/logout', [AuthController::class, 'logout']);
       Route::get('/events', [EventController::class, 'index']);
   });
   ```

---

## 📋 Checklist - Hari Pertama

- [ ] `.env` configured with database credentials
- [ ] `composer install` completed
- [ ] `php artisan key:generate` done
- [ ] Database created
- [ ] `php artisan migrate` successful
- [ ] `php artisan serve` running without errors
- [ ] Can access `http://127.0.0.1:8000` in browser

---

## 🧪 Testing dengan Postman

1. **Download Postman** dari postman.com

2. **Create New Request:**
   - Method: POST
   - URL: `http://127.0.0.1:8000/api/auth/register`
   - Body (JSON):
     ```json
     {
       "name": "John Doe",
       "email": "john@example.com",
       "password": "password123",
       "password_confirmation": "password123"
     }
     ```

3. **Test Login:**
   - Method: POST
   - URL: `http://127.0.0.1:8000/api/auth/login`
   - Body (JSON):
     ```json
     {
       "email": "john@example.com",
       "password": "password123"
     }
     ```

---

## 📚 File Dokumentasi Project

1. **BACKEND_REQUIREMENTS.md** - Lengkap semua fitur & database schema
2. **BACKEND_ROADMAP.md** - 6-week roadmap step-by-step
3. **QUICK_START.md** - Ini (setup cepat)

---

## ✅ Kamu Siap?

Kalau sudah bisa jalankan `php artisan serve` tanpa error, kamu sudah siap mulai development!

Selanjutnya:
1. Buka BACKEND_REQUIREMENTS.md untuk memahami semua fitur
2. Buka BACKEND_ROADMAP.md untuk step-by-step planning
3. Mulai dengan MINGGU 1 tasks

---

## 🆘 Troubleshooting

**Error: "SQLSTATE[HY000] [2002] No such file or directory"**
- → Check MySQL running
- → Verify DB credentials di .env

**Error: "Class not found"**
- → Run: `composer dump-autoload`

**Error: "Composer not found"**
- → Install Composer dari getcomposer.org

**Error: "PHP version too low"**
- → Need PHP 8.3+
- → Check: `php -v`

---

Happy coding! 🎉

