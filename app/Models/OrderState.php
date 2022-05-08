<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    use HasFactory;
    protected $table = 'orderstate';
    protected $primaryKey = 'orderstate_id';
    public $timestamps = false;
    public function order(){
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}
