<p align="center"><img src="https://i.imgur.com/zbYdpt8.png" alt="Valiant Laravel 6 Admin Panel Package" height="75"></p>

Valiant is a Laravel 6 admin panel package which promotes rapid development with high customization capabilities. It includes a model scaffolding command, expressive field & action declaration, Laravel auth integration, user roles, activity logs, AJAX form & modal support, automatic user timezones, and more.

- [Docs](docs/readme.md)
- [Screenshots](https://imgur.com/a/UiWZMml)
- [Support](https://github.com/kdion4891/valiant/issues)
- [Contributions](https://github.com/kdion4891/valiant/pulls)
- [Buy me a coffee](https://paypal.me/kjjdion)

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

# Quickstart

Make scaffolding for a new model:

    php artisan valiant:make MyModel
    
Update the new model `fields()`:

    class MyModel extends Model
    {
        use ValiantModel;
    
        public function fields()
        {
            return [
                Field::make('ID')
                    ->table()->tableSearchSort()->tableDefaultOrder('desc')
                    ->detail(),
    
                Field::make('Name')
                    ->table()->tableSearchSort()
                    ->detail()
                    ->input()->inputCreateEdit()
                    ->rulesCreateEdit(['name' => 'required']),
    
                Field::make('Created At')->detail(),
                Field::make('Updated At')->detail(),
            ];
        }

Update the new migration columns:

    class CreateMyModelsTable extends Migration
    {
        public function up()
        {
            Schema::create('my_models', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->timestamps();
            });
        }
        
Run the migration:

    php artisan migrate
    
Login to your app and click the `My Models` link in the sidebar.

- [Learn more in the docs](docs/readme.md)
