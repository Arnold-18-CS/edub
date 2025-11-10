# Post-Update Setup Guide

This guide will help you set up the project after the recent updates.

## ✅ Changes Made

1. **Theme Updated**: Changed from pink/blue gradient to light blue and white theme
2. **Logo Removed**: All EduBridge logos replaced with text "EduBridge"
3. **Opportunities Visibility Fixed**: Opportunities now properly show for youth after organization verification
4. **2FA Implemented**: Two-factor authentication using email verification codes
5. **Layout Improvements**: Fixed button obstruction and improved spacing

---

## 📋 Required Steps After Update

### Step 1: Run Database Migration

The 2FA feature requires a new database table. Run the migration:

```bash
php artisan migrate
```

This will create the `two_factor_authentications` table.

### Step 2: Configure Email Settings

2FA sends verification codes via email. Configure your email settings in `.env`:

**For Development (Log to File):**
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@edubridge.com
MAIL_FROM_NAME="EduBridge"
```

**For Production (SMTP):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@edubridge.com
MAIL_FROM_NAME="EduBridge"
```

**Note**: For testing, you can use `MAIL_MAILER=log` and check `storage/logs/laravel.log` for the verification codes.

### Step 3: Clear Cache

Clear all caches to ensure new routes and configurations are loaded:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Step 4: Rebuild Frontend Assets

Since CSS and theme colors have changed, rebuild the frontend assets:

```bash
npm run build
```

Or for development:
```bash
npm run dev
```

### Step 5: Verify Organization Verification

**Important**: For opportunities to be visible to youth:

1. Organizations must be verified by an Admin
2. Admin should go to `/admin/dashboard`
3. Click "Verify" button next to the organization
4. Once verified, their opportunities will appear on the youth opportunities page

---

## 🔐 How 2FA Works

### Login Flow:
1. User enters email and password
2. System validates credentials
3. **NEW**: System generates a 6-digit code and sends it via email
4. User is redirected to 2FA verification page
5. User enters the code from their email
6. Upon successful verification, user is logged in

### Features:
- 6-digit verification codes
- Codes expire after 10 minutes
- Codes can be resent
- One-time use (codes are marked as used after verification)

---

## 🎨 Theme Changes

### Color Scheme:
- **Primary**: Light Blue (`#0ea5e9` / `blue-500`)
- **Secondary**: Blue (`#0284c7` / `blue-600`)
- **Background**: Light blue gradient (`from-blue-50 via-white to-blue-50`)
- **Accents**: White cards with blue borders

### Components Updated:
- All buttons now use blue gradients
- Navigation bar uses blue theme
- Cards have blue borders
- Links use blue colors

---

## 🐛 Troubleshooting

### Issue: Opportunities Not Showing for Youth

**Solution**: 
1. Ensure the organization is verified (Admin → Dashboard → Verify)
2. Check that opportunities were created AFTER organization verification
3. Clear cache: `php artisan cache:clear`

### Issue: 2FA Code Not Received

**Solution**:
1. Check `.env` mail configuration
2. If using `log` driver, check `storage/logs/laravel.log`
3. Verify email address is correct
4. Check spam folder

### Issue: Buttons Overlapping or Obstructed

**Solution**:
1. Clear browser cache
2. Rebuild assets: `npm run build`
3. Check browser console for CSS errors

### Issue: Theme Colors Not Applied

**Solution**:
1. Run `npm run build` or `npm run dev`
2. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)
3. Check `tailwind.config.js` and `resources/css/app.css` are updated

---

## 📝 Testing Checklist

After setup, test these features:

- [ ] Login with 2FA (check email for code)
- [ ] Resend 2FA code functionality
- [ ] Organization creates opportunity
- [ ] Admin verifies organization
- [ ] Youth sees verified organization's opportunities
- [ ] Youth applies to opportunity
- [ ] Organization views applicants
- [ ] Organization updates application status
- [ ] All buttons are clickable and not obstructed
- [ ] Theme colors are consistent (light blue/white)

---

## 🚀 Quick Start Commands

```bash
# 1. Run migrations
php artisan migrate

# 2. Clear cache
php artisan cache:clear && php artisan config:clear && php artisan route:clear

# 3. Build assets
npm run build

# 4. Start servers
npm run dev          # Terminal 1
php artisan serve    # Terminal 2
```

---

## 📧 Email Configuration Examples

### Using Mailtrap (Testing):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

### Using Gmail:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

**Note**: For Gmail, you need to generate an "App Password" in your Google Account settings.

---

## ⚠️ Important Notes

1. **Email Verification**: 2FA codes are sent via email. Ensure email is properly configured.
2. **Organization Verification**: Opportunities only show to youth if the organization is verified by an admin.
3. **Code Expiration**: 2FA codes expire after 10 minutes for security.
4. **Session Management**: 2FA uses session storage temporarily. If session expires, user needs to login again.

---

## 🔄 Rollback (If Needed)

If you need to disable 2FA temporarily, edit `app/Http/Controllers/Auth/AuthenticatedSessionController.php`:

Replace the `store` method with:
```php
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();
    return redirect()->intended(route('dashboard', absolute: false));
}
```

---

## 📞 Support

If you encounter any issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify all migrations ran successfully
4. Ensure email configuration is correct

---

**Last Updated**: After theme and 2FA implementation
**Version**: 2.0

