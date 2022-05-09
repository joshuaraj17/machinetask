<?php
namespace App\Helpers;

use App\CustomerCard;
use Exception;
use Stripe;

class Payment
{

    /**
     * Create Card details.
     *
     * @return \Illuminate\Http\Response
     */
    public static function createCardDetails($input = array())
    {
        $error = '';
        $data = [];
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $card = [
                'number' => isset($input['number']) ? $input['number'] : '',
                'exp_month' => isset($input['exp_month']) ? $input['exp_month'] : '',
                'exp_year' => isset($input['exp_year']) ? $input['exp_year'] : '',
                'cvc' => isset($input['cvc']) ? $input['cvc'] : '',
            ];

            $response = $stripe->tokens->create([
                'card' => $card,
            ]);
            // print_r($card);exit;
            $data['card_token'] = $response->card->id;
        } catch (\Stripe\Exception\CardException $e) {
            $error = 'Message is:' . $e->getError()->message;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $error = 'Too many requests made to the API too quickly';
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $error = "Invalid parameters were supplied to Stripe's API";
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $error = "Authentication with Stripe's API failed (maybe you changed API keys recently)";
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $error = "Network communication with Stripe failed";
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $error = "Display a very generic error to the user, and maybe send";
            // yourself an email
        } catch (Exception $e) {
            $error = "Something else happened, completely unrelated to Stripe";
        }
        if ($error == '') {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = \Stripe\Customer::create(array(
                "source" => $response->id,
                "description" => $input['customer_email'] . '_' . $input['last_four_digits'],
            ));
            $data['customer_token'] = $customer->id;
            $cardDetails = $stripe->customers->retrieveSource($data['customer_token'], $data['card_token']);
            $data['card_brand'] = $cardDetails->brand;
            $data['valid_till_year'] = $cardDetails->exp_year;
            $data['valid_till_month'] = $cardDetails->exp_month;
            $data['card_last_four_number'] = $cardDetails->last4;
        }
        $data['error'] = $error;
        return $data;
    }
    /**
     * Payment details.
     *
     * @return \Illuminate\Http\Response
     */
    public static function makePayment($input = array())
    {
        $data['error'] = 'Invalid Card details';
        $data['status'] = 400;
        $customerCarId = isset($input['card_id']) ? $input['card_id'] : 0;
        $txt_amount = isset($input['amount']) ? $input['amount'] : 0;
        $transfer_group = isset($input['transfer_group']) ? $input['transfer_group'] : 0;
        $restaurant_amount = isset($input['restaurant_amount']) && $input['restaurant_amount'] != '' ? $input['restaurant_amount'] : 0;
        $restaurant_account_id = isset($input['restaurant_account_id']) && $input['restaurant_account_id'] != '' ? $input['restaurant_account_id'] : 0;
        if ($customerCarId == 0) {
            return $data;
        }
        $CustomerCard = CustomerCard::select('customer_token')->where('id', $customerCarId)->get()->toArray();
        if (count($CustomerCard) == 0) {
            return $data;
        }
        $customer = isset($CustomerCard[0]['customer_token']) ? $CustomerCard[0]['customer_token'] : '';

        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $inputdata = array(
                "amount" => $txt_amount * 100,
                "currency" => "usd",
                "customer" => $customer,
                "description" => $input['description'],
            );
            if ($transfer_group != 0) {
                $inputdata['transfer_group'] = $input['transfer_group'];
            }
            if ($restaurant_amount != 0 && $restaurant_account_id != 0) {
                $inputdata['transfer_data'] = [
                    'amount' => $input['restaurant_amount'] * 100,
                    'destination' => $input['restaurant_account_id'],
                ];
            }
            $response = Stripe\Charge::create($inputdata);
            if ($response->status == 'succeeded') {
                $data['status'] = 200;
                $data['error'] = '';
                $data['message'] = $response->seller_message;
                $data['txt_id'] = $response->id;
                $data['amount'] = $response->amount;
                $data['application_fee'] = $response->application_fee;
            }
            $data['response_stripe'] = $response;
        } catch (\Stripe\Exception\CardException $e) {
            $error = 'Message is:' . $e->getError()->message;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $error = 'Too many requests made to the API too quickly';
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $error = "Invalid parameters were supplied to Stripe's API";
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $error = "Authentication with Stripe's API failed (maybe you changed API keys recently)";
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $error = "Network communication with Stripe failed";
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $error = "Display a very generic error to the user, and maybe send";
            // yourself an email
        } catch (Exception $e) {
            $error = "Something else happened, completely unrelated to Stripe";
        }

        return $data;
    }
    public static function makeAccountPayment($input = array())
    {
        $data['error'] = 'Invalid Card details';
        $data['status'] = 400;
        $customerCarId = isset($input['card_id']) ? $input['card_id'] : 0;
        $txt_amount = isset($input['amount']) ? $input['amount'] : 0;
        if ($customerCarId == 0) {
            return $data;
        }
        $CustomerCard = CustomerCard::select('customer_token')->where('id', $customerCarId)->get()->toArray();
        if (count($CustomerCard) == 0) {
            return $data;
        }
        $customer = isset($CustomerCard[0]['customer_token']) ? $CustomerCard[0]['customer_token'] : '';

        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $response = Stripe\Charge::create(array(
                "amount" => $txt_amount * 100,
                "currency" => "usd",
                "customer" => $customer,
                "description" => $input['description'],
            ));
            if ($response->status == 'succeeded') {
                $data['status'] = 200;
                $data['error'] = '';
                $data['message'] = $response->seller_message;
                $data['txt_id'] = $response->id;
                $data['amount'] = $response->amount;
                $data['application_fee'] = $response->application_fee;
            }
            $data['response_stripe'] = $response;
        } catch (\Stripe\Exception\CardException $e) {
            $error = 'Message is:' . $e->getError()->message;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $error = 'Too many requests made to the API too quickly';
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $error = "Invalid parameters were supplied to Stripe's API";
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $error = "Authentication with Stripe's API failed (maybe you changed API keys recently)";
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $error = "Network communication with Stripe failed";
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $error = "Display a very generic error to the user, and maybe send";
            // yourself an email
        } catch (Exception $e) {
            $error = "Something else happened, completely unrelated to Stripe";
        }

        return $data;
    }

}