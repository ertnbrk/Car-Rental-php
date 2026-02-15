# Car Rental System

Modern car rental management system built with **Vanilla PHP**, featuring multi-language support, real-time currency conversion, and comprehensive vehicle management.

## Features

- 🚗 **Vehicle Management** - Complete CRUD operations for car fleet
- 💰 **Dynamic Pricing** - Real-time currency conversion with TCMB integration
- 🌍 **Multi-language** - Turkish and English support
- 👥 **User Management** - Role-based access control (Admin/User)
- 📊 **Order System** - Guest and authenticated user orders
- 📧 **Contact Forms** - Customer inquiry management
- 🎨 **Modern UI** - Clean, responsive design with green theme
![Project](gitimages/Screenshot%202025-10-26%20040323.png)

## Tech Stack

- **Backend:** Vanilla PHP
- **Database:** MySQL 8.4
- **Cache:** Redis 7
- **Frontend:** Bootstrap 3, jQuery, Owl Carousel
- **Containerization:** Docker & Docker Compose

## Installation

### Prerequisites
- Docker & Docker Compose
- Git

### Quick Start

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd car-rental
   ```

2. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

3. **Update .env file**
   - Set your `APP_KEY` (or run `php artisan key:generate` later)
   - Configure database credentials
   - Update other settings as needed

4. **Start Docker containers**
   ```bash
   docker-compose up -d
   ```

5. **Install dependencies & setup**
   ```bash
   docker-compose exec app composer install
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan storage:link
   docker-compose exec app php artisan migrate --seed
   ```

6. **Access the application**
   - Application: http://localhost:8080
   - phpMyAdmin: http://localhost:8081

## Default Credentials

After seeding, you can login with:
- **Email:** admin@example.com
- **Password:** password

## Project Structure

```
car-rental/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/               # Eloquent models
│   └── Services/             # Business logic services
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/             # Data seeders
├── resources/
│   └── views/               # Blade templates
├── routes/                  # Application routes
├── public/                  # Public assets
└── docker-compose.yml       # Docker configuration
```

## Development

### Running Artisan Commands
```bash
docker-compose exec app php artisan <command>
```



### Database Access
```bash
docker-compose exec db mysql -uroot -proot car_rental
```

## Color Palette

The application uses a soft, clean green-based theme:
- Primary Green: `#29ca8e`
- Secondary Green: `#1dbf73`
- Dark Green (text): `#1a7f5a`

## Turkish Character Support

Full UTF-8 support for Turkish characters (ç, ğ, ı, ö, ş, ü).

## License

This project is open-sourced software.

## Support

For issues and questions, please open an issue in the repository.
