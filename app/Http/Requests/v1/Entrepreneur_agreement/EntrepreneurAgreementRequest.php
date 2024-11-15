<?php

namespace App\Http\Requests\v1\Entrepreneur_agreement;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class EntrepreneurAgreementRequest extends FormRequest
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
            'entrepreneur_details_id' => 'required|exists:entrepreneur_details,id',
            'agreement_details' => 'nullable|string',
            'agreement_document' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:5120',//5MB
        ];

    }

    public function messages()
    {
        return [
            'agreement_document' => 'File can be Pdf/Doc/Docs',
            'agreement_document.max' => 'FIle size should not exceed than 5MB',
        ];
    }
}
