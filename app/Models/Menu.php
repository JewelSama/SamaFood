<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'price',
        'display_pic',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
