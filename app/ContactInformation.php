<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInformation extends ModelBase
{
    protected $fillable = [
        'id',
        'type', //Email, Phone Number
        'value',
        'verified',
        'date_verified'
    ];
}
