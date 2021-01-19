<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'shipping_fee', 'cart_total', 'address' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

}