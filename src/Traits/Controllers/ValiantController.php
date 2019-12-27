<?php

namespace Kdion4891\Valiant\Traits\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

trait ValiantController
{
    protected $model;
    protected $upload_path;

    public function getIndex(Request $request)
    {
        $table = $this->model->table();
        $this->setGoBackUrl();

        return $request->ajax()
            ? $table->json
            : view('valiant::models.index', ['model' => $this->model, 'html' => $table->html]);
    }

    public function getCreate()
    {
        return view('valiant::models.create', ['model' => $this->model]);
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, $this->model->fieldRules('create'));
        $this->model = $this->model->create($this->requestData('create'));

        if ($this->model->log_actions) {
            $data = $this->model->toArray();
            Log::action('Created ' . $this->model->view_title . ' #' . $this->model->id)->withData($data)->save();
        }

        $response = $request->input('_submit') == 'save' ? back() : $this->goBack();
        return $response->with('status', $this->model->view_title . ' created!');
    }

    public function getDetails($id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->setGoBackUrl();

        return view('valiant::models.details', ['model' => $this->model]);
    }

    public function getEdit($id)
    {
        $this->model = $this->model->findOrFail($id);
        return view('valiant::models.edit', ['model' => $this->model]);
    }

    public function postEdit(Request $request, $id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->validate($request, $this->model->fieldRules('edit'));
        $this->model->update($this->requestData('edit'));
        $data = Arr::only($this->model->toArray(), array_keys($this->model->getChanges()));

        if ($this->model->log_actions && $data) {
            Log::action('Edited ' . $this->model->view_title . ' #' . $this->model->id)->withData($data)->save();
        }

        $response = $request->input('_submit') == 'save' ? back() : $this->goBack();
        return $response->with('status', $this->model->view_title . ' edited!');
    }

    public function postDelete(Request $request, $id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->model->delete();

        if ($this->model->log_actions) {
            Log::action('Deleted ' . $this->model->view_title . ' #' . $this->model->id)->save();
        }

        if ($request->input('request_ajax')) {
            return response()->json([
                'status' => $this->model->view_title . ' deleted!',
                'reload_table' => true,
            ]);
        }
        else {
            $request->session()->flash('status', $this->model->view_title . ' deleted!');
            return response()->json(['redirect' => url($this->model->getTable())]);
        }
    }

    public function postDeleteBulk(Request $request)
    {
        if ($request->input('ids')) {
            foreach (explode(',', $request->input('ids')) as $id) {
                if ($model = $this->model->find($id)) $model->delete();
            }

            if ($this->model->log_actions) {
                $data = ['ids' => $request->input('ids')];
                Log::action('Deleted ' . Str::plural($this->model->view_title))->withData($data)->save();
            }
        }

        return response()->json([
            'status' => Str::plural($this->model->view_title) . ' deleted!',
            'reload_table' => true,
        ]);
    }

    public function postAddField($field_name)
    {
        foreach ($this->model->fields() as $field) if ($field->name == $field_name) break;

        return response()->json([
            'jquery' => [
                'selector' => '[data-fields="' . $field_name . '"]',
                'method' => 'append',
                'content' => view('valiant::inputs.arrays.item', ['model' => $this->model, 'field' => $field, 'id' => uniqid()])->render(),
            ],
        ]);
    }

    public function postDeleteField($field_id)
    {
        return response()->json([
            'jquery' => [
                'selector' => '[data-field]',
                'method' => 'remove',
                'content' => '[data-field="' . $field_id . '"]',
            ],
        ]);
    }

    protected function setGoBackUrl()
    {
        Session::put('go_back_url', URL::current());
    }

    protected function goBack()
    {
        return redirect(Session::get('go_back_url', $this->model->getTable()));
    }

    private function requestData($action)
    {
        $field_keys = array_keys($this->model->fieldInputs($action));
        $data = Arr::only(request()->all(), $field_keys);
        $files = Arr::only(request()->allFiles(), $field_keys);

        foreach ($files as $key => $file) {
            if (is_array($file)) {
                $uploaded_files = [];
                foreach ($file as $k => $f) $uploaded_files[uniqid()] = $this->uploadFile($key . '.' . $k);
                $data[$key] = array_merge($this->model->$key ? $this->model->$key : [], $uploaded_files);
            }
            else {
                if ($this->model->$key) Storage::delete(Arr::first($this->model->$key)['file']);
                $data[$key] = [uniqid() => $this->uploadFile($key)];
            }
        }

        return $data;
    }

    private function uploadFile($key)
    {
        $file = request()->file($key);

        return [
            'file' => $file->store($this->uploadPath()),
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    protected function uploadPath()
    {
        return $this->upload_path ? $this->upload_path : 'files/' . $this->model->getTable();
    }

    public function postDeleteFile($model_id, $field_name, $key)
    {
        $this->model = $this->model->findOrFail($model_id);
        $file_name = $this->model->$field_name[$key]['name'];
        Storage::delete($this->model->$field_name[$key]['file']);
        $this->model->update([$field_name => Arr::except($this->model->$field_name, $key)]);

        if ($this->model->log_actions) {
            Log::action('Deleted ' . $this->model->view_title . ' #' . $this->model->id . ' File: ' . $file_name)->save();
        }

        return response()->json([
            'status' => 'File deleted!',
            'jquery' => [
                'selector' => '[data-file]',
                'method' => 'remove',
                'content' => '[data-file="' . $key . '"]',
            ],
        ]);
    }
}
