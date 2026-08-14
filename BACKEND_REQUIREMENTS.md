# Backend Requirements - Smart Event Management Platform

## 📋 Ringkasan Fungsionalitas Backend

Backend akan melayani 2 klien utama:
1. **Mobile App (Flutter)** - Peserta event
2. **Web Admin Dashboard** - Admin/organizer

---

## 📱 FITUR UNTUK MOBILE APP (Peserta)

### 1. **Autentikasi & Profil**
- [x] Register (email, password, nama)
- [x] Login
- [x] Logout
- [x] Profile Management (edit nama, email, foto profil)
- [x] Password reset
- [x] JWT/Token management

### 2. **Events Listing & Details**
- [x] GET semua events (dengan pagination)
- [x] Filter events (kategori, date range, status)
- [x] Search events by nama
- [x] GET detail event (deskripsi, jadwal, lokasi, pendaftar)

### 3. **Pendaftaran Event**
- [x] POST register ke event (check kuota maksimal)
- [x] GET status pendaftaran peserta
- [x] Cancel pendaftaran
- [x] GET list event yang sudah didaftar peserta

### 4. **Absensi via QR Code**
- [x] GET QR code untuk check-in (unique per peserta per event)
- [x] POST scan QR code (validasi QR, update status absensi)
- [x] GET attendance history

### 5. **Jadwal & Notifikasi**
- [x] GET jadwal event terdaftar
- [x] Push notification untuk reminder event

### 6. **Sertifikat Digital**
- [x] GET list sertifikat (hanya yg sudah event selesai & peserta hadir)
- [x] GET sertifikat detail dengan foto/PDF
- [x] Download/share sertifikat

---

## 🖥️ FITUR UNTUK WEB ADMIN DASHBOARD

### 1. **Authentication**
- [x] Login admin
- [x] JWT/Session management
- [x] Role-based access (Admin, Organizer, Super Admin)

### 2. **Event Management**
- [x] CREATE event (nama, deskripsi, tanggal, lokasi, kuota, kategori)
- [x] READ event (list all, detail)
- [x] UPDATE event
- [x] DELETE event
- [x] Publish/draft status management
- [x] GET event by organizer

### 3. **Peserta Management**
- [x] GET list peserta per event
- [x] Export peserta ke CSV/Excel
- [x] Manual add peserta
- [x] Remove peserta
- [x] Check status pembayaran (jika ada)

### 4. **Absensi Management**
- [x] GET attendance report
- [x] Manual mark attendance
- [x] Export attendance

### 5. **QR Code Management**
- [x] Generate QR code per peserta per event
- [x] GET QR code history
- [x] Regenerate QR code

### 6. **Sertifikat Management**
- [x] Upload template sertifikat
- [x] Generate sertifikat untuk peserta (batch)
- [x] Preview sertifikat
- [x] Export sertifikat

### 7. **Dashboard Statistics**
- [x] Total events
- [x] Total participants
- [x] Attendance rate per event
- [x] Events by category
- [x] Upcoming events
- [x] Charts & analytics

### 8. **Export & Reporting**
- [x] Export attendance (CSV, Excel)
- [x] Export participants (CSV, Excel)
- [x] Report generation

---

## 🏗️ DATABASE SCHEMA (Entities)

```
Users
├── id (PK)
├── name
├── email (UNIQUE)
├── password (hashed)
├── phone
├── profile_photo_path
├── role (participant, organizer, admin, super_admin)
├── is_active
├── created_at
└── updated_at

Events
├── id (PK)
├── title
├── description
├── category
├── location
├── start_date
├── end_date
├── start_time
├── end_time
├── capacity (max participants)
├── current_participants_count
├── organizer_id (FK → Users)
├── status (draft, published, ongoing, completed, cancelled)
├── thumbnail_image_path
├── certificate_template_path
├── is_paid
├── price (nullable)
├── created_at
└── updated_at

Registrations (Event_User)
├── id (PK)
├── user_id (FK → Users)
├── event_id (FK → Events)
├── registration_date
├── registration_number
├── payment_status (pending, completed, failed) - jika paid event
├── status (registered, cancelled, attended)
├── created_at
└── updated_at

Attendance
├── id (PK)
├── registration_id (FK → Registrations)
├── event_id (FK → Events)
├── user_id (FK → Users)
├── qr_code_token (unique)
├── check_in_time (nullable)
├── check_out_time (nullable)
├── status (present, absent)
├── created_at
└── updated_at

Certificates
├── id (PK)
├── registration_id (FK → Registrations)
├── event_id (FK → Events)
├── user_id (FK → Users)
├── certificate_path
├── certificate_number (unique)
├── issued_date
├── is_downloaded
├── downloaded_at (nullable)
├── created_at
└── updated_at

Notifications
├── id (PK)
├── user_id (FK → Users)
├── event_id (FK → Events) - nullable
├── type (event_reminder, registration_confirmed, certificate_ready)
├── title
├── message
├── is_read
├── created_at
└── updated_at
```

---

## 🔌 API ENDPOINTS STRUCTURE

### Authentication Routes
```
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout
POST   /api/auth/refresh-token
POST   /api/auth/forgot-password
POST   /api/auth/reset-password
```

### User Routes (Participant)
```
GET    /api/users/profile
PUT    /api/users/profile
GET    /api/users/my-events
```

### Event Routes (Public)
```
GET    /api/events (public, paginated)
GET    /api/events/:id
GET    /api/events/search
GET    /api/events/filter
```

### Registration Routes (Participant)
```
POST   /api/events/:id/register
DELETE /api/registrations/:id
GET    /api/registrations/my-registrations
GET    /api/registrations/:id/status
```

### Attendance/QR Routes (Participant)
```
GET    /api/events/:id/qr-code
POST   /api/attendance/scan-qr
GET    /api/attendance/history
```

### Certificate Routes (Participant)
```
GET    /api/certificates
GET    /api/certificates/:id
GET    /api/certificates/:id/download
```

### Notification Routes (Participant)
```
GET    /api/notifications
GET    /api/notifications/:id
PUT    /api/notifications/:id/mark-as-read
DELETE /api/notifications/:id
```

### Admin Event Routes
```
POST   /api/admin/events
GET    /api/admin/events
GET    /api/admin/events/:id
PUT    /api/admin/events/:id
DELETE /api/admin/events/:id
```

### Admin Participant Routes
```
GET    /api/admin/events/:id/participants
POST   /api/admin/events/:id/participants
DELETE /api/admin/events/:id/participants/:userId
GET    /api/admin/participants/export
```

### Admin Attendance Routes
```
GET    /api/admin/events/:id/attendance
POST   /api/admin/attendance/mark-present
PUT    /api/admin/attendance/:id
GET    /api/admin/attendance/export
```

### Admin QR Routes
```
POST   /api/admin/events/:id/generate-qr
GET    /api/admin/events/:id/qr-list
GET    /api/admin/qr/:token/validate
```

### Admin Certificate Routes
```
POST   /api/admin/events/:id/certificates/upload-template
GET    /api/admin/events/:id/certificates
POST   /api/admin/events/:id/certificates/generate
GET    /api/admin/certificates/:id/preview
GET    /api/admin/certificates/export
```

### Admin Dashboard Routes
```
GET    /api/admin/dashboard/stats
GET    /api/admin/dashboard/events-overview
GET    /api/admin/dashboard/attendance-rate
GET    /api/admin/dashboard/categories-distribution
```

---

## 🛠️ Tech Stack & Dependencies

### Core
- PHP 8.3+
- Laravel 13
- MySQL/PostgreSQL

### Authentication
- Laravel Passport (OAuth 2.0) atau Sanctum (API tokens)
- JWT Token support

### Image/File Processing
- Intervention Image (QR code, certificate generation)
- Spatie File System untuk uploads

### Validation & Security
- Laravel Validation
- CORS middleware
- Rate limiting

### Export Features
- Maatwebsite Excel (Excel export)
- CSV generation

### Queue & Jobs
- Laravel Queue (background jobs)
- untuk generate certificates

### Testing
- PHPUnit (testing)

---

## 📦 Fitur Tambahan (Optional tapi Useful)

1. **Email Notifications** - verifikasi email, reminder event, certificate notification
2. **SMS Reminders** - reminder event via SMS
3. **Payment Integration** - jika ada fitur berbayar
4. **Analytics Tracking** - Google Analytics integration
5. **API Documentation** - Swagger/OpenAPI docs
6. **Rate Limiting** - API rate limiting
7. **Caching** - Redis cache untuk performa

---

## 🚀 Development Phases

### Phase 1: Foundation (Week 1)
- Setup database & migrations
- Create User, Event models
- Implement authentication (Register/Login)
- User profile management

### Phase 2: Event Management (Week 2)
- Event CRUD operations
- Event listing with filters/search
- Event registration system
- Capacity management

### Phase 3: Attendance System (Week 3)
- QR code generation & storage
- QR code scanning endpoint
- Attendance tracking
- Manual attendance marking

### Phase 4: Certificates (Week 4)
- Certificate template system
- Batch certificate generation
- Certificate download/sharing
- Export functionality

### Phase 5: Admin Dashboard APIs (Week 5)
- Statistics endpoints
- Export endpoints
- Admin-only filters
- Dashboard data aggregation

### Phase 6: Advanced Features (Week 6)
- Notifications system
- Email notifications
- PDF generation optimization
- Performance tuning & caching

---

## 📝 Notes

- Semua API responses harus menggunakan format JSON yang konsisten
- Implementasi proper error handling & HTTP status codes
- Input validation di semua endpoints
- Security: hashing passwords, CORS, SQL injection prevention
- API documentation dengan OpenAPI/Swagger
- Rate limiting untuk mencegah abuse
- Proper logging untuk debugging

