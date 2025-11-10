@echo off
REM Clear Laravel caches for Windows
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear
echo All caches cleared!
pause

