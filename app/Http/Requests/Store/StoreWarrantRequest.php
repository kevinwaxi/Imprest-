<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarrantRequest extends FormRequest
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
        return [
            'warrants'                => ['required', 'array', 'max:10'],
            'warrants.*.doc_number'   => ['required', 'string', 'max:255'],
            'warrants.*.staff_id'     => ['required', 'exists:staff,id'],
            'warrants.*.account_id'   => ['nullable', 'exists:accounts,id'],
            'warrants.*.project_id'   => ['nullable', 'exists:projects,id'],
            'warrants.*.amount'       => ['required', 'numeric', 'min:0'],
            'warrants.*.purpose'      => ['nullable', 'string'],
            'warrants.*.remarks'      => ['nullable', 'string'],
            'warrants.*.payment_date' => ['nullable', 'date'],
            'warrants.*.signed_date'  => ['nullable', 'date'],
            'warrants.*.prepared_by'  => ['nullable', 'exists:users,id'],
        ];
    }
}
