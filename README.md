# EduBridge (Edub)

A Laravel-based web application that connects youth with educational opportunities, internships, volunteering programs, and training courses.

## 🎯 Overview

EduBridge facilitates the interaction between three main user types:
- **Youth** - Students and learners seeking opportunities
- **Organizations** - Providers of educational opportunities
- **Admins** - Platform administrators who verify organizations

## ✨ Features

- ✅ Role-based authentication (Admin, Organization, Youth)
- ✅ Organization opportunity posting and management
- ✅ Admin verification system for organizations
- ✅ Youth application system with status tracking
- ✅ Profile management for all user types
- ✅ Responsive UI with Tailwind CSS
- ⚠️ Certificate generation (partially implemented)

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL/MariaDB or SQLite

### Installation

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env
# For SQLite (easiest): DB_CONNECTION=sqlite
# Then create: touch database/database.sqlite

# 4. Run migrations
php artisan migrate

# 5. Seed test users (optional)
php artisan db:seed --class=UserSeeder

# 6. Start development servers
npm run dev          # Terminal 1
php artisan serve    # Terminal 2
```

Access the application at: `http://localhost:8000`

## 🔑 Default Test Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@edubridge.com | password |
| Organization | org@edubridge.com | password |
| Youth | youth@edubridge.com | password |

## 📚 Documentation

- **[PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)** - Comprehensive project overview and architecture
- **[SETUP_GUIDE.md](SETUP_GUIDE.md)** - Detailed step-by-step setup instructions
- **[QUICK_REFERENCE.md](QUICK_REFERENCE.md)** - Quick reference guide for common tasks

## 🛠️ Technology Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL/MariaDB or SQLite
- **Build Tool:** Vite
- **Testing:** Pest PHP

## 📋 Project Structure

```
edub/
├── app/Http/Controllers/    # Application controllers
├── app/Models/              # Eloquent models
├── database/migrations/     # Database migrations
├── resources/views/         # Blade templates
└── routes/web.php           # Application routes
```

## 🔄 Application Flow

1. Organization registers and posts opportunities
2. Admin verifies the organization
3. Opportunities become visible to Youth
4. Youth browse and apply to opportunities
5. Organization reviews and updates application status
6. Certificates generated upon completion (future feature)

## ⚠️ Known Limitations

- Certificate feature is incomplete (model and controller need implementation)
- Email notifications not configured
- File upload functionality not implemented
- Search/filter features not available

## 🤝 Contributing

This is a private project. For issues or questions, please contact the project maintainer.

## 📄 License

Built with [Laravel](https://laravel.com) framework - MIT License
