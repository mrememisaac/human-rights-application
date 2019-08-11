<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelBase extends Model
{
    protected function creator(){
        return $this->hasMany('\App\User', 'created_by', 'username');
    }

    protected function isCreator(string $username){
        $creator = $this->creator;
        if(!$creator){
            return false;
        }
        $equal = trim(strtolower($creator->username)) == trim(strtolower($username));
        return $equal;
    }
}
