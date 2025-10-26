# Car Rental Laravel - Complete Setup Guide

This guide will walk you through setting up the Laravel application from scratch.

## Prerequisites

- PHP 8.3 or higher
- Composer 2.x
- Node.js 18+ and npm
- MySQL 8.0+
- Redis (optional, for caching and queues)
- Git

## Step-by-Step Setup

### 1. Initialize Laravel Project

Since this is a scaffolded project structure, you need to install Laravel first:

```bash
# Navigate to the project directory
cd car-rental-laravel

# Install Laravel (if not already installed)
composer create-project laravel/laravel temp-laravel
mv temp-laravel/vendor .
mv temp-laravel/artisan .
mv temp-laravel/bootstrap .
mv temp-laravel/public/index.php public/
rm -rf temp-laravel

# Or simply install dependencies
composer install
```

### 2. Install Laravel Breeze (Authentication)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
```

### 3. Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit `.env` file with your settings:

```env
APP_NAME="Car Rental"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_LOCALE=tr
APP_FALLBACK_LOCALE=en

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_rental
DB_USERNAME=root
DB_PASSWORD=your_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null

FX_TCMB_URL=https://www.tcmb.gov.tr/kurlar/today.xml
FX_CACHE_TTL=3600
FX_BASE_CURRENCY=TRY

OFFERS_NTH=5
OFFERS_PERCENT=10
```

### 4. Create Database

```bash
# Log into MySQL
mysql -u root -p

# Create database
CREATE DATABASE car_rental CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 5. Run Migrations and Seeders

```bash
# Run migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

This will create:
- Admin user: `admin@carrental.com` / `admin123`
- Regular user: `user@example.com` / `password`
- Sample cars, offers, pages, testimonials, team members

### 6. Link Storage

```bash
php artisan storage:link
```

### 7. Copy Legacy Assets (Optional)

If you want to use the CSS/JS from the legacy project:

```bash
# Copy from legacy project
cp -r ../css public/
cp -r ../js public/
cp -r ../images public/
cp -r ../fonts public/
```

Or create symbolic links:

```bash
ln -s ../css public/css
ln -s ../js public/js
ln -s ../images public/images
ln -s ../fonts public/fonts
```

### 8. Install Frontend Dependencies

```bash
npm install
npm run build
```

### 9. Fetch Initial FX Rates

```bash
php artisan fx:fetch
```

### 10. Set Up Scheduler (Optional for Development)

For local development, run the scheduler in a separate terminal:

```bash
php artisan schedule:work
```

For production, add this to your crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### 11. Run Queue Worker (Optional)

In a separate terminal:

```bash
php artisan queue:work
```

### 12. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Docker Setup (Alternative)

If you prefer Docker:

```bash
# Start all services
docker-compose up -d

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# Run migrations
docker-compose exec app php artisan migrate --seed

# Fetch FX rates
docker-compose exec app php artisan fx:fetch
```

Access:
- Application: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## Testing the Application

### 1. Public Features

- **Home Page**: View slider, featured cars, testimonials
- **Fleet**: Browse cars, view FX rates, filter cars
- **Guest Reservation**: Create orders without login
  - Fill in car reservation form
  - Provide name, email, phone
  - Order is created and stock is decremented

### 2. Authenticated Features

- **Login**: Use `user@example.com` / `password`
- **My Orders**: View your order history
- **Discounts**: Every 5th order gets 10% off
- **Order Cancellation**: Cancel future orders

### 3. Admin Features

- **Login**: Use `admin@carrental.com` / `admin123`
- **Dashboard**: View statistics (active orders, revenue, messages)
- **Car Management**: Add, edit, delete cars with images
- **Order Management**: View all orders
- **Content Management**: Manage pages, testimonials, team, sliders
- **Contact Messages**: View customer inquiries

## Scheduled Tasks

The application runs these tasks automatically:

1. **Fetch FX Rates** (Hourly)
   ```bash
   php artisan fx:fetch
   ```

2. **Cleanup Expired Orders** (Daily at 2 AM)
   ```bash
   php artisan orders:cleanup
   ```

Manual execution:

```bash
# Dry run (doesn't make changes)
php artisan orders:cleanup --dry-run

# Force FX fetch
php artisan fx:fetch --force
```

## Troubleshooting

### 1. Database Connection Error

Check your `.env` file:
- Verify DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- Ensure MySQL is running: `sudo systemctl status mysql`

### 2. Storage Permission Error

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 3. FX Rates Not Loading

```bash
# Check if command works
php artisan fx:fetch

# Check logs
tail -f storage/logs/laravel.log

# Manually verify URL
curl https://www.tcmb.gov.tr/kurlar/today.xml
```

### 4. Assets Not Loading

```bash
# Verify storage link exists
ls -la public/storage

# Recreate if needed
php artisan storage:link

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 5. Queue Jobs Not Processing

```bash
# Check Redis is running
redis-cli ping

# Restart queue worker
php artisan queue:restart
php artisan queue:work
```

## Code Quality Tools

### Laravel Pint (Code Style)

```bash
./vendor/bin/pint

# Check only
./vendor/bin/pint --test
```

### PHPStan (Static Analysis)

```bash
./vendor/bin/phpstan analyse
```

### Run Tests

```bash
php artisan test

# With coverage
php artisan test --coverage
```

## Key Features Implemented

✅ **Guest Checkout**: Orders can be placed without login
✅ **FX Rates**: Live TCMB exchange rates with caching
✅ **Discount System**: Every Nth order gets discount
✅ **Order Cleanup**: Auto-cleanup expired orders and restore stock
✅ **Transactions**: Safe order creation with stock management
✅ **Security**: CSRF, XSS, SQL injection protection
✅ **RBAC**: Admin/User role-based access control
✅ **Localization**: Turkish and English translations
✅ **Soft Deletes**: Recoverable data deletion
✅ **Caching**: Redis caching for performance
✅ **Queue System**: Background job processing
✅ **Logging**: Comprehensive error and action logging

## Default Credentials

After seeding:

**Admin Account:**
- Email: `admin@carrental.com`
- Password: `admin123`

**Regular User:**
- Email: `user@example.com`
- Password: `password`

## Next Steps

1. **Customize**: Update logo, colors, text in views
2. **Email**: Configure SMTP for order confirmations
3. **Payment**: Integrate payment gateway
4. **SMS**: Add SMS notifications
5. **Testing**: Write feature and unit tests
6. **Deploy**: Follow DEPLOYMENT.md for production

## Support

For issues or questions:
- Check `storage/logs/laravel.log`
- Review documentation in README.md and DEPLOYMENT.md
- Ensure all prerequisites are installed

## File Structure Overview

```
car-rental-laravel/
├── app/
│   ├── Console/Commands/          # CLI commands
│   │   ├── CleanupExpiredOrders.php
│   │   └── FetchFxRates.php
│   ├── Http/Controllers/          # Controllers
│   │   ├── Admin/                 # Admin controllers
│   │   ├── HomeController.php
│   │   ├── FleetController.php
│   │   └── OrderController.php
│   ├── Http/Requests/             # Form validation
│   ├── Models/                    # Eloquent models
│   ├── Providers/                 # Service providers
│   └── Services/                  # Business logic
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Sample data
├── resources/
│   ├── views/                     # Blade templates
│   └── lang/                      # Translations
├── routes/
│   ├── web.php                    # Public routes
│   └── admin.php                  # Admin routes
├── docker/                        # Docker configuration
├── .env.example                   # Environment template
├── composer.json                  # PHP dependencies
├── package.json                   # Frontend dependencies
└── docker-compose.yml             # Docker Compose config
```

---

**Built with ❤️ using Laravel 11 & PHP 8.3**
