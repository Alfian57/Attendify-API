<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
            'nisn' => ['required', 'size:10', Rule::unique('students')->ignore($this->student->id)],
            'name' => ['required', 'max:100'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['required'],
            'profile_picture' => ['image', 'max:10000'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
        ];
    }
}
