<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'id',
        'name',
        'address',
        'city',
        'state',
        'created_by'
    ];

    public function applications(){
        return hasMany("\App\Application", "id", "applicant_id");
    }
}
