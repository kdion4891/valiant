<?php

namespace Kdion4891\Valiant\Traits\Models;

use Kdion4891\Valiant\Action;

trait ValiantModel
{
    use ColumnFillable, UserTimezone;

    public function getViewTitleAttribute($value)
    {
        return property_exists($this, 'view_title')
            ? $this->view_title
            : trim(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', ' $0', class_basename($this)));
    }

    public function getLogActionsAttribute($value)
    {
        return property_exists($this, 'log_actions') ? $this->log_actions : true;
    }

    public function fields()
    {
        return [];
    }

    public function indexActions()
    {
        return [
            Action::createButton(),
        ];
    }

    public function detailActions()
    {
        return [];
    }

    public function rowActions()
    {
        return [
            Action::detailsButton(),
            Action::editButton(),
            Action::deleteButton(),
        ];
    }

    public function singleActions()
    {
        return [
            //Action::detailsButton(),
            Action::backButton(),
            Action::editButton(),
            Action::deleteButton(),
        ];
    }

    public function bulkActions()
    {
        return [
            Action::deleteBulk(),
        ];
    }

    public function table($query = null, $show_actions = true, $show_checkbox = true)
    {
        $fields = $this->fields();
        $row_actions = $this->rowActions();
        $single_actions = $this->singleActions();
        $bulk_actions = $this->bulkActions();

        $table = datatables($query ? $query : $this->tableQuery());
        foreach ($fields as $field) {
            if ($field->table) {
                if ($field->table_view_custom || $field->table_view) {
                    $table->editColumn($field->name, function ($model) use ($field) {
                        $data = array_merge($field->table_view_custom_data, ['model' => $model, 'field' => $field]);
                        return view($field->table_view_custom ? $field->table_view_custom : $field->table_view, $data);
                    });
                }
            }
        }
        if($show_actions && $row_actions) {
            $table->editColumn('table_actions', function($model) {
                return view('valiant::models.actions.row', ['model' => $model]);
            });
        }

//        if ($show_actions && $single_actions) {
//            $table->editColumn('table_actions', function ($model) {
//                return view('valiant::models.actions.single', ['model' => $model]);
//            });
//        }
//
        if ($show_checkbox && $bulk_actions) {
            $table->editColumn('table_checkbox', function ($model) {
                return view('valiant::models.actions.checkbox', ['model' => $model]);
            });
        }

        $columns = [];
        $default_order = null;
        $default_order_index = 0;
        foreach ($fields as $field) {
            if ($field->table) {
                $column = [];
                $column['title'] = $field->label;
                $column['data'] = $field->table_alias ? $field->table_alias : $field->name;
                if (!$field->table_search) $column['searchable'] = false;
                if (!$field->table_sort) $column['orderable'] = false;
                if ($field->table_default_order) $default_order = [$default_order_index, $field->table_default_order];
                if ($field->table_hidden) $column['className'] = 'd-none';
                $columns[] = $column;
                $default_order_index++;
            }
        }
        $html = app('datatables.html')->columns($columns);
        $html->setTableId('table' . preg_replace('/^[^a-z]+|[^\w:.-]+/i', '_', parse_url(request()->url())['path']));
        if ($default_order) $html->orderBy($default_order);
        if ($show_actions && $single_actions) $html->addAction(['title' => '', 'data' => 'table_actions']);
        if ($show_checkbox && $bulk_actions) $html->addCheckbox(['title' => view('valiant::models.actions.checkbox-all')->render(), 'data' => 'table_checkbox']);

        return (object)[
            'json' => $table->toJson(),
            'html' => $html,
        ];
    }

    public function tableQuery()
    {
        return $this->select($this->getTable() . '.*')->with($this->with)->withCount($this->withCount);
    }

    public function fieldInputs($action)
    {
        $field_inputs = [];
        foreach ($this->fields() as $field) if (in_array($action, $field->input_actions)) $field_inputs[$field->name] = $field;
        return $field_inputs;
    }

    public function fieldRules($action)
    {
        $field_rules = [];
        foreach ($this->fields() as $field) if (isset($field->rules_actions[$action])) $field_rules = array_merge($field->rules_actions[$action], $field_rules);
        return $field_rules;
    }
}
