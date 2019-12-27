<?php

namespace Kdion4891\Valiant\Traits\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Kdion4891\Valiant\Action;
use Kdion4891\Valiant\Field;
use Kdion4891\Valiant\Rules\CurrentPassword;

trait ValiantUserModel
{
    use ValiantModel;

    public function getRolesAttribute($value)
    {
        return property_exists($this, 'roles') ? $this->roles : ['Admin', 'User'];
    }

    public function getRegisterRoleAttribute($value)
    {
        return property_exists($this, 'register_role') ? $this->register_role : 'User';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = strlen($value) == 60 && substr($value, 0, 4) == '$2y$' ? $value : Hash::make($value);
    }

    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    public function fields()
    {
        return [
            Field::make('ID')->detail(),

            Field::make('Name')
                ->table()->tableSearchSort()->tableDefaultOrder()
                ->detail()
                ->input()->inputActions(['create', 'edit', 'profile_edit'])
                ->rulesActions(['create', 'edit', 'profile_edit'], ['name' => 'required']),

            Field::make('Email')
                ->table()->tableSearchSort()
                ->detail()
                ->input('email')->inputActions(['create', 'edit', 'profile_edit'])
                ->rulesActions(['create', 'edit', 'profile_edit'], ['email' => ['required', 'email', Rule::unique('users')->ignore($this->id)]]),

            Field::make('Current Password')
                ->input('password')->inputActions(['profile_password'])
                ->rulesActions(['profile_password'], ['current_password' => ['required', new CurrentPassword]]),

            Field::make('Password')
                ->input('password')->inputActions(['create', 'password', 'profile_password'])
                ->rulesActions(['create', 'password', 'profile_password'], ['password' => 'required|confirmed']),

            Field::make('Confirm Password', 'password_confirmation')
                ->input('password')->inputActions(['create', 'password', 'profile_password']),

            Field::make('Role')
                ->table()->tableSearchSort()
                ->detail()
                ->inputSelect($this->roles)->inputActions(['create', 'edit'])
                ->rulesActions(['create', 'edit'], ['role' => ['required', Rule::in($this->roles)]]),

            Field::make('Timezone')
                ->table()->tableSearchSort()
                ->detail(),

            Field::make('Email Verified At')->detail(),
            Field::make('Created At')->detail(),
            Field::make('Updated At')->detail(),
        ];
    }

    public function singleActions()
    {
        return [
            Action::detailsButton(),
            Action::editButton(),
            Action::make('valiant::users.actions.password'),
            Action::deleteButton(),
        ];
    }
}
