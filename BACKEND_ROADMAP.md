# Backend Development Roadmap - Smart Event Management

## 🎯 Apa yang Perlu Kamu Lakukan Sekarang (ASAP)

### ✅ Step 1: Setup Environment & Database (1-2 jam)

1. **Pastikan PHP dan Dependencies terinstall:**
   ```bash
   php -v  # harus PHP 8.3+
   composer --version
   ```

2. **Setup Database:**
   - Buka file `.env`
   - Configure database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=eventty_db
     DB_USERNAME=root
     DB_PASSWORD=
     ```
   - Create database: `mysql -u root -e "CREATE DATABASE eventty_db;"`

3. **Install Dependencies:**
   ```bash
   composer install
   php artisan key:generate
   ```

---

### ✅ Step 2: Membuat Database Models & Migrations (2-3 jam)

**Jalankan artisan commands untuk generate models + migrations:**

```bash
# Users model (sudah ada, tapi perlu update)
php artisan make:model Event -m
php artisan make:model Registration -m
php artisan make:model Attendance -m
php artisan make:model Certificate -m
php artisan make:model Notification -m
```

**Lalu edit setiap migration file dengan schema yang benar.**

---

### ✅ Step 3: Setup Authentication (2-3 jam)

Laravel 13 sudah menggunakan **Laravel Sanctum** untuk API auth (recommended).

1. **Publish Sanctum:**
   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

2. **Update User model** dengan `HasApiTokens` trait

3. **Create auth controllers:**
   ```bash
   php artisan make:controller Api/AuthController
   ```

---

### ✅ Step 4: Setup API Routes & Middleware (1-2 jam)

1. **Setup routes di `routes/api.php`**
2. **Configure CORS middleware** (untuk Flutter app)
3. **Setup rate limiting** untuk API

---

## 📅 DETAILED 6-WEEK ROADMAP

### **MINGGU 1: Database & Authentication**

| Day | Task | Status |
|-----|------|--------|
| Mon | Setup env, database, composer install | ⬜ |
| Tue | Create all models & migrations | ⬜ |
| Wed | Update User model, migrations validation | ⬜ |
| Thu | Setup Sanctum auth, create AuthController | ⬜ |
| Fri | Build Register/Login/Logout endpoints, test with Postman | ⬜ |

**Deliverable:** 
- ✅ Auth endpoints working (register, login, logout)
- ✅ Database tables created
- ✅ JWT/Token validation working

**Testing:** Test di Postman atau Insomnia

---

### **MINGGU 2: Event Management & Registration**

| Day | Task | Status |
|-----|------|--------|
| Mon | Create EventController, CRUD endpoints | ⬜ |
| Tue | Create RegistrationController | ⬜ |
| Wed | Implement capacity checking, registration validation | ⬜ |
| Thu | Add filters (category, date range, search) | ⬜ |
| Fri | API testing & bug fixing | ⬜ |

**Deliverable:**
- ✅ Event CRUD working
- ✅ Registration system working
- ✅ Capacity management working
- ✅ Filters & search working

---

### **MINGGU 3: QR Code & Attendance**

| Day | Task | Status |
|-----|------|--------|
| Mon | Install QR library, setup QR generation | ⬜ |
| Tue | Create AttendanceController | ⬜ |
| Wed | Implement scan QR endpoint | ⬜ |
| Thu | Add QR code validation & error handling | ⬜ |
| Fri | Manual attendance marking, reporting | ⬜ |

**Deliverable:**
- ✅ QR code generation working
- ✅ QR code scanning endpoint working
- ✅ Attendance tracking working

---

### **MINGGU 4: Certificates**

| Day | Task | Status |
|-----|------|--------|
| Mon | Setup certificate template system | ⬜ |
| Tue | Create CertificateController | ⬜ |
| Wed | Implement batch certificate generation | ⬜ |
| Thu | PDF generation & storage | ⬜ |
| Fri | Download & sharing functionality | ⬜ |

**Deliverable:**
- ✅ Certificate generation working
- ✅ Certificate download working
- ✅ Batch generation job working

---

### **MINGGU 5: Admin Dashboard APIs & Export**

| Day | Task | Status |
|-----|------|--------|
| Mon | Create DashboardController | ⬜ |
| Tue | Build statistics endpoints | ⬜ |
| Wed | Implement export to Excel/CSV | ⬜ |
| Thu | Admin-specific endpoints & filters | ⬜ |
| Fri | Test all admin features | ⬜ |

**Deliverable:**
- ✅ Dashboard stats endpoints
- ✅ Export functionality
- ✅ Admin filtering

---

### **MINGGU 6: Notifications, Optimization & Polish**

| Day | Task | Status |
|-----|------|--------|
| Mon | Create NotificationController | ⬜ |
| Tue | Setup email notifications | ⬜ |
| Wed | Performance optimization & caching | ⬜ |
| Thu | API documentation (Swagger) | ⬜ |
| Fri | Final testing, bug fixes, deployment prep | ⬜ |

**Deliverable:**
- ✅ Notifications system working
- ✅ Email reminders working
- ✅ API documented
- ✅ Performance optimized

---

## 🔧 TOOLS & ENVIRONMENT SETUP

### Essential Tools

1. **Postman/Insomnia** - API testing
   - Download dari postman.com atau insomnia.rest
   
2. **Database GUI (Optional)**
   - DBeaver, Sequel Pro, atau MySQL Workbench

3. **VSCode Extensions (Recommended)**
   - PHP Intelephense
   - Laravel Extension Pack (Barryvdh)
   - Thunder Client (API testing in VSCode)

4. **Git & Version Control**
   - Sudah ada (kamu mention sudah git clone)
   - Pastikan push ke branch yang baru

---

## 📊 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── AuthController.php          ⬜
│   │   │   ├── EventController.php         ⬜
│   │   │   ├── RegistrationController.php  ⬜
│   │   │   ├── AttendanceController.php    ⬜
│   │   │   ├── CertificateController.php   ⬜
│   │   │   ├── NotificationController.php  ⬜
│   │   │   └── DashboardController.php     ⬜
│   │   └── Controller.php                  ✅
│   └── Requests/
│       ├── StoreEventRequest.php           ⬜
│       ├── StoreRegistrationRequest.php    ⬜
│       └── ... (validation requests)
├── Models/
│   ├── User.php                            ✅
│   ├── Event.php                           ⬜
│   ├── Registration.php                    ⬜
│   ├── Attendance.php                      ⬜
│   ├── Certificate.php                     ⬜
│   └── Notification.php                    ⬜
├── Services/
│   ├── EventService.php                    ⬜
│   ├── RegistrationService.php             ⬜
│   ├── QRCodeService.php                   ⬜
│   └── CertificateService.php              ⬜
├── Jobs/
│   ├── GenerateCertificates.php            ⬜
│   └── SendNotifications.php               ⬜
└── Exceptions/
    ├── EventFullException.php              ⬜
    └── ... (custom exceptions)

database/
├── migrations/
│   ├── create_users_table.php              ✅
│   ├── create_events_table.php             ⬜
│   ├── create_registrations_table.php      ⬜
│   ├── create_attendance_table.php         ⬜
│   ├── create_certificates_table.php       ⬜
│   └── create_notifications_table.php      ⬜
└── seeders/
    └── DatabaseSeeder.php                  ⬜

routes/
├── api.php                                  ⬜ (Main API routes)
└── web.php
```

---

## 🎯 PRIORITY ORDER (Start Here!)

### **TOP PRIORITY - Mulai dari sini:**

1. ✅ Setup `.env` & database
2. ✅ Create models & migrations (Phase 1)
3. ✅ Implement authentication (Phase 1)
4. ✅ Event CRUD (Phase 2)
5. ✅ Registration system (Phase 2)
6. ✅ QR Code system (Phase 3)
7. ✅ Certificates (Phase 4)
8. ✅ Admin endpoints (Phase 5)
9. ✅ Notifications (Phase 6)

---

## 💡 Best Practices

1. **Use Form Requests** untuk validation
2. **Create Services** untuk business logic
3. **Use Events** untuk notifications & jobs
4. **Proper Error Handling** dengan custom exceptions
5. **Logging** semua important actions
6. **API Documentation** dengan Swagger/OpenAPI
7. **Unit Tests** untuk critical logic
8. **Database Transactions** untuk operasi multiple tables

---

## 🚨 COMMON MISTAKES TO AVOID

❌ Don't: Langsung development tanpa planning database
✅ Do: Plan DB schema dulu sebelum coding

❌ Don't: Menaruh semua logic di controller
✅ Do: Gunakan Services untuk business logic

❌ Don't: Lupa setup CORS untuk Flutter
✅ Do: Configure CORS di middleware

❌ Don't: Store sensitive data di log files
✅ Do: Secure sensitive info, log dengan hati-hati

❌ Don't: Tidak implement rate limiting
✅ Do: Rate limit API endpoints

---

## 🔗 Useful Resources

- [Laravel 13 Documentation](https://laravel.com/docs/13)
- [Laravel Sanctum API Tokens](https://laravel.com/docs/sanctum)
- [Eloquent ORM Guide](https://laravel.com/docs/eloquent)
- [API Response Formatting](https://laravel.com/docs/serialization)

---

## 📞 Communication with Team

**Important Points untuk communicate dengan temen:**

1. **API Specification** - Share endpoint documentation
2. **Response Format** - Agree on JSON response structure
3. **Authentication** - Agreed JWT token format
4. **Error Messages** - Consistent error responses
5. **Database Credentials** - Shared/documented securely
6. **Deployment Target** - Where will backend be deployed?

---

## ✨ Summary

**TODAY (Hari Ini):**
1. Setup `.env` & database ✅
2. Run `composer install` ✅
3. Create all models & migrations ✅
4. Test database connection ✅

**THIS WEEK:**
- Finish authentication
- Basic Event CRUD
- Test dengan postman

**NEXT 5 WEEKS:**
- Follow roadmap di atas
- Push progress ke git branch regularly
- Communicate dengan team

---

Good luck! 🚀 Siap dimulai?

