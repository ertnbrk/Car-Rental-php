@echo off
echo ========================================
echo Car Rental Laravel - Installation Script
echo ========================================
echo.

cd /d "%~dp0"

echo Step 1: Stopping any running containers...
docker-compose down
echo.

echo Step 2: Installing Composer dependencies...
composer install --ignore-platform-reqs
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    echo Please install Composer from: https://getcomposer.org/download/
    pause
    exit /b 1
)
echo.

echo Step 3: Creating .env file...
if not exist .env (
    copy .env.example .env
    echo .env file created!
) else (
    echo .env file already exists, skipping...
)
echo.

echo Step 4: Building and starting Docker containers...
docker-compose up -d --build
echo.

echo Step 5: Waiting for database to be ready...
timeout /t 30 /nobreak
echo.

echo Step 6: Generating application key...
docker-compose exec app php artisan key:generate
echo.

echo Step 7: Running database migrations...
docker-compose exec app php artisan migrate --seed
echo.

echo Step 8: Linking storage...
docker-compose exec app php artisan storage:link
echo.

echo Step 9: Fetching FX rates...
docker-compose exec app php artisan fx:fetch
echo.

echo ========================================
echo Installation Complete!
echo ========================================
echo.
echo Application: http://localhost:8080
echo phpMyAdmin: http://localhost:8081
echo.
echo Default Credentials:
echo Admin: admin@carrental.com / admin123
echo User: user@example.com / password
echo.
echo Press any key to exit...
pause > nul
