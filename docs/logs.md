[Docs](readme.md) > Logs

# Logs

Valiant provides a simple action logging out of the box via the `Log` model.

---

### Logging an action

Using the `action()` constructor method:

    $data = ['ids' => $request->input('ids')];
    Log::action('Marked Vehicles Repaired')->withData($data)->save();
    
---
    
### Checking model allowance

Using a conditional statement:

    if ($this->model->log_actions) {
        $data = $this->model->toArray();
        Log::action('Created My Model ' #' . $this->model->id)->withData($data)->save();
    }
    
---

### Manually creating logs

Using Eloquent:

    Log::create([
        'user_id' => Auth::user()->id,
        'action' => 'Edited My Model #' . $this->model->id,
        'data' => $this->model->toArray(),
    ]);
