<?php

namespace App\Http\Requests\v1\Applications;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
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
            'project_name' => 'nullable|string|max:255',
            'founder_name' => 'nullable|string|max:255',
            // 'email' => 'nullable|email|unique:users',
            'country_code' => 'nullable|integer',
            'phone_number' => 'nullable|string|max:255',
            // 'password' => [
            //     'required',
            //     'string',
            //     'min:8', // Minimum length of 8 characters
            //     'max:16',
            //     'regex:/[A-Z]/', // At least one uppercase letter
            //     'regex:/[a-z]/', // At least one lowercase letter
            //     'regex:/[0-9]/', // At least one number
            //     'regex:/[@$!%*#?&]/', // At least one special character
            // ],
            'linkedin_profile' => 'nullable|string|url',
        ];

           // Access the authenticated user's role
           $userRole = auth()->user()->role;
        // Add rules conditionally based on the role
        if ($userRole === 3) {
            $rules = array_merge($rules, [
               
                'position' => 'nullable|string', 
                'major' => 'nullable|string', 
                'resume' => 'nullable|file|mimes:pdf|max:5120',//5MB
                'website' => 'string|url', // Assuming it's an array
                // 'websites.*' => 'string|url', // Validate each website entry
                'project_description' => 'required|string',
                'problem_solved' => 'required|string',
                'solution_offering' => 'required|string',
                'previous_investment' => 'nullable|numeric', // Allow null or numeric
                'company_registered' => 'required|string', 
                'saudi_vision_alignment' => 'required|string', 
                'positive_impact' => 'required|string',
                'help_needed' => 'required|string',
                'industry_sector' => 'required|string',
                'business_model' => 'nullable|file|mimes:pdf,doc,docx|max:5120',//5MB
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
