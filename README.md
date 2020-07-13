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
This package is dependent on the package [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth), but don't worry, it has already been installed together. It will only take a few implementations for you to have working token authentication.

### Step 1
Then create a controller for authentication you can use the artisan command for this:
```
php artisan make:controller v1/AuthController
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

```
'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],
```

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

## Creating an endpoint

### Step 1
Create a table for your new endpoint
```
php artisan make:migration create_cars_table
```

### Step 2
The **fabio-pv:generate-endpoint-class** command will automatically create all necessary dependencies for the endpoint.</br>
It will only be necessary to provide a name for the class and the name of the table that the model will reference.</br>
```
 php artisan fabio-pv:generate-endpoint-class Car --table-name=cars
```
This command will create 5 class in your project with versioning in the v1 directory.
* Model
* Controller
* Service
* Validation
* Transformer

### Step 3 **Optional**
If you want to validate the request body, you must implement its rules in **App/Http/Validations/v1** </br>
This validation works using Laravel [validation](https://laravel.com/docs/7.x/validation) through the base class   
```php
$this->fieldsCreate = [
        'name' => 'required',
        'license_plate' => 'required',
        'motor_power' => 'required',
];
```

### Step 4
Create the return object from your endpoint using [laravel-fractal](https://github.com/spatie/laravel-fractal) which was created in App/Http/Transformers/v1
```php
public function transform(Car $car)
    {
        return [
            'name' => $car->name,
            'license_plate' => $car->license_plate,
            'motor_power' => $car->motor_power,
        ];
    }
```


### Step 5
Create your route in routes/api.php
```php
Route::resource('v1/car', 'v1\CarController');
```

### Step 6 
Test, if everything goes well you will have an endpoint working with the functions:
* GET 
```
/api/v1/car
```
* GET 
```
/api/v1/car/{uuid}
```
* POST  
```
/api/v1/car
```
* PATCH 
```
/api/v1/car/{uuid}
```
* DELETE 
```
/api/v1/car/{uuid
```




