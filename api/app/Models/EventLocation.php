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
    public $fillable = [
        'event_id',
        'addres_id',
        'maps_link'
    ];

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
