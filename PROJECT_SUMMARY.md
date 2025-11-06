# EduBridge (Edub) - Comprehensive Project Summary

## 🎯 Project Overview

**EduBridge** is a Laravel-based web application that connects youth with educational opportunities, internships, volunteering programs, and training courses. The platform facilitates the interaction between three main user types: **Youth** (students/learners), **Organizations** (providers of opportunities), and **Admins** (platform administrators).

### Purpose
- Enable organizations to post and manage opportunities
- Allow youth to discover and apply for opportunities
- Provide admins with tools to verify organizations and oversee the platform
- Track applications and generate certificates upon completion

---

## 🏗️ Architecture & Technology Stack

### Backend Framework
- **Laravel 12** (PHP 8.2+)
- **MySQL/MariaDB** or **SQLite** database
- **Eloquent ORM** for database interactions

### Frontend Technologies
- **Blade Templates** (server-side rendering)
- **Tailwind CSS 3.1** (utility-first CSS framework)
- **Alpine.js 3.4** (lightweight JavaScript framework)
- **Vite 7.0** (build tool and asset bundler)

### Authentication & Security
- **Laravel Breeze** (authentication scaffolding)
- **Role-based Access Control (RBAC)** via custom middleware
- **Password hashing** (bcrypt)
- **CSRF protection** (built-in Laravel)

### Testing
- **Pest PHP 4.1** (testing framework)
- **PHPUnit** for unit and feature tests

---

## 👥 User Roles & Permissions

### 1. **Admin Role**
**Capabilities:**
- View all registered organizations and youth
- Verify organizations (approve/revoke verification status)
- Access admin dashboard with platform statistics
- Full platform oversight

**Routes Access:**
- `/admin/dashboard` - Admin dashboard
- `/admin/verify/{id}` - Verify organization
- `/admin/revoke/{id}` - Revoke organization verification

**Middleware:** `auth`, `role:Admin`

---

### 2. **Organization Role**
**Capabilities:**
- Create and manage opportunities (internships, volunteering, training)
- View applicants for their posted opportunities
- Update application status (Pending → Accepted/Rejected)
- Manage organization profile
- Post opportunities that become visible only after admin verification

**Routes Access:**
- `/organization/dashboard` - View and create opportunities
- `/organization/opportunity/{id}/applicants` - View applicants
- `/organization/application/{id}/status` - Update application status
- `/organization/profile` - Manage profile

**Middleware:** `auth`, `role:Organization`

**Important Notes:**
- Organizations must be verified by an admin before their opportunities are visible to youth
- Opportunities link to organization via `organization_id`
- Organization record is auto-created when first opportunity is posted

---

### 3. **Youth Role**
**Capabilities:**
- Browse verified opportunities from verified organizations
- Apply to opportunities (with optional cover letter)
- View application status (Pending/Accepted/Rejected)
- Manage youth profile (education, skills, bio, availability)
- View certificates (feature partially implemented)

**Routes Access:**
- `/opportunities` - Browse all verified opportunities
- `/opportunities/{id}` - View opportunity details
- `/opportunities/{id}/apply` - Apply to opportunity
- `/my-applications` - View personal applications
- `/youth/profile` - View/Edit profile
- `/certificates` - View certificates (incomplete)

**Middleware:** `auth`, `role:Youth`

**Important Notes:**
- Only opportunities from verified organizations are visible
- Cannot apply twice to the same opportunity (duplicate prevention)
- Youth profile is auto-created on first application

---

## 📊 Database Schema

### Core Tables

#### 1. **users**
**Purpose:** Authentication and basic user information
```sql
- id (primary key)
- name
- email (unique)
- password (hashed)
- role (enum: 'Admin', 'Organization', 'Youth')
- verified (boolean) - for organization verification
- organization_name (nullable)
- description (nullable)
- bio (nullable)
- skills (nullable)
- email_verified_at (nullable)
- remember_token
- created_at, updated_at
```

**Relationships:**
- `hasOne` YouthProfile
- `hasOne` Organization

---

#### 2. **youth_profiles**
**Purpose:** Extended profile information for youth users
```sql
- id (primary key)
- user_id (foreign key → users)
- full_name
- gender (nullable)
- birth_date (nullable)
- education_level (nullable)
- bio (nullable)
- skills (JSON array)
- availability (nullable)
- contact_number (nullable)
- location (nullable)
- verified (boolean, default: false)
- created_at, updated_at
```

**Relationships:**
- `belongsTo` User
- `hasMany` Applications (via youth_profile_id)

---

#### 3. **organizations**
**Purpose:** Organization details and verification status
```sql
- id (primary key)
- user_id (foreign key → users)
- name
- type (nullable) - e.g., 'NGO', 'Company', 'Training Center'
- contact_email
- contact_phone (nullable)
- location (nullable)
- description (nullable)
- verified (boolean, default: false) - admin verification
- created_at, updated_at
```

**Relationships:**
- `belongsTo` User
- `hasMany` Opportunities

**Important:** Organization record is created automatically when an organization user posts their first opportunity.

---

#### 4. **opportunities**
**Purpose:** Posted opportunities (internships, volunteering, training)
```sql
- id (primary key)
- organization_id (foreign key → organizations)
- title
- description (text)
- requirements (text, nullable)
- type (nullable) - 'internship', 'volunteering', 'training'
- start_date (date, nullable)
- end_date (date, nullable)
- deadline (date, nullable)
- duration_weeks (integer, nullable)
- available_slots (integer, default: 1)
- approved (boolean, default: false) - admin approval
- created_at, updated_at
```

**Relationships:**
- `belongsTo` Organization
- `hasMany` Applications

**Visibility Rules:**
- Only opportunities from verified organizations are shown to youth
- Organizations can see all their own opportunities regardless of verification

---

#### 5. **applications**
**Purpose:** Youth applications to opportunities
```sql
- id (primary key)
- opportunity_id (foreign key → opportunities)
- youth_profile_id (foreign key → youth_profiles)
- status (enum: 'Pending', 'Accepted', 'Rejected', 'Completed')
- cover_letter (text, nullable)
- applied_on (date, default: current date)
- created_at, updated_at
```

**Relationships:**
- `belongsTo` Opportunity
- `belongsTo` YouthProfile

**Business Logic:**
- Status defaults to 'Pending'
- Cannot apply twice (enforced in ApplicationController)
- Status can be updated by organization owner

---

#### 6. **certificates**
**Purpose:** Certificates issued upon opportunity completion
```sql
- id (primary key)
- application_id (foreign key → applications)
- certificate_number (string, unique)
- file_path (nullable) - PDF storage path
- issued_on (date, default: current date)
- created_at, updated_at
```

**Status:** ⚠️ **INCOMPLETE** - Model and controller are empty, migration exists

**Relationships:**
- `belongsTo` Application (should be implemented)

---

## 🔄 Application Flow & User Journeys

### Journey 1: Organization Posts Opportunity

1. **Registration/Login**
   - Organization registers with role "Organization"
   - Logs in via `/login`

2. **Dashboard Access**
   - Redirected to `/organization/dashboard`
   - Sees form to create opportunity

3. **Create Opportunity**
   - Fills form: title, description, deadline, seats
   - Submits → `OpportunityController@store`
   - Organization record auto-created if doesn't exist
   - Opportunity saved with `approved = false`

4. **Admin Verification Required**
   - Admin logs in → `/admin/dashboard`
   - Sees organization in "Pending" status
   - Clicks "Verify" → sets `verified = true` on User model
   - Opportunity becomes visible to youth

5. **View Applicants**
   - Organization clicks "View Applicants" on opportunity
   - Sees list of applications with youth details
   - Can update status: Pending → Accepted/Rejected

---

### Journey 2: Youth Applies for Opportunity

1. **Registration/Login**
   - Youth registers with role "Youth"
   - Logs in via `/login`

2. **Browse Opportunities**
   - Redirected to `/opportunities` (list view)
   - Sees only opportunities from verified organizations
   - Can click to view details (`/opportunities/{id}`)

3. **Apply**
   - Clicks "Apply" button
   - `ApplicationController@apply` checks for duplicates
   - YouthProfile auto-created if doesn't exist
   - Application created with status "Pending"

4. **Track Applications**
   - Navigates to `/my-applications`
   - Sees all applications with current status
   - Can view opportunity details

5. **Profile Management**
   - Accesses `/youth/profile` to view profile
   - `/youth/profile/edit` to update:
     - Full name, gender, birth date
     - Education level, bio
     - Skills (comma-separated, converted to JSON array)
     - Availability, contact, location

---

### Journey 3: Admin Manages Platform

1. **Login**
   - Admin logs in → redirected to `/admin/dashboard`

2. **View Organizations**
   - Sees table of all organizations
   - Status column shows "Verified" or "Pending"

3. **Verify Organization**
   - Clicks "Verify" → `AdminController@verifyOrg`
   - Sets `user.verified = true`
   - Organization's opportunities become visible to youth

4. **Revoke Verification**
   - Can revoke if needed → sets `verified = false`
   - Opportunities hidden from youth

5. **View Youth**
   - Sees table of all registered youth users
   - Read-only view for monitoring

---

## 🛣️ Route Structure

### Public Routes
- `/` - Welcome page
- `/login` - Login form
- `/register` - Registration form
- `/forgot-password` - Password reset request
- `/reset-password/{token}` - Password reset form

### Authenticated Routes (All Roles)
- `/dashboard` - Role-based redirect
- `/profile` - Profile management
- `/logout` - Logout

### Admin Routes (`role:Admin`)
- `/admin/dashboard` - Admin dashboard
- `/admin/verify/{id}` - Verify organization (POST)
- `/admin/revoke/{id}` - Revoke verification (POST)

### Organization Routes (`role:Organization`)
- `/organization/dashboard` - View/create opportunities
- `/organization/opportunities` (POST) - Create opportunity
- `/organization/opportunity/{id}/applicants` - View applicants
- `/organization/application/{id}/status` (POST) - Update status
- `/organization/profile` - Organization profile

### Youth Routes (`role:Youth`)
- `/opportunities` - List all verified opportunities
- `/opportunities/{id}` - View opportunity details
- `/opportunities/{id}/apply` (POST) - Apply to opportunity
- `/my-applications` - View personal applications
- `/youth/profile` - View youth profile
- `/youth/profile/edit` - Edit youth profile
- `/youth/profile/update` (POST) - Update profile
- `/certificates` - View certificates (incomplete)

---

## 🎨 Views & UI Components

### Layouts
- `layouts/app.blade.php` - Main authenticated layout
- `layouts/guest.blade.php` - Guest/public layout
- `components/navigation.blade.php` - Navigation menu

### Auth Views
- `auth/login.blade.php` - Login form
- `auth/register.blade.php` - Registration form
- `auth/forgot-password.blade.php` - Password reset request
- `auth/reset-password.blade.php` - Password reset form
- `auth/verify-email.blade.php` - Email verification

### Admin Views
- `admin/dashboard.blade.php` - Admin dashboard with organizations/youth tables

### Organization Views
- `organization/dashboard.blade.php` - Opportunity creation form + list
- `organization/applicants.blade.php` - Applicants list for opportunity
- `organization/profile.blade.php` - Organization profile

### Youth Views
- `youth/opportunities.blade.php` - Opportunities listing
- `youth/applications.blade.php` - Personal applications
- `youth/profile.blade.php` - View profile
- `youth/edit-profile.blade.php` - Edit profile form

### Shared Views
- `show.blade.php` - Opportunity detail view
- `profile/edit.blade.php` - Generic profile edit
- `welcome.blade.php` - Landing page

---

## 🔐 Security & Middleware

### Middleware Stack

1. **Authenticate Middleware** (`auth`)
   - Checks if user is logged in
   - Redirects to `/login` if not authenticated

2. **Role Middleware** (`role:RoleName`)
   - Checks user role matches required role(s)
   - Returns 403 if unauthorized
   - Used in route groups: `middleware(['auth', 'role:Admin'])`

### Security Features
- **CSRF Protection** - All POST forms include `@csrf`
- **Password Hashing** - Bcrypt via Laravel Hash
- **SQL Injection Protection** - Eloquent ORM prevents injection
- **XSS Protection** - Blade `{{ }}` auto-escapes output
- **Role-based Access** - Middleware enforces permissions

---

## 📝 Controllers & Business Logic

### AdminController
- `index()` - Show admin dashboard with organizations/youth
- `verifyOrg($id)` - Set organization verified = true
- `revokeOrg($id)` - Set organization verified = false

### OrganizationController
- `dashboard()` - Show opportunities list + creation form
- `viewApplicants($id)` - Show applicants for opportunity
- `updateApplicationStatus($id)` - Update application status

### OpportunityController
- `index()` - Organization's own opportunities (for dashboard)
- `store(Request)` - Create new opportunity
- `list()` - Youth view: all verified opportunities
- `show($id)` - View single opportunity details

### ApplicationController
- `apply($id, Request)` - Youth applies to opportunity
- `applicants()` - Organization views applicants (unused, moved to OrganizationController)
- `updateStatus($id)` - Update status (unused, moved to OrganizationController)
- `myApplications()` - Youth views their applications

### YouthProfileController
- `index()` - View youth profile
- `edit()` - Show edit form
- `update(Request)` - Update profile (handles skills array conversion)

### ProfileController
- `edit(Request)` - Show profile form (role-based views)
- `update(ProfileUpdateRequest)` - Update user profile
- `destroy(Request)` - Delete user account

### CertificateController
- ⚠️ **EMPTY** - Needs implementation

---

## 🔧 Models & Relationships

### User Model
```php
fillable: name, email, password, role, verified, organization_name, description, bio, skills
relationships:
  - hasOne(YouthProfile)
  - hasOne(Organization)
```

### YouthProfile Model
```php
fillable: user_id, full_name, gender, birth_date, education_level, bio, skills (JSON), availability, contact_number, location, verified
casts: skills => array, verified => boolean, birth_date => date
relationships:
  - belongsTo(User)
```

### Organization Model
```php
fillable: user_id, name, type, contact_email, contact_phone, location, description, verified
casts: verified => boolean
relationships:
  - belongsTo(User)
  - hasMany(Opportunity)
```

### Opportunity Model
```php
fillable: organization_id, title, description, requirements, type, start_date, end_date, deadline, duration_weeks, available_slots, approved
casts: start_date => date, end_date => date, deadline => date, approved => boolean
relationships:
  - belongsTo(Organization)
  - hasMany(Application)
```

### Application Model
```php
fillable: opportunity_id, youth_profile_id, status, cover_letter, applied_on
casts: applied_on => date
relationships:
  - belongsTo(Opportunity)
  - belongsTo(YouthProfile)
```

### Certificate Model
```php
⚠️ INCOMPLETE - Only extends Model, no fillable, relationships, or methods
```

---

## 🚨 Known Issues & Incomplete Features

### 1. Certificate Feature (Incomplete)
- **Model:** Empty, needs relationships and fillable attributes
- **Controller:** Empty, needs CRUD methods
- **Views:** Missing certificate views
- **Routes:** Certificate route exists but controller is empty

### 2. Missing Features
- Email notifications for application status changes
- File upload for certificates (PDF generation)
- Search/filter functionality for opportunities
- Pagination for large lists
- Email verification enforcement
- Password reset email configuration

### 3. Potential Improvements
- Organization verification workflow (admin receives notification)
- Application status workflow (notify youth on status change)
- Certificate generation upon opportunity completion
- Analytics dashboard for organizations
- Rating/review system

---

## 📦 Dependencies

### PHP Packages (composer.json)
- `laravel/framework: ^12.0`
- `laravel/tinker: ^2.10.1`
- `laravel/breeze: ^2.3` (dev)
- `pestphp/pest: ^4.1` (dev)

### JavaScript Packages (package.json)
- `@tailwindcss/forms: ^0.5.2`
- `@tailwindcss/vite: ^4.0.0`
- `alpinejs: ^3.4.2`
- `axios: ^1.11.0`
- `vite: ^7.0.7`
- `laravel-vite-plugin: ^2.0.0`

---

## 🗂️ Project Structure

```
edub/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── ApplicationController.php
│   │   │   ├── CertificateController.php (empty)
│   │   │   ├── OpportunityController.php
│   │   │   ├── OrganizationController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── YouthProfileController.php
│   │   │   └── Auth/ (Breeze controllers)
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/
│   │       └── ProfileUpdateRequest.php
│   ├── Models/
│   │   ├── Application.php
│   │   ├── Certificate.php (incomplete)
│   │   ├── Opportunity.php
│   │   ├── Organization.php
│   │   ├── User.php
│   │   └── YouthProfile.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   └── app.php (middleware registration)
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── ...
├── database/
│   ├── migrations/ (10 migrations)
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php
├── public/
│   └── index.php (entry point)
├── resources/
│   ├── views/ (Blade templates)
│   ├── css/app.css
│   └── js/app.js
├── routes/
│   ├── web.php (main routes)
│   └── auth.php (auth routes)
├── storage/ (logs, cache, files)
├── tests/ (Pest tests)
├── composer.json
├── package.json
├── vite.config.js
└── tailwind.config.js
```

---

## ✅ Current Status Summary

### ✅ Working Features
- User authentication (login, register, password reset)
- Role-based access control
- Organization opportunity posting
- Organization verification (admin)
- Youth opportunity browsing (filtered by verified orgs)
- Application system (apply, track, update status)
- Youth profile management
- Organization profile management
- Admin dashboard

### ⚠️ Incomplete Features
- Certificate generation and management
- Email notifications
- File uploads
- Advanced search/filtering

### 🔄 Data Flow Summary
1. **Organization** → Creates opportunity → **Admin** verifies → **Youth** sees opportunity
2. **Youth** → Applies → **Organization** reviews → Updates status
3. **Application** → Completed → **Certificate** generated (not implemented)

---

## 📚 Additional Notes

- **Default Role:** New users default to "Youth" role (defined in migration)
- **Auto-Creation:** Organization and YouthProfile records are auto-created on first use
- **Verification:** Organization verification is stored on `users.verified`, not `organizations.verified`
- **Skills Storage:** Youth skills are stored as JSON array in database
- **Status Values:** Application statuses: 'Pending', 'Accepted', 'Rejected', 'Completed'

---

*Last Updated: Based on codebase analysis*
*Project Type: Laravel 12 Web Application*
*Purpose: Youth-Opportunity Matching Platform*

