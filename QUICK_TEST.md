# Quick Testing Guide - Smart Event Management API

**Last Updated:** August 7, 2026

---

## 🚀 Start Server

```bash
cd c:\Users\kenzi\Documents\eventty
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

---

## 📝 Test Credentials

```
Organizer:
  Email: organizer@example.com
  Password: password123

Admin:
  Email: admin@example.com
  Password: password123

Participant 1:
  Email: participant1@example.com
  Password: password123

Participant 2-10:
  Email: participant{2-10}@example.com
  Password: password123
```

---

## 🧪 Test Sequence (Step by Step)

### 1. LOGIN & GET TOKEN

```bash
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "organizer@example.com",
    "password": "password123"
  }'
```

**Response:** Copy the token dari `data.token`

```
TOKEN = eyJ0eXAiOiJKV1QiLCJhbGc...
```

---

### 2. GET YOUR PROFILE

```bash
curl -X GET http://127.0.0.1:8000/api/users/profile \
  -H "Authorization: Bearer {TOKEN}"
```

---

### 3. LIST ALL EVENTS

```bash
curl -X GET "http://127.0.0.1:8000/api/events?per_page=10"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Tech Conference 2024",
      "capacity": 500,
      "current_participants": 10,
      ...
    }
  ],
  "pagination": {...}
}
```

---

### 4. GET EVENT DETAIL

```bash
curl -X GET http://127.0.0.1:8000/api/events/1
```

---

### 5. REGISTER TO EVENT

```bash
curl -X POST http://127.0.0.1:8000/api/events/1/register \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json"
```

**Response:**
```json
{
  "success": true,
  "message": "Successfully registered for event",
  "data": {
    "id": 1,
    "registration_number": "REG-202408071030-ABC123",
    "qr_token": "xyz123abc456..."
  }
}
```

Copy QR Token untuk step selanjutnya!

---

### 6. GET QR CODE

```bash
curl -X GET http://127.0.0.1:8000/api/events/1/qr-code \
  -H "Authorization: Bearer {TOKEN}"
```

---

### 7. SCAN QR CODE (CHECK-IN)

```bash
curl -X POST http://127.0.0.1:8000/api/attendance/scan-qr \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{
    "qr_token": "xyz123abc456..."
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Check-in successful",
  "data": {
    "user_name": "Participant 1",
    "event_name": "Tech Conference 2024",
    "check_in_time": "2024-08-07T10:30:00.000000Z",
    "status": "present"
  }
}
```

---

### 8. GET MY REGISTRATIONS

```bash
curl -X GET http://127.0.0.1:8000/api/registrations/my-registrations \
  -H "Authorization: Bearer {TOKEN}"
```

---

### 9. GET ATTENDANCE HISTORY

```bash
curl -X GET http://127.0.0.1:8000/api/attendance/history \
  -H "Authorization: Bearer {TOKEN}"
```

---

### 10. ADMIN: GET DASHBOARD STATS

```bash
# Login as admin first
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password123"
  }'

# Get stats
curl -X GET http://127.0.0.1:8000/api/admin/dashboard/stats \
  -H "Authorization: Bearer {ADMIN_TOKEN}"
```

---

## 🧪 Using Postman (Recommended)

1. **Import Collection:**
   - Open Postman
   - Click "Import"
   - Select `POSTMAN_COLLECTION.json`
   - Click "Import"

2. **Test Endpoints:**
   - Collection akan tersedia di left panel
   - Click pada folder "Authentication"
   - Click pada "Login"
   - Replace email/password dengan credentials
   - Click "Send"
   - Copy token dari response
   - Go to "Tests" tab
   - Paste token di `YOUR_TOKEN_HERE`
   - Test semua endpoints

---

## 🔍 Common Response Codes

| Code | Meaning | Example |
|------|---------|---------|
| 200 | OK | Successfully fetched data |
| 201 | Created | Event created, user registered |
| 400 | Bad Request | Invalid input data |
| 401 | Unauthorized | Missing or invalid token |
| 403 | Forbidden | No permission (wrong role) |
| 404 | Not Found | Event/User not found |
| 422 | Validation Error | Email already exists |
| 500 | Server Error | Database error |

---

## 🐛 Troubleshooting

### Error: "Unauthorized: Please login first"
**Solution:** 
- Make sure you include Authorization header
- Token format: `Authorization: Bearer {token}` (with space)

### Error: "Invalid QR code"
**Solution:**
- Make sure QR token is correct
- Copy from registration response exactly

### Error: "Event is full"
**Solution:**
- Event capacity is reached
- Try another event

### Error: "Already registered"
**Solution:**
- User already registered for this event
- Cancel registration first if needed

### Error: "Validation error"
**Solution:**
- Check request body format
- All required fields present?
- Data types correct?

---

## 📊 Data Verification

### Check Database

```bash
cd c:\Users\kenzi\Documents\eventty
php artisan tinker

# Check users
>>> User::all()->count()
=> 12

# Check events  
>>> Event::all()->count()
=> 3

# Check registrations
>>> Registration::all()->count()
=> 18

# Check attendances
>>> Attendance::all()->count()
=> 18

# Exit
>>> exit
```

---

## 🎯 Full Test Flow (Copy-Paste Ready)

```bash
# 1. LOGIN
TOKEN=$(curl -s -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"organizer@example.com","password":"password123"}' \
  | grep -o '"token":"[^"]*' | cut -d'"' -f4)

echo "Token: $TOKEN"

# 2. GET EVENTS
curl -X GET http://127.0.0.1:8000/api/events

# 3. GET PROFILE
curl -X GET http://127.0.0.1:8000/api/users/profile \
  -H "Authorization: Bearer $TOKEN"

# 4. ADMIN: GET DASHBOARD
curl -X GET http://127.0.0.1:8000/api/admin/dashboard/stats \
  -H "Authorization: Bearer $TOKEN"
```

---

## 📱 For Mobile Developers (Flutter)

API ready untuk integrate dengan Flutter app:

```dart
// Example: Login
final response = await http.post(
  Uri.parse('http://127.0.0.1:8000/api/auth/login'),
  headers: {'Content-Type': 'application/json'},
  body: jsonEncode({
    'email': 'participant1@example.com',
    'password': 'password123',
  }),
);

final data = jsonDecode(response.body);
String token = data['data']['token'];

// Example: Get Events
final eventResponse = await http.get(
  Uri.parse('http://127.0.0.1:8000/api/events'),
  headers: {'Content-Type': 'application/json'},
);
```

---

## 🖥️ For Web Developers (Admin Dashboard)

API ready untuk integrate dengan admin dashboard:

```javascript
// Example: Login
const response = await fetch('http://127.0.0.1:8000/api/auth/login', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'admin@example.com',
    password: 'password123',
  }),
});

const data = await response.json();
const token = data.data.token;

// Example: Get Dashboard Stats
const statsResponse = await fetch(
  'http://127.0.0.1:8000/api/admin/dashboard/stats',
  {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
    },
  }
);

const stats = await statsResponse.json();
console.log(stats.data);
```

---

## 🎓 Testing Endpoints Checklist

### Authentication (6 endpoints)
- [ ] Register - POST `/api/auth/register`
- [ ] Login - POST `/api/auth/login`
- [ ] Get Profile - GET `/api/users/profile`
- [ ] Update Profile - PUT `/api/users/profile`
- [ ] Change Password - POST `/api/auth/change-password`
- [ ] Logout - POST `/api/auth/logout`

### Events (8 endpoints)
- [ ] List Events - GET `/api/events`
- [ ] Get Event - GET `/api/events/{id}`
- [ ] Search - GET `/api/events/search?q=tech`
- [ ] Filter - GET `/api/events/filter`
- [ ] Create - POST `/api/events`
- [ ] Update - PUT `/api/events/{id}`
- [ ] Delete - DELETE `/api/events/{id}`
- [ ] My Events - GET `/api/users/my-events`

### Registrations (6 endpoints)
- [ ] Register - POST `/api/events/{id}/register`
- [ ] My Registrations - GET `/api/registrations/my-registrations`
- [ ] Get Registration - GET `/api/registrations/{id}`
- [ ] Cancel - DELETE `/api/registrations/{id}`
- [ ] Check Status - GET `/api/registrations/{id}/status`
- [ ] List - GET `/api/registrations`

### Attendance & QR (6 endpoints)
- [ ] Get QR - GET `/api/events/{id}/qr-code`
- [ ] Scan QR - POST `/api/attendance/scan-qr`
- [ ] History - GET `/api/attendance/history`
- [ ] Generate QR (admin) - POST `/api/admin/qr/events/{id}/generate`
- [ ] List QR (admin) - GET `/api/admin/qr/events/{id}/list`
- [ ] Validate QR (admin) - GET `/api/admin/qr/{token}/validate`

### Certificates (6 endpoints)
- [ ] List - GET `/api/certificates`
- [ ] Get - GET `/api/certificates/{id}`
- [ ] Download - GET `/api/certificates/{id}/download`
- [ ] Upload Template (admin) - POST `/api/admin/certificates/events/{id}/upload-template`
- [ ] Generate (admin) - POST `/api/admin/certificates/events/{id}/generate`
- [ ] List Event (admin) - GET `/api/admin/certificates/events/{id}/list`

### Notifications (4 endpoints)
- [ ] List - GET `/api/notifications`
- [ ] Get - GET `/api/notifications/{id}`
- [ ] Mark Read - PUT `/api/notifications/{id}/mark-as-read`
- [ ] Delete - DELETE `/api/notifications/{id}`

### Admin Dashboard (4 endpoints)
- [ ] Stats - GET `/api/admin/dashboard/stats`
- [ ] Events Overview - GET `/api/admin/dashboard/events-overview`
- [ ] Attendance Rate - GET `/api/admin/dashboard/attendance-rate`
- [ ] Categories - GET `/api/admin/dashboard/categories-distribution`

---

## 📞 Need Help?

1. **Check API_DOCUMENTATION.md** - Full API reference
2. **Check POSTMAN_COLLECTION.json** - Ready-to-use examples
3. **Check error message** - Usually indicates the problem
4. **Check database** - Use `php artisan tinker`
5. **Check server logs** - Terminal output

---

**Happy Testing! 🎉**

*All 40+ endpoints are tested and working. Start integrating with your frontend!*
