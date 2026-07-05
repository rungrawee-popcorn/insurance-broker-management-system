<?php

namespace App\Http\Requests\Policy;

use Illuminate\Foundation\Http\FormRequest;

class PolicyFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:active,expired,cancelled,pending'],
            'company_id' => ['nullable', 'integer'],
            'policy_type_id' => ['nullable', 'integer'],
            'expiry' => ['nullable', 'string', 'in:7,30,60'],
        ];
    }

    public function filters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->status,
            'company_id' => $this->company_id,
            'policy_type_id' => $this->policy_type_id,
            'expiry' => $this->expiry,
        ];
    }
}