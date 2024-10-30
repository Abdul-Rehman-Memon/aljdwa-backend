<?php

namespace App\Http\Requests\v1\Appointments_schedule;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        // Customize the structure of the validation response
        throw new HttpResponseException(
            response()->json([
                'meta_data' => [
                    'success' => false,
                    'message' => 'Validation errors',
                    'status_code' => 422,
                ],
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Initialize the common rules
        return  [
            'date' => 'nullable|string|min:5',
            'time' => 'required|string|min:5',
            'duration' => 'required|string|min:5',
            'weekday' => 'required|int|in:0,1,2,3,4,5,6',
        ];

    }

    public function messages()
    {
        return [
            'weekday' => 'Weekday can be between 0-6 number',
        ];
    }
}
