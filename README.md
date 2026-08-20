# Customer Request Management System

A lightweight internal system for registering and managing customer requests built with PHP 8 and MySQL.

## Features

- **Request List**: View all requests with filtering by status and priority
- **Search**: Search requests by client name or email
- **Create Requests**: Add new requests with validation
- **View Details**: See complete request information
- **Edit Requests**: Modify existing requests
- **Status Management**: Update request status (New, In Progress, Closed)

## Technology Stack

- PHP 8.0+
- MySQL 8.0+
- HTML5, CSS3, JavaScript (vanilla)
- No framework used

## Quick Start with Docker (Recommended)

The easiest way to run this project is using Docker. It handles all dependencies automatically.

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or Docker Engine + Docker Compose)

## Installation

### Setup Instructions with Docker

1. **Clone the repository**:

```bash
git clone https://github.com/Oscar-Sherelis/customer-request-system
cd customer-request-system
```

2. Start the containers::
```bash
docker-compose up -d
```

#### This will:
```text

Download PHP 8.2 with Apache
Download MySQL 8.0
Download phpMyAdmin for database management

Set up the database with sample data
Start all services
```

3. Access the application:
```text
Main Application: http://localhost:8080


phpMyAdmin: http://localhost:8082

Username: app_user
Password: app_password
```

4. Stop the containers:
```bash
docker-compose down
```

To remove all data and start fresh:
```bash
docker-compose down -v
```

### Docker Commands Reference
```bash
# View logs
docker-compose logs -f

# Rebuild containers after changes
docker-compose up -d --build

# Access web container shell
docker exec -it request_system_web bash

# Access database container shell
docker exec -it request_system_db bash

# Connect to MySQL directly
docker exec -it request_system_db mysql -u app_user -p
```

### Prerequisites if Docker is not used

- PHP 8.0 or higher
- MySQL 8.0 or higher
- Web server (Apache/Nginx) or PHP built-in server

### Setup Instructions, Without Docker

1. **Clone or extract the project** to your web server's document root:

```bash
git clone https://github.com/Oscar-Sherelis/customer-request-system
cd request-system
```

2. Create the database:

```bash
mysql -u root -p < database.sql
```

3. Configure database connection in the .env file:

```bash

$host = getenv('MYSQL_HOST') ?: 'localhost';
$port = getenv('MYSQL_PORT') ?: '3306';
$database = getenv('MYSQL_DATABASE') ?: 'request_system';
$username = getenv('MYSQL_USER') ?: 'root';
$password = getenv('MYSQL_PASSWORD') ?: '';

```

4. Start the development server.
Using PHP's built-in server:

```bash
php -S localhost:8000
```

5. Access the application:
Open your browser and navigate to http://localhost:8000