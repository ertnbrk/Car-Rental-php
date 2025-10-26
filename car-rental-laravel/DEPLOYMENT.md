# Production Deployment Guide

This guide covers deploying the Car Rental Laravel application to a production server.

## Prerequisites

- Ubuntu 22.04 LTS or similar Linux distribution
- Root or sudo access
- Domain name pointed to your server
- SSL certificate (Let's Encrypt recommended)

## Server Setup

### 1. Update System
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Install Required Packages
```bash
sudo apt install -y nginx mysql-server redis-server php8.3-fpm php8.3-cli php8.3-mysql \
    php8.3-redis php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-gd \
    php8.3-intl php8.3-bcmath git unzip supervisor certbot python3-certbot-nginx
```

### 3. Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 4. Configure MySQL
```bash
sudo mysql_secure_installation

# Create database and user
sudo mysql
```

```sql
CREATE DATABASE car_rental CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'laravel'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON car_rental.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 5. Configure Redis
```bash
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

## Application Deployment

### 1. Clone Repository
```bash
cd /var/www
sudo git clone <repository-url> car-rental
cd car-rental
```

### 2. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/car-rental
sudo chmod -R 755 /var/www/car-rental
sudo chmod -R 775 /var/www/car-rental/storage
sudo chmod -R 775 /var/www/car-rental/bootstrap/cache
```

### 3. Install Dependencies
```bash
sudo -u www-data composer install --no-dev --optimize-autoloader
```

### 4. Configure Environment
```bash
sudo -u www-data cp .env.example .env
sudo -u www-data nano .env
```

Update these critical values:
```env
APP_NAME="Car Rental"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_rental
DB_USERNAME=laravel
DB_PASSWORD=your_secure_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail settings (configure with your SMTP provider)
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Session security
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

### 5. Generate Application Key
```bash
sudo -u www-data php artisan key:generate
```

### 6. Run Migrations
```bash
sudo -u www-data php artisan migrate --force
```

### 7. Seed Database (Optional)
```bash
sudo -u www-data php artisan db:seed --force
```

### 8. Link Storage
```bash
sudo -u www-data php artisan storage:link
```

### 9. Optimize Application
```bash
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan optimize
```

## Nginx Configuration

### 1. Create Nginx Site Configuration
```bash
sudo nano /etc/nginx/sites-available/car-rental
```

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name your-domain.com www.your-domain.com;

    root /var/www/car-rental/public;
    index index.php index.html;

    # SSL certificates (managed by Certbot)
    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Logging
    access_log /var/log/nginx/car-rental-access.log;
    error_log /var/log/nginx/car-rental-error.log;

    # Main location
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
    }

    # Deny access to hidden files
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Static file caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Client upload size
    client_max_body_size 20M;
}
```

### 2. Enable Site and Test
```bash
sudo ln -s /etc/nginx/sites-available/car-rental /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## SSL Certificate (Let's Encrypt)

```bash
sudo certbot --nginx -d your-domain.com -d www.your-domain.com
```

Follow the prompts and choose to redirect HTTP to HTTPS.

## Queue Worker Setup (Supervisor)

### 1. Create Supervisor Configuration
```bash
sudo nano /etc/supervisor/conf.d/car-rental-queue.conf
```

```ini
[program:car-rental-queue]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php /var/www/car-rental/artisan queue:work redis --sleep=3 --tries=3 --timeout=90 --max-jobs=1000
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/car-rental/storage/logs/queue.log
stopwaitsecs=3600
```

### 2. Start Supervisor
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start car-rental-queue:*
```

## Cron Job for Scheduler

```bash
sudo crontab -e -u www-data
```

Add:
```
* * * * * cd /var/www/car-rental && php artisan schedule:run >> /dev/null 2>&1
```

## PHP-FPM Optimization

```bash
sudo nano /etc/php/8.3/fpm/pool.d/www.conf
```

Adjust these settings based on your server resources:
```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 500
```

```bash
sudo systemctl restart php8.3-fpm
```

## Monitoring & Maintenance

### Log Monitoring
```bash
# Laravel logs
tail -f /var/www/car-rental/storage/logs/laravel.log

# Nginx logs
tail -f /var/log/nginx/car-rental-error.log

# Queue logs
tail -f /var/www/car-rental/storage/logs/queue.log
```

### Database Backup Script
Create `/var/www/car-rental/backup.sh`:
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/www/car-rental/storage/backups"
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u laravel -p'your_password' car_rental > $BACKUP_DIR/db_$DATE.sql

# Compress
gzip $BACKUP_DIR/db_$DATE.sql

# Keep only last 30 days
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +30 -delete

echo "Backup completed: db_$DATE.sql.gz"
```

```bash
chmod +x /var/www/car-rental/backup.sh
```

Add to crontab:
```bash
0 2 * * * /var/www/car-rental/backup.sh >> /var/www/car-rental/storage/logs/backup.log 2>&1
```

## Security Hardening

### 1. Firewall (UFW)
```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### 2. Fail2Ban
```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 3. Disable Unused Services
```bash
sudo systemctl disable apache2  # If installed
```

## Health Checks

### Application Health
```bash
# Check application status
curl -I https://your-domain.com

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check queue
php artisan queue:work --once

# Check cache
php artisan cache:clear
php artisan config:clear
```

### Service Status
```bash
sudo systemctl status nginx
sudo systemctl status php8.3-fpm
sudo systemctl status mysql
sudo systemctl status redis-server
sudo supervisorctl status
```

## Update Deployment

When deploying updates:
```bash
cd /var/www/car-rental

# Enable maintenance mode
sudo -u www-data php artisan down

# Pull latest code
sudo -u www-data git pull origin main

# Update dependencies
sudo -u www-data composer install --no-dev --optimize-autoloader

# Run migrations
sudo -u www-data php artisan migrate --force

# Clear and rebuild cache
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan optimize

# Restart services
sudo supervisorctl restart car-rental-queue:*
sudo systemctl reload php8.3-fpm

# Disable maintenance mode
sudo -u www-data php artisan up
```

## Troubleshooting

### Common Issues

**500 Error:**
```bash
# Check permissions
sudo chown -R www-data:www-data /var/www/car-rental
sudo chmod -R 775 /var/www/car-rental/storage
sudo chmod -R 775 /var/www/car-rental/bootstrap/cache

# Check logs
tail -f /var/www/car-rental/storage/logs/laravel.log
```

**Queue Not Processing:**
```bash
# Check supervisor
sudo supervisorctl status
sudo supervisorctl restart car-rental-queue:*

# Check Redis
redis-cli ping
```

**Database Connection Error:**
```bash
# Test connection
mysql -u laravel -p car_rental

# Check .env credentials
```

## Performance Monitoring

Consider installing:
- New Relic or DataDog for APM
- Sentry for error tracking
- Laravel Telescope (development only)

## Contact & Support

For production issues, contact: admin@your-domain.com

---

**Last Updated:** 2025-01-25
