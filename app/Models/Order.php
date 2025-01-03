<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['fooditem_id', 'order_number', 'name', 'email', 'phone', 'status', 'notes'];

    public function fooditem()
    {
        return $this->belongsTo(Fooditem::class);
    }
}
