# Post-Update Setup Guide - Complete Edition

**Last Updated**: After database error fixes and verified column migration  
**Version**: 4.1

---

## 🎯 Overview

This guide provides **step-by-step instructions** to set up the EduBridge project after pulling the latest updates. Follow these steps **in order** to ensure 100% functionality.

---

## ✅ What Changed in This Update

1. **Logo Removal**: All EduBridge logo components removed, replaced with text "EduBridge"
2. **Theme Consistency**: Blue-white theme applied across ALL pages
3. **Registration Fix**: Dynamic organization fields for Admin/Organization roles
4. **Database Error Fixes**: 
   - Fixed `organization_name` and `description` columns error (removed from User model)
   - Fixed `bio` and `skills` columns error (now saved to YouthProfile model)
   - Added `verified` column migration for users table
   - Fixed ProfileController to use correct models
5. **Bug Fixes**: 
   - Fixed duplicate code in ApplicationController
   - Fixed opportunity visibility query (checks User.verified, not Organization.verified)
   - Fixed Organization model relationship
6. **Component Updates**: All components updated to blue theme

---

## 📋 REQUIRED SETUP STEPS (Follow in Order)

### Step 1: Pull Latest Changes

```bash
# Navigate to project directory
cd /path/to/edub

# Pull latest changes from repository
git pull origin arnold

# Or if you're on a different branch
git checkout arnold
git pull origin arnold
```

---

### Step 2: Install/Update Dependencies

```bash
# Install PHP dependencies (if composer.json changed)
composer install

# Install/Update Node.js dependencies
npm install

# Clear Composer autoload cache
composer dump-autoload
```

---

### Step 3: Run Database Migrations

**CRITICAL**: New migrations are required. Run migrations:

```bash
php artisan migrate
```

**Expected Output**: 
- Creates `two_factor_authentications` table
- Creates `documents` table
- Adds eligibility criteria fields to `opportunities` table
- Adds `verified` column to `users` table
- All existing tables remain intact

**If Migration Fails**:
```bash
# Check migration status
php artisan migrate:status

# If needed, rollback and re-run
php artisan migrate:rollback --step=1
php artisan migrate
```

---

### Step 4: Configure Environment Variables

Edit `.env` file and ensure these are set:

```env
APP_NAME=EduBridge
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edubridge
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Email Configuration (REQUIRED for 2FA)
MAIL_MAILER=log
MAIL_HOST=localhost
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@edubridge.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**For Development (Log to File)**:
```env
MAIL_MAILER=log
```

**For Production (SMTP)**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # or your SMTP server
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

---

### Step 5: Clear All Caches

**IMPORTANT**: Clear all caches to ensure new routes, configs, and views are loaded:

```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Clear compiled files
php artisan clear-compiled

# Optimize (optional, for production)
php artisan optimize:clear
```

---

### Step 6: Rebuild Frontend Assets

**CRITICAL**: CSS and theme changes require rebuilding assets:

```bash
# For production
npm run build

# OR for development (keeps watching for changes)
npm run dev
```

**Keep `npm run dev` running** in a separate terminal if developing.

---

### Step 7: Set File Permissions (Linux/Mac)

```bash
# Ensure storage and cache directories are writable
chmod -R 775 storage bootstrap/cache

# Set ownership (replace 'www-data' with your web server user)
chown -R www-data:www-data storage bootstrap/cache
```

---

### Step 8: Verify Database Structure

Check that all tables exist:

```bash
php artisan tinker
```

Then run:
```php
>>> \DB::table('users')->count()
>>> \DB::table('organizations')->count()
>>> \DB::table('opportunities')->count()
>>> \DB::table('applications')->count()
>>> \DB::table('two_factor_authentications')->count()
```

All should return numbers (0 or more). If any table doesn't exist, run migrations again.

---

## 🧪 COMPREHENSIVE TESTING CHECKLIST

Test **every single functionality** to ensure 100% perfection:

### Authentication Tests

- [ ] **Registration - Youth**
  - [ ] Can register as Youth
  - [ ] No organization fields shown
  - [ ] Redirects to opportunities page after registration
  - [ ] User created in database

- [ ] **Registration - Organization**
  - [ ] Can register as Organization
  - [ ] Organization fields appear dynamically
  - [ ] All organization fields are required
  - [ ] Organization record created in database
  - [ ] User NOT auto-verified (must be verified by admin)
  - [ ] Redirects to organization dashboard

- [ ] **Registration - Admin**
  - [ ] Can register as Admin
  - [ ] Organization fields appear dynamically
  - [ ] Admin user is auto-verified
  - [ ] Admin organization is auto-verified
  - [ ] Redirects to admin dashboard

- [ ] **Login - All Roles**
  - [ ] Can login with email/password
  - [ ] 2FA code sent to email
  - [ ] Can enter 2FA code
  - [ ] Can resend 2FA code
  - [ ] Invalid code shows error
  - [ ] Expired code shows error
  - [ ] Successful login redirects to correct dashboard

- [ ] **Logout**
  - [ ] Logout works for all roles
  - [ ] Redirects to welcome page
  - [ ] Session cleared

### Admin Functionality Tests

- [ ] **Admin Dashboard**
  - [ ] Shows list of organizations
  - [ ] Shows list of youth
  - [ ] Verify button works
  - [ ] Revoke button works
  - [ ] Status badges show correctly

- [ ] **Organization Verification**
  - [ ] Can verify organization
  - [ ] Verified organizations show green badge
  - [ ] Verified organizations' opportunities appear to youth
  - [ ] Can revoke verification
  - [ ] Revoked organizations' opportunities hidden from youth

### Organization Functionality Tests

- [ ] **Organization Dashboard**
  - [ ] Shows form to create opportunity
  - [ ] Can create opportunity
  - [ ] Shows list of created opportunities
  - [ ] Shows application count for each opportunity
  - [ ] Can view applicants for opportunity

- [ ] **Opportunity Management**
  - [ ] All fields validated (title, description, deadline, seats)
  - [ ] Deadline must be future date
  - [ ] Seats must be positive integer
  - [ ] Opportunities saved correctly

- [ ] **Application Management**
  - [ ] Can view applicants for opportunity
  - [ ] Shows applicant name and email
  - [ ] Can update application status (Pending/Accepted/Rejected)
  - [ ] Status updates saved correctly

### Youth Functionality Tests

- [ ] **Opportunities List**
  - [ ] Only shows opportunities from VERIFIED organizations
  - [ ] Shows opportunity title, description, deadline, seats
  - [ ] Shows organization name
  - [ ] Can click to view opportunity details

- [ ] **Apply to Opportunity**
  - [ ] Can apply to opportunity
  - [ ] Cannot apply twice (shows error)
  - [ ] Cannot apply to unverified organization's opportunity
  - [ ] Application status defaults to "Pending"
  - [ ] Success message shown

- [ ] **My Applications**
  - [ ] Shows all applications
  - [ ] Shows opportunity title, organization, status, deadline
  - [ ] Status badges show correctly (Pending/Accepted/Rejected)
  - [ ] Empty state shows if no applications

- [ ] **Youth Profile**
  - [ ] Can view profile
  - [ ] Can edit profile
  - [ ] All fields save correctly
  - [ ] Skills field handles comma-separated values

### UI/Theme Tests

- [ ] **Logo Removal**
  - [ ] No logo images anywhere
  - [ ] "EduBridge" text appears in navigation
  - [ ] "EduBridge" text appears in guest layout
  - [ ] "EduBridge" text appears in welcome page

- [ ] **Blue-White Theme**
  - [ ] All pages use blue-white gradient background
  - [ ] All buttons use blue gradient
  - [ ] All links use blue color
  - [ ] Cards have blue borders
  - [ ] Navigation uses blue theme
  - [ ] No pink/old theme colors visible

- [ ] **Responsiveness**
  - [ ] All pages work on mobile (< 640px)
  - [ ] All pages work on tablet (640px - 1024px)
  - [ ] All pages work on desktop (> 1024px)
  - [ ] No buttons obstructed
  - [ ] Tables scroll horizontally on mobile
  - [ ] Forms stack vertically on mobile

### Edge Cases & Error Handling

- [ ] **Error Scenarios**
  - [ ] Invalid login credentials show error
  - [ ] Invalid 2FA code shows error
  - [ ] Expired 2FA code shows error
  - [ ] Duplicate application shows error
  - [ ] Unauthorized access shows 403 error
  - [ ] Missing required fields show validation errors

- [ ] **Data Integrity**
  - [ ] Cannot apply to non-existent opportunity
  - [ ] Cannot update application status for other organization's opportunity
  - [ ] Cannot access admin dashboard as non-admin
  - [ ] Cannot access organization dashboard as non-organization
  - [ ] Cannot access youth routes as non-youth

---

## 🐛 TROUBLESHOOTING GUIDE

### Issue 1: "Class not found" or Autoload Errors

**Symptoms**: `Class 'App\Http\Controllers\...' not found`

**Solution**:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

---

### Issue 2: "Vite manifest not found"

**Symptoms**: CSS/JS files not loading, 404 errors for assets

**Solution**:
```bash
# Rebuild assets
npm run build

# OR start dev server
npm run dev

# Clear view cache
php artisan view:clear
```

---

### Issue 3: Opportunities Not Showing for Youth

**Symptoms**: Youth sees empty opportunities list even after organization creates opportunities

**Solution**:
1. **Verify Organization**: Admin must verify the organization first
   - Go to `/admin/dashboard`
   - Click "Verify" next to the organization
   - Check that organization shows "Verified" badge

2. **Check Database**:
   ```bash
   php artisan tinker
   ```
   ```php
   // Check if organization user is verified
   >>> $org = \App\Models\User::where('role', 'Organization')->first();
   >>> $org->verified; // Should be true
   
   // Check if opportunities exist
   >>> \App\Models\Opportunity::count();
   ```

3. **Clear Cache**:
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

---

### Issue 4: 2FA Code Not Received

**Symptoms**: Login works but no email with code received

**Solution**:

1. **Check Email Configuration**:
   ```bash
   # Check .env file
   cat .env | grep MAIL
   ```

2. **If Using Log Driver**:
   ```bash
   # Check Laravel log file
   tail -f storage/logs/laravel.log
   ```
   The code will be in the log file.

3. **If Using SMTP**:
   - Verify SMTP credentials
   - Check spam folder
   - Test SMTP connection:
   ```bash
   php artisan tinker
   ```
   ```php
   >>> Mail::raw('Test', function($m) { $m->to('your@email.com')->subject('Test'); });
   ```

---

### Issue 5: Registration Form Not Showing Organization Fields

**Symptoms**: Selecting "Organization" or "Admin" doesn't show organization fields

**Solution**:

1. **Check Alpine.js is Loaded**:
   ```bash
   # Verify app.js includes Alpine
   cat resources/js/app.js
   ```
   Should see: `import Alpine from 'alpinejs';`

2. **Rebuild Assets**:
   ```bash
   npm run build
   ```

3. **Check Browser Console**:
   - Open browser DevTools (F12)
   - Check Console tab for JavaScript errors
   - Alpine.js should be loaded

---

### Issue 6: "Route [dashboard] not defined"

**Symptoms**: After login, error shows route not found

**Solution**:
```bash
# Clear route cache
php artisan route:clear

# List all routes to verify
php artisan route:list | grep dashboard
```

Should see:
- `GET|HEAD  dashboard`
- `GET|HEAD  admin/dashboard`
- `GET|HEAD  organization/dashboard`

---

### Issue 7: Theme Colors Not Applied

**Symptoms**: Old theme colors still showing

**Solution**:
```bash
# Rebuild assets
npm run build

# Clear all caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Hard refresh browser (Ctrl+Shift+R or Cmd+Shift+R)
```

---

### Issue 8: Database Migration Errors

**Symptoms**: `SQLSTATE[42S01]: Base table or view already exists`

**Solution**:
```bash
# Check migration status
php artisan migrate:status

# If table exists but migration not recorded:
php artisan migrate --pretend

# Or rollback and re-run:
php artisan migrate:rollback --step=1
php artisan migrate
```

---

### Issue 9: "500 Internal Server Error"

**Symptoms**: White screen or generic error page

**Solution**:

1. **Check Laravel Logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Enable Debug Mode** (temporarily):
   ```env
   APP_DEBUG=true
   ```

3. **Common Causes**:
   - Missing environment variables
   - Database connection issues
   - Missing migrations
   - File permission issues

---

### Issue 10: Buttons Overlapping or Obstructed

**Symptoms**: Buttons hidden behind other elements

**Solution**:
```bash
# Rebuild assets
npm run build

# Clear browser cache
# Hard refresh: Ctrl+Shift+R (Windows/Linux) or Cmd+Shift+R (Mac)
```

---

## 🚀 QUICK START COMMANDS (Copy & Paste)

Run these commands **in order** after pulling updates:

```bash
# 1. Install dependencies
composer install && npm install

# 2. Run migrations
php artisan migrate

# 3. Clear all caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear

# 4. Rebuild assets
npm run build

# 5. Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache

# 6. Start development servers
# Terminal 1:
npm run dev

# Terminal 2:
php artisan serve
```

---

## 📧 EMAIL CONFIGURATION EXAMPLES

### Development (Log to File) - RECOMMENDED FOR TESTING

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@edubridge.com"
MAIL_FROM_NAME="EduBridge"
```

**To View Codes**: Check `storage/logs/laravel.log`

---

### Production (SMTP - Mailtrap for Testing)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@edubridge.com"
MAIL_FROM_NAME="EduBridge"
```

---

### Production (SMTP - Gmail)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@edubridge.com"
MAIL_FROM_NAME="EduBridge"
```

**Note**: For Gmail, generate an "App Password" in Google Account settings.

---

## ⚠️ CRITICAL NOTES

1. **Email is REQUIRED**: 2FA codes are sent via email. Without email configuration, login will fail.

2. **Organization Verification**: Opportunities only show to youth if the organization is verified by an admin. This is intentional for security.

3. **Code Expiration**: 2FA codes expire after 10 minutes for security.

4. **Session Management**: 2FA uses session storage temporarily. If session expires during 2FA, user must login again.

5. **Database Backups**: Always backup database before running migrations in production.

6. **Asset Building**: Always run `npm run build` after pulling updates that change CSS/JS.

---

## 🔄 ROLLBACK PROCEDURE (If Needed)

If you need to rollback to previous version:

```bash
# 1. Check git log
git log --oneline

# 2. Rollback to specific commit
git reset --hard <commit-hash>

# 3. Run migrations rollback if needed
php artisan migrate:rollback

# 4. Rebuild assets
npm run build

# 5. Clear caches
php artisan cache:clear && php artisan config:clear
```

---

## 📞 SUPPORT & DEBUGGING

### Check Logs

```bash
# Laravel application logs
tail -f storage/logs/laravel.log

# PHP error logs (if configured)
tail -f /var/log/php_errors.log
```

### Verify Installation

```bash
# Check PHP version (should be 8.1+)
php -v

# Check Composer
composer --version

# Check Node.js
node -v
npm -v

# Check Laravel
php artisan --version
```

### Database Verification

```bash
php artisan tinker
```

```php
// Check tables exist
>>> \DB::select('SHOW TABLES');

// Check user count
>>> \App\Models\User::count();

// Check organizations
>>> \App\Models\Organization::count();

// Check opportunities
>>> \App\Models\Opportunity::count();
```

---

## ✅ FINAL VERIFICATION CHECKLIST

Before considering setup complete, verify:

- [ ] All migrations ran successfully
- [ ] Email configuration is set
- [ ] All caches cleared
- [ ] Assets rebuilt (`npm run build`)
- [ ] Can access welcome page
- [ ] Can register as Youth
- [ ] Can register as Organization (fields appear)
- [ ] Can register as Admin (fields appear, auto-verified)
- [ ] Can login (2FA works)
- [ ] Admin can verify organizations
- [ ] Organizations can create opportunities
- [ ] Youth can see verified opportunities
- [ ] Youth can apply to opportunities
- [ ] Organizations can view applicants
- [ ] All pages show blue-white theme
- [ ] No logos, only "EduBridge" text
- [ ] No console errors in browser
- [ ] No Laravel log errors

---

## 📝 VERSION HISTORY

- **v3.0** (Latest): Logo removal, blue-white theme, registration fixes, bug fixes
- **v2.0**: 2FA implementation, theme update
- **v1.0**: Initial setup

---

**Last Updated**: After SRS compliance implementation  
**Version**: 4.0  
**Maintained By**: Development Team  
**For Issues**: Check troubleshooting section above or review Laravel logs

---

## 📊 SRS COMPLIANCE INFORMATION

### New Features Implemented

This update includes backend implementations for SRS functional requirements:

1. **FR-03: Document Upload System** ✅ Backend Complete
   - Document model, controller, migrations ready
   - File upload functionality implemented
   - Admin verification workflow ready
   - **Remaining**: Views need to be created

2. **DR-02: Eligibility Criteria** ✅ Backend Complete
   - Eligibility fields added to opportunities table
   - Model updated with new fields
   - **Remaining**: Forms and filtering logic need implementation

3. **FR-07: Certificate Generation** ✅ Model Complete
   - Certificate model with number generation
   - Relationships established
   - **Remaining**: PDF generation service and views

4. **FR-05: Opportunity Edit/Publish** ✅ Routes Ready
   - Status field added (draft/published/closed)
   - Routes configured
   - **Remaining**: Controller methods and views

### Compliance Documents

For detailed information, see:
- `SRS_COMPLIANCE_GAP_ANALYSIS.md` - Complete gap analysis
- `SRS_COMPLIANCE_STATUS.md` - Current implementation status  
- `SRS_IMPLEMENTATION_PLAN.md` - Implementation roadmap

### Additional Setup for SRS Features

**Document Upload**:
```bash
php artisan storage:link
mkdir -p storage/app/public/documents
chmod -R 775 storage
```

**PDF Generation** (for certificates):
```bash
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

**New Routes Available**:
- `/documents` - Youth document management
- `/admin/documents` - Admin document verification
- `/opportunities/{id}/edit` - Edit opportunities
- `/opportunities/{id}/publish` - Publish opportunities
- `/opportunities/recommended` - Recommended opportunities (matching engine)
- `/admin/reports` - Admin reporting dashboard
- `/certificates/verify/{number}` - Public certificate verification

**Note**: Some features require view implementation. See `SRS_IMPLEMENTATION_PLAN.md` for details.
