# LaunchCart Test Installation

This file should address all the steps to install and run the LaunchCart Test

## Getting Started

Before running 'php artisan server' please rename the `.env.example` file to `.env`.

The main variables to modify in this file would be 

```
APP_NAME="LaunchCart Test"
APP_URL= 

KLAVIYO_PUBLIC_KEY= Your public klaviyo API key or the one provided 
KLAVIYO_PIVRATE_KEY= Your private klaviyo API key or the one provided 
```

### Executing program

* To set up the database structure run
```
php artisan migrate
```
* To start the program run 
```
php artisan serve
```

## Authors

Contributors names and contact info

Marco Segura  
[@3birdsmedia](https://twitter.com/3birdsmedia)

## Version History

* 0.1
    * Initial Release

## Acknowledgments

Inspiration, code snippets, etc.
* [Registration Form](https://vegibit.com/how-to-create-user-registration-in-laravel/)
* [Implementing MVC in Laravel](https://blog.pusher.com/laravel-mvc-use/)
* [Laravel Resource CRUD](https://scotch.io/tutorials/simple-laravel-crud-with-resource-controllers)
* [Easy to implement Laravel 6-7 CRUD] (https://www.techiediaries.com/laravel/php-laravel-7-6-tutorial-crud-example-app-bootstrap-4-mysql-database/)
