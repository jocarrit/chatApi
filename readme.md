# Chat API Challenge

This is the Back-End of a Chat API Code Challenge which its endpoints are described in 

http://docs.oracodechallenge.apiary.io/#introduction/submission 

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

To get the Server with the API running, you will need the same things Laravel frameworks needs to run, like PHP and Composer.
For this Challenge we used MariaDB as our database.
The easiest way to run Laravel Apps on development, if you're on mac install Laravel Valet:

https://laravel.com/docs/5.4/valet

But, if you are on windows install Laragon:

https://laragon.org/

Finally, on Linux you could use Homestead, the official Laravel Vagrant box:

https://laravel.com/docs/5.4/homestead

### Installing

Now that we are ready, lets install our App.

- First of all, clone the github repository

```
$ git clone git@github.com:jocarr/chatApi.git
```

- Second, Install Dependencies

```
$ composer update
```

- Generate App Key

```
php artisan key:generate
```

- Now, create a new database:

```
$ mysql
$ CREATE DATABASE Chat
```
- Change the name of env.example file to .env, then open it and set up your database credentials

```	
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chat
DB_USERNAME=user	
DB_PASSWORD=secret
```	

- Then, run Migrations, to get the database structure

```	
$ php artisan migrate
```

- Create a password grant client 

```	
$ php artisan passport:install
```

- Copy the id and the secret and paste them into .env, like this

```	
PASWORD_CLIENT_ID=3
PASSWORD_CLIENT_SECRET=pDQ1kfsepvwex2uqiiw5GhhxYWFNZ0eBQBF2ydSt
```

With all these steps, you can now consult the API with the previously described endpoints

## Running the tests

Every endpoint described by the challenge is tested, at least with one test

```
$ vendor\bin\phpunit
``` 

## Built With

* [The Laravel Framework](https://laravel.com/) - The web framework used
* [Composer](https://getcomposer.org/) - Dependency Management
* [Laravel Passport](https://laravel.com/docs/5.4/passport) - The Laravels PHP Leagues implementation of the OAuth2 server
* [Spatie/Fractilistic](https://github.com/spatie/laravel-fractal) - Wraper for PHP Leagues Fractal, for managing API Responses
* [optimus/api-consumer](https://github.com/esbenp/laravel-api-consumer) - For autoconsuming API

## Authors

* **Jose Manuel Carrillo** - *Initial work* - [Jocarr](https://github.com/jocarr)

## License

This project is licensed under the MIT License.

