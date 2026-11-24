<?php

namespace App\Http\Requests\Course;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'duration' => ['required', 'integer', 'min:1'],
            'fee' => ['required', 'decimal:0,2', 'min:0'],
            'difficulty' => ['required', Rule::in(['Easy', 'Medium', 'Hard'])],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
