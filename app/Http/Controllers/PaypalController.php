<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use PaypalServerSdkLib\Authentication\ClientCredentialsAuthCredentialsBuilder;
use PaypalServerSdkLib\Environment;
use PaypalServerSdkLib\Exceptions\ApiException;
use PaypalServerSdkLib\PaypalServerSdkClient;
use PaypalServerSdkLib\PaypalServerSdkClientBuilder;
use stdClass;

class PaypalController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    private function paypalClient(): PaypalServerSdkClient
    {
        $mode = strtolower((string) env('PAYPAL_MODE', 'sandbox'));
        $isLive = $mode === 'live';

        $clientId = $isLive
            ? (string) env('PAYPAL_LIVE_CLIENT_ID', '')
            : (string) env('PAYPAL_SANDBOX_CLIENT_ID', '');
        $clientSecret = $isLive
            ? (string) env('PAYPAL_LIVE_CLIENT_SECRET', '')
            : (string) env('PAYPAL_SANDBOX_CLIENT_SECRET', '');

        return PaypalServerSdkClientBuilder::init()
            ->clientCredentialsAuthCredentials(
                ClientCredentialsAuthCredentialsBuilder::init($clientId, $clientSecret)
            )
            ->environment($isLive ? Environment::PRODUCTION : Environment::SANDBOX)
            ->build();
    }

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
            Order::PAYMENT_PAYPAL,
            'USD',
            [
                'email' => $customerContact,
                'country' => $country,
                'major' => $major,
            ]
        );

        $returnUrl = URL::temporarySignedRoute('paypal.success', now()->addHours(1), ['order_id' => $order->id]);
        $cancelUrl = URL::temporarySignedRoute('paypal.cancel', now()->addHours(1), ['order_id' => $order->id]);

        try {
            $client = $this->paypalClient();

            $createResponse = $client->getOrdersController()->createOrder([
                'body' => [
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
                ],
                // Ensure we get links[] (approve URL) back
                'prefer' => 'return=representation',
            ]);

            $ppOrder = $createResponse->getResult();
            if (is_array($ppOrder)) {
                $id = $ppOrder['id'] ?? null;
                $links = $ppOrder['links'] ?? [];
                if ($id && is_array($links)) {
                    foreach ($links as $link) {
                        if (($link['rel'] ?? null) === 'approve' && ! empty($link['href'])) {
                            return redirect()->away($link['href']);
                        }
                    }
                }
            } elseif ($ppOrder && method_exists($ppOrder, 'getId') && $ppOrder->getId()) {
                foreach (($ppOrder->getLinks() ?? []) as $link) {
                    if ($link->getRel() === 'approve') {
                        return redirect()->away($link->getHref());
                    }
                }
            }

            Log::warning('PayPal createOrder missing approve link', [
                'status' => $createResponse->getStatusCode(),
                'body' => $createResponse->getBody(),
            ]);
        } catch (ApiException $e) {
            Log::error('PayPal createOrder failed', [
                'message' => $e->getMessage(),
                'status' => $e->getCode(),
                'response_body' => $e->hasResponse() ? $e->getHttpResponse()?->getRawBody() : null,
            ]);
        } catch (\Throwable $e) {
            Log::error('PayPal createOrder unexpected error', [
                'message' => $e->getMessage(),
            ]);
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

        try {
            $client = $this->paypalClient();
            $captureResponse = $client->getOrdersController()->captureOrder([
                'id' => $token,
                'body' => new stdClass(),
            ]);

            $ppOrder = $captureResponse->getResult();
            $status = null;
            if (is_array($ppOrder)) {
                $status = $ppOrder['status'] ?? null;
            } elseif ($ppOrder && method_exists($ppOrder, 'getStatus')) {
                $status = $ppOrder->getStatus();
            }

            if ($status === 'COMPLETED') {
                $this->orderService->completeOrder($orderId, $token);
                return redirect()
                    ->route('checkout')
                    ->with('success', 'Payment completed successfully. Your license will be emailed shortly.');
            }
        } catch (ApiException $e) {
            Log::error('PayPal captureOrder failed', [
                'message' => $e->getMessage(),
                'status' => $e->getCode(),
                'response_body' => $e->hasResponse() ? $e->getHttpResponse()?->getRawBody() : null,
            ]);
        } catch (\Throwable $e) {
            Log::error('PayPal captureOrder unexpected error', [
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'Payment could not be completed. Please contact support or try again.');
    }
}
