<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends ModelBase
{
    protected $fillable = [
        'id',
        'subject',
        'summary',
        'body',
        'applicant_id',
        'created_by'
    ];

    public function documents(){
        return $this->hasMany('\App\Document', 'application_id', 'id');
    }

    public function actions(){
        return $this->hasMany('\App\Action', 'application_id', 'id');
    }
    
    public function applicant(){
        return $this->belongsTo("\App\Applicant", "applicant_id", "id");
    }

    public function author(){
        return $this->belongsTo("\App\User", "created_by", "email");
    }
}
