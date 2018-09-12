<?php

namespace App\Http\Controllers;

use Session;
use Redirect;
use Input;
use URL;
use Config;

use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;

class PaypalController extends Controller
{
    private $_api_context;

    public function __construct()

    {
        /** setup PayPal api context **/

        $paypal_conf = Config::get('paypal');

        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));

        $this->_api_context->setConfig($paypal_conf['settings']);

    }

    public function payWithPaypal()
    {

        return view('paywithpaypal');

    }

    public function postPaymentWithpaypal(Request $request)

    {

        $payer = new Payer();

        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Item 1') /** item name **/

            ->setCurrency('USD')

            ->setQuantity(1)

            ->setPrice($request->get('amount')); /** unit price **/

        $item_list = new ItemList();

        $item_list->setItems(array($item_1));

        $amount = new Amount();

        $amount->setCurrency('USD')

            ->setTotal($request->get('amount'));

        $transaction = new Transaction();

        $transaction->setAmount($amount)

            ->setItemList($item_list)

            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();

        $redirect_urls->setReturnUrl(URL::route('payment.status')) /** Specify return URL **/

            ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();

        $payment->setIntent('Sale')

            ->setPayer($payer)

            ->setRedirectUrls($redirect_urls)

            ->setTransactions(array($transaction));


        try {

            $payment->create($this->_api_context);

        } catch (PayPal\Exception\PPConnectionException $ex) {

            if (Config::get('app.debug')) {

                Session::put('error','Connection timeout');

                return Redirect::route('payWithPaypal');

                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/

                /** $err_data = json_decode($ex->getData(), true); **/

                /** exit; **/

            } else {

                Session::put('error','Some error occur, sorry for inconvenient');

                return Redirect::route('payWithPaypal');

                /** die('Some error occur, sorry for inconvenient'); **/

            }

        }

        foreach($payment->getLinks() as $link) {

            if($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();

                break;

            }

        }

        /** add payment ID to session **/

        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {

            /** redirect to paypal **/

            return Redirect::away($redirect_url);

        }

        Session::put('error','Unknown error occurred');

        return Redirect::route('payWithPaypal');

    }

    public function getPaymentStatus(Request $request)

    {

        /** Get the payment ID before session clear **/
                // dd(Session::get('paypal_payment_id'));
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/

        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {

            Session::put('error','Payment failed');

            return Redirect::route('payWithPaypal');

        }

        $payment = Payment::get($payment_id, $this->_api_context);

        /** PaymentExecution object includes information necessary **/

        /** to execute a PayPal account payment. **/

        /** The payer_id is added to the request query parameters **/

        /** when the user is redirected from paypal back to your site **/

        $execution = new PaymentExecution();

        $execution->setPayerId($request->input('PayerID'));

        /**Execute the payment **/

        $result = $payment->execute($execution, $this->_api_context);

        /** dd($result);exit; /** DEBUG RESULT, remove it later **/

        if ($result->getState() == 'approved') { 

            

            /** it's all right **/

            /** Here Write your database logic like that insert record or value in database if you want **/

            Session::put('success','Payment success');

            return Redirect::route('payWithPaypal');

        }

        Session::put('error','Payment failed');

        return Redirect::route('payWithPaypal');

    }

}
