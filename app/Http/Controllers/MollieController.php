<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Create a Mollie payment and redirect the customer to Mollie checkout.
     * Order id is passed via signed return/cancel URLs (no session).
     */
    public function handlePayment(Request $request)
    {
        $amount = $request->input('order_total');
        $cartData = $request->input('cart_data');
        $customerContact = trim((string) $request->input('customer_contact', ''));
        $country = trim((string) $request->input('country', ''));
        $major = trim((string) $request->input('customer_major', ''));

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

        $order = $this->orderService->createOrderFromCart(
            $cart,
            $amount,
            Order::PAYMENT_MOLLIE,
            'USD',
            [
                'email' => $customerContact,
                'country' => $country,
                'major' => $major,
            ]
        );

        $returnUrl = URL::temporarySignedRoute('mollie.success', now()->addHours(1), ['order_id' => $order->id]);
        $cancelUrl = URL::temporarySignedRoute('mollie.cancel', now()->addHours(1), ['order_id' => $order->id]);

        $value = number_format($amount, 2, '.', '');

        $payment = Mollie::api()->payments->create([
            'amount' => [
                'currency' => 'USD',
                'value' => $value,
            ],
            'description' => 'Di-tool Premium Checkout',
            'redirectUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
        ]);

        $order->update(['metadata' => array_merge($order->metadata ?? [], ['mollie_payment_id' => $payment->id])]);

        $checkoutUrl = $payment->getCheckoutUrl();
        if ($checkoutUrl) {
            return redirect()->away($checkoutUrl);
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'Unable to initiate Mollie payment. Please try again.');
    }

    /**
     * Called when the customer cancels the payment on Mollie.
     * order_id is passed via signed URL.
     */
    public function cancel(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid signature.');
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'You cancelled the payment.');
    }

    /**
     * Called when Mollie redirects the customer back after payment.
     * order_id is passed via signed URL; payment id is read from order metadata.
     */
    public function success(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid signature.');
        }

        $orderId = (int) $request->query('order_id');
        $order = Order::find($orderId);

        if (! $order) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Order not found. Please contact support.');
        }

        $paymentId = $order->metadata['mollie_payment_id'] ?? null;
        if (! $paymentId) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Payment not found. Please contact support.');
        }

        $payment = Mollie::api()->payments->get($paymentId);

        if ($payment->isPaid()) {
            $this->orderService->completeOrder($orderId, $paymentId);
            return redirect()
                ->route('checkout')
                ->with('success', 'Payment completed successfully. Your license will be emailed shortly.');
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'Payment could not be completed. Please contact support or try again.');
    }
}
