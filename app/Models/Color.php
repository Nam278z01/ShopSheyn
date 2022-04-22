<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $table = 'color';
    protected $primaryKey = 'color_id';
    public $timestamps = false;
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    public function sizes(){
        return $this->hasMany(Size::class, 'color_id', 'color_id');
    }
}
