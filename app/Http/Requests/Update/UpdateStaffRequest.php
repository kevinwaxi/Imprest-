<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $staffId = $this->route('staff');

        return [
            'staff_number' => ['nullable', 'string', 'max:255', "unique:staff,staff_number,{$staffId}"],
            'name'         => ['sometimes', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'is_active'    => ['boolean'],
        ];
    }
}
