<?php

namespace App\Http\Requests\v1\Applications;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'reason' => 'nullable|string',
            'status' => [
                'required',
                'string',
                'regex:/^(pending|returned|resubmit|rejected|approved)$/i', // Case-insensitive role validation
            ],
        ];

    }

    public function messages()
    {
        return [
            'status' => 'Staus can be Pending/Returned/Resubmit/Rejected/Approved',
        ];
    }
}