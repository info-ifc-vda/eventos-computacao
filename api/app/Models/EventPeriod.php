<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOpeningHour extends Model
{
    public $table = 'event_periods';
    public $primaryKey = 'id';
    const UPDATED_AT = null;
}
