<?php

namespace Kdion4891\Valiant;

class Action
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public static function make($view = '')
    {
        return new static($view);
    }

    public static function createButton()
    {
        return self::make('valiant::models.actions.create-button');
    }

    public static function detailsButton()
    {
        return self::make('valiant::models.actions.details-button');
    }

    public static function detailsTab()
    {
        return self::make('valiant::models.actions.details-tab');
    }

    public static function editButton()
    {
        return self::make('valiant::models.actions.edit-button');
    }

    public static function deleteButton()
    {
        return self::make('valiant::models.actions.delete-button');
    }

    public static function deleteBulk()
    {
        return self::make('valiant::models.actions.delete-bulk');
    }
}
