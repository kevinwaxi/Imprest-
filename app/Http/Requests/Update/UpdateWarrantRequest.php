<?php

namespace App\Http\Requests\Update;

use App\Enums\WarrantStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWarrantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $warrantId = $this->route('warrant');

        return [
            'doc_number'           => ['sometimes', 'string', 'max:255', "unique:warrants,doc_number,{$warrantId}"],
            'staff_id'             => ['sometimes', 'exists:staff,id'],
            'account_id'           => ['sometimes', 'exists:accounts,id'],
            'department_id'        => ['nullable', 'exists:departments,id'],
            'project_id'           => ['nullable', 'exists:projects,id'],

            'amount'               => ['sometimes', 'numeric', 'min:0'],
            'purpose'              => ['nullable', 'string'],
            'remarks'              => ['nullable', 'string'],

            'payee_bank'           => ['nullable', 'string', 'max:255'],
            'payee_account_number' => ['nullable', 'string', 'max:255'],
            'paying_bank'          => ['nullable', 'string', 'max:255'],
            'cheque_number'        => ['nullable', 'string', 'max:255'],
            'memo_number'          => ['nullable', 'string', 'max:255'],
            'payment_date'         => ['nullable', 'date'],
            'signed_date'          => ['nullable', 'date'],

            'status'               => ['sometimes', 'in:' . implode(',', array_column(WarrantStatus::cases(), 'value'))],
            'status_remarks'       => ['nullable', 'string'],
        ];

    }
}
