<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='products';
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    public function colors()
    {
        return $this->hasMany(Prod_color::class,'prod_id');
    }
    public function units()
    {
        return $this->hasMany(Prod_unit::class,'prod_id');
    }
    public function images()
    {
        return $this->hasMany(Prod_Img::class,'prod_id');
    }

    public function factory()
    {
        return $this->belongsTo(factory::class);
    }
    /**                newwwww               */
    public function Orders(){
        return $this->belongsToMany(Order::class, 'order_item');
    }

    public function orderItems()
    {
        return $this->hasMany(orderItems::class);
    }
}
