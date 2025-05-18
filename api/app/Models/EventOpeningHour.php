<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOpeningHour extends Model
{
    public $table = 'event_opening_hours';
    public $primaryKey = 'id';
    const UPDATED_AT = null;
}
