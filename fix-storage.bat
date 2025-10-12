@echo off
REM Fix Storage Permissions and Directories for Laravel
REM Run this script on your production server (Windows)

echo Creating storage directories...

REM Create all necessary storage directories
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\framework\testing" mkdir "storage\framework\testing"
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\app\public" mkdir "storage\app\public"
if not exist "storage\app\private" mkdir "storage\app\private"
if not exist "storage\app\livewire-tmp" mkdir "storage\app\livewire-tmp"
if not exist "storage\logs" mkdir "storage\logs"
if not exist "bootstrap\cache" mkdir "bootstrap\cache"

echo Storage directories created!
echo.
echo Running Laravel cache clear commands...

php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

echo.
echo Storage setup complete!
pause
