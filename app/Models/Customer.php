<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'national_id',
        'address',
    ];

    // Customer has many policies
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }
}