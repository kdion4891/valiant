<?php

namespace Kdion4891\Valiant\Traits\Controllers;

use Illuminate\Http\Request;

trait ValiantProfileController
{
    use ValiantController;

    public function getEdit()
    {
        return view('valiant::auth.profile', ['model' => $this->model]);
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, $this->model->fieldRules('profile_edit'));
        $this->model->update($this->requestData('profile_edit'));

        return back()->with('status', 'Profile edited!');
    }

    public function getPassword()
    {
        return view('valiant::auth.passwords.change', ['model' => $this->model]);
    }

    public function postPassword(Request $request)
    {
        $this->validate($request, $this->model->fieldRules('profile_password'));
        $this->model->update($this->requestData('profile_password'));

        return back()->with('status', 'Password changed!');
    }
}
