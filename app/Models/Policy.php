<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_number',
        'customer_id',
        'insurance_company_id',
        'policy_type_id',
        'user_id',
        'start_date',
        'end_date',
        'premium',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'premium'    => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereDate('end_date', '<', today());
    }

    public function scopeExpiringSoon(Builder $query): Builder
    {
        return $query
            ->whereDate('end_date', '>=', today())
            ->whereDate('end_date', '<=', today()->copy()->addDays(30));
    }

    /*
    |--------------------------------------------------------------------------
    | Business Helpers
    |--------------------------------------------------------------------------
    */

    public function isExpired(): bool
    {
        return $this->end_date < today();
    }

    public function isExpiringSoon(): bool
    {
        return $this->end_date >= today()
            && $this->end_date <= today()->copy()->addDays(30);
    }
}