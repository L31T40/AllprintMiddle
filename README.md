<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>
 
## About This Project

This project is a basis for API development with authentication using Laravel Passport.

  
## Project Setup

Create a laravel db and set credential in .env


php artisan serve


-- register new user
http://127.0.0.1:8000/api/register
Post - form-data
Body request:
    email
    password
    c_password
    name

-- login
http://127.0.0.1:8000/api/login
Post - form-data
Body request:
    email
    password
   
-- API utils
http://127.0.0.1:8000/api/?
Post - 
Header request:
    Authorization Bearer accessToken
    Content-Length  application/x-www-form-urlencoded
    Accept  application/json
    
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
