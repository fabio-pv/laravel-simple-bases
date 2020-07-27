<h1 align="center">Laravel Simple Bases</h1>
<h5 align="center">A set of base classes to help create projects with Laravel</h5>

<p align="center">
        <img src="https://img.shields.io/github/v/release/fabio-pv/laravel-simple-bases">
</p>

## Summary   

:lock: &nbsp; [Configuration authentication with JWT](#configuration-authentication-with-jwt-arrow_up)</br>
:satellite: &nbsp; [Creating an endpoint](#creating-an-endpoint-arrow_up)</br>
:wrench: &nbsp; [Utilities on request](#utilities-on-request-arrow_up)</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:mag_right: &nbsp; [Filters](#filters-arrow_up)</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:arrow_up_down: &nbsp; [Ordering](#ordering-arrow_up)</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:keycap_ten: &nbsp; [Pagination](#pagination-arrow_up)</br>
:floppy_disk: &nbsp; [Intercept uuid for id](#Intercept-uuid-for-id-arrow_up)</br>
:paperclip: &nbsp; [Intercept base64 to file](#Intercept-base64-to-file-arrow_up)</br>
:red_circle: &nbsp; [Exception](#exception-arrow_up)</br>
:triangular_ruler: &nbsp; [Helpers](#helpers-arrow_up)</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:keycap_ten: &nbsp; [fractal_transformer](#fractal_transformer-arrow_up)</br>

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

## Sample repository
[Sample](https://github.com/fabio-pv/laravel-simple-bases-exemple)

## Installation
`composer require fabio/laravel-simple-bases`

## Configuration authentication with JWT [:arrow_up:](#summary)
This package is dependent on the package [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth), but don't worry, it has already been installed together. It will only take a few implementations for you to have working token authentication.

### Step 1
Then create a controller for authentication you can use the artisan command for this:
```
php artisan make:controller v1/AuthController
```

### Step 2
Extend your controller to BaseAuth
```php
class AuthController extends BaseAuth
```

### Step 3
In your file routes `routes/api.php`, create a login route. Ex.:
```php
Route::post('v1/login', 'v1\AuthController@login');
```

### Step 4
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

### Step 5
Generate secret key
```
php artisan jwt:secret
```

### Step 6
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

### Step 7
**Optional**, if using config with cache, execute:
```
php artisan config:cache
```

## Creating an endpoint [:arrow_up:](#summary)

### Step 1
Create a table for your new endpoint
```
php artisan make:migration create_cars_table
```

### Step 2
The **fabio-pv:generate-endpoint-class** command will automatically create all necessary dependencies for the endpoint.It will only be necessary to provide a name for the class and the name of the table that the model will reference.</br>
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
* GET with pagination
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
/api/v1/car/{uuid}
```

**Ex.:**
```json
{
    "data": [
        {
            "uuid": "d96598d0-c527-11ea-b192-517bb6c42efa",
            "name": "Mustang boss 302 68",
            "license_plate": "ter-1234",
            "motor_power": 290
        },
        {
            "uuid": "44d54ed0-c528-11ea-96f6-658ec4d2da56",
            "name": "Camaro ss 68",
            "license_plate": "ter-4321",
            "motor_power": 295
        }
    ],
    "meta": {
        "pagination": {
            "total": 2,
            "count": 2,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {}
        }
    }
}
```

## Utilities on request [:arrow_up:](#summary)
All endpoints that extend ```BaseController``` have filters ready to be used.</br>
Note:</br>
In the current version the filter only works for the model's main table.</br>

### Filters [:arrow_up:](#summary)

```
{{url}}/api/v1/car?filters[index_filter][name_column@name_operator]=value
{{url}}/api/v1/car?filters[0][name@equal]=Mustang boss 302 68
```

**index_filter** = Array index for the filter string</br>
**name_column** = Name of the column to be applied the filter</br>
**name_operator** = Operator to be applied to the filter ``` equal, not_equal, greater_than_or_equal_to, less_than_or_equal_to, like  ```</br>
**value** = Value for the filter</br>

#### Filter on related tables
As of version v0.3.0, the filter also works with the related tables.

**Example:**

* user endpoint response
```json
[
{
            "uuid": "64b774c0-c153-11ea-a4e9-01b907f3026a",
            "name": "default",
            "car": {
                "uuid": "c1f87e50-c769-11ea-99ef-356032d7a36b",
                "name": "Honda Civic",
                "license_plate": "ter-1223",
                "motor_power": 140,
                "car_type": {
                    "uuid": "527b20a0-cda3-11ea-8820-6d38fc501b58",
                    "name": "Hatch"
                }
            }
        },
        ...
]
```

Assuming that we only want **user** who have a **car** with **motor_power** equal to **'140'**. Our queryString will look like this:

```
{{url}}/api/v1/user?filters[0][car.motor_power@equal]=140
```

**Other example**

Assuming we want all **user** who have **car** of **car_type** equal to **'Sporty'**
```
{{url}}/api/v1/user?filters[0][car.car_type.name@equal]=Sporty
```

**Note**
The functioning of the filters depends on the following requirements:
* The name of the properties in transformer must be the same as the database tables. (This is related to usability)
* The relationships in the transformer must follow the same name as the models only separated by '_'. </br>
Model
```php
public function carType()
```

Transformer
```php
'car_type' => fractal_transformer(
                $car->carType,
                CarTypeTransformer::class,
                null
            )
```

### Ordering [:arrow_up:](#summary)

```
{{url}}/api/v1/car?order[name_column]=order
{{url}}/api/v1/car?order[name]=asc
```

**name_column** = Name of the column to be applied the filter</br>
**order** = asc or desc

### Pagination [:arrow_up:](#summary)
Default is 10 per page

```
{{url}}/api/v1/car?paginate=value

{{url}}/api/v1/car?paginate=false
{{url}}/api/v1/car?paginate=20

```

**value** = Can receive ``` false ``` to disable a page or a number to change an amount per page

## Intercept uuid for id [:arrow_up:](#summary)
On request where it is necessary to pass the relationship of another table is common to do by uuid but internally we need the id, to facilitate this 'transformation' this package has a config file where this transformation can be configured so that it happens automatically. Continue reading to learn more

### MER for this example

<img src="https://user-images.githubusercontent.com/56044466/87470933-e5b83180-c5f3-11ea-856c-3789587f4df2.png"/>

### Step 1
Publish configuration file

```
php artisan fabio-pv:from-to-data-config
```

### Step 2
Configure the file ``` config/from_to_data.php ```

```php
return [
    'model::class' => [
        'property_param' => [
            'model' => 'Model::class',
            'property' => 'property_database'
        ],
    ]
];

```

How to configure ?</br>

**model::class** = Model that receives the relationship</br>
**property_param** = Parameter name in request</br>
**Model::class** = Model where the relationship comes from</br>
**property_database** = Property name in the model</br>

Your ``` config/from_to_data.php ``` file should look like this</br>

```php
return [
    \App\Models\v1\User::class => [

        'car_uuid' => [
            'model' => \App\Models\v1\Car::class,
            'property' => 'car_id'
        ],

    ]
];
```

### Step 3
Test, if everything went well using the method post or patch and passing the relationship you should have the relationship in your database automatically

## Intercept base64 to file [:arrow_up:](#summary)
This package provides an easy way to implement file upload via base64 on any model you want.</br>
Note: Files are saved using Laravel [Storage](https://laravel.com/docs/7.x/filesystem)</br>

### Step 1
Run the command below to publish the configuration file
```
php artisan fabio-pv:model-with-file-config
```

### Step 2
Configure the file in ```config/model_with_file.php```
```php
return [
    'model::class' => [
        'fantasy_property' => 'photo',
        'save_location' => '/photos/property_item',
        'extension' => '.png'
    ],
];
```

**model::class** = Model that will receive file</br>
**fantasy_property** = Property name with base64 in the request
**save_location** = Directory where the image will be saved ()
**extension** = File extension

**Example**

```php
return [

    \App\Models\v1\Car::class => [
        'fantasy_property' => 'photo',
        'save_location' => '/photos/car',
        'extension' => '.png'
    ],

];
```

### Step 3 Optional
If your config files are cached don't forget to run:
```
php artisan config:cache
```

### Step 4
Test.</br>
**Example Request**
```json
{
    "name": "Honda Civic",
    "license_plate": "ter-1223",
    "motor_power": 140,
    "photo": "your_base64"
}
```
Note: the property you defined can receive multiple uploads for that, just pass an array

### Step 5 Optional
If you want to show the files in the reply just use the model ```files``` function</br>
**Implementation**</br>
In your transformer add a name for the property and use the ```fractal_transformer``` helper</br>
Note: The files function is present in all models that extend ```ModelAuthenticatableBase``` or ```ModelBase```</br>
```php
public function transform(Car $car)
    {
        return [
            'uuid' => $car->uuid,
            'name' => $car->name,
            'license_plate' => $car->license_plate,
            'motor_power' => $car->motor_power,
            'files' => fractal_transformer(
                $car->files,
                FileTransformer::class,
                null
            )
        ];
    }
```

**Example response**
```json
{
            "uuid": "ff8e9ad0-c768-11ea-8a2a-e3c9240324d2",
            "name": "Camaro ss 68",
            "license_plate": "ter-4321",
            "motor_power": 295,
            "files": [
                {
                    "uuid": "ff90fb00-c768-11ea-926f-29877bf386e1",
                    "file": "ff8f2170-c768-11ea-84b6-a1fa0486978b",
                    "extension": ".png",
                    "url": "http://laravel-simple-bases-test/v1/file/photos/car/ff8f2170-c768-11ea-84b6-a1fa0486978b.png"
                }
            ]
        }
```

### Update file
To update the file just pass a new parameter with the same name as the property you created with a '_uuid' at the end and in the original property pass the new file.
Example:
```json
{
    "photo": "you_base64",
    "photo_uuid": "uuid of the file that will be updated"
}
```
### Delete file
To delete the file, just pass a new parameter with the same name as the property you created with a '_uuid' at the end and in the original property pass the value null.
Example:
```json
{
    "photo": "null",
    "photo_uuid": "uuid of the file to be deleted"
}
```

## Exception [:arrow_up:](#summary)
This package has a base class to extend in ```app/Exceptions/Handler.php```. This class will make the return of errors more pleasant for those who use the api

**Original**</br>

![Captura de tela de 2020-07-16 11-36-29](https://user-images.githubusercontent.com/56044466/87684453-a6efbc00-c758-11ea-9c85-c52639dabb9e.png)

</br>

**With ```BaseHandlerException```**</br>

```APP_DEBUG=true```
```json
{
    "error": {
        "message": "Resource not found",
        "file": "/var/www/laravel-simple-bases-test/vendor/fabio/laravel-simple-bases/src/Services/BaseService.php",
        "line": 59
    }
}
```

```APP_DEBUG=false```
```json
{
    "error": {
        "message": "Resource not found",        
    }
}
```

**Usage**</br>
Just replace the ```ExceptionHandler``` class in ```app/Exceptions/Handler.php``` with ```BaseHandlerException```

## Helpers [:arrow_up:](#summary)

### fractal_transformer [:arrow_up:](#summary)
Returns an array of an existing transformer.</br>
Created mainly to be used inside another transformer, with it you can standardize your returns from the api</br>

**Description**
```php
fractal_transformer(mixed $data, Transformer $transformer, mixed $defaultValue = [])
```

**Example**

```php
fractal_transformer($user->car, CarTransformer::class, null)
```

**Transformer implementation**

```php
public function transform(User $user)
    {
        return [
            'uuid' => $user->uuid,
            'name' => $user->name,
            'car' => fractal_transformer(
                $user->car,
                CarTransformer::class,
                null
            ),
        ];
    }
```

**Example response**
```json
{
    "data": [
        {
            "uuid": "64b774c0-c153-11ea-a4e9-01b907f3026a",
            "name": "default",
            "car": null
        },
        {
            "uuid": "9c3c8960-c763-11ea-8a64-0b7b48fb6453",
            "name": "new user 2",
            "car": {
                "uuid": "d96598d0-c527-11ea-b192-517bb6c42efa",
                "name": "Mustang boss 302 68",
                "license_plate": "ter-1234",
                "motor_power": 290
            }
        }
    ]
}
```




