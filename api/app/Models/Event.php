<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $table = 'events';
    public $primaryKey = 'uuid';

    /******************************************
     *                                        *
     *              ATTRIBUTES                *
     *                                        *
     ******************************************/
    protected function cancelled(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->cancellation_date ? true : false
        );
    }

    /******************************************
     *                                        *
     *               RELATIONS                *
     *                                        *
     ******************************************/
    public function event_periods()
    {
        return $this->hasMany('event_periods', 'event_id', 'id');
    }

    /******************************************
     *                                        *
     *                 SCOPES                 *
     *                                        *
     ******************************************/



    /******************************************
     *                                        *
     *                METHODS                 *
     *                                        *
     ******************************************/
}
