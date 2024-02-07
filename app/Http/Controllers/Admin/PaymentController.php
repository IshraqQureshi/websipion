<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PaymentDetails;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Library\Paypal;
use App\Models\User;
use Razorpay\Api\Api;


class PaymentController extends Controller
{
    public function invoiceNumber()
    {
        $InvoiceNumber = PaymentDetails::get();
        return date('dmY') . '-00' . count($InvoiceNumber) + 1;
    }

    public function PaymentSaveRazorpay(Request $request)
    {

        if ($request->type == 'subscription') {
            $Settings = Settings::first()->toArray();
            $api = new Api($Settings['key_id'], $Settings['key_secret']);

            $packages = Package::find($request->packageID);
            $pricePackages = $packages->price * $request->websiteTotal;

            $price =  ($pricePackages * 100);

            $obj =  $api->plan->create(
                array(
                    'period' => $request->paymentType,
                    'interval' => 1,
                    'item' => array(
                        'name' => $request->packageName,
                        'description' => '' . $request->packageID .  ',' . $request->websiteTotal .  ', ' . $request->packageName .  ',' . $request->paymentType .  ' 1 plan, ' . $pricePackages .  '',
                        'amount' => $price,
                        'currency' => 'INR'
                    )
                )
            );


            $planArray = $obj->toArray();

            $subscriptionObje =  $api->subscription->create(
                array(
                    'plan_id' => $planArray['id'],
                    'total_count' => 12,
                    'quantity' => 1,
                    // 'start_at' => strtotime($day),
                    'expire_by' => 2532470340,
                    'customer_notify' => 1,
                    'addons' => array(
                        array(
                            'item' => array(
                                // 'name' => 'subscription charges',
                                // 'amount' => $price,
                                // 'currency' => 'USD'
                            )
                        )
                    ),
                    'notes' => array('notes_key_1' => $planArray['item']['description']),
                )
            );

            $subscriptionArray = $subscriptionObje->toArray();
            return response()->json(['url' => route('PaymentSaveRazorpay'), 'Razorpay_key' => $Settings['key_id'], 'subscription_id' => $subscriptionArray['id'], 'description' => $subscriptionArray['notes']['notes_key_1']]);
        } else {

            $subscription_id = '';
            if (!empty($request->subscription_id)) {
                $subscription_id = $request->subscription_id;
            }

            $this->paymentSave(Auth::user()->id, $request->packageID, $request->websiteTotal, $request->payment_id, $subscription_id, 'Razorpay', $request->totalPrice);
            return response()->json(['status' => 200, 'msg' => 'payment successfully completed', 'url' => route('TransactionHistory')]);
        }
    }


    public function PaymentStripe(Request $request)
    {
        if ($request->type == 'subscription') {
            $Settings = Settings::latest()->first()->toArray();
            $stripe = new \Stripe\StripeClient($Settings['stripe_client_secret']);
            $packages = Package::find($request->packageID);
            $price = $packages->price * $request->websiteTotal;
            $price =  $price * 100;
            $stripe_metadata    = array(
                // 'address'       => 'india',
                'product_id'    => $request->packageID,
                'variation_id'  => '',
                'product_name'  => $request->packageName,
                'first_price'   =>  $price,
                'after_price'   =>  $price,
                'currency'      => 'USD',
                'email'         => $request->email,
            );

            $plan = $stripe->plans->create([
                'amount' => $price,
                'currency' => 'USD',
                'interval' => ('day'),
                'product' => [
                    'name' =>  $request->packageName,
                    'metadata' => $stripe_metadata,
                ],
            ]);

            if (@$plan) {
                $name                   = explode('@', $request->email);
                $subscription_fields    = [
                    'customer'          => $stripe->customers->create(['email' => $request->email, 'name' => @$name[0]])->id,
                    'items'             => [['price' => $plan->id],],
                    'payment_behavior'  => 'default_incomplete',
                    'expand'            => ['latest_invoice.payment_intent'],
                    'metadata'          => $stripe_metadata
                ];
                $subscriptions      = $stripe->subscriptions->create([$subscription_fields]);
                if (@$subscriptions->latest_invoice->hosted_invoice_url) {
                    return response()->json(['status' => 200, 'url' => $subscriptions->latest_invoice->hosted_invoice_url]);
                }
            }

        } else {
            $packages = Package::find($request->packageID);
            $price = $packages->price * $request->websiteTotal;
            $Settings = Settings::latest()->first()->toArray();
            $stripe = new \Stripe\StripeClient($Settings['stripe_client_secret']);
            $stripe_metadata    = array(
                'address'       => '',
                'product_id'    => $packages->id,
                'sale_price'    => $price,
                'email'         => Auth::user()->email,
                'currency' => 'USD',
            );

            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'USD',
                        'product_data' => [
                            'name' => Auth::user()->name,
                        ],
                        'unit_amount' => $price * 100,
                    ],
                    'quantity' => 1,
                ]],
                "metadata"    => $stripe_metadata,
                'mode'        => 'payment',
                'customer_email' => Auth::user()->email,
                'success_url' => route('stripeSuccess') . '?session_id={CHECKOUT_SESSION_ID}&UserID=' . Auth::user()->id . '&packageID=' . $request->packageID . '&price=' . $price . '&websiteTotal=' . $request->websiteTotal,
                'cancel_url'  => route('PackageList'),
                'billing_address_collection' => 'auto',
            ]);
            return response()->json(['status' => 200, 'url' => $checkout_session->url]);
        }
    }

    public function stripeSuccess(Request $request)
    {
        $this->paymentSave($request->UserID, $request->packageID, $request->websiteTotal, $request->session_id, '', 'Stripe', $request->price);

        Session::flash('success', 'Payment has been successfully!');
        return redirect(route('TransactionHistory'));
    }


    public function PaymentPaypal(Request $request)
    {
        $checkout = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => uniqid() . rand(100, 999),
                    "amount" => [
                        "currency_code" => 'USD',
                        "value" => $request->price,
                    ]
                ]
            ],
            "transaction_object " => 'payment on credit point',
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "payment_method_selected" => "PAYPAL",
                        "brand_name" => env('APP_NAME'),
                        "locale" => "en-US",
                        "landing_page" => "LOGIN",
                        'auto_bill_outstanding' => true,
                        "user_action" => "PAY_NOW",
                        'return_url' => route('successPaypal') . '?&UserID=' . Auth::user()->id . '&websiteTotal=' . $request->websiteTotal . '&price=' . $request->price . '&packageID=' . $request->packageID,
                        "cancel_url" => route('PackageList'),
                    ]
                ]
            ]
        ];


        $listener = new Paypal();
        $result = $listener->Paypal_Create_Order($checkout);

        if (@$result->error_description) {
            return response()->json(['status' => 201, 'msg' => 'Server Error']);
        }
        if (@$result->links) {
            foreach ($result->links as $key => $value) {
                if ($value->rel == 'payer-action') {
                    return response()->json(['status' => 200, 'url' => $value->href]);
                }
            }
        }
    }

    public function successPaypal(Request $request)
    {
        $Settings = Settings::latest()->first()->toArray();
        $listener = new Paypal();

        if ( isset($request->subscription_id) && $request->subscription_id ) {
            $transactions = $listener->Paypal_Subscription_Transactions( $request->subscription_id );

            if ( @$transactions->transactions[0]->id ) {
                $pay_id = $transactions->transactions[0]->id;
                $result_details     = $listener->Paypal_Get_Payment_Details($pay_id);
                $price              = $result_details->amount->value;
                $currency           = $result_details->amount->currency_code;

                if( $result_details->id && $result_details->status=='COMPLETED' ){
                    $paymentSave = $this->paymentSave(
                        $request->UserID,
                        $request->packageID,
                        $request->websiteTotal,
                        $pay_id,
                        $request->subscription_id,
                        'Paypal',
                        $request->price*$request->websiteTotal
                    );

                    if( $paymentSave ){
                        return redirect()->route('TransactionHistory')->with('success', 'Subscription created successfully!');
                    }
                }
            }

        }else{
            $result = $listener->Paypal_Capture_Order_Payment(@$_GET['token']);
            if (@$result['payment']->id) {
                $pay_id = $result['payment']->id;

                $this->paymentSave($request->UserID, $request->packageID, $request->websiteTotal, $pay_id, '', 'Paypal', $request->price);

                return redirect()->route('TransactionHistory')->with('success', 'Payment has been successfully!');
            }
        }

    }

    public function paypalWebhook(){
        $request    = json_decode(  file_get_contents( 'php://input' ) ,true );
        $event      = isset($request['event_type']) ?: array();
        $resource   = isset($request['resource']) ?: $request['resource'];
        switch ($event) {
            case 'PAYMENT.SALE.COMPLETED':
                if ( isset($resource['billing_agreement_id']) && $resource['billing_agreement_id'] ) {
                    $subscription_id    = $resource['billing_agreement_id'];
                    $payment_id         = $resource['id'];

                    $order = PaymentDetails::firstWhere('active', 1);
                    if (!@$order) { die(); }

                    $paymentSave = $this->paymentSave(
                        $order->userID,
                        $order->packagesID,
                        $order->totalWebsite,
                        $payment_id,
                        $subscription_id,
                        'Paypal',
                        $resource['amount']['total']
                    );
                }
                break;

            case 'BILLING.SUBSCRIPTION.PAYMENT.FAILED':
                $subscription_id         = $resource['id'];
                break;

            case 'BILLING.SUBSCRIPTION.CANCELLED':
                $subscription_id         = $resource['id'];
                break;

            case 'BILLING.SUBSCRIPTION.SUSPENDED':
                $subscription_id         = $resource['id'];
                break;

            case 'BILLING.SUBSCRIPTION.EXPIRED':
                $subscription_id         = $resource['id'];
                break;

            case 'BILLING.SUBSCRIPTION.RE-ACTIVATED':
                $subscription_id         = $resource['id'];
                break;

            default:
                // code...
                break;
        }
    }


    public  function razorpayWebhook(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        // file_put_contents("./webhook_data2.json", json_encode($data, JSON_PRETTY_PRINT));

        if (!empty($data['event'])) {

            if ($data['event'] == 'subscription.charged') {
                $user = User::where('email', '=', $data['payload']['payment']['entity']['email'])->first();

                if (!empty($user->email)) {
                    $str = str_replace('"', '', $data['payload']['subscription']['entity']['notes']['notes_key_1']);
                    $ar = explode(',', $str);
                    if (!empty($ar)) {
                        $this->paymentSave($user->id, $ar[0], $ar[1], $ar[3], '', '', $ar[6]);
                    }
                }
            }
        }
    }

    public function paymentSave($userID, $packagesID, $totalWebsite, $transactionID, $subscriptionID, $paymentMode, $totalPayment)
    {

        $packages = Package::find($packagesID);

        if ($packages->paymentType == 'Fixed') {
            $day =  '2000 year';
        } else if ($packages->paymentType == 'monthly') {
            $day = '30 day';
        } else if ($packages->paymentType == 'yearly') {

            $day = '365 day';
        }

        PaymentDetails::create([
            'userID' => $userID,
            'packagesID' => $packagesID,
            'totalWebsite' => $totalWebsite,
            'invoiceNumber' => $this->invoiceNumber(),
            'transactionID' => $transactionID,
            'subscriptionID' => $subscriptionID,
            'paymentMode' => $paymentMode,
            'totalPayment' => $totalPayment,
            'transactionTime' => strtotime(date('Y-m-d H:i:s')),
            'expiryDate' => date('d-m-Y h:i:s', strtotime($day)),
        ]);
    }
}
