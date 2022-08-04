## Requirements

- PHP ^8.1
- Composer
- Docker (WSL if you're using Windows)

## How to run

1. Copy the `.env.example` file to `.env` and make changes as you see fit (specially for JWT secret and Admin info when
   running the admin seeder)

    ```bash
    cp .env.example .env
    ```
2. Run `composer install`
3. Run `php artisan key:generate`
4. Run `./vendor/bin/sail up -d`
5. Ready to go! `http://127.0.0.1/api`

## Deploy 🚀
- Currently deployed @ [Heroku](https://simple-blog-api-laravel.herokuapp.com/) 
