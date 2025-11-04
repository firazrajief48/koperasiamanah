@echo off
echo Clearing Laravel cache...
cd /d "%~dp0"
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo.
echo Cache cleared successfully!
echo.
pause

