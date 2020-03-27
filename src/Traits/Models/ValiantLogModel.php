<?php

namespace Kdion4891\Valiant\Traits\Models;

use Illuminate\Support\Facades\Auth;
use Kdion4891\Valiant\Action;
use Kdion4891\Valiant\Field;

trait ValiantLogModel
{
    use ValiantModel;

    public function user()
    {
        return $this->belongsTo('App\User')->withDefault(['name' => null]);
    }

    public function fields()
    {
        return [
            Field::make('ID')->detail(),

            Field::make('User', 'user_id')
                ->table('user.name')->tableSearchSort()
                ->detail('user.name'),

            Field::make('Action')
                ->table()->tableSearchSort()
                ->detail(),

            Field::make('Data')->detail(),

            Field::make('Created At')
                ->table()->tableSearchSort()->tableDefaultOrder('desc')
                ->detail(),
        ];
    }

    public function indexActions()
    {
        return [];
    }

    public function singleActions()
    {
        return [
            //Action::detailsButton(),
            Action::backButton(),
            Action::deleteButton(),
        ];
    }

    public static function action($action)
    {
        $log = new static();
        $log->user_id = Auth::check() ? Auth::user()->id : null;
        $log->action = $action;
        return $log;
    }

    public function withData($data = [])
    {
        $this->data = $data ? $data : null;
        return $this;
    }
}
