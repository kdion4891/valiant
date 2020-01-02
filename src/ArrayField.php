<?php

namespace Kdion4891\Valiant;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArrayField
{
    private $label;
    private $name;
    private $input_view;
    private $input_view_custom;
    private $input_view_custom_data = [];
    private $input_type;
    private $input_rows;
    private $input_options = [];
    private $input_column_class = 'col';

    public function __construct($label, $name)
    {
        $this->label = $label;
        $this->name = $name ? $name : Str::snake(Str::lower($label));
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public static function make($label, $name = '')
    {
        return new static($label, $name);
    }

    public function inputView($view = '', $data = [])
    {
        $this->input_view_custom = $view;
        $this->input_view_custom_data = $data;
        return $this;
    }

    public function input($type = 'text')
    {
        $this->input_view = 'valiant::inputs.arrays.text';
        $this->input_type = $type;
        return $this;
    }

    public function inputTextarea($rows = 3)
    {
        $this->input_view = 'valiant::inputs.arrays.textarea';
        $this->input_rows = $rows;
        return $this;
    }

    public function inputCheckbox()
    {
        $this->input_view = 'valiant::inputs.arrays.checkbox';
        return $this;
    }

    public function inputSwitch()
    {
        $this->input_view = 'valiant::inputs.arrays.switch';
        return $this;
    }

    public function inputSelect($options = [])
    {
        $this->input_view = 'valiant::inputs.arrays.select';
        $this->input_options = $this->inputOptions($options);
        return $this;
    }

    private function inputOptions($options)
    {
        return !Arr::isAssoc($options) ? array_combine($options, $options) : $options;
    }

    public function inputColumnClass($class = 'col')
    {
        $this->input_column_class = $class;
        return $this;
    }
}
