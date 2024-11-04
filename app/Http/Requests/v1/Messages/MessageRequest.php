<?php

namespace App\Http\Requests\v1\Messages;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'receiver_id' => 'required|exists:users,id',
            'message_text' => 'required|string',
            'attachment' => 'nullable|file',
            // 'attachment' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',//5MB
        ];

    }

    // public function messages()
    // {
    //     return [
    //         'attachment' => 'File can be Pdf/Doc/Docs',
    //         'attachment.max' => 'FIle size should not exceed than 5MB',
    //     ];
    // }
}
