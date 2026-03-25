@echo off
echo Fixing jobs table conflict...
echo.

echo Step 1: Renaming migration file...
cd database\migrations
if exist 2024_01_01_000005_create_jobs_table.php (
    rename 2024_01_01_000005_create_jobs_table.php 2024_01_01_000005_create_project_jobs_table.php
    echo Migration renamed successfully.
) else (
    echo Migration file not found, continuing...
)
cd ..\..

echo.
echo Step 2: Dropping all tables...
php artisan db:wipe

echo.
echo Step 3: Running migrations...
php artisan migrate

echo.
echo Step 4: Running seeders...
php artisan db:seed

echo.
echo Fix complete!
pause