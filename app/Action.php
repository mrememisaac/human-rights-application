<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = [
        'id',
        'application_id',        
        'status', //Submitted, Viewed, Approved, Rejected, OnHold, Action Required, Scheduled
        'remarks',
        'created_by'
    ];

    public function author(){
        return $this->belongsTo("\App\User", "created_by", "email");
    }
}
