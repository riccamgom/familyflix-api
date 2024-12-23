<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel JWT API

A Laravel 11 application implementing JWT-based authentication using `lcobucci/jwt`. This API supports user login, token generation, and middleware-based token validation.

# File structure

```
app/
├── Http/
│ ├── Controllers/
│ │ ├── AuthController.php
│ ├── Middleware/
│ │ └── JWTMiddleware.php
├── Services/
│ └── JWTService.php
config/
├── jwt.php
routes/
├── api.php
bootstrap/
├── app.php
```

## Prerequisites

-   **PHP 8.4 or higher**
-   **Composer**
-   **Laravel 11**
-   **MySQL or compatible database**

## Installation

### 1. Install Laravel Globally

```bash
composer global require laravel/installer
```

### 2. Create the Laravel project

```bash
laravel new token-api
```

### 3. Configure the database

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Install Laravel Sanctum

```
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

#### Update bootstrap/app.php to include sanctum middleware

```
->withMiddleware(function (Middleware $middleware) {
$middleware->append(\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);
})
```

### 5. Install lcobucci/jwt

```bash
composer require lcobucci/jwt
```

### 6. Create configuration for JWT (config/jwt.php)

```
<?php

return [
    'secret' => env('JWT_SECRET', 'your_default_secret_key'),
];
```

#### Add it to .env file -> JWT_SECRET=your_generated_secret_key

### 7. Create required files

#### app/services/JWTService.php

#### app/controllers/AuthController.php

#### app/middleware/JWTMiddleware.php

#### routes/api.php

### 8. Register this new files (services, controllers, routes and middleware)

#### Register the service in appserviceprovider.php

```
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(JWTService::class, function ($app) {
            return new JWTService();
        });
    }
```

#### Define api routes in the new file api.php

#### -> This would create routes under api/

```
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['jwt'])->group(function () {
    // Protected routes go here
});
```

#### Add middleware to app.php configuration

```
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\JWTMiddleware::class);
})
```

#### Register middleware in the AppServiceProvider

```
   public function boot(Router $router): void
    {
        // Register the middleware
        $router->aliasMiddleware('jwt.auth', JWTMiddleware::class);
    }
```

### 9. RUN LARAVEL

```bash
php artisan serve
```

### 10. Create users that could obtain token with seeder

```bash
php artisan db:seed
```
