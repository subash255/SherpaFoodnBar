<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    public function fooditems()
    {
        return $this->hasMany(Fooditem::class);
    }
}
