# 🎉 Eventty — School Event Management System

<p align="center">
  <img src="public/images/logo.jpeg" alt="Eventty Logo" width="100" style="border-radius:12px;">
</p>

<p align="center">
  A web-based school event management system built with <strong>Laravel 13</strong> and <strong>Vite</strong>.<br>
  Designed for schools to manage events, track attendance, and issue certificates — with separate dashboards for students and admins (OSIS).
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.8-red?logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3-blue?logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Vite-8-purple?logo=vite" alt="Vite">
  <img src="https://img.shields.io/badge/TailwindCSS-4.0-teal?logo=tailwindcss" alt="Tailwind">
  <img src="https://img.shields.io/badge/MySQL-supported-orange?logo=mysql" alt="MySQL">
</p>

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Database Schema](#database-schema)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Default Credentials](#default-credentials)
- [Routes](#routes)
- [Screenshots](#screenshots)

---

## Overview

**Eventty** is a school event management system that allows:

- **Students** to browse events, register, track attendance, and download certificates
- **Admins (OSIS)** to create and manage events, record attendance, issue certificates, and post announcements

All data is tied to individual user accounts — every student sees their own events, stats, and certificates, not shared dummy data.

---

## Features

### 👤 Student Dashboard
| Feature | Description |
|---|---|
| Dashboard | Personalized stats (events joined, certificates, upcoming, completed) + live event list from DB |
| Browse Events | Search, filter by category/status, paginated event grid |
| Event Detail | Full event info, quota bar, register/cancel button |
| My Events | Personal event history filtered by attendance status |
| Certificates | View and download earned certificates |
| Notifications | Read/delete individual or all notifications |
| Profile | View and edit name, email, phone, address; upload avatar |
| Settings | Theme toggle (dark/light), account info |

### 🛠️ Admin Dashboard
| Feature | Description |
|---|---|
| Dashboard | System-wide stats, participation analytics, recent events table |
| Manage Events | Full CRUD — create, edit, delete events with banner upload |
| Attendance | Mark students present/absent per event, bulk actions |
| Participants | View registered participants per event |
| Certificates | Generate and manage certificates per event |
| Announcements | Post announcements to students |
| Students | View student accounts |
| Notifications | Admin notification feed |
| File Manager | Upload and manage files for events |

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.3 + Laravel 13.8 |
| Frontend | Blade templates + Vite 8 |
| CSS | Tailwind CSS 4.0 + custom CSS per page |
| JS | Vanilla JS with custom `api.js` AJAX utility |
| Database | MySQL (recommended) |
| Auth | Laravel session-based auth with role middleware |
| File Storage | Laravel Storage (public disk) |
| Build Tool | Vite with `laravel-vite-plugin` |

---

## Database Schema

The system uses **10 database tables**:

```
users                  — Students and admins with school fields (NIS, class, role)
event_categories       — Event categories (Workshop, Seminar, Competition, etc.)
events                 — All school events
event_participants     — Many-to-many: users ↔ events (with attendance status)
certificates           — Issued certificates per user per event
announcements          — Admin announcements with targeting
notifications          — Per-user notification feed
cache                  — Laravel cache
jobs                   — Laravel queue jobs
sessions               — User sessions
```

### Key Relationships
```
User          ──< EventParticipant >── Event
User          ──< Certificate
Event         ──< Certificate
Event         >── EventCategory
Announcement  >── User (created_by)
Notification  >── User
```

---

## Project Structure

```
eventty/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/AuthController.php        # Login, Register, Logout
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php    # Admin stats & analytics
│   │   │   │   ├── EventController.php        # Event CRUD
│   │   │   │   ├── AttendanceController.php   # Mark attendance
│   │   │   │   └── FileController.php         # File management
│   │   │   └── User/
│   │   │       ├── DashboardController.php    # Student dashboard
│   │   │       ├── EventController.php        # Browse & register events
│   │   │       ├── CertificateController.php  # View certificates
│   │   │       ├── NotificationController.php # Notifications
│   │   │       └── ProfileController.php      # Edit profile & avatar
│   │   └── Middleware/
│   │       └── RoleMiddleware.php             # student / admin guard
│   ├── Models/
│   │   ├── User.php
│   │   ├── Event.php
│   │   ├── EventCategory.php
│   │   ├── EventParticipant.php
│   │   ├── Certificate.php
│   │   ├── Announcement.php
│   │   └── Notification.php
│   ├── Providers/
│   │   └── AuthHelperServiceProvider.php      # Blade @admin / @student directives
│   └── Services/
│       └── FileUploadService.php              # Handles banner & avatar uploads
│
├── database/
│   ├── migrations/                            # 10 migration files
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UsersSeeder.php                    # Seeds admin account only
│       └── EventCategoriesSeeder.php          # Seeds 6 default categories
│
├── resources/
│   ├── views/
│   │   ├── auth/          # login, register, forgot-password, reset-password, landing
│   │   ├── user/          # dashboard, events, my-events, certificates, notifications, profile, settings
│   │   └── admin/         # dashboard, events, create-event, edit-event, attendance, participants, certificates, announcements, students, settings
│   ├── css/
│   │   ├── components/    # design-system.css, sidebar.css, header.css
│   │   ├── user/          # per-page CSS for student views
│   │   ├── admin/         # per-page CSS for admin views
│   │   └── auth/          # auth page CSS
│   └── js/
│       ├── utils/api.js   # Central AJAX utility (CSRF, error handling, loading states)
│       ├── components/    # sidebar.js, header.js
│       ├── user/          # dashboard.js, events.js, my-events.js, certificates.js, notifications.js, profile.js
│       ├── admin/         # dashboard.js, events.js, create-event.js, edit-event.js, attendance.js
│       └── auth/          # login.js, register.js
│
├── routes/web.php          # All routes (auth, user, admin, API)
├── vite.config.js
└── .env.example
```

---

## Getting Started

### Requirements

- PHP >= 8.3
- Composer
- Node.js >= 18
- MySQL (or compatible)
- A local server — [Laragon](https://laragon.org/) recommended on Windows

### 1. Clone the repository

```bash
git clone https://github.com/afganzefanya/eventty.git
cd eventty
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Then open `.env` and set your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eventty_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations and seed the database

```bash
php artisan migrate --seed
```

This will create all tables and seed:
- 1 admin account
- 6 default event categories

### 6. Create storage symlink

```bash
php artisan storage:link
```

### 7. Start the development server

In two separate terminals:

```bash
# Terminal 1 — PHP server
php artisan serve

# Terminal 2 — Vite asset bundler
npm run dev
```

App will be available at **http://localhost:8000**

---

## Default Credentials

After seeding, only one account exists by default:

| Role | Name | NIS | Password |
|---|---|---|---|
| Admin | Admin OSIS | `00001` | `password` |

> **Students** register themselves at `/register` with their name, class, NIS, and password.
> After registering, they log in manually at `/login`.

---

## Routes

### Auth
| Method | URL | Description |
|---|---|---|
| GET | `/login` | Login page |
| POST | `/login` | Process login |
| GET | `/register` | Register page |
| POST | `/register` | Create student account |
| POST | `/logout` | Logout |

### Student (requires auth + role: student)
| Method | URL | Description |
|---|---|---|
| GET | `/user/dashboard` | Student dashboard |
| GET | `/user/events` | Browse all events |
| GET | `/user/events/{id}` | Event detail |
| POST | `/user/events/register` | Register for event |
| POST | `/user/events/cancel` | Cancel registration |
| GET | `/user/my-events` | My registered events |
| GET | `/user/certificates` | My certificates |
| GET | `/user/notifications` | Notifications |
| GET | `/user/profile` | Profile page |
| GET | `/user/settings` | Settings page |

### Admin (requires auth + role: admin)
| Method | URL | Description |
|---|---|---|
| GET | `/admin/dashboard` | Admin dashboard |
| GET | `/admin/events` | List all events |
| GET | `/admin/events/create` | Create event form |
| POST | `/admin/events` | Store new event |
| GET | `/admin/events/{id}/edit` | Edit event form |
| PUT | `/admin/events/{id}` | Update event |
| DELETE | `/admin/events/{id}` | Delete event |
| GET | `/admin/attendance` | Attendance management |
| GET | `/admin/participants` | Participant list |
| GET | `/admin/certificates` | Certificate management |
| GET | `/admin/announcements` | Announcements |
| GET | `/admin/students` | Student accounts |

### API (AJAX, requires auth)
| Method | URL | Description |
|---|---|---|
| GET | `/api/user/stats` | Student dashboard stats |
| GET | `/api/user/events` | Paginated event list |
| GET | `/api/user/my-events` | Student's registered events |
| GET | `/api/user/notifications` | Notification feed |
| GET | `/api/user/certificates` | Student's certificates |
| GET | `/api/admin/stats` | Admin dashboard stats |
| GET | `/api/admin/events` | Admin event list |
| GET | `/api/admin/attendance` | Attendance data |
| POST | `/api/admin/attendance/mark` | Mark student attendance |

---

## Design System

| Token | Value |
|---|---|
| Primary | `#0f1f4e` (navy) / `#1d4ed8` (blue) |
| Success | `#10b981` |
| Warning | `#f59e0b` |
| Danger | `#ef4444` |
| Font | Plus Jakarta Sans, Inter |
| Dark bg | `#0f172a` |
| Light bg | `#f8fafc` |

Supports **dark mode** via `data-theme` attribute, toggled per-user in settings/preferences.

---

## License

This project is developed as a school assignment. All rights reserved by the author.
