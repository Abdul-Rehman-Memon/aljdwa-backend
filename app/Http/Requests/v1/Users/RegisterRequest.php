<?php

namespace App\Http\Requests\v1\Users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                    'errors' => $validator->errors(),
                ],
                'data' => null
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
        $rules = [
            'project' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'country_code' => 'required|integer',
            'phone_number' => 'required|string|max:255',
            // 'password' => [
            //     'required',
            //     'string',
            //     'min:8', // Minimum length of 8 characters
            //     'max:255',
            //     'regex:/[A-Z]/', // At least one uppercase letter
            //     'regex:/[a-z]/', // At least one lowercase letter
            //     'regex:/[0-9]/', // At least one number
            //     'regex:/[@$!%*#?&]/', // At least one special character
            // ],
            'password' => 'required|min:8|',
            'role' => 'required|integer|in:1,2,3,4', // Allow roles 2 and 3
        ];

        // Add rules conditionally based on the role
        if ($this->input('role') == 3) {
            $rules = array_merge($rules, [
                'website' => 'string|url', // Assuming it's an array
                // 'websites.*' => 'string|url', // Validate each website entry
                'project_description' => 'required|string',
                'problem_solved' => 'required|string',
                'solution_offering' => 'required|string',
                'previous_investment' => 'nullable|numeric', // Allow null or numeric
                'industry_sector' => 'required|string',
                'business_model' => 'required|string',
                'patent' => 'nullable|string', // Allow null or string
            ]);
        }

        return $rules;
    }

    // public function messages()
    // {
    //     return [
    //         'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
    //         'password.min' => 'Password must be at least 8 characters long.',
    //     ];
    // }
}
