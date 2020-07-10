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

