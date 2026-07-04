<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PolicyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Policy type has many policies
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }
}