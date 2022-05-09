<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'orderdetails';
    protected $primaryKey = 'orderdetail_id';
    public $timestamps = false;
    public function order(){
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
    public function size(){
        return $this->hasOne(Size::class, 'size_id', 'size_id');
    }
}
