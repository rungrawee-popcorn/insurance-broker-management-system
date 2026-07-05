<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
    |-------------------------
    | RELATIONS
    |-------------------------
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
    |-------------------------
    | SCOPES (READY FOR FUTURE)
    |-------------------------
    */

    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereDate('end_date', '<', today());
    }

    public function scopeExpiringSoon(Builder $query): Builder
    {
        return $query->whereDate('end_date', '>=', today())
                     ->whereDate('end_date', '<=', today()->copy()->addDays(30));
    }

    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query->where('policy_number', 'like', "%{$search}%")
            ->orWhereHas('customer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->orWhereHas('insuranceCompany', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
    }

    /*
    |-------------------------
    | HELPERS
    |-------------------------
    */

    public function isExpired(): bool
    {
        return today()->greaterThan($this->end_date);
    }

    public function isExpiringSoon(): bool
    {
        return !$this->isExpired()
            && today()->diffInDays($this->end_date) <= 30;
    }
}