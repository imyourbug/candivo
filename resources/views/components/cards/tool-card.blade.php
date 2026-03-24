@php
    $tool = (object) $tool;
    $toolName = $tool->name ?? '';
    $toolPricing = isset($tool->pricing) ? collect($tool->pricing)->sortBy('price')->first() : null;
    $toolPrice = $toolPricing ? (float) $toolPricing->price : 0;
    $toolCurrency = $toolPricing?->currency ?? 'EUR';
    $toolCurrencyIsEur = strtoupper((string) $toolCurrency) === 'EUR';
    $toolCurrencySymbol = $toolCurrencyIsEur ? '€' : $toolCurrency . ' ';
    $toolPeriod =
        $toolPricing && (int) ($toolPricing->duration_months ?? 0) > 0
            ? (int) $toolPricing->duration_months . ' months'
            : '';
    $imageSources = $imageSources ?? [];
    $toolImage =
        isset($tool->avatar) && trim((string) $tool->avatar) !== ''
            ? trim($tool->avatar)
            : ($imageSources[$idx % max(count($imageSources), 1)] ?? '');
    $hasProductId = isset($tool->id);
    $resolvedProductId = $productId ?? ($hasProductId ? $tool->id : $idx);
    $isClickable = $isClickable ?? true;
    $detailUrl = $detailUrl ?? ($isClickable && $hasProductId ? route('product-detail', $tool) : '');
    $enableLink = $isClickable && !empty($detailUrl);
@endphp

<div class="group bg-white border-2 border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition-all {{ $enableLink ? 'cursor-pointer' : '' }}"
    @if ($enableLink) onclick="window.location.href='{{ $detailUrl }}'" role="link" tabindex="0"
        onkeydown="if(event.key === 'Enter'){ window.location.href='{{ $detailUrl }}'; }" @endif>
    <div class="aspect-square bg-slate-100 p-4">
        <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
            alt="{{ $toolName }}" src="{{ $toolImage }}" />
    </div>
    <div class="p-4">
        <h4 class="font-bold text-sm mb-1 truncate">{{ $toolName }}</h4>
        <div class="flex items-center justify-between gap-2">
            <span
                class="text-[var(--enterprise-blue)] font-bold text-sm inline-flex items-center gap-0.5 min-w-0">
                @if ($toolPricing)
                    @if ($toolCurrencyIsEur)
                        <span class="material-symbols-outlined !text-lg !leading-none shrink-0"
                            aria-hidden="true">euro</span>
                        <span class="truncate">{{ number_format($toolPrice, 2) }}</span>
                    @else
                        <span class="truncate">{{ $toolCurrencySymbol }}{{ number_format($toolPrice, 2) }}</span>
                    @endif
                @else
                    Contact us
                @endif
            </span>
            @if ($toolPricing)
                <button type="button"
                    class="addProductToCartBtn w-8 h-8 shrink-0 rounded-full border border-slate-200 flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all"
                    onclick="event.stopPropagation();" data-product-id="{{ $resolvedProductId }}"
                    data-product-name="{{ $toolName }}"
                    data-product-price="{{ number_format((float) $toolPrice, 2, '.', '') }}"
                    data-product-currency="{{ $toolPeriod }}" data-product-image="{{ $toolImage }}"
                    data-product-detail-url="{{ $detailUrl }}">
                    <span class="material-symbols-outlined !text-sm">add</span>
                </button>
            @endif
        </div>
    </div>
</div>
