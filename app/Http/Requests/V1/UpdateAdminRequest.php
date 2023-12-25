<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('admins')->ignore($this->admin->id)],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['required'],
            'profile_picture' => ['image', 'size:10000'],
        ];
    }
}
