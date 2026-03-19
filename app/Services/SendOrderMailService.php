<?php

namespace App\Services;

use App\Constants\GlobalConstant;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class SendOrderMailService
{
    public function sendCoreFreeDownloadMail(string $email, string $inventorVersion, array $context = []): void
    {
        $safeVersion = trim($inventorVersion) !== '' ? trim($inventorVersion) : 'Latest';
        $derivedName = strstr($email, '@', true) ?: 'Customer';
        $customerName = trim((string) ($context['full_name'] ?? '')) ?: ucfirst((string) $derivedName);
        $selectedEntityName = trim((string) ($context['selected_entity_name'] ?? '')) ?: 'DI-Tools Core Free';
        $selectedEntityType = trim((string) ($context['selected_entity_type'] ?? 'package')) ?: 'package';
        $selectedEntityId = trim((string) ($context['selected_entity_id'] ?? ''));

        $data = [
            'order' => null,
            'isCoreFree' => true,
            'customerEmail' => $email,
            'customerName' => $customerName,
            'country' => $selectedEntityType,
            'major' => $selectedEntityId !== '' ? $selectedEntityId : '-',
            'firstItemName' => $selectedEntityName,
            'firstItemPeriod' => $safeVersion,
        ];

        Mail::send('mail.mail-free', $data, function ($message) use ($email, $selectedEntityName) {
            $message->to($email)->subject('Welcome to DI-Tools Free Package - ' . $selectedEntityName);
        });
    }

    public function sendCheckoutSuccessMail(Order $order): void
    {
        if (! $order->email) {
            return;
        }

        $order->loadMissing('items');

        $isCoreFree = $this->isCoreFreeOrder($order);
        $view = $isCoreFree ? 'mail.mail-free' : 'mail.mail-stand';

        $data = [
            'order' => $order,
            'isCoreFree' => $isCoreFree,
            'customerEmail' => $order->email,
            'customerName' => $order->customer_name ?: 'Customer',
            'country' => $order->metadata['country'] ?? '-',
            'major' => $order->metadata['major'] ?? '-',
            'firstItemName' => optional($order->items->first())->name ?: 'Di-tool Package',
            'firstItemPeriod' => optional($order->items->first())->period_label ?: 'One-time',
        ];

        Mail::send($view, $data, function ($message) use ($order, $isCoreFree) {
            $subject = $isCoreFree
                ? 'Welcome to DI-Tools Free Package'
                : 'Your DI-Tools Order Is Confirmed';

            $message->to($order->email)->subject($subject);
        });
    }

    private function isCoreFreeOrder(Order $order): bool
    {
        foreach ($order->items as $item) {
            if ($item->entity_type === 'package') {
                $package = Package::find($item->entity_id);
                if ($package && $package->type_code === GlobalConstant::TYPE_CORE_FREE) {
                    return true;
                }
                continue;
            }

            if ($item->entity_type === 'product') {
                $product = Product::find($item->entity_id);
                if ($product && (bool) $product->is_free) {
                    return true;
                }
            }
        }

        return false;
    }
}

