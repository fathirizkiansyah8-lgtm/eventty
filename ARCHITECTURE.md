# 🏗️ Backend Architecture - Smart Event Management

## 📐 System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    Client Applications                       │
├──────────────────────────────┬──────────────────────────────┤
│  📱 Flutter Mobile App       │  🖥️ Web Admin Dashboard     │
│  (Participants)             │  (Organizers/Admin)         │
└──────────────────────────────┴──────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                    API Gateway Layer                         │
│  ├─ CORS Middleware                                         │
│  ├─ Rate Limiting                                           │
│  └─ Request Logging                                         │
└──────────────────────────┬──────────────────────────────────┘
                           ▼
┌─────────────────────────────────────────────────────────────┐
│              Laravel Backend (REST API)                      │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────────────────────────────────────┐      │
│  │           API Routes (routes/api.php)            │      │
│  │  ├─ /api/auth/*                                  │      │
│  │  ├─ /api/events/*                                │      │
│  │  ├─ /api/registrations/*                         │      │
│  │  ├─ /api/attendance/*                            │      │
│  │  ├─ /api/certificates/*                          │      │
│  │  ├─ /api/notifications/*                         │      │
│  │  └─ /api/admin/*                                 │      │
│  └──────────────────────────────────────────────────┘      │
│                           ▼                                 │
│  ┌──────────────────────────────────────────────────┐      │
│  │            Controllers Layer                      │      │
│  │  ├─ AuthController                               │      │
│  │  ├─ EventController                              │      │
│  │  ├─ RegistrationController                       │      │
│  │  ├─ AttendanceController                         │      │
│  │  ├─ CertificateController                        │      │
│  │  ├─ NotificationController                       │      │
│  │  └─ DashboardController                          │      │
│  └──────────────────────────────────────────────────┘      │
│                           ▼                                 │
│  ┌──────────────────────────────────────────────────┐      │
│  │            Services Layer                        │      │
│  │  ├─ AuthService (Login, Register)                │      │
│  │  ├─ EventService (CRUD, Filtering)               │      │
│  │  ├─ RegistrationService (Register, Cancel)       │      │
│  │  ├─ QRCodeService (Generate, Validate)           │      │
│  │  ├─ AttendanceService (Check-in, Reports)        │      │
│  │  ├─ CertificateService (Generate, Export)        │      │
│  │  └─ NotificationService (Send, Track)            │      │
│  └──────────────────────────────────────────────────┘      │
│                           ▼                                 │
│  ┌──────────────────────────────────────────────────┐      │
│  │         Validation & Business Logic              │      │
│  │  ├─ Form Requests (Validation)                   │      │
│  │  ├─ Custom Exceptions                            │      │
│  │  └─ Authorization (Policies & Gates)             │      │
│  └──────────────────────────────────────────────────┘      │
│                           ▼                                 │
│  ┌──────────────────────────────────────────────────┐      │
│  │         Models Layer (Eloquent ORM)              │      │
│  │  ├─ User                                         │      │
│  │  ├─ Event                                        │      │
│  │  ├─ Registration                                 │      │
│  │  ├─ Attendance                                   │      │
│  │  ├─ Certificate                                  │      │
│  │  └─ Notification                                 │      │
│  └──────────────────────────────────────────────────┘      │
│                           ▼                                 │
│  ┌──────────────────────────────────────────────────┐      │
│  │       Jobs & Queue (Background Tasks)            │      │
│  │  ├─ GenerateCertificatesJob                      │      │
│  │  ├─ SendNotificationsJob                         │      │
│  │  └─ SendEmailJob                                 │      │
│  └──────────────────────────────────────────────────┘      │
│                                                              │
└─────────────────────────────┬───────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│              Data Layer & External Services                  │
├──────────────────────┬───────────────┬──────────────────────┤
│   🗄️ MySQL Database  │  📨 Mail      │  🖼️ File Storage   │
│   ├─ users           │  └─ SMTP      │   ├─ Images        │
│   ├─ events          │               │   ├─ Certificates  │
│   ├─ registrations   │               │   └─ QR Codes      │
│   ├─ attendance      │               │                     │
│   ├─ certificates    │               │                     │
│   └─ notifications   │               │                     │
└──────────────────────┴───────────────┴──────────────────────┘
```

---

## 📦 Detailed Component Architecture

### 1. **Authentication Layer** (Sanctum JWT)

```
User Request
    ↓
Sanctum Middleware (Validate Token)
    ↓
✓ Valid → Access granted
✗ Invalid → 401 Unauthorized
```

**Flow:**
```
Register/Login → Generate Token → Send to Client → Client stores token
Client includes token in every request → Backend validates
```

---

### 2. **Request-Response Cycle**

```
REQUEST
┌──────────────────────────────────┐
│ POST /api/events/1/register      │
│ Headers: {                        │
│   Authorization: Bearer {token}  │
│   Content-Type: application/json │
│ }                                │
│ Body: {                          │
│   confirmation: true             │
│ }                                │
└──────────────────────────────────┘
          ↓ (Routing)
┌──────────────────────────────────┐
│ RegistrationController@store()   │
└──────────────────────────────────┘
          ↓ (Validation)
┌──────────────────────────────────┐
│ StoreRegistrationRequest         │
└──────────────────────────────────┘
          ↓ (Business Logic)
┌──────────────────────────────────┐
│ RegistrationService::register()  │
└──────────────────────────────────┘
          ↓ (Database)
┌──────────────────────────────────┐
│ Registration::create()           │
│ Database INSERT                  │
└──────────────────────────────────┘
          ↓ (Response)
┌──────────────────────────────────┐
│ RESPONSE 201 Created             │
│ {                                │
│   success: true                  │
│   data: { id, user_id, ... }    │
│   message: "Registered"          │
│ }                                │
└──────────────────────────────────┘
```

---

### 3. **Database Schema Relationships**

```
┌─────────────────┐
│ users           │ (1)
├─────────────────┤
│ id (PK)         │
│ name            │
│ email           │
│ password        │
│ role            │
│ ...             │
└────────┬────────┘
         │
         │ (1 → M)
         │
    ┌────┴──────────────────────────┐
    │                               │
    ↓ (organizer)            ↓ (participant)
┌──────────────────┐    ┌─────────────────────┐
│ events           │    │ registrations       │
├──────────────────┤    ├─────────────────────┤
│ id (PK)          │    │ id (PK)             │
│ organizer_id (FK)────→│ user_id (FK)        │
│ title            │    │ event_id (FK)       │
│ capacity         │    │ registration_date   │
│ status           │    │ status              │
│ ...              │    │ ...                 │
└────────┬─────────┘    └──────────┬──────────┘
         │ (1 → M)                 │ (1 → 1)
         │                         │
    ┌────┴──────────────────┐      ▼
    ↓                       │  ┌──────────────────┐
┌─────────────────┐   ┌─────┴──────────┐        │ attendance      │
│ attendance      │   │ certificates    │        ├──────────────────┤
├─────────────────┤   ├─────────────────┤        │ id (PK)          │
│ id (PK)         │   │ id (PK)         │        │ registration_id │
│ event_id (FK)   │   │ registration_id │        │ qr_token        │
│ user_id (FK)    │   │ user_id (FK)    │        │ check_in_time   │
│ qr_token        │   │ certificate_path│        │ status          │
│ check_in_time   │   │ issued_date     │        │ ...             │
│ status          │   │ ...             │        └──────────────────┘
│ ...             │   └─────────────────┘
└─────────────────┘
```

---

### 4. **API Endpoint Organization**

```
Routes: /api/

PUBLIC ROUTES (No authentication required):
  /api/auth/register
  /api/auth/login
  /api/events (list)
  /api/events/:id (detail)
  /api/events/search
  /api/events/filter

PROTECTED ROUTES (Authentication required):
  /api/auth/logout
  /api/users/profile
  /api/users/profile (PUT)
  /api/registrations/my-registrations
  /api/events/:id/register
  /api/events/:id/qr-code
  /api/attendance/scan-qr
  /api/certificates
  /api/notifications

ADMIN ROUTES (Admin authentication required):
  /api/admin/events (CRUD)
  /api/admin/events/:id/participants
  /api/admin/events/:id/attendance
  /api/admin/events/:id/certificates/generate
  /api/admin/dashboard/stats
```

---

### 5. **Data Flow Examples**

#### **Event Registration Flow**

```
User clicks "Register" (Mobile)
    ↓
POST /api/events/:id/register
    ↓
RegistrationController@store()
    ↓
StoreRegistrationRequest (Validate input)
    ↓
RegistrationService::register()
    - Check event exists
    - Check user not already registered
    - Check event capacity not full
    ↓
Registration::create()
    - Insert to database
    ↓
Emit Event "UserRegistered"
    ↓
Jobs queued:
    - SendConfirmationEmail
    - GenerateQRCode
    ↓
Response: 201 Created
    {
      success: true,
      data: { registration object },
      message: "Successfully registered"
    }
    ↓
Background Jobs Processing:
    - Email sent to user
    - QR code generated & stored
```

---

#### **QR Code Scan Flow**

```
User scans QR code (Mobile camera)
    ↓
Extract QR token
    ↓
POST /api/attendance/scan-qr
    {
      qr_token: "abc123def456"
    }
    ↓
AttendanceController@scanQR()
    ↓
QRCodeService::validate()
    - Find attendance record by token
    - Check event is happening
    - Check not already checked in
    ↓
Attendance::update()
    - Set check_in_time = now()
    - Set status = "present"
    ↓
Response: 200 OK
    {
      success: true,
      message: "Check-in successful",
      data: { 
        user_name,
        event_name,
        check_in_time
      }
    }
```

---

#### **Certificate Generation Flow**

```
Admin clicks "Generate Certificates" (Web)
    ↓
POST /api/admin/events/:id/certificates/generate
    ↓
CertificateController@generate()
    ↓
Queue Job: GenerateCertificatesJob
    ↓
Job Processing:
    - Find all participants who attended (status = "present")
    - For each participant:
        - Load certificate template
        - Replace placeholders (name, date, etc)
        - Generate PDF
        - Save to storage
        - Create Certificate record in DB
    ↓
Email Notification sent to users:
    "Your certificate is ready!"
    ↓
Admin Dashboard shows completion status
```

---

## 🔄 Data Persistence & Relationships

```
WHEN USER REGISTERS FOR EVENT:
  ├─ Create Registration record
  ├─ Update Event.current_participants_count
  ├─ Generate QR code token
  ├─ Queue background jobs
  └─ Response to client

WHEN USER CHECKS IN:
  ├─ Find Attendance record
  ├─ Update check_in_time
  ├─ Update status to "present"
  └─ Queue notification job

WHEN CERTIFICATE GENERATED:
  ├─ Validate user attended
  ├─ Generate PDF file
  ├─ Create Certificate record
  ├─ Store file path
  └─ Send notification email

WHEN USER LOGS OUT:
  ├─ Revoke token
  ├─ Log logout event
  └─ Notify user
```

---

## 🛡️ Security Architecture

```
┌────────────────────────────────────────┐
│      Client Request                    │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 1. CORS Middleware                     │
│    (Check origin)                      │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 2. Rate Limiting                       │
│    (Throttle by IP/User)               │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 3. Authentication Middleware           │
│    (Validate JWT token)                │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 4. Authorization (Policies)            │
│    (Check user permissions)            │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 5. Input Validation                    │
│    (Form Requests)                     │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 6. Sanitization                        │
│    (Clean user input)                  │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 7. Execute Action (Safe)               │
└────────────────────────────────────────┘
            ↓
┌────────────────────────────────────────┐
│ 8. Response (No sensitive data)        │
└────────────────────────────────────────┘
```

---

## 🎯 Service Layer Pattern

```
Controller
    ↓
Service (Business Logic)
    ├─ Data Validation
    ├─ Business Rules Check
    ├─ Authorization Check
    ├─ Database Operations
    ├─ External API Calls
    ├─ Queue Background Jobs
    └─ Return Result
    ↓
Response to Client
```

**Example:**

```php
// Controller
public function register(Request $request, $eventId)
{
    return $this->registrationService->register(
        auth()->user(),
        $eventId,
        $request->validated()
    );
}

// Service
public function register(User $user, $eventId, array $data)
{
    // Validate event exists
    $event = Event::findOrFail($eventId);
    
    // Check user not already registered
    if ($user->registrations()->where('event_id', $eventId)->exists()) {
        throw new AlreadyRegisteredException();
    }
    
    // Check capacity
    if ($event->current_participants >= $event->capacity) {
        throw new EventFullException();
    }
    
    // Create registration
    $registration = $user->registrations()->create([
        'event_id' => $eventId,
        'registration_number' => $this->generateRegistrationNumber(),
    ]);
    
    // Update event count
    $event->increment('current_participants');
    
    // Generate QR code
    QRCodeService::generate($registration);
    
    // Queue jobs
    SendConfirmationEmail::dispatch($registration);
    
    return $registration;
}
```

---

## 📊 Caching Strategy

```
┌──────────────────────┐
│ Request              │
└──────────┬───────────┘
           ↓
    ┌──────────────────┐
    │ Check Cache      │
    └──────┬───────────┘
           ↓
    ┌─────────────────────┐
    │ Cache HIT?          │
    └──────┬──────────────┘
        NO │    YES
           │      └─→ Return cached value
           ↓
    ┌────────────────────┐
    │ Query Database     │
    └────────┬───────────┘
             ↓
    ┌────────────────────┐
    │ Store in Cache     │ (TTL: 1 hour)
    └────────┬───────────┘
             ↓
    ┌────────────────────┐
    │ Return to Client   │
    └────────────────────┘
```

**What to cache:**
- Event list (20 min TTL)
- Event details (20 min TTL)
- Attendance reports (5 min TTL)
- User profile (10 min TTL)

**Invalidate cache when:**
- Event updated
- New registration
- Attendance marked
- Certificate generated

---

## 🔄 Error Handling Flow

```
Request reaches Controller/Service
    ↓
Try to execute logic
    ↓
Exception thrown?
    ├─ ValidationException
    │   └─ Response: 422 + errors
    ├─ AuthenticationException
    │   └─ Response: 401 + message
    ├─ AuthorizationException
    │   └─ Response: 403 + message
    ├─ ModelNotFoundException
    │   └─ Response: 404 + message
    ├─ CustomBusinessException
    │   └─ Response: 400 + message
    └─ SystemException
        └─ Response: 500 + message

All logged to logs/laravel.log
User receives appropriate response
```

---

## 📈 Performance Optimization

```
API Request
    ↓
┌─────────────────────────────────┐
│ 1. Eager Loading (N+1 problem)  │
│    Event::with(['organizer',    │
│                 'registrations']│
└─────────────────────────────────┘
    ↓
┌─────────────────────────────────┐
│ 2. Pagination                   │
│    Event::paginate(20)          │
└─────────────────────────────────┘
    ↓
┌─────────────────────────────────┐
│ 3. Indexing (Database)          │
│    user_id, event_id, status    │
└─────────────────────────────────┘
    ↓
┌─────────────────────────────────┐
│ 4. Caching                      │
│    Cache results                │
└─────────────────────────────────┘
    ↓
Response delivered to client
(Ideally < 200ms)
```

---

## 🎯 Summary

**Backend Architecture Highlights:**

1. **Layered Architecture** - Clear separation of concerns
2. **Service-Oriented** - Business logic isolated in services
3. **Middleware Security** - Multiple security layers
4. **Database Normalization** - Proper relationships & indexing
5. **Job Queue** - Background processing for heavy tasks
6. **Caching** - Performance optimization
7. **Error Handling** - Graceful error responses
8. **API Documentation** - Clear endpoints & formats

This architecture ensures:
- ✅ Scalability
- ✅ Maintainability
- ✅ Security
- ✅ Performance
- ✅ Testability

