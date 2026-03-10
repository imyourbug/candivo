<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function handlePayment(Request $request)
    {
        $amount = $request->input('order_total');
        $cartData = $request->input('cart_data');

        if ($amount === null || ! is_numeric($amount) || $amount <= 0) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Invalid order total. Please try again.');
        }

        $amount = (float) $amount;
        $cart = $this->orderService->parseCartData($cartData);
        if (empty($cart)) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }

        $order = $this->orderService->createOrderFromCart($cart, $amount, Order::PAYMENT_PAYPAL);

        $returnUrl = URL::temporarySignedRoute('paypal.success', now()->addHours(1), ['order_id' => $order->id]);
        $cancelUrl = URL::temporarySignedRoute('paypal.cancel', now()->addHours(1), ['order_id' => $order->id]);

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($amount, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'cancel_url' => $cancelUrl,
                'return_url' => $returnUrl,
            ],
        ]);

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'Unable to initiate PayPal payment. Please try again.');
    }

    /**
     * Called by PayPal when the customer cancels the payment.
     * order_id is passed via signed URL. PayPal may add query params, so we validate while ignoring them.
     */
    public function cancel(Request $request)
    {
        if (! $request->hasValidSignatureWhileIgnoring(['token', 'PayerID'])) {
            abort(403, 'Invalid signature.');
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'You cancelled the PayPal payment.');
    }

    /**
     * Called by PayPal after the customer approves the payment.
     * order_id is passed via signed URL. PayPal adds token & PayerID, so we validate while ignoring them.
     */
    public function success(Request $request)
    {
        if (! $request->hasValidSignatureWhileIgnoring(['token', 'PayerID'])) {
            abort(403, 'Invalid signature.');
        }

        $orderId = (int) $request->query('order_id');
        $token = $request->query('token');

        if (! $token) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Missing PayPal token. Please try again.');
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $result = $provider->capturePaymentOrder($token);

        if (isset($result['status']) && $result['status'] === 'COMPLETED') {
            $this->orderService->completeOrder($orderId, $token);
            return redirect()
                ->route('checkout')
                ->with('success', 'Payment completed successfully. Your license will be emailed shortly.');
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'Payment could not be completed. Please contact support or try again.');
    }
}
