[Docs](readme.md) > Examples

# Examples

Here are a few examples to introduce you to Valiant design patterns.

---

### Relationship Fields

Field declaration:

    Field::make('Brand', 'brand_id')
        ->table('brand.name')->tableSearchSort()
        ->detail('brand.name')
        ->inputSelect(Brand::orderBy('name')->pluck('name', 'id')->toArray())->inputCreateEdit()
        ->rulesCreateEdit(['brand_id' => ['required', Rule::exists('brands', 'id')]]),

- This model has a `belongsTo` relationship with `App\Brand`
- This relationship is eagerly loaded via the `$with` property

Using counts:

    Field::make('Accidents', 'accidents_count')
        ->table()
        ->detail(),

- This model has a `belongsTo` relationship with `App\Accident`
- This count is eagerly loaded via the `$withCount` property

---

### Custom Table Views

View file `resources/views/vehicles/tables/color.blade.php`:

    <i class="fa fa-circle" style="color: {{ $model->{$field->name} }}"></i>

Field declaration:

    Field::make('Color')
        ->table()->tableSearchSort()->tableView('vehicles.tables.color')
        ->inputSelect($colors = ['Red', 'Green', 'Blue', 'Black'])->inputCreateEdit()
        ->rulesCreateEdit(['color' => ['required', Rule::in($colors)]]),
    
---

### Custom Detail Views

View file `resources/views/vehicles/details/photo.blade.php`:

    <img src="{{ asset(Arr::first($model->{$field->name})['file']) }}" alt="Photo" height="120">

Field declaration:

    Field::make('Photo')
        ->detail()->detailView('vehicles.details.photo')
        ->inputFile()->inputCreateEdit()
        ->rulesCreate(['photo' => 'required|image']),

- The `public` disk has been configured as `default` and symlinked
- This model is casting `photo` to an `array` via the `$casts` property
- The migration for this field column is `text`

---

### Custom Input Views

View file `resources/views/inputs/date.blade.php`:

    <input
        type="datetime-local"
        name="{{ $field->name }}"
        id="{{ $field->name }}"
        class="form-control @error($field->name) is-invalid @enderror"
        value="{{ old($field->name, $model->{$field->name}) }}"
    >
    
    @error($field->name)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror

Field declaration:

    Field::make('Date Sold')->inputView('inputs.date')->inputCreateEdit(),
    
Note the use of the `$model` and `$field` objects in the view.
    
---

### Custom single action form

Field declaration:

    Field::make('Password')
        ->input('password')->inputActions('password')
        ->rulesActions('password', ['password' => 'required|confirmed']),

    Field::make('Confirm Password', 'password_confirmation')
        ->input('password')->inputActions('password'),

Note the use of `inputActions()` and `rulesActions()`.

Action declaration:

    Action::make('users.actions.password'),

Action button view file `resources/views/users/actions/password.blade.php`:

    <a
        href="{{ url($model->getTable() . '/password/' . $model->id) }}"
        class="btn btn{{ !Request::is($model->getTable() . '/password/' . $model->id) ? '-outline' : '' }}-primary px-btn"
        title="Password"
    >
        <i class="fa fa-fw fa-lock"></i>
    </a>

Action form view file `resources/views/users/password.blade.php`:

    @extends('valiant::layouts.auth')
    
    @section('title', 'Change ' . $model->view_title . ' Password')
    
    @section('child-header')
        <div class="row">
            <div class="col-sm">
                <h1 class="mb-2 text-dark">@yield('title')</h1>
            </div>
            <div class="col-sm-auto">
                @include('valiant::models.actions.single')
            </div>
        </div>
    @endsection
    
    @section('child-content')
        <form method="POST" action="{{ url($model->getTable() . '/password/' . $model->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="list-group list-group-flush">
                    @include('valiant::inputs.list', ['action' => 'password'])
                </div>
                <div class="card-footer text-center bg-light rounded-bottom">
                    <button type="submit" name="_submit" value="save" class="btn btn-primary">Save</button>
                    <button type="submit" name="_submit" value="back" class="btn btn-primary">Save &amp; Go Back</button>
                </div>
            </div>
        </form>
    @endsection

Action controller methods:

    public function getPassword($id)
    {
        $this->model = $this->model->findOrFail($id);
        return view('users.password', ['model' => $this->model]);
    }

    public function postPassword(Request $request, $id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->validate($request, $this->model->fieldRules('password'));
        $this->model->update($this->requestData('password'));

        if ($this->model->log_actions) {
            Log::action('Changed User #' . $this->model->id . ' Password')->save();
        }

        $response = $request->input('_submit') == 'save' ? back() : $this->goBack();
        return $response->with('status', $this->model->view_title . ' password changed!');
    }
    
---

### Custom single action modal

Action declaration:

    Action::make('vehicles.actions.report-accident-button'),

Action button view file `resources/views/vehicles/actions/report-accident-button.blade.php`:

    <button
        type="button"
        class="btn btn-outline-primary px-btn"
        title="Report Accident"
        data-show-modal="{{ url('vehicles/report-accident/' . $model->id) }}"
    >
        <i class="fa fa-fw fa-car-crash"></i>
    </button>

Note the use of `[data-show-modal]` in the button.

Action modal view file `resources/views/users/password.blade.php`:

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

Action controller methods:

    public function getReportAccident($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.report-accident', ['model' => $vehicle]);
    }

    public function postReportAccident(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $this->validate($request, ['details' => 'required']);
        $vehicle->accidents()->create($request->all());

        return response()->json([
            'status' => 'Report saved!',
            'dismiss_modal' => true,
            'reload_table' => true,
        ]);
    }
    
---

### Custom detail action relationship

Action declaration:

    Action::make('vehicles.actions.details-accidents-tab'),

Action tab view file `resources/views/vehicles/actions/details-accidents-tab.blade.php`:

    <li class="nav-item">
        <a
            class="nav-link {{ Request::is($model->getTable() . '/details-accidents/' . $model->id) ? 'active' : '' }}"
            href="{{ url($model->getTable() . '/details-accidents/' . $model->id) }}"
            role="tab"
        >
            Accidents
        </a>
    </li>

Action page view file `resources/views/users/password.blade.php`:

    @extends('valiant::layouts.auth')
    
    @section('title', 'Vehicle Accidents')
    
    @section('child-header')
        <div class="row">
            <div class="col-sm">
                <h1 class="mb-2 text-dark">@yield('title')</h1>
            </div>
            <div class="col-sm-auto">
                @include('valiant::models.actions.single')
            </div>
        </div>
    @endsection
    
    @section('child-content')
        <div class="card card-primary card-outline card-outline-tabs">
            @include('valiant::models.actions.detail')
    
            <div class="card-body">
                {!! $html->table() !!}
            </div>
        </div>
    @endsection
    
    @push('scripts')
        {!! $html->scripts() !!}
    @endpush

Action controller method:

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
    
Note the use of `$this->setGoBackUrl()` so forms return to this page if `Save & Go Back` is clicked.
    
---

### Custom bulk action ajax

Action declaration:

    Action::make('vehicles.actions.repaired-bulk'),

Action button view file `resources/views/vehicles/actions/repaired-bulk.blade.php`:

    <form method="POST" action="{{ url($model->getTable() . '/repaired-bulk') }}" data-ajax-form>
        @csrf
        <input type="hidden" name="ids" data-checkbox-ids>
        <button type="submit" class="dropdown-item">
            Mark Repaired
        </button>
    </form>

Note the `[data-checkbox-ids]` input, which is passed a comma-separated list of checked model IDs via the table.

Action controller method:

    public function postRepairedBulk(Request $request)
    {
        if ($request->input('ids')) {
            foreach (explode(',', $request->input('ids')) as $id) {
                if ($vehicle = Vehicle::find($id)) {
                    $vehicle->update(['repaired' => true]);
                }
            }

            $data = ['ids' => $request->input('ids')];
            Log::action('Marked Vehicles Repaired')->withData($data)->save();
        }

        return response()->json([
            'status' => 'Vehicles marked repaired!',
            'reload_table' => true,
        ]);
    }
