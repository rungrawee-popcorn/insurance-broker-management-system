<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\PolicyType;
use App\Models\User;

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

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // A policy belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // A policy is issued by an insurance company
    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    // A policy belongs to a specific policy type (life, health, etc.)
    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }

    // A policy is created by a user (staff/admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the policy is expiring soon (within 30 days)
     */
    public function isExpiringSoon()
    {
        return now()->diffInDays($this->end_date, false) <= 30;
    }

    /**
     * Check if the policy is already expired
     */
    public function isExpired()
    {
        return now()->greaterThan($this->end_date);
    }
}