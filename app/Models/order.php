<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    public function orderItems(){
        return $this->hasMany(orderItems::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_item','prod_id');
    }
    protected $hidden = ['created_at', 'updated_at'];
}
