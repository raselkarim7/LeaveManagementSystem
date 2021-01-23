<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /*
    * associations
    */ 
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }
}
