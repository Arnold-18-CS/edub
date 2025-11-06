# EduBridge - Quick Reference Guide

## 🚀 Quick Start (TL;DR)

```bash
# 1. Install dependencies
composer install && npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env (SQLite is easiest)
# DB_CONNECTION=sqlite

# 4. Create SQLite database
touch database/database.sqlite

# 5. Run migrations
php artisan migrate

# 6. Seed test users
php artisan db:seed --class=UserSeeder

# 7. Start development servers (in separate terminals)
npm run dev          # Terminal 1
php artisan serve    # Terminal 2

# 8. Access: http://localhost:8000
```

---

## 🔑 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@edubridge.com | password |
| **Organization** | org@edubridge.com | password |
| **Youth** | youth@edubridge.com | password |

---

## 📍 Key Routes

### Public Routes
- `/` - Welcome page
- `/login` - Login
- `/register` - Register

### Admin Routes
- `/admin/dashboard` - Admin dashboard
- `/admin/verify/{id}` - Verify organization (POST)
- `/admin/revoke/{id}` - Revoke verification (POST)

### Organization Routes
- `/organization/dashboard` - Create/view opportunities
- `/organization/opportunity/{id}/applicants` - View applicants
- `/organization/profile` - Organization profile

### Youth Routes
- `/opportunities` - Browse opportunities
- `/opportunities/{id}` - View opportunity details
- `/my-applications` - View my applications
- `/youth/profile` - View/edit profile
- `/certificates` - View certificates (incomplete)

---

## 🗄️ Database Tables

1. **users** - User accounts and authentication
2. **youth_profiles** - Extended youth user profiles
3. **organizations** - Organization details
4. **opportunities** - Posted opportunities
5. **applications** - Youth applications
6. **certificates** - Certificates (incomplete)

---

## 🔧 Common Commands

### Database
```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh        # Fresh migration (deletes data)
php artisan migrate:rollback     # Rollback last migration
php artisan db:seed              # Run seeders
php artisan db:seed --class=UserSeeder  # Seed specific seeder
```

### Cache & Optimization
```bash
php artisan config:clear         # Clear config cache
php artisan cache:clear          # Clear application cache
php artisan view:clear           # Clear view cache
php artisan route:clear          # Clear route cache
php artisan optimize              # Optimize application
```

### Development
```bash
php artisan serve                # Start dev server
php artisan tinker               # Interactive shell
npm run dev                      # Build assets (watch mode)
npm run build                    # Build assets (production)
```

---

## 🏗️ Project Structure Overview

```
edub/
├── app/
│   ├── Http/Controllers/       # Application controllers
│   ├── Models/                  # Eloquent models
│   └── Http/Middleware/         # Custom middleware
├── database/
│   ├── migrations/              # Database migrations
│   └── seeders/                 # Database seeders
├── resources/
│   └── views/                   # Blade templates
├── routes/
│   └── web.php                  # Web routes
└── public/                      # Public assets
```

---

## 🔐 User Roles & Permissions

### Admin
- ✅ Verify/revoke organizations
- ✅ View all users
- ✅ Access admin dashboard

### Organization
- ✅ Create opportunities
- ✅ View applicants
- ✅ Update application status
- ⚠️ Opportunities visible only after admin verification

### Youth
- ✅ Browse verified opportunities
- ✅ Apply to opportunities
- ✅ View application status
- ✅ Manage profile

---

## 📊 Application Flow

```
1. Organization registers → Creates opportunity
2. Admin verifies organization
3. Opportunity becomes visible to Youth
4. Youth applies → Application status: Pending
5. Organization reviews → Updates status (Accepted/Rejected)
6. [Future] Certificate generated on completion
```

---

## ⚠️ Known Issues

1. **Certificate Feature** - Model and controller are empty
2. **Email Notifications** - Not implemented
3. **File Uploads** - Not configured
4. **Search/Filter** - Not implemented

---

## 🐛 Troubleshooting Quick Fixes

| Issue | Solution |
|-------|----------|
| Class not found | `composer dump-autoload` |
| 500 Error | Check `.env` exists, run `php artisan config:clear` |
| Assets not loading | Run `npm run dev` or `npm run build` |
| Database error | Check `.env` DB credentials |
| Migration error | `php artisan migrate:fresh` (deletes data) |

---

## 📚 Documentation Files

- **PROJECT_SUMMARY.md** - Detailed project overview
- **SETUP_GUIDE.md** - Complete setup instructions
- **QUICK_REFERENCE.md** - This file

---

## 🔗 Useful Links

- Laravel Docs: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- Alpine.js: https://alpinejs.dev

---

*Quick Reference v1.0*

