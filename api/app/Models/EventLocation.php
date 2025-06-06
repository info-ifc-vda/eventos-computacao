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
    public $primaryKey = 'id';

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
        return $this->belongsTo(Address::class, 'address_id', 'id');
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
