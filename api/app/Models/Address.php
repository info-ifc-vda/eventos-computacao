<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasUuids, SoftDeletes;


    /******************************************
    *                                         *
    *              PROPERTIES                 *
    *                                         *
    ******************************************/

    public $table = 'addresses';
    public $primaryKey = 'uuid';

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
