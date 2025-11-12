# EduBridge (Edub) - Step-by-Step Setup Guide

This guide will walk you through setting up and running the EduBridge project on your local machine from scratch.

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

### Required Software
1. **PHP 8.2 or higher**
   - Check: `php -v`
   - Download: https://www.php.net/downloads.php

2. **Composer** (PHP Dependency Manager)
   - Check: `composer --version`
   - Download: https://getcomposer.org/download/

3. **Node.js & npm** (for frontend assets)
   - Check: `node -v` and `npm -v`
   - Download: https://nodejs.org/

4. **Database** (Choose one):
   - **MySQL 5.7+** or **MariaDB 10.3+** (Recommended)
   - **SQLite** (Easier for development)
   - **PostgreSQL** (Alternative)

5. **Git** (for cloning repository)
   - Check: `git --version`
   - Download: https://git-scm.com/downloads

### Optional but Recommended
- **PHP IDE** (VS Code, PhpStorm, etc.)
- **MySQL Workbench** or **phpMyAdmin** (for database management)
- **Terminal/Command Line** access

---

## 🚀 Step-by-Step Installation

### Step 1: Get the Project Files

#### Option A: Clone from Repository
```bash
git clone <repository-url>
cd edub
```

#### Option B: Extract from ZIP/Archive
```bash
# Extract the archive to your desired location
cd edub
```

---

### Step 2: Install PHP Dependencies

Open your terminal in the project root directory (`edub/`) and run:

```bash
composer install
```

This will:
- Download all PHP packages defined in `composer.json`
- Install Laravel framework and dependencies
- Set up autoloading

**Expected Output:**
```
Loading composer repositories with package information
Installing dependencies from lock file
...
Package operations: X installs, X updates, X removals
```

**If you encounter errors:**
- Ensure PHP version is 8.2+
- Check internet connection
- Try: `composer install --no-cache`

---

### Step 3: Install JavaScript Dependencies

In the same terminal, run:

```bash
npm install
```

This will:
- Download all Node.js packages (Vite, Tailwind CSS, Alpine.js, etc.)
- Create `node_modules/` directory

**Expected Output:**
```
added X packages, and audited X packages in Xs
```

---

### Step 4: Environment Configuration

#### 4.1 Copy Environment File

```bash
# On Linux/Mac
cp .env.example .env

# On Windows
copy .env.example .env
```

#### 4.2 Generate Application Key

```bash
php artisan key:generate
```

This creates a unique encryption key for your application.

#### 4.3 Configure Database

Open `.env` file in a text editor and update the database settings:

**For MySQL/MariaDB:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edub
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**For SQLite (Easier for development):**
```env
DB_CONNECTION=sqlite
# Comment out other DB_* lines or leave them
```

Then create the SQLite database file:
```bash
touch database/database.sqlite
# or on Windows: type nul > database\database.sqlite
```

**For PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=edub
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 4.4 Configure Application Settings

In `.env`, update these values:

```env
APP_NAME="EduBridge"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

#### 4.5 Configure Mail (Optional, for password reset)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@edubridge.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** For development, you can use Mailtrap (https://mailtrap.io) or Gmail SMTP.

---

### Step 5: Create Database

#### Option A: MySQL/MariaDB

1. **Create Database:**
```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE edub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Exit MySQL
EXIT;
```

Or use phpMyAdmin/MySQL Workbench to create database `edub`.

#### Option B: SQLite

The database file will be created automatically when you run migrations (if you followed Step 4.3).

---

### Step 6: Run Database Migrations

This creates all the necessary tables in your database. **Migrations are ordered correctly** to ensure dependencies are created before tables that reference them.

```bash
php artisan migrate
```

**Migration Order (Automatic):**
1. Base Laravel tables (users, cache, jobs, sessions)
2. Add role column to users table
3. Add verified column to users table
4. Create two_factor_authentications table (depends on users)
5. Create youth_profiles table (depends on users)
6. Create organizations table (depends on users)
7. Add bio/skills to organizations table
8. Create opportunities table (depends on organizations)
9. Add eligibility criteria to opportunities table
10. Create documents table (depends on users)
11. Create applications table (depends on opportunities and youth_profiles)
12. Create certificates table (depends on applications)

**Expected Output:**
```
Migration table created successfully.
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table (X.XXs)
Migrating: 2025_01_01_000003_add_role_to_users_table
Migrated:  2025_01_01_000003_add_role_to_users_table (X.XXs)
...
```

**If you encounter errors:**
- Check database credentials in `.env`
- Ensure database exists (for MySQL)
- For SQLite, ensure `database/database.sqlite` exists and is writable
- If you see "Base table or view already exists" errors, run: `php artisan migrate:fresh` (WARNING: This deletes all data!)
- If foreign key constraint errors occur, ensure you're running migrations in order (they should run automatically in order)

---

### Step 7: Seed Database (Optional but Recommended)

This creates test users for all three roles:

```bash
php artisan db:seed --class=UserSeeder
```

**This creates:**
- **Admin User:**
  - Email: `admin@edubridge.com`
  - Password: `password`
  - Role: Admin

- **Organization User:**
  - Email: `org@edubridge.com`
  - Password: `password`
  - Role: Organization

- **Youth User:**
  - Email: `youth@edubridge.com`
  - Password: `password`
  - Role: Youth

**Security Note:** Change these passwords in production!

---

### Step 8: Build Frontend Assets

#### For Development (with hot reload):

```bash
npm run dev
```

Keep this terminal running. This starts Vite dev server for live reloading.

#### For Production (one-time build):

```bash
npm run build
```

This compiles Tailwind CSS and JavaScript assets.

---

### Step 9: Start the Development Server

Open a **new terminal window** (keep `npm run dev` running in the first one) and run:

```bash
php artisan serve
```

**Expected Output:**
```
INFO  Server running on [http://127.0.0.1:8000]

  Press Ctrl+C to stop the server
```

**Alternative:** Use Laravel Sail (Docker) if preferred:
```bash
./vendor/bin/sail up
```

---

### Step 10: Access the Application

Open your web browser and navigate to:

```
http://localhost:8000
```

You should see the Laravel welcome page or the EduBridge application.

---

## ✅ Verification Checklist

### Check 1: Homepage Loads
- Visit `http://localhost:8000`
- Should see welcome page or application interface

### Check 2: Login Works
- Visit `http://localhost:8000/login`
- Try logging in with seeded users:
  - `admin@edubridge.com` / `password`
  - `org@edubridge.com` / `password`
  - `youth@edubridge.com` / `password`

### Check 3: Role-Based Redirects
- **Admin** → Should redirect to `/admin/dashboard`
- **Organization** → Should redirect to `/organization/dashboard`
- **Youth** → Should redirect to `/opportunities`

### Check 4: Database Tables Exist
```bash
php artisan tinker
>>> \DB::table('users')->count()
```

Should return a number (0 or more).

---

## 🔧 Troubleshooting

### Issue 1: "Class not found" or Autoload Errors

**Solution:**
```bash
composer dump-autoload
```

---

### Issue 2: "SQLSTATE[HY000] [1045] Access denied"

**Solution:**
- Check database credentials in `.env`
- Ensure database user has proper permissions
- Verify database exists

---

### Issue 3: "Vite manifest not found"

**Solution:**
```bash
npm run build
# or keep npm run dev running in a separate terminal
```

---

### Issue 4: "The stream or file could not be opened"

**Solution:**
```bash
# Ensure storage directories are writable
chmod -R 775 storage bootstrap/cache

# On Windows, ensure folder permissions allow write access
```

---

### Issue 5: "500 Internal Server Error"

**Solution:**
1. Check Laravel logs: `storage/logs/laravel.log`
2. Ensure `.env` file exists and is configured
3. Run: `php artisan config:clear`
4. Run: `php artisan cache:clear`

---

### Issue 6: Styles/JavaScript Not Loading

**Solution:**
```bash
# Ensure Vite is running
npm run dev

# Or build assets
npm run build

# Clear cache
php artisan view:clear
php artisan cache:clear
```

---

### Issue 7: Migration Errors

**Common Migration Errors:**

**Error: "Base table or view already exists"**
```bash
# Check migration status
php artisan migrate:status

# If migrations are out of sync, refresh:
php artisan migrate:fresh
# WARNING: This deletes all data!

# Or rollback specific migration:
php artisan migrate:rollback --step=1
php artisan migrate
```

**Error: "Foreign key constraint fails"**
```bash
# This should not happen with correct migration order
# If it does, ensure migrations run in order:
php artisan migrate:fresh
php artisan migrate

# Verify migration order:
ls -1 database/migrations/*.php | sort
```

**Error: "Column already exists"**
```bash
# This happens when a migration tries to add a column that exists
# Check if migration was partially run:
php artisan migrate:status

# Rollback and re-run:
php artisan migrate:rollback --step=1
php artisan migrate
```

**Migration Order Verification:**
Migrations are automatically ordered by timestamp. The correct order is:
1. Base tables (users, cache, jobs)
2. User table modifications (role, verified)
3. Tables depending on users (two_factor_authentications, youth_profiles, organizations, documents)
4. Organization modifications
5. Tables depending on organizations (opportunities)
6. Opportunity modifications
7. Tables depending on opportunities and youth_profiles (applications)
8. Tables depending on applications (certificates)

---

## 📝 Quick Start Commands Summary

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env file

# 4. Create database (MySQL) or SQLite file

# 5. Run migrations (automatically ordered correctly)
php artisan migrate

# 6. Seed test users (optional)
php artisan db:seed --class=UserSeeder

# 7. Build assets (development)
npm run dev

# 8. Start server (in new terminal)
php artisan serve

# 9. Access application
# Open: http://localhost:8000
```

## 🔄 Migration Order Details

**Important:** Migrations are automatically ordered by timestamp. The current migration order ensures:

✅ **Base tables created first:**
- `users`, `cache`, `jobs`, `sessions`, `password_reset_tokens`

✅ **User table modifications before dependent tables:**
- `role` column added
- `verified` column added

✅ **Tables depending on users created next:**
- `two_factor_authentications` (references users)
- `youth_profiles` (references users)
- `organizations` (references users)
- `documents` (references users for both owner and verifier)

✅ **Organization modifications before opportunities:**
- `bio` and `skills` columns added to organizations

✅ **Tables depending on organizations:**
- `opportunities` (references organizations)
- Eligibility criteria added to opportunities

✅ **Tables depending on multiple tables created last:**
- `applications` (references opportunities and youth_profiles)
- `certificates` (references applications)

**This order prevents foreign key constraint errors during migration.**

---

## 🎯 Next Steps After Setup

### 1. Test All User Roles

**As Admin:**
- Login: `admin@edubridge.com` / `password`
- Verify an organization
- View dashboard

**As Organization:**
- Login: `org@edubridge.com` / `password`
- Create an opportunity
- Wait for admin verification
- View applicants

**As Youth:**
- Login: `youth@edubridge.com` / `password`
- Browse opportunities (after org is verified)
- Apply to opportunity
- View applications

---

### 2. Create Test Data

```bash
# Use Tinker to create test data
php artisan tinker

# Example: Create an organization
$org = \App\Models\User::create([
    'name' => 'Test Organization',
    'email' => 'testorg@example.com',
    'password' => \Hash::make('password'),
    'role' => 'Organization',
    'verified' => true
]);

# Create organization record
\App\Models\Organization::create([
    'user_id' => $org->id,
    'name' => 'Test Organization',
    'contact_email' => 'testorg@example.com',
    'verified' => true
]);
```

---

### 3. Complete Certificate Feature

The certificate feature is incomplete. To implement:

1. **Update Certificate Model** (`app/Models/Certificate.php`):
```php
protected $fillable = ['application_id', 'certificate_number', 'file_path', 'issued_on'];

public function application() {
    return $this->belongsTo(Application::class);
}
```

2. **Implement CertificateController** methods
3. **Create certificate views**
4. **Add certificate generation logic**

---

## 🔐 Security Checklist for Production

Before deploying to production:

- [ ] Change `APP_DEBUG=false` in `.env`
- [ ] Set strong `APP_KEY` (already generated)
- [ ] Use secure database credentials
- [ ] Change default test user passwords
- [ ] Configure proper mail settings
- [ ] Set up HTTPS/SSL
- [ ] Configure proper file permissions
- [ ] Set up backup system
- [ ] Review and update middleware
- [ ] Enable rate limiting
- [ ] Configure CORS if needed

---

## 📚 Additional Resources

- **Laravel Documentation:** https://laravel.com/docs
- **Tailwind CSS Docs:** https://tailwindcss.com/docs
- **Alpine.js Docs:** https://alpinejs.dev
- **Vite Docs:** https://vitejs.dev

---

## 🆘 Getting Help

If you encounter issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode: `APP_DEBUG=true` in `.env`
3. Check browser console for JavaScript errors
4. Verify all prerequisites are installed correctly
5. Review error messages carefully

---

## 📋 Default Test Credentials

After running the seeder:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@edubridge.com | password |
| Organization | org@edubridge.com | password |
| Youth | youth@edubridge.com | password |

**⚠️ Remember to change these in production!**

---

*Setup Guide Version: 1.0*
*Last Updated: Based on Laravel 12 and current codebase*

