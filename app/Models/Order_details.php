<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $timestamps = false;
    public function pizza()
    {
        return $this->belongsTo(Pizza::class, 'pizza_id');
    }
}
