<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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

    // =========================
    // RELATIONS
    // =========================
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

    // =========================
    // CORE: REAL-TIME STATUS
    // =========================
    public function getCalculatedStatusAttribute(): string
    {
        $today = Carbon::today();
        $end = Carbon::parse($this->end_date);
        $expiringLimit = $today->copy()->addDays(30);

        if ($end->lt($today)) {
            return 'expired';
        }

        if ($end->between($today, $expiringLimit)) {
            return 'expiring';
        }

        return 'active';
    }

    public function getIsExpiredAttribute(): bool
    {
        return Carbon::today()->gt($this->end_date);
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        return !$this->is_expired &&
            Carbon::today()->diffInDays($this->end_date) <= 30;
    }

    // =========================
    // SCOPES (FIXED: USE REAL DATE)
    // =========================
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
}