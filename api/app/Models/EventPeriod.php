<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPeriod extends Model
{
    public $table = 'event_periods';
    public $primaryKey = 'id';
    const UPDATED_AT = null;
    public $fillable = [
        'date',
        'opening_time',
        'closing_time'
    ];
}
