[Docs](readme.md) > Fields

# Fields

Valiant provides an expressive way to construct and customize model fields.

Specifying fields in models:

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
 
---

### `make($label, $name = '')`

Constructs a field.

#### `$label`

The label for UI elements.

#### `$name`

Optional database column name for the field. If no name is specified, Valiant will use a snake cased `$label` for the `$name` by default.

---

### `table($alias = '')`

Sets the field to be a table column.

#### `$alias`

Optional database query alias to use e.g. `brand.name`. Useful for relationships.

---

### `tableSearch()`

Sets the field to be searchable in tables.

---

### `tableSort()`

Sets the field to be sortable in tables.

---

### `tableSearchSort()`

Sets the field to be searchable and sortable in tables.

---

### `tableDefaultOrder($direction = 'asc')`

Sets the field to become the default order in tables. Only one field should be the default order.

#### `$direction`

Optional direction for ordering. Accepts `asc` or `desc`.

---

### `tableHidden()`

Sets the field to be hidden in tables. Useful for fields you want searchable in tables, but not actually visible.

---

### `tableView($view = '', $data = [])`

Sets a custom view to use for the field in tables.

#### `$view`

The view to use.

#### `$data`

Optional data to pass to the view.

All custom table views are passed `$model` and `$field` objects to use.

- [Learn more in examples](examples.md)

---

### `detail($alias = '')`

Sets the field to be present in the details page.

#### `$alias`

Optional relationship alias to use e.g. `brand.name`.

---

### `detailView($view = '', $data = [])`

Sets a custom view to use for the field in the details page.

Uses the same logic as `tableView()`.

---

### `input($type = 'text')`

Sets the field to be a form text input.

#### `$type`

Optional HTML5 input type e.g. `text`, `number`, `tel`, etc.

---

### `inputTextarea($rows = 3)`

Sets the field to be a form textarea input.

#### `$rows`

Optional amount of rows for the textarea to have.

---

### `inputFile()`

Sets the field to be a single form file input.

File fields must be cast to array in the model `$casts` property. The migration column should be `text`. File field values are a multidimensional array of data including `file` (asset path), `name` (original name), and `mime_type`, with a `uniqid()` as the key for each file uploaded.

Uploaded files use the `public` disk.

- [Learn more in controller docs](controllers.md)

---

### `inputFiles()`

Sets the field to be a `multiple` form file input.

Uses the same logic as `inputFile()`.

---

### `inputCheckbox()`

Sets the field to be a single form checkbox input.

The migration column for a checkbox should be `boolean`.

---

### `inputCheckboxes($options = [])`

Sets the field to be multiple form checkbox inputs.

Checkboxes fields must be cast to array in the model `$casts` property. The migration column should be `text`.

#### `$options`

An array of options to use for the checkboxes. If the options are a sequential array, it's values will be used for the checkbox values and labels. If the options are an associative array, it's keys will be used for the checkbox values, and its values for the checkbox labels.

Using a sequential array:

    Field::make('Color')->inputCheckboxes(['Red', 'Green', 'Blue']),
    
Translates to:

    <option value="Red">Red</option>
    <option value="Green">Green</option>
    <option value="Blue">Blue</option>

Using an associative array:

    Field::make('Color')->inputCheckboxes([
        '#ff0000' => 'Red', 
        '#00ff00' => 'Green', 
        '#0000ff' => 'Blue',
    ]),
    
Translates to:

    <option value="#ff0000">Red</option>
    <option value="#00ff00">Green</option>
    <option value="#0000ff">Blue</option>

---

### `inputRadio($options = [])`

Sets the field to be a form radio input.

#### `$options`

Uses the same logic as `inputCheckboxes()`.

---

### `inputSelect($options = [])`

Sets the field to be a form select input.

#### `$options`

Uses the same logic as `inputCheckboxes()`.

---

### `inputArray($fields = [])`

Sets the field to be an array of form inputs.

#### `$fields`

An array of `ArrayField`s. An `ArrayField` is a stripped down `Field` which only contains a handful of input methods.

Declaring an array field:

    Field::make('Office Locations')
        ->inputArray([
            ArrayField::make('City')->input()->inputColumnClass('col-2'),
            ArrayField::make('Province')->inputSelect($provinces = ['Alberta', 'BC', 'Ontario']),
        ])
        ->inputCreateEdit()
        ->rulesCreateEdit([
            'office_locations' => 'required',
            'office_locations.*.city' => 'required',
            'office_locations.*.province' => ['required', Rule::in($provinces)],
        ]),

- [Learn more in examples](examples.md)

---

### `inputPlaintext()`

Sets the field to be a plaintext form input.

---

### `inputView($view = '', $data = [])`

Sets a custom view to use for the field input in forms.

Uses the same logic as `tableView()`.

---

### `inputCreate()`

Sets the field input to be present in the `create` form.

---

### `inputEdit()`

Sets the field input to be present in the `edit` form.

---

### `inputCreateEdit()`

Sets the field input to be present in the `create` and `edit` forms.

---

### `inputActions($actions)`

Sets the field input to be present in custom action forms.

#### `$actions`

An array of multiple custom actions or a string of a single custom action.

Showing custom action inputs in a custom form view, e.g. `my_custom_action`:

    <form method="POST" action="{{ url($model->getTable() . '/my-custom-action/' . $model->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="list-group list-group-flush">
                @include('valiant::inputs.list', ['action' => 'my_custom_action'])
            </div>
            <div class="card-footer text-center bg-light rounded-bottom">
                <button type="submit" name="_submit" value="save" class="btn btn-primary">Save</button>
                <button type="submit" name="_submit" value="back" class="btn btn-primary">Save &amp; Go Back</button>
            </div>
        </div>
    </form>

- [Learn more in examples](examples.md)

---

### `rulesCreate($rules = [])`

Sets the validation rules to use in the `create` form.

#### `$rules`

An array of Laravel validation rules.

---

### `rulesEdit($rules = [])`

Sets the validation rules to use in the `edit` form.

Uses the same logic as `rulesCreate()`.

---

### `rulesCreateEdit($rules = [])`

Sets the validation rules to use in the `create` and `edit` forms.

Uses the same logic as `rulesCreate()`.

---

### `rulesActions($actions, $rules = [])`

Sets the validation rules to use in custom action forms.

#### `$actions`

An array of multiple custom actions or a string of a single custom action.

#### `$rules`

An array of Laravel validation rules.

Using rules in a custom action controller method, e.g. `my_custom_action`:

    public function postMyCustomAction(Request $request, $id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->validate($request, $this->model->fieldRules('my_custom_action'));

- [Learn more in examples](examples.md)
