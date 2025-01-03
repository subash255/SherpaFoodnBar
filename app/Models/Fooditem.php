<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fooditem extends Model
{
    protected $fillable = ['category_id','subcategory_id', 'name', 'slug', 'price', 'image'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
