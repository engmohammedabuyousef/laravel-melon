<a href="https://github.com/engmohammedabuyousef/laravel-melon"> <h1 align="center">Melon</h1></a>

## About

Melon project is a skeleton system with dashboard


## Pre Requirements

- PHP 8
- Composer
- Laravel 9
- Node.js 16.15.0+
- Yarn 1.22+


## Installation

> **Warning** Make sure to follow the requirements first.

Here is how you can run the project locally:

1. Clone this repo

  ```sh
  git clone https://github.com/engmohammedabuyousef/laravel-melon.git
  ```

2. Go into the project root directory

  ```sh
  cd laravel-melon
  ```

3. Copy .env.example file to .env file

  ```sh
  cp .env.example .env
  ```

4. Create database `reports` (you can change database name)

5. Go to `.env` file

  - set database credentials 

    ```sh
      DB_DATABASE=reports
      DB_USERNAME=root
      DB_PASSWORD=[YOUR PASSWORD]
    ```

    > Make sure to follow your database username and password

6. Install PHP dependencies

  ```sh
  composer install
  ```

7. Generate key

  ```sh
  php artisan key:generate
  ```

8. Run migrations & seeders

  ```
  php artisan migrate:fresh --seed
  ```

9. Link the storage folder to public

  ```
  php artisan storage:link
  ```

10. For Frontend

  ```
  npm install --global yarn
  ```

  ```
  yarn
  ```

  ```
  npm run dev
  ```

11. Run server

  ```sh
  php artisan serve
  ```

12. Visit [localhost:8000](http://localhost:8000) in your favorite browser.

  > Make sure to follow your Laravel local Development Environment.
