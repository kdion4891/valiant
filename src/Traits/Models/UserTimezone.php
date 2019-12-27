<?php

namespace Kdion4891\Valiant\Traits\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait UserTimezone
{
    public function getCreatedAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

    public function getDeletedAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $this->userTimezone($value);
    }

    private function userTimezone($value)
    {
        return ($value && Auth::check()) ? Carbon::parse($value)->tz(Auth::user()->timezone)->toDateTimeString() : $value;
    }
}
