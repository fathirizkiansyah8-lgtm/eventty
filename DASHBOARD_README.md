# Eventy - School Event Management System
## Frontend Dashboard Documentation

### 📋 Project Overview
Eventy adalah aplikasi School Event Management System yang dikembangkan menggunakan Laravel. Dokumentasi ini menjelaskan frontend dashboard yang telah dibuat untuk User/Siswa dan Admin/OSIS.

### 🏗️ Struktur Project

```
resources/
├── views/
│   ├── user/                          # User Dashboard Pages
│   │   ├── dashboard.blade.php         # User Dashboard
│   │   ├── events.blade.php             # All Events Page
│   │   ├── event-detail.blade.php       # Event Detail Page
│   │   ├── my-events.blade.php          # My Events Page
│   │   ├── certificates.blade.php       # Certificates Page
│   │   ├── notifications.blade.php      # Notifications Page
│   │   ├── profile.blade.php            # Profile Page
│   │   ├── settings.blade.php           # Settings Page
│   │   └── layout.blade.php            # User Layout Component
│   │
│   └── admin/                         # Admin Dashboard Pages
│       ├── dashboard.blade.php         # Admin Dashboard
│       ├── events.blade.php             # Manage Events Page
│       ├── create-event.blade.php       # Create Event Form
│       ├── edit-event.blade.php        # Edit Event Form
│       ├── participants.blade.php        # Participants Page
│       ├── attendance.blade.php          # Attendance Page
│       ├── certificates.blade.php       # Certificates Management
│       ├── announcements.blade.php       # Announcements Page
│       ├── students.blade.php            # Students Data Page
│       ├── notifications.blade.php      # Admin Notifications
│       └── settings.blade.php           # Admin Settings
│
├── css/
│   ├── components/                     # Shared CSS Components
│   │   ├── design-system.css           # Design System & Variables
│   │   ├── sidebar.css                 # Sidebar Component
│   │   └── header.css                  # Header Component
│   │
│   ├── user/                           # User Dashboard CSS
│   │   ├── dashboard.css               # Dashboard Styles
│   │   ├── my-events.css               # My Events Styles
│   │   ├── certificates.css            # Certificates Styles
│   │   ├── notifications.css           # Notifications Styles
│   │   ├── profile.css                 # Profile Styles
│   │   ├── events.css                  # Events Styles
│   │   ├── event-detail.css             # Event Detail Styles
│   │   └── settings.css                 # Settings Styles
│   │
│   └── admin/                          # Admin Dashboard CSS
│       ├── dashboard.css               # Dashboard Styles
│       ├── events.css                   # Events Management Styles
│       ├── create-event.css             # Create Event Form Styles
│       ├── edit-event.css               # Edit Event Form Styles
│       ├── participants.css             # Participants Styles
│       ├── attendance.css               # Attendance Styles
│       ├── certificates.css             # Certificates Styles
│       ├── announcements.css            # Announcements Styles
│       ├── students.css                 # Students Data Styles
│       ├── notifications.css            # Admin Notifications Styles
│       └── settings.css                 # Admin Settings Styles
│
└── js/
    ├── components/                     # Shared JavaScript Components
    │   ├── sidebar.js                  # Sidebar Interactions
    │   └── header.js                   # Header Interactions
    │
    ├── user/                           # User Dashboard JavaScript
    │   ├── dashboard.js                # Dashboard Interactions
    │   ├── my-events.js                 # My Events Interactions
    │   ├── certificates.js              # Certificates Interactions
    │   ├── notifications.js             # Notifications Interactions
    │   ├── profile.js                   # Profile Interactions
    │   ├── events.js                    # Events Interactions
    │   ├── event-detail.js              # Event Detail Interactions
    │   └── settings.js                  # Settings Interactions
    │
    └── admin/                          # Admin Dashboard JavaScript
        ├── dashboard.js                 # Dashboard Interactions
        ├── events.js                     # Events Management Interactions
        ├── create-event.js               # Create Event Form Interactions
        ├── edit-event.js                 # Edit Event Form Interactions
        ├── participants.js               # Participants Interactions
        ├── attendance.js                 # Attendance Interactions
        ├── certificates.js               # Certificates Interactions
        ├── announcements.js              # Announcements Interactions
        ├── students.js                   # Students Data Interactions
        ├── notifications.js              # Admin Notifications Interactions
        └── settings.js                  # Admin Settings Interactions
```

### 🎨 Design System

#### Colors
- **Primary**: Blue (#3b82f6)
- **Success**: Green (#10b981)
- **Warning**: Orange (#f59e0b)
- **Danger**: Red (#ef4444)
- **Info**: Cyan (#06b6d4)
- **Background**: Dark (#0f172a) / Light (#f8fafc)
- **Text**: Primary (#f8fafc) / Secondary (#94a3b8)

#### Typography
- **Font Family**: Inter (body), Outfit (headings)
- **Font Weights**: 300, 400, 500, 600, 700
- **Sizes**: Custom scale for hierarchy

#### Spacing
- XS: 0.25rem, SM: 0.5rem, MD: 1rem, LG: 1.5rem, XL: 2rem, 2XL: 3rem

#### Components
- **Card**: Reusable card with hover effects
- **Badge**: Status indicators with colors
- **Button**: Primary, secondary, outline, danger variants
- **Input**: Form inputs with validation states
- **Table**: Responsive tables with styling
- **Modal**: Overlay modals for forms
- **Dropdown**: Menu dropdowns
- **Avatar**: User profile images

### 👤 User Dashboard Features

#### 1. Dashboard
- Statistics cards (Events Diikuti, Event Mendatang, Event Selesai, Sertifikat)
- Nearest event highlight with countdown
- Upcoming events grid with cards
- Animated statistics on load
- Dynamic greeting based on time

#### 2. Event Saya
- List of registered events
- Filter by status (Registered, Attended, Absent, Completed, Cancelled)
- Attendance status display
- Action buttons (View, Certificate)
- Empty state handling

#### 3. Sertifikat
- Grid layout of certificate cards
- Certificate type indicators
- View and download actions
- Empty state for no certificates
- Responsive grid system

#### 4. Notifikasi
- Filter tabs (All, Unread, Read)
- Notification list with icons
- Mark as read functionality
- Mark all as read
- Delete all notifications
- Action buttons per notification
- Timestamp display

#### 5. Profil
- Profile card with avatar
- Personal information display
- Statistics (Events, Certificates, Attendance)
- Edit profile modal
- Form validation
- Avatar upload placeholder

### 👨‍💼 Admin Dashboard Features

#### 1. Dashboard
- Statistics cards (Total Event, Event Aktif, Total Peserta, Event Selesai)
- Analytics charts (Bar chart for participation, Pie chart for attendance)
- Recent events table with actions
- Animated statistics
- Chart interactions

#### 2. Kelola Event
- Events table with full CRUD actions
- Search functionality
- Filter by category and status
- Pagination UI
- Delete confirmation modal
- Empty state handling

#### 3. Buat Event
- Comprehensive event creation form
- Multiple form sections (Info, Time & Location, Capacity, Banner, Status)
- Frontend validation
- File upload for banner
- Date/time pickers
- Cancel confirmation

#### 4. Edit Event
- Pre-filled form with existing data
- Same validation as create form
- Update functionality
- Cancel with confirmation

#### 5. Peserta
- Participants table with search
- Filter by event, class, and status
- View participant details
- Pagination UI
- Empty state handling

#### 6. Kehadiran
- Attendance management table
- Quick action buttons (Mark Present/Absent)
- Filter by event and attendance status
- Status badges
- Confirmation dialogs
- Empty state handling

#### 7. Sertifikat
- Certificates management table
- View, Generate, Download actions
- Filter by event and status
- Pagination UI
- Status indicators

#### 8. Pengumuman
- Announcement cards layout
- Create announcement modal
- Edit and delete actions
- Target selection
- Status management
- Search and filter functionality

#### 9. Data Siswa
- Students data table
- Search by name, NIS, email, class
- Filter by class and status
- View student details
- Pagination UI
- Empty state handling

### 📱 Responsive Design

#### Desktop (>1024px)
- Full sidebar with all labels
- Grid layouts (4 columns for statistics, 3 for cards)
- Full table display
- All modals centered

#### Tablet (768px - 1024px)
- Compact sidebar (icons only)
- Grid layouts (2 columns)
- Table with horizontal scroll
- Adjusted modal sizes

#### Mobile (<768px)
- Sidebar as drawer/menu
- Single column grids
- Stacked action buttons
- Full-width modals
- Touch-friendly buttons
- Simplified navigation

### 🔧 JavaScript Features

#### Shared Components
- **Sidebar**: Toggle functionality, active state management, mobile drawer
- **Header**: Notification dropdown, profile dropdown, close on outside click

#### User Dashboard
- Statistics animation on load
- Dynamic greeting based on time
- Event card interactions
- Filter functionality
- Modal handling
- Form validation
- Real-time search

#### Admin Dashboard
- Chart interactions
- Table actions (View, Edit, Delete)
- Search and filter
- Pagination handling
- Form validation with error messages
- Modal confirmations
- File upload validation
- Auto-fill form fields

### 🛣️ Routes

#### User Routes
- `/user/dashboard` - User Dashboard
- `/user/events` - All Events
- `/user/events/{id}` - Event Detail
- `/user/my-events` - My Events
- `/user/certificates` - Certificates
- `/user/notifications` - Notifications
- `/user/profile` - Profile
- `/user/settings` - Settings

#### Admin Routes
- `/admin/dashboard` - Admin Dashboard
- `/admin/events` - Manage Events
- `/admin/events/create` - Create Event
- `/admin/events/edit/{id}` - Edit Event
- `/admin/participants` - Participants
- `/admin/attendance` - Attendance
- `/admin/certificates` - Certificates
- `/admin/announcements` - Announcements
- `/admin/students` - Students Data
- `/admin/notifications` - Notifications
- `/admin/settings` - Settings

### ⚠️ Important Notes

#### Mock Data
- Semua data saat ini menggunakan mock data di JavaScript
- Setiap file JavaScript memiliki komentar `// TODO: Replace mock data with backend data`
- Backend integration perlu dilakukan oleh tim backend

#### Backend Integration
- Form submissions menggunakan console.log untuk debugging
- Route navigations sudah disiapkan
- Validasi frontend sudah siap, tinggal connect ke backend
- File upload validation sudah ada di frontend

#### Files Tidak Disentuh
- Login page ✓ (Tidak diubah)
- Register page ✓ (Tidak diubah)
- Forgot password ✓ (Tidak diubah)
- Authentication ✓ (Tidak diubah)
- Backend ✓ (Tidak disentuh)
- Database ✓ (Tidak disentuh)
- Controller ✓ (Tidak disentuh)
- Model ✓ (Tidak disentuh)
- Migration ✓ (Tidak disentuh)

### 🚀 Cara Menggunakan

#### 1. Install Dependencies
```bash
npm install
```

#### 2. Run Development Server
```bash
npm run dev
```

#### 3. Access Dashboard
- User Dashboard: `http://localhost:8000/user/dashboard`
- Admin Dashboard: `http://localhost:8000/admin/dashboard`

#### 4. Build for Production
```bash
npm run build
```

### 📝 TODO untuk Backend

1. **Authentication Middleware**
   - Tambah middleware untuk protect dashboard routes
   - Role-based access (user vs admin)

2. **Data Integration**
   - Connect semua mock data ke database
   - Implement API endpoints untuk CRUD operations

3. **File Upload**
   - Implement file upload untuk event banners
   - Storage configuration untuk images

4. **Notifications**
   - Implement real-time notifications
   - Email notifications untuk event updates

5. **Certificates**
   - Implement certificate generation system
   - PDF generation for certificates

### ✅ Checklist Selesai

- [x] Struktur file frontend dibuat
- [x] Design system CSS
- [x] Sidebar component
- [x] Header component
- [x] User dashboard
- [x] User statistics cards
- [x] User upcoming events
- [x] User nearest event
- [x] User my events page
- [x] User certificates page
- [x] User notifications page
- [x] User profile page
- [x] User events page
- [x] User event detail page
- [x] User settings page
- [x] Admin dashboard
- [x] Admin statistics cards
- [x] Admin analytics charts
- [x] Admin recent events table
- [x] Admin manage events page
- [x] Admin create event form
- [x] Admin edit event form
- [x] Admin participants page
- [x] Admin attendance page
- [x] Admin certificates page
- [x] Admin announcements page
- [x] Admin students data page
- [x] Admin notifications page
- [x] Admin settings page
- [x] JavaScript interactions
- [x] Responsive design
- [x] Routes configuration
- [x] Vite configuration
- [x] Mock data dengan TODO comments

### 🎉 Status: SELESAI

Frontend dashboard Eventy sudah selesai dibuat dan siap diintegrasikan dengan backend. Semua halaman user dan admin sudah dibuat dengan design yang modern, clean, dan profesional. Responsive design sudah diimplementasikan untuk semua ukuran layar.
