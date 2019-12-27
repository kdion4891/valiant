[Docs](readme.md) > Quickstart

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
