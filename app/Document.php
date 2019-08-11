<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends ModelBase
{
    protected $fillable = [
        'id',
        'type', //Photo, Document
        'description',
        'content_type',
        'ext',
        'size',
        'path'
    ];
}
