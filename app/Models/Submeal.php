<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submeal extends Model
{
    protected $guarded = [];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

}
