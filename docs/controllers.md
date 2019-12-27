[Docs](readme.md) > Controllers

# Controllers

The `ValiantController` trait provides all of the methods for CRUD including field management, logging, file uploads, "go back" redirects, and more.

---

### Model

The `ValiantController` trait requires a `$model` to be specified:

    class MyModelController extends Controller
    {
        use ValiantController;
    
        public function __construct()
        {
            $this->model = new MyModel;
            $this->middleware('auth');
        }
        
---

### Go back URL

The "go back" methods are used when a user clicks on the `Save & Go Back` button in forms.

You can specify a "go back" URL in any controller method:

    $this->setGoBackUrl()

This will set the "go back" URL to the current URL. You should call this in your custom detail page methods.

Returning a redirect with the current "go back" URL:

    return $this->goBack()
    
---

### File uploads

Files uploaded by Valiant controllers go into the `public` disk. 

Be sure to update your `filesystems` config to use the `public` disk by default:

    'default' => env('FILESYSTEM_DRIVER', 'public'),
    
And symlink it:

    php artisan storage:link
    
You can specify a custom file upload path via the `$upload_path` property:

    class MyModelController extends Controller
    {
        use ValiantController;
    
        public function __construct()
        {
            $this->model = new MyModel;
            $this->middleware('auth');
            $this->upload_path = 'files/mypath';
        }
        
Or by overriding the `uploadPath()` method:

    protected function uploadPath()
    {
        return 'files/' . $this->model->getTable() . '/' . Auth::user()->id;
    }
