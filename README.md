This project is a ecommerce site made using laravel and angular js.
The front end is made using angular js and laravel and the backend is laravel.
The project also implements the payment gate way paypal.
For api authentication I have used laravel passport.
Spatia Permission is used in backend for access control.
I have used made a multiple authentication system in this project so we have seperate users and admins table.
Also this project can be a multi vendor system.
For setting up the project.
1. Clone the project.
2. Run php artisan key:generate command
3. Make a database in phpmyadmin
4. configure you .env file and connect your database if you have paypal sand box account configure them too
5. Run php artisan migrate:fresh --seed
6. Run php artisan serve
The seeder has already made an admin with email admin@admin.com with password => secret