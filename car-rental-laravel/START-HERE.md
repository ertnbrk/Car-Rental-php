# 🚀 START HERE - Get Your Laravel App Running

## Current Status

✅ Laravel project structure created
✅ All migrations, models, controllers created
✅ Docker configuration ready
✅ Core Laravel files created (artisan, index.php, bootstrap/app.php)
❌ Laravel framework NOT yet installed (need to run composer)

## Quick Start (3 Options)

Choose ONE of these methods:

---

## Option 1: Automated Install (EASIEST) ⭐

### Windows

1. Open PowerShell or CMD in the project folder
2. Run the install script:

```batch
INSTALL.bat
```

That's it! The script will:
- Stop any running containers
- Install Laravel via Composer
- Start Docker containers
- Set up database
- Run migrations
- Configure everything

After it completes, visit: **http://localhost:8080**

---

## Option 2: Manual Docker Install

### Step-by-Step:

```bash
# 1. Stop existing containers
docker-compose down

# 2. Install Composer dependencies (REQUIRED!)
composer install --ignore-platform-reqs

# 3. Create environment file
copy .env.example .env

# 4. Start Docker containers
docker-compose up -d --build

# 5. Wait 30 seconds for MySQL to initialize
# (First time takes longer)

# 6. Generate application key
docker-compose exec app php artisan key:generate

# 7. Run migrations and seeders
docker-compose exec app php artisan migrate --seed

# 8. Link storage
docker-compose exec app php artisan storage:link

# 9. Fetch FX rates
docker-compose exec app php artisan fx:fetch
```

Visit: **http://localhost:8080**

---

## Option 3: Local Install (No Docker)

### Prerequisites:
- PHP 8.3+
- Composer
- MySQL 8.0+
- Node.js & npm

### Steps:

```bash
# 1. Install dependencies
composer install
npm install

# 2. Create .env file
copy .env.example .env
php artisan key:generate

# 3. Edit .env - Update these lines:
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_rental
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# 4. Create database
mysql -u root -p
CREATE DATABASE car_rental;
EXIT;

# 5. Run migrations
php artisan migrate --seed
php artisan storage:link

# 6. Fetch FX rates
php artisan fx:fetch

# 7. Build frontend assets
npm run build

# 8. Start server
php artisan serve
```

Visit: **http://localhost:8000**

---

## Troubleshooting

### Problem: "composer: command not found"

**Solution**: Install Composer from https://getcomposer.org/download/

### Problem: Docker containers fail to start

**Solution**:

```bash
# Check if ports are already in use
netstat -ano | findstr :8080
netstat -ano | findstr :3306

# If ports are in use, stop other services or change ports in docker-compose.yml
```

### Problem: Database connection error

**Solution**:

```bash
# Wait longer for MySQL to initialize (first time can take 1-2 minutes)
docker-compose logs db

# Or restart the database container
docker-compose restart db
```

### Problem: 404 Not Found error

**Solution**:

```bash
# Make sure composer install was successful
composer install --ignore-platform-reqs

# Clear Laravel cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear

# Restart containers
docker-compose restart
```

### Problem: "Class not found" errors

**Solution**:

```bash
# Rebuild autoloader
composer dump-autoload

# Restart PHP-FPM
docker-compose restart app
```

---

## After Installation

### Access Points:

| Service | URL | Notes |
|---------|-----|-------|
| Application | http://localhost:8080 | Main website |
| phpMyAdmin | http://localhost:8081 | Database management |
| MySQL | localhost:33060 | Direct DB access |

### Default Login Credentials:

**Admin Account:**
- Email: `admin@carrental.com`
- Password: `admin123`

**Regular User:**
- Email: `user@example.com`
- Password: `password`

### Test the Application:

1. **Public Access (No login required)**:
   - Visit home page: slider, testimonials, team
   - Browse fleet: see cars with FX rates
   - Make reservation as guest (fill form with name/email/phone)

2. **User Access**:
   - Login with user credentials
   - Make reservations (get 10% off every 5th order!)
   - View order history
   - Cancel future orders

3. **Admin Access**:
   - Login with admin credentials
   - View dashboard (statistics, active orders)
   - Manage cars (add, edit, delete with images)
   - View all orders
   - Read contact messages

---

## Useful Commands

### Docker Commands:

```bash
# View running containers
docker-compose ps

# View logs
docker-compose logs -f

# Stop containers
docker-compose down

# Start containers
docker-compose up -d

# Restart specific service
docker-compose restart app

# Execute commands in container
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
```

### Laravel Commands:

```bash
# Via Docker:
docker-compose exec app php artisan [command]

# Or locally:
php artisan [command]

# Useful commands:
php artisan migrate          # Run migrations
php artisan db:seed          # Seed database
php artisan fx:fetch         # Fetch FX rates
php artisan orders:cleanup   # Clean expired orders
php artisan cache:clear      # Clear cache
php artisan route:list       # List all routes
php artisan tinker           # Laravel REPL
```

---

## What's Included

✅ **Complete Laravel 11 Application**
✅ **10 Database Tables** with migrations
✅ **10 Eloquent Models** with relationships
✅ **Guest Checkout** (orders without login)
✅ **FX Rate Integration** (live TCMB rates)
✅ **Discount System** (every Nth order)
✅ **Admin Panel** with CRUD operations
✅ **Docker Setup** (Nginx, PHP-FPM, MySQL, Redis, phpMyAdmin)
✅ **Security** (CSRF, XSS protection, password hashing)
✅ **Localization** (Turkish & English)
✅ **Scheduled Tasks** (FX fetch, order cleanup)

---

## Need Help?

1. Check **QUICK-FIX.md** for common issues
2. Read **PROJECT-STATUS.md** to see what's implemented
3. Review **SETUP-GUIDE.md** for detailed explanations
4. Check **DEPLOYMENT.md** for production deployment

---

## Next Steps

After getting the app running:

1. ✅ Test all features (public, user, admin)
2. 📧 Configure email settings in `.env` for notifications
3. 🎨 Customize views and styling
4. 🧪 Write tests
5. 🚀 Deploy to production (see DEPLOYMENT.md)

---

**Let's get started!** Run `INSTALL.bat` or follow Option 2/3 above.
