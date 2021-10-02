# Laravel 8.x /grades endpoint

## Installation

1. Install dependencies with composer

`composer install`

2. Start the app in docker via Laravel Sail

`./vendor/bin/sail up`

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

```OST http://localhost:9090/api/register
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


## Testing
`./vendor/bin/sail artisan test tests/Feature/ExampleTest.php `
