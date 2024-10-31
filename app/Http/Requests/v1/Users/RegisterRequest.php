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
        $rules = [
            'founder_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'country_code' => 'required|integer',
            'phone_number' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'max:16',
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[@$!%*#?&]/', // At least one special character
            ],
            // 'password' => 'required|min:8|',
           
            'role' => [
                'required',
                'string',
                'regex:/^(admin|mentor|entrepreneur|investor)$/i', // Case-insensitive role validation
            ],
        ];

        // Add rules conditionally based on the role
        if ($this->input('role') === 'mentor') {
            $rules = array_merge($rules, [
               
                'linkedin_profile' => 'required|string|url',
                'project_name' => 'required|string|max:255',
            ]);
        }
        elseif ($this->input('role') === 'entrepreneur') {
            $rules = array_merge($rules, [
                'linkedin_profile' => 'required|string|url',
                'project_name' => 'required|string|max:255',
                'position' => 'required|string', 
                'major' => 'required|string', 
                'resume' => 'required|file|mimes:pdf|max:5120',//5MB
                'website' => 'string|url', // Assuming it's an array
                // 'websites.*' => 'string|url', // Validate each website entry
                'project_description' => 'required|string',
                'problem_solved' => 'required|string',
                'solution_offering' => 'required|string',
                'previous_investment' => 'nullable|numeric', // Allow null or numeric
                'industry_sector' => 'required|string',
                'business_model' => 'required|file|mimes:pdf,doc,docx|max:5120',//5MB
                'patent' => 'nullable|file|mimes:pdf,doc,docx|max:5120',//5MB
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.min' => 'Password must be at least 8 characters long.',
            'role.regex' => 'Role can be Mentor/Entrepreneur/Investor',
            'business_model' => 'File can be Pdf/Doc/Docs',
            'business_model.max' => 'FIle size should not exceed than 5MB',
            'patent' => 'File can be Pdf/Doc/Docs',
            'patent.max' => 'FIle size should not exceed than 5MB',
        ];
    }
}
