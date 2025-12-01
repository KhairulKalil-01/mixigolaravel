# Mixigo Pro

## Project Overview

This project is a web-based business management system, likely for a healthcare or home care agency. It is built with the Laravel framework (version 12) and uses a MySQL database. The frontend is built with Bootstrap and Vite.

### Key Technologies:

*   **Backend:** PHP 8.2, Laravel 12
*   **Frontend:** Bootstrap, Vite, jQuery, DataTables
*   **Database:** MySQL
*   **Authentication:** Laravel Sanctum
*   **Roles & Permissions:** spatie/laravel-permission
*   **PDF Generation:** barryvdh/laravel-dompdf

### Core Features:

*   Caregiver, Client, and Patient Management
*   Invoicing and Quotaions
*   Payroll and Salary Management
*   Role-based access control

## Building and Running

### Prerequisites:

*   PHP 8.2 or higher
*   Composer
*   Node.js and npm
*   A database server (e.g., MySQL, MariaDB)

### Installation and Setup:

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    ```
2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```
3.  **Install JavaScript dependencies:**
    ```bash
    npm install
    ```
4.  **Create a copy of the `.env` file:**
    ```bash
    cp .env.example .env
    ```
5.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```
6.  **Configure your database credentials** in the `.env` file.
7.  **Run database migrations:**
    ```bash
    php artisan migrate
    ```

### Running the Development Server:

The project includes a convenient script to run the development server, queue listener, and Vite build process concurrently.

```bash
composer run dev
```

This will:
*   Start the PHP development server at `http://localhost:8000`
*   Start the queue listener
*   Start the `pail` utility for logging
*   Start the Vite development server

## Development Conventions

### Coding Style

The project follows the PSR-4 autoloading standard. For code style, it uses Laravel Pint, which is configured to follow the `laravel` preset.

To format your code, run:

```bash
./vendor/bin/pint
```

### Database Migrations

Database schema changes should be made through migration files. You can create a new migration file using the `artisan` command:

```bash
php artisan make:migration <migration_name>
```

### Testing

The project uses PHPUnit for testing. You can run the test suite with the following command:

```bash
php artisan test
```
