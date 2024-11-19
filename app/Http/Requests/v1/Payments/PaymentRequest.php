<?php

namespace App\Http\Requests\v1\Payments;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
        // return  [
        //     'payments_details' => 'nullable|string',
        //     'payment_refrence' => 'nullable|string',
        //     'entrepreneur_details_id' => 'required|exists:entrepreneur_details,id',
        //     'invoice_Id' => 'nullable|int',
        //     'amount' => 'required|int',
        //     'currency' => 'required|string',
        //     'token' => 'required|string',
        //     'voucher' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',//5MB
        //     // 'payment_date' => 'required|date',
        //     // 'status' => 'nullable|string|in:paid,unpaid',
        // ];

        return  [
            'payments_details' => 'nullable|string',
            'entrepreneur_details_id' => 'required|exists:entrepreneur_details,id',
            'amount' => 'required|int',
            'currency' => 'required|string',
            'card_type' => 'required|string',
            'payment_id' => 'required|string',
        ];

    }

    // public function messages()
    // {
    //     return [
    //         'status' => 'Staus can be Paid/Unpaid',
    //         'voucher' => 'File can be pdf/jpg/jpeg/png',
    //         'voucher.max' => 'FIle size should not exceed than 5MB',
    //     ];
    // }
}
