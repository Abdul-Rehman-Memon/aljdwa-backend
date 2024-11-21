<?php

namespace App\Repositories\v1\Payments;

use App\helpers\appHelpers;
use App\Models\Payment;
use App\Models\User;
use App\Models\EntrepreneurDetail;
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
    
    public function createCheckout(array $data)
    {
        $userId = Auth::user()->id;
        $data['payment_date'] = Carbon::now()->toDateTimeString();

        // return $data;
        $response = appHelpers::hyperPayCreateCheckout($data);
        if ($response['result']['code'] == '000.200.100') {    
            $data['payment_reference'] = $response['id'] ?? null;            
        }
        $payment = Payment::where('entrepreneur_details_id',$data['entrepreneur_details_id'])
        ->first();
        if ($payment) {
            $payment->update($data);
        }

        return $response;
    }

    public function createPaymentInvoice(array $data)
    {
        $entrepreneur_details_id = $data['entrepreneur_details_id'];
        $user = User::with([
            'entreprenuer_details',
        ])
        ->whereHas('entreprenuer_details', function ($query) use ($entrepreneur_details_id) {
            $query->where('id', $entrepreneur_details_id);
        })->first();

        $entrepreneur_id =  $user['id'];
        $data['entrepreneur_id'] = $entrepreneur_id;

        $status = 'pending';
        $data['status'] = appHelpers::lookUpId('Payment_status',$status);
        
        $data['total_amount'] = $data['tax'] ? ($data['amount'] + $data['tax']) : $data['amount'];
        $payment =  Payment::create($data);
        // Load payment status for returning full data
        $payment = $payment->load('payment_status');

        return $payment;
    }

    public function getPaymentInvoice()
    {
        $userId = Auth::user()->id;
        return  Payment::with('payment_status')
            ->where('payments.entrepreneur_id',$userId)->first();
    }
    
    public function createPayment(array $data)
    {
        
        $userId = Auth::user()->id;
        $data['entrepreneur_id'] = $userId;
        $data['payment_date'] = Carbon::now()->toDateTimeString();

        $status = 'unpaid';

        $response = appHelpers::verifyHyperPay($data);
        if ($response['result']['code'] == '000.200.100') {    
            $status = 'paid';          
        }
        $data['status'] = appHelpers::lookUpId('Payment_status',$status);
        $payment = Payment::where('entrepreneur_details_id',$data['entrepreneur_details_id'])
        ->first();
        if ($payment) {
            $payment->update($data);
        }

        // Load payment status for returning full data
        $payment = $payment->load('payment_status');

        $payment['hyperpay'] = $response;

        // Get user and admin emails
        // $userEmail = Auth::user()->email;
        // $userName = Auth::user()->founder_name;
        // $amount = $payment['amount'];

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
  
        $limit    = $data->input('limit', 10);
        $offset   = $data->input('offset', 0);
        $status   = $data->input('status')   ? appHelpers::lookUpId('Payment_status',$data->input('status'))   : NULL;
        $fromDate = $data->input('fromDate') ? Carbon::createFromTimestamp($data->input('fromDate'))->startOfDay() : NULL;
        $toDate   = $data->input('toDate')   ? Carbon::createFromTimestamp($data->input('toDate'))->endOfDay()     : NULL;
        $userId   = $data->input('user_id') ?? null;

        $query = Payment::with(
            ['payment_status', ////payment -> lookup_details,
             'payment_entrepreneur_detail',
             'payment_entrepreneur_detail.user',
            ])
        ->has('payment_entrepreneur_detail');

        if ($status) {
            $query->where('payments.status',$status);
        }
        if ($fromDate || $toDate) {

            if ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->where('created_at', '<=', $toDate);
            }
        }

        if ($userId) {
            $query->where('payments.entrepreneur_id',$userId);
        }

        $result = $query->orderBy('created_at','desc')
        ->limit($limit)
        ->offset($offset)
        ->get();

        $totalCount = $query->count();

        return [
            'totalCount' => $totalCount,
            'limit' => $limit,
            'offset' => $offset,
            'result' => $result
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

        if ($payment && isset($data['voucher'])) {
            $fileInfo['user_id'] = $payment->entrepreneur_id; 
            $fileInfo['file'] = $data['voucher']; 
            $fileInfo['fileName'] = 'voucher'; 
            $filePath = appHelpers::uploadFile($fileInfo);
            $data['voucher'] = $filePath;
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
