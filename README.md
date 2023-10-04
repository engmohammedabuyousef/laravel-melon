<p align="center">
  <a href="https://github.com/engmohammedabuyousef/laravel-melon">
    <h1>Melon</h1>
  </a>
</p>

## About

Melon is a customizable Laravel-based skeleton project with a dashboard.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP 8**
- **Composer**
- **Laravel 9**
- **Node.js 16.15.0+**
- **Yarn 1.22+**

## Installation

**Warning**: Please make sure to meet the prerequisites listed above before proceeding with the installation.

To run the project locally, follow these steps:

1. Clone this repository:

    ```bash
    git clone https://github.com/engmohammedabuyousef/laravel-melon.git
    ```

2. Navigate to the project's root directory:

    ```bash
    cd laravel-melon
    ```

3. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Create a database named `melon` (you can change the database name).

5. Open the `.env` file and set the database credentials:

    ```env
    DB_DATABASE=melon
    DB_USERNAME=root
    DB_PASSWORD=[YOUR PASSWORD]
    ```

    Be sure to use your actual database username and password.

6. Install PHP dependencies:

    ```bash
    composer install
    ```

7. Generate an application key:

    ```bash
    php artisan key:generate
    ```

8. Run migrations and seeders:

    ```bash
    php artisan migrate:fresh --seed
    ```

9. Create a symbolic link for the storage folder:

    ```bash
    php artisan storage:link
    ```

10. Generate Passport keys:

    ```bash
    php artisan passport:keys
    ```

11. For the frontend, install Yarn globally if you haven't already:

    ```bash
    npm install --global yarn
    ```

    Then, install the frontend dependencies:

    ```bash
    yarn
    ```

    Finally, build the frontend assets:

    ```bash
    npm run dev
    ```

12. Start the development server:

    ```bash
    php artisan serve
    ```

13. Visit [localhost:8000](http://localhost:8000) in your favorite web browser.

Make sure to configure your Laravel local development environment as needed.

