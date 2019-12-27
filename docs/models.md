[Docs](readme.md) > Models

# Models

The `ValiantModel` trait provides all of the methods for handling fields, actions, tables, view titles, allowing logs, using user timezones, and more.

---

### Fields

Specify the `fields()` to use for the model:

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
    
- [Learn more about fields](fields.md)

---

### Actions

Specify the various actions to use for the model:

    public function singleActions()
    {
        return [
            Action::detailsButton(),
            Action::editButton(),
            Action::deleteButton(),
        ];
    }
    
#### `indexActions()`

These actions appear on the model index page.

#### `detailActions()`

These actions appear as tabs in the model details pages.

#### `singleActions()`

These actions appear within table rows and all model CRUD sub pages.

#### `bulkActions()`

These actions appear in the checkbox dropdown on the model index page.

Return `null` inside any method to disable actions:

    public function detailActions()
    {
        return null;
    }
    
- [Learn more about actions](actions.md)

---

### Tables

#### `table($query = null, $show_actions = true, $show_checkbox = true)`

Returns an object containing datatables `json` and `html` for use in views.

#### `tableQuery()`

Returns the base table query for the model.

Using model tables in controllers:

    public function getDetailsAccidents(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $accident = new Accident;
        $query = $accident->tableQuery()->where('vehicle_id', $id);
        $table = $accident->table($query, true, false);

        $this->setGoBackUrl();

        return $request->ajax()
            ? $table->json
            : view('vehicles.details-accidents', ['model' => $vehicle, 'html' => $table->html]);
    }

---

### Traits

#### ColumnFillable

Sets the model `$fillable` to its database table column names.

#### UserTimezone

Retrieves timestamp strings in the user timezone via accessors.

Adding a custom user timezone accessor to a model:
    
    public function getCustomAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

User timezones are automatically set when they login or register.

---

### Properties

#### `$view_title`

Sets a custom title to use in model views:

    class MyModel extends Model
    {
        use ValiantModel;
        
        protected $view_title = 'My Awesome Model';
        
#### `$log_actions`

Enable or disable action logging for the model:

    class MyModel extends Model
    {
        use ValiantModel;
        
        protected $log_actions = false;
