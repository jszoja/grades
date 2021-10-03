# Laravel 8.x /grades endpoint

## Installation

1. Install dependencies with composer on local machine  
`composer install`

2. Set environment variables

Copy .env.example to .env file  
`cp .env.example .env`  

Please adjust app/database ports by adding APP_PORT and FORWARD_DB_PORT
variables to .env file.

3. Start the app in docker via Laravel Sail  
`./vendor/bin/sail up`

4. Update dependencies with composer on docker  
`./vendor/bin/sail composer update`

This will update dependencies to PHP 8.x on docker.

6. Run migrations  
`./vendor/bin/sail artisan migrate`


## App access
Endpoint should be available at HTTP POST:  
http://localhost:9090/api/grades

```
POST http://localhost:9090/api/grades
Accept: application/json
Authorization: Bearer {{auth token}}
```

It uses Bearer authentication.

First you need to reqister with HTTP POST:  
http://localhost:9090/api/register

```POST http://localhost:9090/api/register
Accept: application/json
Content-Type: application/x-www-form-urlencoded

name=Jan&email=user@gmail.com&password=mypass123&password_confirmation=mypass123
```

To logout use HTTP POST to:  
http://localhost:9090/api/logout

```POST http://localhost:9090/api/logout
Accept: application/json
Authorization: Bearer 1|WIN9lqFSxaeHIevahsi9qtCmpNA03FO1mTABmOOk
```

You can use your existing login to get the token via HTTP POST:  
http://localhost:9090/api/login

```POST http://localhost:9090/api/login
Accept: application/json
Content-Type: application/x-www-form-urlencoded

email=user@gmail.com&password=mypass123
```


## Testing
`./vendor/bin/sail artisan test tests/Feature/ExampleTest.php `
