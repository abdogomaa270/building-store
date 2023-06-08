<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prod_color extends Model
{
    protected $table='prod_colors';
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected $hidden = ['created_at', 'updated_at'];
}
