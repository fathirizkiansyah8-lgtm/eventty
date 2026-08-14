# ✅ Backend Setup Checklist - START HERE!

## 🎯 Untuk Dikerjakan HARI INI (Perkiraan 1-2 jam)

### Phase 1: Environment Setup (15 menit)

**Step 1: Verify Prerequisites**
- [ ] PHP 8.3+ terinstall: `php -v`
- [ ] Composer terinstall: `composer --version`
- [ ] MySQL/MariaDB running
- [ ] Git sudah di-setup di project

**Step 2: Configure Environment**
```bash
# Di project directory (eventty)
cd eventty

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

**Step 3: Update .env Database Settings**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eventty_db
DB_USERNAME=root
DB_PASSWORD=
```

**Step 4: Create Database**
```bash
# Buka MySQL prompt
mysql -u root -p

# Jalankan:
CREATE DATABASE eventty_db;
EXIT;
```

**Verifikasi:**
- [ ] `.env` file sudah di-update
- [ ] Database sudah dibuat
- [ ] Bisa connect ke MySQL

---

### Phase 2: Install Dependencies (20 menit)

```bash
# Install PHP dependencies
composer install

# Verify installation
php artisan --version
```

**Status check:**
- [ ] `composer install` selesai tanpa error
- [ ] Folder `vendor/` sudah ada
- [ ] `php artisan --version` menghasilkan version number

---

### Phase 3: Setup Sanctum (API Authentication) (10 menit)

```bash
# Publish Sanctum configuration
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Run Sanctum migrations
php artisan migrate
```

**Status check:**
- [ ] Migration selesai
- [ ] Database tables tercipta

---

### Phase 4: Verify Installation (10 menit)

```bash
# Start development server
php artisan serve

# Should see: "Laravel development server started at [http://127.0.0.1:8000]"
```

**Test di browser:**
- [ ] Buka `http://127.0.0.1:8000`
- [ ] Lihat Laravel welcome page

**Status check:**
- [ ] Server running
- [ ] No error messages
- [ ] Dapat akses localhost

---

## 📋 CREATE INITIAL MODELS & MIGRATIONS

**Run commands untuk generate Models + Migrations:**

```bash
php artisan make:model Event -m
php artisan make:model Registration -m
php artisan make:model Attendance -m
php artisan make:model Certificate -m
php artisan make:model Notification -m
```

**Status check:**
- [ ] Semua models created di `app/Models/`
- [ ] Semua migrations created di `database/migrations/`

---

## 🔧 UPDATE USER MODEL

**Edit `app/Models/User.php`:**

Pastikan ini ada:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;  // ← ADD THIS

class User extends Authenticatable
{
    use HasApiTokens;  // ← ADD THIS
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',           // ← ADD THIS
        'profile_photo_path',  // ← ADD THIS
        'role',            // ← ADD THIS
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

**Status check:**
- [ ] `HasApiTokens` trait sudah added
- [ ] File disave
- [ ] Tidak ada error syntax

---

## 🗄️ SETUP DATABASE MIGRATIONS

**Edit `database/migrations/[timestamp]_create_users_table.php`:**

```php
public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('phone')->nullable();
        $table->string('profile_photo_path')->nullable();
        $table->enum('role', ['participant', 'organizer', 'admin', 'super_admin'])->default('participant');
        $table->boolean('is_active')->default(true);
        $table->rememberToken();
        $table->timestamps();
    });
}
```

**Status check:**
- [ ] Users migration updated dengan phone, role, profile_photo_path
- [ ] File disave

---

## 🚀 INITIALIZE GIT & CREATE BRANCH

**Status check:**
- [ ] Sudah `git clone` project dari temen
- [ ] Sudah di branch baru (bukan main/master)

```bash
# Check current branch
git status

# If not in new branch, create one
git checkout -b feature/backend-setup

# Check branch
git branch
```

**Status check:**
- [ ] In new branch (not main/master)
- [ ] Git initialized

---

## 📝 DOCUMENTATION REVIEW

**Files yang sudah saya buat untuk kamu:**

- [ ] `BACKEND_REQUIREMENTS.md` - Baca ini untuk memahami semua fitur
- [ ] `BACKEND_ROADMAP.md` - Baca ini untuk step-by-step planning
- [ ] `QUICK_START.md` - Reference untuk setup
- [ ] `TEAM_COMMUNICATION.md` - Reference untuk communicate dengan team
- [ ] `SETUP_CHECKLIST.md` - Ini (current checklist)

**Action:**
- [ ] Buka dan baca `BACKEND_REQUIREMENTS.md` setelah setup selesai
- [ ] Buka dan baca `BACKEND_ROADMAP.md` untuk planning

---

## ✅ FINAL VERIFICATION

```bash
# Test database connection
php artisan migrate:status

# Run test
php artisan migrate

# Verify migrations ran
php artisan migrate:status
```

Expected output:
```
Migration table created successfully.
Migrating: 2024_01_01_000000_create_users_table
...
Migrated:  2024_01_01_000000_create_users_table
```

**Final Status Check:**
- [ ] All migrations successful
- [ ] Database tables created
- [ ] No error messages
- [ ] Server dapat start dengan `php artisan serve`

---

## 🎯 NEXT STEPS (After Today)

### Tomorrow / Day 2:

1. **Create Authentication Controller**
   ```bash
   php artisan make:controller Api/AuthController
   ```

2. **Create Form Requests** untuk validation:
   ```bash
   php artisan make:request RegisterRequest
   php artisan make:request LoginRequest
   ```

3. **Setup API Routes** di `routes/api.php`

4. **Implement Login/Register endpoints**

5. **Test dengan Postman**

### This Week:

- Create Event CRUD endpoints
- Create Registration system
- Create Attendance tracking
- Test semua endpoints

### Next Week:

- QR Code system
- Certificates
- Admin endpoints

---

## 📞 If You Get Stuck

**Common issues & solutions:**

| Issue | Solution |
|-------|----------|
| `SQLSTATE[HY000] [2002]` | MySQL not running |
| `Class not found` | Run `composer dump-autoload` |
| `Port 8000 already in use` | Run `php artisan serve --port=8001` |
| `Permission denied on migrate` | Run as admin atau check folder permissions |
| `table or view already exists` | Run `php artisan migrate:fresh` (⚠️ drops all data) |

---

## ✨ SUMMARY

**Hari Ini Harus Selesai:**

✅ Environment configured
✅ Dependencies installed  
✅ Database created
✅ Models & migrations generated
✅ User model updated with Sanctum
✅ First migrations run
✅ Development server running
✅ Git branch created

**Kalau semua di atas sudah ✅, kamu sudah siap mulai development!**

---

**Total waktu: 1-2 jam**

Good luck! Kalau ada masalah, debug & ask. 🚀

