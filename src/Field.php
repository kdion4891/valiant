<?php

namespace Kdion4891\Valiant;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Field
{
    private $label;
    private $name;
    private $table = false;
    private $table_view;
    private $table_view_custom;
    private $table_view_custom_data = [];
    private $table_alias;
    private $table_search = false;
    private $table_sort = false;
    private $table_default_order;
    private $table_hidden = false;
    private $detail = false;
    private $detail_view;
    private $detail_view_custom;
    private $detail_view_custom_data = [];
    private $detail_alias = [];
    private $input_view;
    private $input_view_custom;
    private $input_view_custom_data = [];
    private $input_type;
    private $input_rows;
    private $input_options = [];
    private $input_fields = [];
    private $input_actions = [];
    private $rules_actions = [];

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

    public function table($alias = '')
    {
        $this->table = true;
        $this->table_alias = $alias;
        return $this;
    }

    public function tableView($view = '', $data = [])
    {
        $this->table_view_custom = $view;
        $this->table_view_custom_data = $data;
        return $this;
    }

    public function tableSearch()
    {
        $this->table_search = true;
        return $this;
    }

    public function tableSort()
    {
        $this->table_sort = true;
        return $this;
    }

    public function tableSearchSort()
    {
        return $this->tableSearch()->tableSort();
    }

    public function tableDefaultOrder($direction = 'asc')
    {
        $this->table_default_order = $direction;
        return $this;
    }

    public function tableHidden()
    {
        $this->table_hidden = true;
        return $this;
    }

    public function detail($alias = '')
    {
        $this->detail = true;
        $this->detail_alias = $alias ? explode('.', $alias) : [];
        return $this;
    }

    public function detailView($view = '', $data = [])
    {
        $this->detail_view_custom = $view;
        $this->detail_view_custom_data = $data;
        return $this;
    }

    public function inputView($view = '', $data = [])
    {
        $this->input_view_custom = $view;
        $this->input_view_custom_data = $data;
        return $this;
    }

    public function input($type = 'text')
    {
        $this->input_view = 'valiant::inputs.text';
        $this->input_type = $type;
        return $this;
    }

    public function inputTextarea($rows = 3)
    {
        $this->input_view = 'valiant::inputs.textarea';
        $this->input_rows = $rows;
        return $this;
    }

    public function inputFile()
    {
        $this->table_view = 'valiant::details.files';
        $this->detail_view = 'valiant::details.files';
        $this->input_view = 'valiant::inputs.file';
        return $this;
    }

    public function inputFiles()
    {
        $this->table_view = 'valiant::details.files';
        $this->detail_view = 'valiant::details.files';
        $this->input_view = 'valiant::inputs.files';
        return $this;
    }

    public function inputCheckbox()
    {
        $this->table_view = 'valiant::details.checkbox';
        $this->detail_view = 'valiant::details.checkbox';
        $this->input_view = 'valiant::inputs.checkbox';
        return $this;
    }

    public function inputSwitch()
    {
        $this->table_view = 'valiant::details.checkbox';
        $this->detail_view = 'valiant::details.checkbox';
        $this->input_view = 'valiant::inputs.switch';
        return $this;
    }

    public function inputCheckboxes($options = [])
    {
        $this->table_view = 'valiant::details.checkboxes';
        $this->detail_view = 'valiant::details.checkboxes';
        $this->input_view = 'valiant::inputs.checkboxes';
        $this->input_options = $this->inputOptions($options);
        return $this;
    }

    public function inputRadio($options = [])
    {
        $this->input_view = 'valiant::inputs.radio';
        $this->input_options = $this->inputOptions($options);
        return $this;
    }

    public function inputSelect($options = [])
    {
        $this->input_view = 'valiant::inputs.select';
        $this->input_options = $this->inputOptions($options);
        return $this;
    }

    private function inputOptions($options)
    {
        return !Arr::isAssoc($options) ? array_combine($options, $options) : $options;
    }

    public function inputArray($fields = [])
    {
        $this->input_view = 'valiant::inputs.arrays.list';
        $this->input_fields = $fields;
        return $this;
    }

    public function inputPlaintext()
    {
        $this->input_view = 'valiant::inputs.plaintext';
        return $this;
    }

    public function inputCreate()
    {
        return $this->inputActions('create');
    }

    public function inputEdit()
    {
        return $this->inputActions('edit');
    }

    public function inputCreateEdit()
    {
        return $this->inputActions(['create', 'edit']);
    }

    public function inputActions($actions)
    {
        if (!is_array($actions)) $actions = [$actions];
        foreach ($actions as $action) $this->input_actions[] = $action;
        return $this;
    }

    public function rulesCreate($rules = [])
    {
        return $this->rulesActions('create', $rules);
    }

    public function rulesEdit($rules = [])
    {
        return $this->rulesActions('edit', $rules);
    }

    public function rulesCreateEdit($rules = [])
    {
        return $this->rulesActions(['create', 'edit'], $rules);
    }

    public function rulesActions($actions, $rules = [])
    {
        if (!is_array($actions)) $actions = [$actions];
        foreach ($actions as $action) $this->rulesAction($action, $rules);
        return $this;
    }

    private function rulesAction($action = '', $rules = [])
    {
        foreach ($rules as $key => $rule) {
            $rule = !is_array($rule) ? explode('|', $rule) : $rule;
            $this->rules_actions[$action][$key] = isset($this->rules_actions[$action][$key])
                ? array_merge($this->rules_actions[$action][$key], $rule)
                : $rule;
        }
        return $this;
    }
}
