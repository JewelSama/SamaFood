<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'display_pic',
        'opening_time',
        'closing_time',
        'description',
        'phone_number',
    ];
    
    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
    
    public function order()
    {
        return $this->hasMany(Order::class);
    }


}
