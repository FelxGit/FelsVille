<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasApiTokens;
    
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function cart() 
    {
        return $this->hasMany(Cart::class);
    }
}