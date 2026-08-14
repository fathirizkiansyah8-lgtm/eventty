# 🤝 Backend & Frontend/Mobile Communication Guide

**PENTING:** Sebagai backend dev, kamu perlu communicate dengan teman-teman untuk memastikan semua berjalan lancar.

---

## 📱 UNTUK FLUTTER DEVELOPER

### API Response Format (Harus Disepakati)

**Format Sukses:**
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    "id": 1,
    "name": "Event Name",
    ...
  }
}
```

**Format Error:**
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "email": ["Email already exists"],
    "password": ["Password must be at least 8 characters"]
  }
}
```

### Authentication Token Format

```
Header: Authorization
Value: Bearer {token}

Contoh:
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

### Error Codes & HTTP Status

| Code | Meaning | Example |
|------|---------|---------|
| 200 | OK | Login successful |
| 201 | Created | Event created |
| 400 | Bad Request | Invalid input |
| 401 | Unauthorized | Token invalid/expired |
| 403 | Forbidden | No permission |
| 404 | Not Found | Event not found |
| 422 | Validation Error | Email already exists |
| 500 | Server Error | Database error |

### Endpoint Checklist untuk Flutter

**Auth Endpoints:**
- [ ] POST `/api/auth/register` - Register user
- [ ] POST `/api/auth/login` - Login user
- [ ] POST `/api/auth/logout` - Logout
- [ ] GET `/api/users/profile` - Get user profile
- [ ] PUT `/api/users/profile` - Update profile

**Event Endpoints:**
- [ ] GET `/api/events` - List all events (pagination)
- [ ] GET `/api/events/:id` - Event detail
- [ ] GET `/api/events/search?q=keyword` - Search events
- [ ] GET `/api/events/filter?category=tech&date=2024-09-01` - Filter events

**Registration Endpoints:**
- [ ] POST `/api/events/:id/register` - Register ke event
- [ ] GET `/api/registrations/my-registrations` - My events
- [ ] DELETE `/api/registrations/:id` - Cancel registration
- [ ] GET `/api/registrations/:id/status` - Check registration status

**QR Code Endpoints:**
- [ ] GET `/api/events/:id/qr-code` - Get QR code untuk event
- [ ] POST `/api/attendance/scan-qr` - Scan QR code (send token)
- [ ] GET `/api/attendance/history` - Attendance history

**Certificate Endpoints:**
- [ ] GET `/api/certificates` - List my certificates
- [ ] GET `/api/certificates/:id` - Certificate detail
- [ ] GET `/api/certificates/:id/download` - Download certificate

**Notification Endpoints:**
- [ ] GET `/api/notifications` - Get notifications
- [ ] PUT `/api/notifications/:id/mark-as-read` - Mark as read
- [ ] DELETE `/api/notifications/:id` - Delete notification

---

## 🖥️ UNTUK WEB ADMIN DEVELOPER

### Admin API Response Format

Same as Flutter, gunakan format yang sama untuk consistency.

### Admin Authentication

```
POST /api/auth/admin/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password123"
}

Response:
{
  "success": true,
  "data": {
    "token": "eyJ0eXAi...",
    "user": {
      "id": 1,
      "name": "Admin Name",
      "role": "admin"
    }
  }
}
```

### Admin Endpoints Checklist

**Event Management:**
- [ ] POST `/api/admin/events` - Create event
- [ ] GET `/api/admin/events` - List events
- [ ] GET `/api/admin/events/:id` - Event detail
- [ ] PUT `/api/admin/events/:id` - Update event
- [ ] DELETE `/api/admin/events/:id` - Delete event

**Participant Management:**
- [ ] GET `/api/admin/events/:id/participants` - List participants
- [ ] POST `/api/admin/events/:id/participants` - Add participant manually
- [ ] DELETE `/api/admin/events/:id/participants/:userId` - Remove participant
- [ ] GET `/api/admin/participants/export` - Export to CSV/Excel

**Attendance Management:**
- [ ] GET `/api/admin/events/:id/attendance` - Attendance report
- [ ] POST `/api/admin/attendance/mark-present` - Manual attendance
- [ ] PUT `/api/admin/attendance/:id` - Update attendance
- [ ] GET `/api/admin/attendance/export` - Export attendance

**QR Management:**
- [ ] POST `/api/admin/events/:id/generate-qr` - Generate QR codes
- [ ] GET `/api/admin/events/:id/qr-list` - List all QR codes
- [ ] GET `/api/admin/qr/:token/validate` - Validate QR token

**Certificate Management:**
- [ ] POST `/api/admin/events/:id/certificates/upload-template` - Upload template
- [ ] GET `/api/admin/events/:id/certificates` - List certificates
- [ ] POST `/api/admin/events/:id/certificates/generate` - Generate certificates (batch)
- [ ] GET `/api/admin/certificates/:id/preview` - Preview certificate
- [ ] GET `/api/admin/certificates/export` - Export certificates

**Dashboard:**
- [ ] GET `/api/admin/dashboard/stats` - Statistics
- [ ] GET `/api/admin/dashboard/events-overview` - Events overview
- [ ] GET `/api/admin/dashboard/attendance-rate` - Attendance rate
- [ ] GET `/api/admin/dashboard/categories-distribution` - Categories distribution

---

## 🗣️ DISCUSSION POINTS (Discuss dengan team)

### 1. **Database Credentials**
- Di-host di server mana?
- Credentials shared via secure channel (never on Github)
- `.env` file harus di `.gitignore`

### 2. **API Base URL**
- Local: `http://127.0.0.1:8000`
- Staging: `https://staging-api.eventty.com`
- Production: `https://api.eventty.com`

### 3. **Pagination**
```json
{
  "success": true,
  "data": [
    { /* item 1 */ },
    { /* item 2 */ }
  ],
  "pagination": {
    "total": 100,
    "per_page": 10,
    "current_page": 1,
    "last_page": 10
  }
}
```

### 4. **Date/Time Format**
- Use ISO 8601: `2024-09-15T14:30:00Z`
- Timezone: UTC di database, client converts to local

### 5. **File Upload**
- Images: `/api/upload/image` endpoint
- Response: `{ "success": true, "path": "/storage/images/filename.jpg" }`
- Max size: 5MB per file

### 6. **Notification/Real-time Updates**
- Use WebSockets (Laravel Pusher/Reverb)?
- Atau polling `/api/notifications` setiap 30 detik?
- Decide dengan team

### 7. **Versioning**
- API version di URL: `/api/v1/events`
- Easier untuk maintain backward compatibility

### 8. **Rate Limiting**
- Per user: 100 requests per minute?
- Per IP: 1000 requests per minute?
- Decide dengan team

---

## 📅 SPRINT SYNC SCHEDULE

**Suggest untuk team sync setiap:**
- **Weekly standup:** Monday pagi (15 menit)
- **Integration test:** Friday siang (1 jam)
- **Deployment preparation:** Friday malam

**Meeting agenda:**
- [ ] What did each person complete this week?
- [ ] What are blockers?
- [ ] Do APIs match what frontend/mobile expects?
- [ ] Any conflicts atau issues?

---

## 📊 Sample Data Exchange Format

### Events Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Tech Conference 2024",
    "description": "A conference about...",
    "category": "Technology",
    "location": "Jakarta Convention Center",
    "start_date": "2024-09-15",
    "end_date": "2024-09-17",
    "start_time": "08:00:00",
    "end_time": "18:00:00",
    "capacity": 500,
    "current_participants": 250,
    "status": "published",
    "organizer": {
      "id": 1,
      "name": "Tech Community Jakarta"
    },
    "image_url": "https://api.eventty.com/storage/events/tech-conf.jpg",
    "is_registered": false,
    "remaining_spots": 250,
    "created_at": "2024-08-01T10:00:00Z",
    "updated_at": "2024-08-15T14:30:00Z"
  }
}
```

### Registration Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "user_id": 5,
    "event_id": 1,
    "registration_number": "REG-20240915-001",
    "status": "registered",
    "registration_date": "2024-08-20T10:30:00Z",
    "payment_status": "completed",
    "qr_code_token": "abc123def456",
    "event": {
      "id": 1,
      "title": "Tech Conference 2024",
      "start_date": "2024-09-15",
      "location": "Jakarta"
    }
  }
}
```

### QR Code Response
```json
{
  "success": true,
  "data": {
    "qr_code_url": "https://api.eventty.com/storage/qr-codes/abc123.png",
    "qr_token": "abc123def456",
    "event_id": 1,
    "user_id": 5,
    "status": "active",
    "created_at": "2024-09-15T08:00:00Z"
  }
}
```

---

## 🔐 Security Agreements

**Agree dengan team:**

1. **Never commit sensitive data** (passwords, API keys, DB credentials)
2. **Use `.env` file** untuk sensitive config
3. **Add `.env` to `.gitignore`**
4. **Create `.env.example`** dengan placeholder values untuk reference
5. **Always hash passwords** sebelum save ke database
6. **Use HTTPS** di production
7. **Implement CORS** hanya untuk known domains
8. **Rate limiting** untuk mencegah abuse
9. **Input validation** di semua endpoints
10. **Proper error handling** (jangan expose internal error details)

---

## 📝 Git Workflow (Coordinate dengan team)

```bash
# Create feature branch
git checkout -b feature/auth-system

# Regular commits
git commit -m "Implement login endpoint"

# Push ke remote
git push origin feature/auth-system

# Create Pull Request untuk review

# After approval, merge ke develop/main
```

**Branch naming convention:**
- Feature: `feature/event-management`
- Bug fix: `bugfix/qr-scan-error`
- Hotfix: `hotfix/critical-bug`

---

## ✅ BEFORE SHIPPING TO FRONTEND/MOBILE

**Checklist sebelum pass API ke frontend dev:**

- [ ] All endpoints tested with Postman
- [ ] Error responses consistent
- [ ] Authentication working
- [ ] Rate limiting implemented
- [ ] CORS configured for frontend domain
- [ ] Input validation implemented
- [ ] Documentation complete (Swagger)
- [ ] Sample requests & responses provided
- [ ] Response times acceptable (<200ms)
- [ ] Logging implemented
- [ ] Security best practices followed

---

## 📚 Shared Documentation

**Create & share dengan team:**

1. **API Documentation** (Swagger/OpenAPI)
2. **Database Schema Diagram**
3. **Authentication Flow Diagram**
4. **Error Codes Reference**
5. **Request/Response Examples**

**Tools untuk documentation:**
- Swagger UI (auto-generated dari code)
- Postman Collection (shareable API examples)
- Confluence (team knowledge base)

---

Good luck with collaboration! 🚀

