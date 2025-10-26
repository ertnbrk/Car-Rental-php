@echo off
echo ========================================
echo Car Rental Laravel - Docker-Only Install
echo (No local Composer required)
echo ========================================
echo.

cd /d "%~dp0"

echo Step 1: Stopping any running containers...
docker-compose down
echo.

echo Step 2: Creating .env file...
if not exist .env (
    copy .env.example .env
    echo .env file created!
) else (
    echo .env file already exists, skipping...
)
echo.

echo Step 3: Building Docker containers...
docker-compose build
echo.

echo Step 4: Starting containers...
docker-compose up -d
echo.

echo Step 5: Waiting for containers to start...
timeout /t 10 /nobreak
echo.

echo Step 6: Installing Composer dependencies INSIDE Docker...
docker-compose exec app composer install --no-interaction --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed inside Docker!
    echo Make sure Docker is running and containers are up.
    pause
    exit /b 1
)
echo.

echo Step 7: Waiting for database to be ready...
timeout /t 20 /nobreak
echo.

echo Step 8: Generating application key...
docker-compose exec app php artisan key:generate
echo.

echo Step 9: Running database migrations...
docker-compose exec app php artisan migrate --seed
echo.

echo Step 10: Linking storage...
docker-compose exec app php artisan storage:link
echo.

echo Step 11: Fetching FX rates...
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
