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
    protected $fillable = ['order_id', 'orderstate_name'];
    public function order(){
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}
