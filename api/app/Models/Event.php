<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasUuids;
    /******************************************
     *                                        *
     *              PROPERTIES                *
     *                                        *
     ******************************************/

    public $table = 'events';

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
