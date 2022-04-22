<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'subcategory';
    protected $primaryKey = 'subcategory_id';
    public $timestamps = false;
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
    public function products(){
        return $this->hasMany(Product::class, 'subcategory_id', 'subcategory_id');
    }
}
