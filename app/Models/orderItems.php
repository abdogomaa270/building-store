<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderItems extends Model
{
    protected $table='order_item';
    protected $hidden = ['created_at', 'updated_at'];

    public function product(){
        return $this->belongsTo(Product::class,'prod_id');
    }
    public function order(){
        return $this->belongsTo(order::class);
    }
    use HasFactory;
}
