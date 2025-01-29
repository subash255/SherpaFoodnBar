<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class VismaPayService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('VISMAPAY_API_URL');  // API base URL
        $this->apiKey = env('VISMAPAY_API_KEY');  // API key
    }

    /**
     * Create a payment session and return the payment URL.
     */
    public function createPaymentSession($order)
    {
        $payload = [
            'order_number' => $order->order_number,
            'amount' => $order->total,
            'currency' => 'USD',  // Ensure you use the correct currency
            'email' => $order->email,
            'return_url' => route('payment.success', ['orderNumber' => $order->order_number]),
            'cancel_url' => route('payment.cancel', ['orderNumber' => $order->order_number]),
            'api_key' => $this->apiKey,
        ];

        $response = Http::post("{$this->apiUrl}/create-payment-session", $payload);

        if ($response->successful()) {
            return $response->json()['payment_url'];  // This URL is the hosted payment page URL
        }

        return null;  // In case of failure, return null
    }
}
