<?php

namespace Modules\PaypalSubscribe\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class App
{
    public function validate($user)
    {
        // Set up the PayPal API credentials and endpoint
        $clientId = config('paypal-subscribe.client_id');
        $clientSecret = config('paypal-subscribe.secret');
        $mode = config('paypal-subscribe.mode') === 'sandbox' ? 'sandbox.' : '';
        $baseUrl = 'https://api.' . $mode . 'paypal.com';

        Log::info('PayPal Subscribe: Validating user subscription');
        Log::info('PayPal Subscribe: User ID: ' . $user->id);
       

        // Get a new OAuth token from PayPal
        $authResponse = Http::withBasicAuth($clientId, $clientSecret)
                            ->asForm()
                            ->post($baseUrl . '/v1/oauth2/token', [
                                'grant_type' => 'client_credentials'
                            ]);

        $token = $authResponse['access_token'];

        // Check the subscription ID from the user model
        $createdAgreement = $user->paypal_subscription_id;

        if ($createdAgreement != null) {
            // Make the HTTP GET request to fetch subscription details
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($baseUrl . '/v1/billing/subscriptions/' . $createdAgreement);

            if ($response->status() !== 200) {
                return new JsonResponse(['results' => []], $response->status());
            }

            Log::info('PayPal Subscribe: Subscription details fetched successfully');
            Log::info($response->json());

            $responseBody = $response->json();
            $status = $responseBody['status'];
            $links = $responseBody['links'];

            if ($status == 'CANCELLED') {
                $user->update_url = "";
                $user->cancel_url = "";
                $user->plan_id = null;
                $user->paypal_subscription_id = "";
                $user->update();
            } elseif ($status != 'INACTIVE') {
                $user->update_url = $links[1]['href'];
                $user->cancel_url = $links[0]['href'];
                $user->update();
            }
        } else {
            $user->plan_id = null;
            $user->cancel_url = null;
            $user->update_url = null;
            $user->update();
        }
    }
}
