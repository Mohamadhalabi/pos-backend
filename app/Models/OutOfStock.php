<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutOfStock extends Model
{
    use HasFactory;
    protected $table = 'out_of_stocks';
    protected $fillable = ['product_id','email'];
}
