<?php

namespace App\Http\Requests\v1\Payments;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'payments_details' => 'nullable|string',
            'payment_refrence' => 'nullable|int',
            'invoice_Id' => 'nullable|int',
            'amount' => 'nullable|int',
            'voucher' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',//5MB
            'payment_date' => 'nullable|date',
            'status' => 'required|string|in:paid,unpaid',
        ];

    }

    public function messages()
    {
        return [
            'status' => 'Staus can be Paid/Unpaid',
            'voucher' => 'File can be pdf/jpg/jpeg/png',
            'voucher.max' => 'FIle size should not exceed than 5MB',
        ];
    }
}