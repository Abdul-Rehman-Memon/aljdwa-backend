<?php

namespace App\Http\Requests\v1\Appointments;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentUpdateRequest extends FormRequest
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
        return [
            'link' => 'nullable|url|required_if:status,booked',  // Required if status is 'booked'
            'meeting_password' => 'nullable|string|required_if:status,booked',  // Required if status is 'booked'
            'status' => [
                'required',
                'string',
                'regex:/^(pending|booked|cancelled|completed)$/i', // Case-insensitive status validation
            ],
        ];

    }

    public function messages()
    {
        return [
            'status.regex' => 'Status can be Pending/Booked/Cancelled/Completed',
            'link.required_if' => 'The link field is required when the status is booked.',
            'meeting_password.required_if' => 'The meeting password is required when the status is booked.',
        ];
    }
}
