[Docs](readme.md) > Installation

# Installation

Create a new Laravel app via Composer:

    laravel new myapp
    
Configure your `.env` file with your app name, URL, database, & mail server.

Require Valiant via Composer:

    composer require kdion4891/valiant
    
Publish install files using the `--force`:

    php artisan vendor:publish --tag=install --force

Run the migrations:

    php artisan migrate
    
Create an `Admin` user:

    php artisan tinker
    $user = new User
    $user->name = 'Admin'
    $user->email = 'admin@example.com'
    $user->password = 'admin123' // user passwords are auto-encrypted
    $user->role = 'Admin'
    $user->save()

Visit your app URL and login.
