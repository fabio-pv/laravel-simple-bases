<h1 align="center">Laravel Simple Bases</h1>
<h5 align="center">A set of base classes to help create projects with Laravel</h5>

## About
This package creates an initial base and utilities for your Laravel projects with a focus on REST api.</br> 
Containing the following resources:
* Base class for authentication using JWT (package)
* Base class for models, with uuid and additional functions
* Base class for controller, with index, show, store, update, destrory functions implemented and each with interesting features (see detail below)
* Base class for service, in the same way that the controller has implemented functions and features (see detail below)
* Filters through the request using queryString
* Intercept uuid to id automatically
* Simple implementation of image upload via base64 in a simple way in any model
* Artisan commands to facilitate the creation of the structure
* Base class for validation (see details)
* Base class for the handler for Exceptions
* Among other features

## Installation
`composer require fabio/laravel-simple-bases`

## Configuration authentication with JWT
This package is dependent on the package https://github.com/tymondesigns/jwt-auth, but don't worry, it has already been installed together. It will only take a few implementations for you to have working token authentication.

### Step 1
Then create a controller for authentication you can use the artisan command for this:
```
php artisan make: controller v1/AuthController
```

### Step 2
In your file routes `routes/api.php`, create a login route. Ex.:
```php
Route::post('v1/login', 'v1\AuthController@login');
```

### Step 3
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

### Step 4
Generate secret key
```
php artisan jwt:secret
```

### Step 5
In config/auth.php make the changes

**From**
```
'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
```

**To**
```
'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],
```

**From**

```php
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],
```

**To**
```php
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
            'hash' => false,
        ],
    ],
```

**Optional but recommended**</br>
Change the path for the User model. </br>
**From**

```php
'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
```    
**To**


```php
'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\v1\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
```    

### Step 6
**Optional**, if using config with cache, execute:
```
php artisan config:cache
```





