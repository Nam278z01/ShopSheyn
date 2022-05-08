<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = 'orderdetails';
    protected $primaryKey = 'orderdetails_id';
    public $timestamps = false;
    public function order(){
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}
