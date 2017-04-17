## Chat API Challenge

This is a Chat API Code Challenge which its endpoints are described in 

http://docs.oracodechallenge.apiary.io/#introduction/submission 

## Install Instructions

- Clone the Repo
```	
$ git clone git@github.com:jocarr/chatApi.git
```
- Install Dependencies
```	
$ composer update
```
- Run Migrations
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

## Tests

Every endpoint described by the challenge is tested, at least with one test
```
$ vendor\bin\phpunit
```    