[Docs](readme.md) > Commands

# Commands

### `php artisan valiant:make Model`
    
Makes scaffolding for a new model, including:

- controller file
- model file
- migration file
- sidebar nav item insertion
- route insertion

---

### `php artisan vendor:publish --tag=TAG`

Publishes package files for the specified `TAG`.

#### `--tag=install`

Publishes the installation files, including:

- default Laravel auth controllers
- Valiant user profile controller
- default Laravel home controller
- Valiant log & user controllers 
- Valiant log & user models
- public CSS, images, JS, & web font assets
- sidebar nav items view file
- Laravel & Valiant routes

#### `--tag=public`

Publishes the public CSS, images, JS, & web font assets.

#### `--tag=views`

Publishes all package views files.
