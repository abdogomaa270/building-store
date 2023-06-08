<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prod_unit extends Model
{
    protected $table='prod_units';
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
