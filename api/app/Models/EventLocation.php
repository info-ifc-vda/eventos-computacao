<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
    /******************************************
    *                                         *
    *              PROPERTIES                 *
    *                                         *
    ******************************************/

    public $table = 'event_location';
    public $timestamps = false;

    /******************************************
    *                                         *
    *              ATTRIBUTES                 *
    *                                         *
    ******************************************/

    /******************************************
    *                                         *
    *               RELATIONS                 *
    *                                         *
    ******************************************/

    public function address()
    {
        return $this->belongsTo(Address::class, 'id', 'address_id');
    }

    /******************************************
    *                                         *
    *                 SCOPES                  *
    *                                         *
    ******************************************/

    /******************************************
    *                                         *
    *                METHODS                  *
    *                                         *
    ******************************************/
}
