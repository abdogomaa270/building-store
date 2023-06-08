<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $table='subsubcategories';
    protected $hidden = ['created_at', 'updated_at'];
    use HasFactory;
}
