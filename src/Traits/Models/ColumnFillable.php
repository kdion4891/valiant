<?php

namespace Kdion4891\Valiant\Traits\Models;

use Illuminate\Support\Facades\Schema;

trait ColumnFillable
{
    public function getFillable()
    {
        return Schema::getColumnListing($this->getTable());
    }
}
