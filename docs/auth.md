[Docs](readme.md) > Auth

# Auth

Valiant is fully integrated with Laravel `Auth` and `Gate`.

---

### Setting available user roles

In the `User` model `$roles` property:

    class User extends Authenticatable
    {
        use Notifiable, ValiantUserModel;
        
        protected $roles = ['Admin', 'Manager', 'User'];

---

### Setting the default registration role

In the `User` model `$register_role` property:

    class User extends Authenticatable
    {
        use Notifiable, ValiantUserModel;
        
        protected $register_role = 'User';

---

### Setting available auth routes

Using the Laravel `Auth::routes()` method:

    Auth::routes(['register' => false]);

---

### Protecting controller methods

Using middleware:

    class VehicleController extends Controller
    {
        use ValiantController;
    
        public function __construct()
        {
            $this->middleware('can:Admin')->except(['getIndex', 'getDetails']);
        }

---

### Protecting model fields and actions

Using `Gate::check()` conditional statements:

    class Vehicle extends Model
    {
        use ValiantModel;
    
        public function fields()
        {
            if (Gate::check('Admin') {
                return [
                    Field::make('Name')
                        ->table()->tableSearchSort()->tableDefaultOrder()
                        ->detail()
                        ->input()->inputCreateEdit()
                        ->rulesCreateEdit(['name' => 'required']),
                ];
            }
            
            return null;
        }
        
        public function indexActions()
        {
            if (Gate::check('Admin')) {
                return [
                    Action::createButton(),
                ];
            }
            
            return null;
        }
        
---

### Protecting views

Using blade directives:

    @can('Admin')
        <li class="nav-item">
            <a href="{{ url('brands') }}" class="nav-link {{ Request::is('brands') ? 'active' : '' }}">
                <i class="nav-icon fa fa-copyright"></i> <p>Brands</p>
            </a>
        </li>
    @endcan
