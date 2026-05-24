# 🏨 Reservation System API

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP_8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Testing](https://img.shields.io/badge/PHPUnit-Tested-success?style=for-the-badge&logo=phpunit)

A robust, highly-scalable RESTful API for managing businesses, services, and reservations. This project is built using modern **Domain-Driven Design (DDD)** principles on top of the Laravel framework, ensuring clean architecture, maintainability, and enterprise-grade code quality.

---

## ✨ Features

- **Domain-Driven Architecture**: Codebase is modularized into distinct domains (`Auth`, `Businesses`, `Services`, `Reservations`, etc.) to separate concerns.
- **Data Transfer Objects (DTOs)**: Enforces type safety and predictable data structures between the HTTP and Domain layers.
- **Action Classes**: Encapsulates core business logic into single-responsibility Action classes instead of bloated controllers.
- **Modern PHP 8.3+**: Leverages the latest PHP features including attributes, strict typing, and readonly properties.
- **Standardized API Responses**: Consistent JSON response structures across all endpoints.
- **Comprehensive Test Suite**: Feature tests for all API endpoints to guarantee reliability.

## 📁 Architecture Overview

Unlike standard Laravel applications, this project adopts a specialized structure to support scalability:

```
app/
├── Domain/              # Core business logic
│   ├── Businesses/      # Business bounded context
│   │   ├── Actions/     # Single-responsibility logic classes
│   │   ├── DTOs/        # Data Transfer Objects
│   │   ├── Models/      # Eloquent Models
│   │   ├── Requests/    # Form Requests (Validation)
│   │   └── Resources/   # API Resources
│   ├── Services/        # Service bounded context
│   └── Users/           # User bounded context
├── Http/                # Infrastructure layer (Controllers, Middleware)
├── Providers/           # Service Providers
└── Support/             # Cross-domain helpers
```

## 🚀 Getting Started

### Prerequisites

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- Make (optional, but recommended for using the provided Makefile)

### Installation (Docker)

1. **Clone the repository**
   ```bash
   git clone <your-repository-url>
   cd ReservationSystem
   ```

2. **Set up your environment variables**
   ```bash
   cp .env.example .env
   ```

3. **Build and start the Docker containers**
   ```bash
   make build
   ```

4. **Run database migrations**
   ```bash
   make migrate
   ```
   *(Or use `make fresh` to run migrations with seeders)*

### Helpful Make Commands

- `make build` - Build and start the containers (`docker-compose up -d --build`)
- `make up` - Start the containers (`docker-compose up -d`)
- `make down` - Stop the containers (`docker-compose down`)
- `make remove` - Stop the containers and remove volumes (`docker-compose down -v`)
- `make migrate` - Run migrations inside the container
- `make fresh` - Refresh migrations and seed the database inside the container

## 🧪 Testing

The application is fully tested using PHPUnit. To run the test suite locally:

```bash
make test
```

## 🛣️ API Endpoints

A quick overview of the available V1 endpoints:

### Public
- `POST /api/v1/auth/register` - Register a new user
- `POST /api/v1/auth/login` - Authenticate a user
- `GET /api/v1/businesses` - List businesses
- `GET /api/v1/businesses/{slug}` - Get business details
- `GET /api/v1/businesses/{business}/services` - List services for a business

### Protected (Requires Sanctum Token)
- `POST /api/v1/auth/logout` - Logout user
- `GET /api/v1/user` - Get current user profile
- `POST /api/v1/businesses` - Create a new business
- `POST /api/v1/businesses/{business}/services` - Add a service to a business
- `DELETE /api/v1/businesses/{business}/services/{service}` - Remove a service

## 🛡️ License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
