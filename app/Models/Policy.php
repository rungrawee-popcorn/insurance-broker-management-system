<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    // Policy belongs to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Policy belongs to insurance company
    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    // Policy belongs to policy type
    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }

    // Policy belongs to user (creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}