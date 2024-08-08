# Music App built by Mark Eubans

A sample music application created using Laravel, Vue, and TailwindCSS.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Packages and versions](#packages-and-versions)
- [Testing](#testing)

## Installation
⚠️ Important: Ensure you have PHP (version 8.2 or higher), Composer (latest), and Node.js (version 18.3 or higher) installed on your local machine.

### Getting Started

```sh
# Navigate to the project
cd music-app

# Install PHP dependencies
composer install

# Generate Laravel application key
php artisan key:generate

# Run database migrations and seed data
php artisan migrate --seed --seeder=MusicSeeder

# Install Node.js dependencies
npm install
```

### Getting Started

```sh
# Start the Laravel development server
php artisan serve

# Compile assets (CSS, JS)
npm run dev
```

#### Access the application:
Open your web browser and go to http://127.0.0.1:8000

## Usage

1. Registration and Login:
- Navigate to the registration page to create a new account.
- Alternatively, if you already have an account, log in using the login page.

2. Dashboard:
- Upon successful login, you will be redirected to the dashboard.
- Explore and enjoy using the Music Application features.

## Packages and versions

- laravel/framework (^11.9)
- vue (^3.4.29)
- tailwindcss (^3.1.0)
- laravel/sanctum (^4.0)
- vue-router (^4.3.3)
- pinia (^2.1.7)
- @vueform/slider (^2.1.10)
- moment (^2.30.1)
- axios (^1.6.4)

## Testing

```sh
# To run tests
npm run test
php artisan test
```
