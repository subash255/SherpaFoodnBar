<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class VismaPayService
{
    protected $apiKey;
    protected $privateKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('VISMAPAY_API_KEY');
        $this->privateKey = env('VISMAPAY_PRIVATE_KEY');
        $this->apiUrl = env('VISMAPAY_API_URL');
    }

    public function createPaymentUrl($orderNumber, $amount, $currency, $email, $returnUrl, $cancelUrl)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey
        ])->post($this->apiUrl . '/create-payment', [
            'order_number' => $orderNumber,
            'amount' => $amount,
            'currency' => $currency,
            'email' => $email,
            'return_url' => $returnUrl,
            'cancel_url' => $cancelUrl
        ]);

        if ($response->successful()) {
            return $response->json(); // Contains the payment URL and other relevant information
        }

        throw new \Exception('Failed to create payment URL');
    }

    public function verifyPayment($paymentToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey
        ])->post($this->apiUrl . '/verify-payment', [
            'token' => $paymentToken
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Payment verification failed');
    }
}

