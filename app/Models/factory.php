<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factory extends Model
{
  protected $table='factories';

  public function products(){

    return $this->hasMany(Product::class);
}
    protected $hidden = ['created_at', 'updated_at'];
    use HasFactory;
}
