[Docs](readme.md) > Actions

# Actions

Actions are represented by views in the UI.

Specifying actions in models:

    public function singleActions()
    {
        return [
            Action::detailsButton(),
            Action::make('vehicles.actions.report-accident-button'),
            Action::editButton(),
            Action::deleteButton(),
        ];
    }

---

### `make($view = '')`

Creates a custom action using the specified `$view`:

    Action::make('vehicles.actions.report-accident-button'),
    
Example of a custom action button view:

    <button
        type="button"
        class="btn btn-outline-primary px-btn"
        title="Report Accident"
        data-show-modal="{{ url('vehicles/report-accident/' . $model->id) }}"
    >
        <i class="fa fa-fw fa-car-crash"></i>
    </button>
    
- [Learn more in examples](examples.md)

---

### Default actions

#### `createButton()`

Shows the create button which goes to the model create form.

Used in model `indexActions()` by default.

#### `detailsButton()`

Shows the details icon button which goes to the model details page.

Used in model `singleActions()` by default.

#### `detailsTab()`

Shows the details tab which goes to the model details page.

Useful in model `detailActions()` for models with multiple detail pages.

#### `editButton()`

Shows the edit icon button which goes to the model edit form.

Used in model `singleActions()` by default.

#### `deleteButton()`

Shows the delete icon button which deletes the model and then reloads tables or redirects depending on context.

Used in model `singleActions()` by default.

#### `deleteBulk()`

Shows the delete bulk dropdown item which deletes checked models.

Used in model `bulkActions()` by default.
