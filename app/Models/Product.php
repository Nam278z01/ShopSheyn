<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public $timestamps = false;
    public function subcategory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'subcategory_id');
    }
    public function colors(){
        return $this->hasMany(Color::class, 'product_id', 'product_id');
    }
}
