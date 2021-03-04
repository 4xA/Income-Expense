## Installation instructions

- Copy .env.example and input your env configuration.
- Run `composer install`
- Run `php artisan migrate`.
- Run `php artisan db:seed`
- Always add header `Accept:application/json`.
- Login at route `api/login` with the following application/json body:
```
    {
        "email": "admin@classera.com",
        "password": "Password1234"
    }
```

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Assumptions

1. I used basic api authentication that comes bundled with the Laravel framework with plaintext api tokens and I did not use a package like `Passport` in order to simplify application development since this is not production level
2. I did not implement `content negotiation`; i.e. I did not implement supporting multiple request types like (json, xml, png) but only support application/json.
3. I merged the registration endpoint with the create method for users for simplification
4. I did not implement route caching but typically we would add a layer that will cache results for x seconds
5. I did not implement API versioning