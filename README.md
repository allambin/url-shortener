# Setup Guide

This is a Laravel 11 project that uses an SQLite database.

## Prerequisites

Before running the project, make sure you have the following installed:

- [PHP 8.1+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [nvm](https://github.com/nvm-sh/nvm)

## Setup Instructions

### Clone the Repository
Clone this repository to your local machine using the following command:

```bash
git clone https://github.com/allambin/url-shortener.git
cd url-shortener
nvm install
```

### Install Dependencies

```bash
composer install
npm install && npm run build
```

### Configure the Environment

```bash
cp .env.example .env
```

Update the `.env` file to set the `APP_URL`:

```bash
APP_URL=http://localhost:8000
```
(Adjust the port if your app is running on a different one.)

This will configure the base URL for your application.

### Set Up the SQLite Database

```bash
touch database/database.sqlite
```

### Generate the Application Key

```bash
php artisan key:generate
```

### Run Migrations

```bash
php artisan migrate
```

### Serve the Application

```bash
composer run dev
```

### Test the API

You can test the application using tools like Postman or Insomnia. To do this:

1. Open Postman (or another API testing tool).
2. Set the request method (GET, POST, etc.) to the appropriate endpoint (e.g., http://127.0.0.1:8000/encode).
3. Send requests and check the responses from your API.

**List of API endpoints:**

- POST /encode (`{"url": "..."}`)
- POST /decode (`{"short_url": "..."}`)
- GET /urls

### Test the Application

```bash
php artisan test
```
