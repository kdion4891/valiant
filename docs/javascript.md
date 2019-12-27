[Docs](readme.md) > JavaScript

# JavaScript

Valiant offers a bit of useful JavaScript functionality out of the box including support for AJAX forms, dynamic modals, confirmations, JSON response handlers, and more.

---

### `[data-ajax-post]`

Invokes a simple AJAX POST using a URL and CSRF token:

    <button
        type="button"
        data-ajax-post="{{ url($model->getTable() . '/my-custom-post') }}"
        data-ajax-token="{{ csrf_token() }}"
        class="btn btn-outline-primary"
    >
        My Custom POST
    </button>
    
---

### `[data-confirm]`

Asks the user for confirmation using a specified message when clicking a button:
    
    <button type="submit" class="btn btn-danger" data-confirm="Are you sure?">
        Delete
    </button>
    
---

### `[data-show-modal]`

Opens an AJAX modal using the specified URL:

    <button
        type="button"
        class="btn btn-outline-primary px-btn"
        title="Report Accident"
        data-show-modal="{{ url('vehicles/report-accident/' . $model->id) }}"
    >
        <i class="fa fa-fw fa-car-crash"></i>
    </button>

AJAX modals should extend the `valiant::layouts.modal` view:

    @extends('valiant::layouts.modal')
    
    @section('title', 'Report Accident')
    
    @section('child-content')
        <form method="POST" action="{{ url('vehicles/report-accident/' . $model->id) }}" data-ajax-form>
            @csrf
    
            <div class="modal-body">
                <div class="form-group mb-0">
                    <textarea name="details" class="form-control" rows="3" placeholder="Details" data-error-input="details"></textarea>
                    <span class="invalid-feedback" role="alert" data-error-feedback="details"></span>
                </div>
            </div>
    
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Report</button>
            </div>
        </form>
    @endsection
    
---

### `[data-ajax-form]`

Turns a form into an AJAX-powered form which expects a JSON response.

    <form method="POST" action="{{ url($model->getTable() . '/delete-bulk') }}" data-ajax-form>
    
Showing AJAX form errors dynamically:

    <div class="form-group">
        <textarea name="details" class="form-control" rows="3" placeholder="Details" data-error-input="details"></textarea>
        <span class="invalid-feedback" role="alert" data-error-feedback="details"></span>
    </div>
    
Note the use of `[data-error-input]` and `[data-error-feedback]`.   
 
---

### `[data-checkbox-ids]`

Contains a comma-separated list of checked model IDs via the table on the page:

    <form method="POST" action="{{ url($model->getTable() . '/delete-bulk') }}" data-ajax-form>
        @csrf
        <input type="hidden" name="ids" data-checkbox-ids>
        <button type="submit" class="dropdown-item" data-confirm="Are you sure?">
            Delete
        </button>
    </form>  
    
Used by bulk actions.
 
---

### JSON Responses

AJAX buttons and forms expect a JSON response from controllers:

    return response()->json([
        'status' => 'My Model deleted!',
        'reload_table' => true,
    ]);
    
#### `redirect`

Redirects the user to the specified URL.

    'redirect' => url('home'),
    
#### `reload_page`

Reloads the current URL.

    'reload_page' => true,
    
#### `reload_table`

Reloads the table on the current page.

    'reload_table' => true,
    
#### `show_modal`

Dynamically shows a modal with view content.

    'show_modal' => view('my_models.custom-modal', ['model' => $this->model])->render(),
    
#### `dismiss_modal`

Dismisses the currently open AJAX modal:

    'dismiss_modal' => true,

#### `status`

Briefly shows a successful toast message with the given status:

    'status' => 'Report saved!',
    
#### `jquery`

Executes jQuery with a given selector, method, and content:

    'jquery' => [
        'selector' => '[data-field]',
        'method' => 'remove',
        'content' => '[data-field="' . $field_id . '"]',
    ],

---

### Custom CSS & JS

Valiant installation creates empty `public/valiant/js/custom.css` and `public/valiant/js/custom.js` files to use for custom code.

You can insert your own CSS & JS in these files, or use webpack to compile assets to them. These files are included in the parent layout view.

Updating webpack to use these paths:

    mix.js('resources/js/app.js', 'public/valiant/js/custom.js')
        .sass('resources/sass/app.scss', 'public/valiant/js/custom.css');
