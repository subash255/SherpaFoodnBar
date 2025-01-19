<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
   protected $guarded = [];

    public function submeals()
    {
         return $this->hasMany(Submeal::class);
    }
}
