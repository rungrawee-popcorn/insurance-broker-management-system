<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // User belongs to role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // User has many policies
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    // User has many activity logs
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}