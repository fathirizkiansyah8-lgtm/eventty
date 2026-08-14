# Smart Event Management API Documentation

**API Version:** 1.0.0  
**Base URL:** `http://127.0.0.1:8000/api`  
**Authentication:** Bearer Token (Sanctum)

---

## Table of Contents

1. [Authentication](#authentication)
2. [Events API](#events-api)
3. [Registrations API](#registrations-api)
4. [Attendance & QR Code](#attendance--qr-code)
5. [Certificates](#certificates)
6. [Notifications](#notifications)
7. [Admin Dashboard](#admin-dashboard)
8. [Error Handling](#error-handling)

---

## Authentication

### Register User

**POST** `/auth/register`

Create a new user account.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "08123456789",
  "role": "participant"
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "08123456789",
      "role": "participant"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
  }
}
```

---

### Login

**POST** `/auth/login`

Authenticate user and get access token.

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "08123456789",
      "role": "participant",
      "profile_photo_path": null
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
  }
}
```

---

### Get Profile

**GET** `/users/profile`

Get authenticated user's profile.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "08123456789",
    "role": "participant",
    "profile_photo_path": null,
    "is_active": true,
    "created_at": "2024-08-07T10:00:00.000000Z"
  }
}
```

---

### Update Profile

**PUT** `/users/profile`

Update authenticated user's profile.

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "John Updated",
  "phone": "08987654321"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "id": 1,
    "name": "John Updated",
    "email": "john@example.com",
    "phone": "08987654321",
    "profile_photo_path": null
  }
}
```

---

### Logout

**POST** `/auth/logout`

Logout and revoke access token.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

## Events API

### List Events (Public)

**GET** `/events`

Get all published events with pagination.

**Query Parameters:**
- `per_page` (default: 10) - Items per page

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Tech Conference 2024",
      "description": "Annual technology conference",
      "category": "Technology",
      "location": "Jakarta Convention Center",
      "start_date": "2024-09-15",
      "end_date": "2024-09-17",
      "start_time": "08:00:00",
      "end_time": "18:00:00",
      "capacity": 500,
      "current_participants": 250,
      "remaining_spots": 250,
      "organizer": {
        "id": 1,
        "name": "Tech Community",
        "email": "tech@example.com"
      },
      "is_paid": false,
      "price": 0,
      "thumbnail_image_path": null,
      "created_at": "2024-08-07T10:00:00.000000Z"
    }
  ],
  "pagination": {
    "total": 100,
    "per_page": 10,
    "current_page": 1,
    "last_page": 10
  }
}
```

---

### Get Event Detail

**GET** `/events/{id}`

Get detail of a specific event.

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Tech Conference 2024",
    "description": "Annual technology conference",
    "category": "Technology",
    "location": "Jakarta Convention Center",
    "start_date": "2024-09-15",
    "end_date": "2024-09-17",
    "start_time": "08:00:00",
    "end_time": "18:00:00",
    "capacity": 500,
    "current_participants": 250,
    "remaining_spots": 250,
    "organizer": {
      "id": 1,
      "name": "Tech Community",
      "email": "tech@example.com"
    },
    "status": "published",
    "is_paid": false,
    "price": 0,
    "is_registered": false,
    "created_at": "2024-08-07T10:00:00.000000Z"
  }
}
```

---

### Search Events

**GET** `/events/search?q=keyword`

Search events by title, description, or category.

**Query Parameters:**
- `q` (required) - Search query (minimum 2 characters)

**Response (200 OK):**
```json
{
  "success": true,
  "data": [...],
  "pagination": {...}
}
```

---

### Filter Events

**GET** `/events/filter`

Filter events by category, date range, location, and price.

**Query Parameters:**
- `category` - Event category
- `start_date` - Filter from this date (YYYY-MM-DD)
- `end_date` - Filter until this date (YYYY-MM-DD)
- `location` - Location search
- `is_paid` - Filter by paid/free (0 or 1)

**Response (200 OK):**
```json
{
  "success": true,
  "data": [...],
  "pagination": {...}
}
```

---

### Create Event

**POST** `/events`

Create a new event (authenticated users).

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "title": "Tech Conference 2024",
  "description": "Annual technology conference",
  "category": "Technology",
  "location": "Jakarta Convention Center",
  "start_date": "2024-09-15",
  "end_date": "2024-09-17",
  "start_time": "08:00",
  "end_time": "18:00",
  "capacity": 500,
  "status": "published",
  "is_paid": false,
  "price": 0
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Event created successfully",
  "data": {
    "id": 1,
    "title": "Tech Conference 2024",
    ...
  }
}
```

---

### My Events

**GET** `/users/my-events`

Get events where authenticated user is registered.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [...],
  "pagination": {...}
}
```

---

## Registrations API

### Register to Event

**POST** `/events/{id}/register`

Register authenticated user to an event.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Successfully registered for event",
  "data": {
    "id": 1,
    "registration_number": "REG-202408071000-ABC123",
    "event_id": 1,
    "event_title": "Tech Conference 2024",
    "status": "confirmed",
    "qr_token": "xyz123abc456...",
    "registration_date": "2024-08-07T10:30:00.000000Z"
  }
}
```

---

### My Registrations

**GET** `/registrations/my-registrations`

Get all registrations of authenticated user.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [...],
  "pagination": {...}
}
```

---

### Cancel Registration

**DELETE** `/registrations/{id}`

Cancel a registration.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Registration cancelled"
}
```

---

## Attendance & QR Code

### Get QR Code

**GET** `/events/{event_id}/qr-code`

Get QR code for check-in.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "qr_token": "xyz123abc456...",
    "event_id": 1,
    "event_title": "Tech Conference 2024",
    "qr_code_url": "http://127.0.0.1:8000/api/qr/xyz123abc456.png"
  }
}
```

---

### Scan QR Code

**POST** `/attendance/scan-qr`

Check-in by scanning QR code.

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "qr_token": "xyz123abc456..."
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Check-in successful",
  "data": {
    "user_name": "John Doe",
    "event_name": "Tech Conference 2024",
    "check_in_time": "2024-09-15T08:30:00.000000Z",
    "status": "present"
  }
}
```

---

### Attendance History

**GET** `/attendance/history`

Get attendance history of authenticated user.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [...],
  "pagination": {...}
}
```

---

## Certificates

### List Certificates

**GET** `/certificates`

Get all certificates of authenticated user.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [...],
  "pagination": {...}
}
```

---

### Get Certificate

**GET** `/certificates/{id}`

Get certificate detail.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "certificate_number": "CERT-2024-ABC123",
    "user": {...},
    "event": {...},
    "issued_date": "2024-09-17T18:00:00.000000Z",
    "is_downloaded": false,
    "created_at": "2024-09-17T18:00:00.000000Z"
  }
}
```

---

### Download Certificate

**GET** `/certificates/{id}/download`

Download certificate.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Certificate download link ready",
  "data": {
    "certificate_path": "certificates/1/1_abc123.pdf",
    "certificate_number": "CERT-2024-ABC123",
    "downloaded_at": "2024-08-07T10:00:00.000000Z"
  }
}
```

---

## Notifications

### Get Notifications

**GET** `/notifications`

Get all notifications of authenticated user.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": [...],
  "pagination": {...},
  "unread_count": 5
}
```

---

### Mark as Read

**PUT** `/notifications/{id}/mark-as-read`

Mark a notification as read.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Notification marked as read",
  "data": {...}
}
```

---

## Admin Dashboard

### Dashboard Stats

**GET** `/admin/dashboard/stats`

Get overall statistics.

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "total_events": 50,
    "total_participants": 5000,
    "total_users": 1000,
    "upcoming_events": 10,
    "completed_events": 20
  }
}
```

---

### Events Overview

**GET** `/admin/dashboard/events-overview`

Get overview of all events.

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Tech Conference 2024",
      "organizer": "Tech Community",
      "start_date": "2024-09-15",
      "capacity": 500,
      "registered": 250,
      "remaining": 250,
      "occupancy_rate": "50.00%",
      "status": "published"
    }
  ]
}
```

---

### Attendance Rate

**GET** `/admin/dashboard/attendance-rate`

Get attendance rates for completed events.

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "event_id": 1,
      "event_title": "Tech Conference 2024",
      "total_registered": 250,
      "total_attended": 200,
      "attendance_rate": "80.00%"
    }
  ]
}
```

---

### Categories Distribution

**GET** `/admin/dashboard/categories-distribution`

Get event distribution by category.

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "category": "Technology",
      "events": 25,
      "total_participants": 2500
    },
    {
      "category": "Business",
      "events": 15,
      "total_participants": 1500
    }
  ]
}
```

---

## Error Handling

### Error Response Format

All error responses follow this format:

```json
{
  "success": false,
  "message": "Error message",
  "error": "Detailed error information (optional)"
}
```

### HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Successful request |
| 201 | Created - Resource created successfully |
| 400 | Bad Request - Invalid input |
| 401 | Unauthorized - Missing or invalid token |
| 403 | Forbidden - No permission |
| 404 | Not Found - Resource not found |
| 422 | Unprocessable Entity - Validation error |
| 500 | Internal Server Error - Server error |

### Validation Error Response

```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "email": ["Email is required", "Email must be valid"],
    "password": ["Password must be at least 8 characters"]
  }
}
```

---

## Rate Limiting

API endpoints are rate-limited to prevent abuse:

- **Per User:** 100 requests per minute
- **Per IP:** 1000 requests per minute

Rate limit headers are included in responses:
```
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 99
X-RateLimit-Reset: 1629018000
```

---

## Authentication

All authenticated endpoints require:

```
Authorization: Bearer {access_token}
```

Access tokens are obtained from the login endpoint and remain valid until revoked (logout) or if explicitly deleted.

---

## Pagination

List endpoints support pagination:

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 10)

**Response includes:**
```json
"pagination": {
  "total": 100,
  "per_page": 10,
  "current_page": 1,
  "last_page": 10
}
```

---

## Testing

### Import Postman Collection

1. Open Postman
2. Click "Import"
3. Upload `POSTMAN_COLLECTION.json`
4. Replace `YOUR_TOKEN_HERE` with actual tokens from login response
5. Start testing!

### Using cURL

```bash
# Register
curl -X POST http://127.0.0.1:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'

# Get Profile (with token)
curl -X GET http://127.0.0.1:8000/api/users/profile \
  -H "Authorization: Bearer {token}"
```

---

**Last Updated:** August 7, 2026  
**API Version:** 1.0.0  
**Maintained by:** Backend Team
