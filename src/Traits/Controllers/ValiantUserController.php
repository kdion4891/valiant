<?php

namespace Kdion4891\Valiant\Traits\Controllers;

use App\Log;
use Illuminate\Http\Request;

trait ValiantUserController
{
    use ValiantController;

    public function getPassword($id)
    {
        $this->model = $this->model->findOrFail($id);
        return view('valiant::users.password', ['model' => $this->model]);
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
}
