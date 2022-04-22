<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = 'size';
    protected $primaryKey = 'size_id';
    public $timestamps = false;
    public function color(){
        return $this->belongsTo(Color::class, 'color_id', 'color_id');
    }
}
