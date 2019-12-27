[Docs](readme.md) > Routing

# Routing

Valiant uses [Laravel advanced route](https://github.com/lesichkovm/laravel-advanced-route) for routing. This is similar to the old `Route::controller()` method.

---

### Declaring routes

Only one route is necessary per model:

    AdvancedRoute::controller('brands', 'BrandController');

---

### Mapping a URL to a controller method

Setting the URL in a view:

    <a href="{{ url($this->model->getTable() . '/edit/' . $this->model->id) }}">
        Edit Brand
    </a>
    
The controller method:

    public function getEdit($id)
    {
        $this->model = $this->model->findOrFail($id);
        return view($this->model->getTable() . '.edit', ['model' => $this->model]);
    }
    
This works for any HTTP method, with any number of parameters.
    
- [Learn more in the Laravel advanced route readme](https://github.com/lesichkovm/laravel-advanced-route)
