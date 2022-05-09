<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    public function orderdetails(){
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }
    public function orderstates(){
        return $this->hasMany(OrderState::class, 'order_id', 'order_id');
    }
}
