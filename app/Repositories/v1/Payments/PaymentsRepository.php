<?php

namespace App\Repositories\v1\Payments;

use App\helpers\appHelpers;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmationForUser;
use App\Mail\PaymentNotificationForAdmin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentsRepository implements PaymentsInterface
{
    
    /*********** For Entrepeneur User ***********/
    public function createPayment(array $data)
    {
        
        $userId = Auth::user()->id;
        $data['entrepreneur_id'] = $userId;
        $data['payment_date'] = Carbon::now()->toDateTimeString();

        $status = 'unpaid';
        /* -- use stripe payment gateway -- */
        $response = $this->stripePaymentgateWay($data);

        if ($response) {    
            $status = $response['success']? 'paid' : 'unpaid';
            $data['payment_reference'] = $response['success']? $response['payment_intent_id'] : null;            
        }

        $data['status'] = appHelpers::lookUpId('Payment_status',$status);

       /* -- voucher file--*/ 
        $file = $data['voucher'] ?? null;
        $fullUrl = null;
        if($file){
            $fileName = 'payment_voucher';
            $directory = "public/entrepreneur/{$userId}/{$fileName}";

            if (!File::exists(storage_path("app/{$directory}"))) {
                File::makeDirectory(storage_path("app/{$directory}"), 0755, true);
            }

            $timestamp = time();
            $filePath = Storage::disk('public')->putFileAs($directory, $file, "{$timestamp}.{$file->getClientOriginalExtension()}");

            $fullUrl = asset("storage/" . str_replace('public/', '', $filePath));
            $data['voucher']  = $fullUrl;
        }

        $payment =  Payment::create($data);

        // Load payment status for returning full data
        $payment = $payment->load('payment_status');

        // Get user and admin emails
        $userEmail = Auth::user()->email;
        $userName = Auth::user()->founder_name;
        $amount = $payment['amount'];

        // Format payment_date to a more readable date-time format
        // $paymentDate = Carbon::parse($payment['payment_date'])->format('d M Y, h:i A');

        // $adminEmail = config('mail.admin_email'); // Ensure this is set in the .env
        // Send email to user
        // Mail::to($userEmail)->send(new PaymentConfirmationForUser($userName, $amount, $paymentDate));
        // Send email to admin
        // Mail::to($adminEmail)->send(new PaymentNotificationForAdmin($userName, $amount, $paymentDate));

        return $payment;
    }

    public function stripePaymentgateWay(array $data)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); // Your Stripe Secret Key

        $paymentIntent = PaymentIntent::create([
            'amount' => $data['amount'] * 100, // Convert to cents
            'currency' => $data['currency'],
            'payment_method' => $data['token'],
            // 'confirmation_method' => 'manual',
            'confirm' => true, // Automatically confirm the payment
            // 'automatic_payment_methods' => [
            //     'enabled' => true,
            //     'allow_redirects' => 'never',
            // ],
            'return_url' => 'https://your-frontend-url.com/payment-success',
        ]);

        if ($paymentIntent->status === 'requires_action') {
            return [
                'requires_action' => true,
                'payment_intent_client_secret' => $paymentIntent->client_secret,
            ];
        } else if ($paymentIntent->status === 'succeeded') {
            // Handle successful payment
            return [
                'success' => true,
                'payment_intent_id' => $paymentIntent->id,
            ];
        }

        return null;
    }

    public function verifyStripePayment(string $paymentIntentId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); // Your Stripe Secret Key

        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

        // Check the status
        if ($paymentIntent->status === 'succeeded') {
            return [
                'success' => true,
                'message' => 'Payment verified successfully.',
                'data' => $paymentIntent,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Payment not completed.',
                'status' => $paymentIntent->status,
            ];
        }
    }

    public function getEntrepreneurPayment()
    {
        $userId = Auth::user()->id;
        $result = Payment::with(
            ['payment_status', ////payment -> lookup_details,
             'payment_entrepreneur_detail' => function ($query) use ($userId){
                $query->where('entrepreneur_details.user_id',$userId); 
                },
            ])
            ->first();

            if($result){
                return  $result;
            }
            return false;      
    }

    /*********** Admin Section - Agreements ***********/
    public function getAllPayments(object $data = null)
    {
        $limit = $data['limit'] ?? 10;
        $offset = $data['offset'] ?? 0;
        $status = $data['status'] ? appHelpers::lookUpId('Payment_status',$data['status']) : 0;

        $totalCount = Payment::has('payment_entrepreneur_detail')->count();

        $result = Payment::with(
            ['payment_status', ////payment -> lookup_details,
             'payment_entrepreneur_detail',
             'payment_entrepreneur_detail.user',
            ])
        ->has('payment_entrepreneur_detail')
        ->limit($limit)
        ->offset($offset);

        if($status){
            $result = $result->where('payments.status',$status);
        }  

        $result = $result->get();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'payments' => $result
        ];        
    }

    public function getPayment(int $paymentId)
    {
        return Payment::with(
            ['payment_status', ////payment -> lookup_details,
             'payment_entrepreneur_detail',
             'payment_entrepreneur_detail.user'
            ])
        ->where('id',$paymentId)
        ->first();         
    }

    public function updatePayment(array $data, int $paymentId)
    {
        
        if(isset($data['payment_date']))
            $data['payment_date'] = date('Y-m-d H:i:s', strtotime($data['payment_date']));

        $payment = Payment::with(
            ['payment_status',
             'payment_entrepreneur_detail',
             'payment_entrepreneur_detail.user'
            ])
            ->find($paymentId);

        $file = $data['voucher'] ?? null;

        $fullUrl = null;

        if($payment && $file){
            $fileName = 'payment_voucher';
            $directory = "public/entrepreneur/{$payment->entrepreneur_id}/{$fileName}";

            if (!File::exists(storage_path("app/{$directory}"))) {
                File::makeDirectory(storage_path("app/{$directory}"), 0755, true);
            }

            $timestamp = time();
            $filePath = Storage::disk('public')->putFileAs($directory, $file, "{$timestamp}.{$file->getClientOriginalExtension()}");

            $fullUrl = asset("storage/" . str_replace('public/', '', $filePath));
            $data['voucher']  = $fullUrl;
        }          
        
        if ($payment && $payment->update($data)) {
            $updatedPayment = $payment->fresh(
                    'payment_status', ////payment -> lookup_details,
                    'payment_entrepreneur_detail',
                    'payment_entrepreneur_detail.user'
                );

            return $updatedPayment;   
        }
  
        return false;        
    }
}
