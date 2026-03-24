@extends('layouts.main')

@section('title', ($product->name ?? 'Product Detail') . ' - Di-tool')

@push('styles')
    <style type="text/tailwindcss">
        .pro-card {
            background: linear-gradient(165deg, #0a2540 0%, #0d2d4a 35%, #061a2e 100%);
            border: 1px solid rgba(59, 130, 246, 0.25);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 10px 30px -8px rgba(15, 23, 42, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        }

        .pro-card:hover {
            border-color: rgba(59, 130, 246, 0.45);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.08) inset;
            transform: translateY(-4px);
        }

        .core-free-card {
            border: 1px solid rgba(30, 121, 220, 0.4);
            background: #eff6ff;
        }

        .core-free-card:hover {
            border-color: rgba(30, 121, 220, 0.6);
        }

        .glow-check {
            color: #7dd3fc;
        }
    </style>
@endpush

@section('content')
    @php
        $productName = $product->name ?? 'Product';
        $productDesc = $product->description ?: 'Professional CAD productivity add-on for Autodesk Inventor workflows.';
        $mainImage =
            $product->avatar ?: 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png';

        $imageItems = collect(explode(',', (string) $product->images))
            ->map(fn($item) => trim($item))
            ->filter()
            ->values();

        if ($imageItems->isEmpty()) {
            $imageItems = collect([$mainImage]);
        }

        $pricingOptions = $product->pricing->sortBy('duration_months')->values();
        $hasPricingTiers = $pricingOptions->isNotEmpty();
        $activePricing =
            $pricingOptions->sortByDesc('duration_months')->first() ??
            (object) ['price' => 0, 'duration_months' => 0, 'currency' => 'EUR'];
        $currencyPrefix =
            ($activePricing->currency ?? 'EUR') === 'EUR' ? '€' : ($activePricing->currency ?? 'USD') . ' ';

        $isBasic = (int) $product->is_basic === 1;
        $isProfessional = (int) $product->is_professional === 1;
        $isPremium = (int) $product->is_premium === 1;

        $featureFlags = [
            ['label' => 'Basic', 'active' => $isBasic],
            ['label' => 'Professional', 'active' => $isProfessional],
            ['label' => 'Premium', 'active' => $isPremium],
        ];

        $specs = [
            ['label' => 'Category', 'value' => $product->category?->name ?: 'N/A'],
            ['label' => 'Value Status', 'value' => $product->value_status ?: 'N/A'],
            ['label' => 'CAT Set', 'value' => $product->cat_set ?: 'N/A'],
            ['label' => 'Stand Set', 'value' => $product->stand_set ?: 'N/A'],
            ['label' => 'Included In', 'value' => $product->packages->count() . ' package(s)'],
        ];
    @endphp

    <div class="mx-auto w-full max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        @php
            $typeCode = $product->packages?->first()?->type?->code ?? '';
        @endphp
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-500">
            <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            @if ($typeCode)
                <a class="hover:text-primary transition-colors"
                    href="{{ route('home', ['tab' => $typeCode]) }}">{{ $typeCode }}</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            @endif
            <a class="hover:text-primary transition-colors"
                href="{{ route('package-detail', ['package' => $product->packages?->first()?->slug]) }}">{{ $product->packages?->first()?->name }}</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-slate-900">{{ $productName }}</span>
        </nav>
    </div>

    <main class="mx-auto w-full max-w-7xl grow px-4 py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
            <div class="lg:col-span-7 flex flex-col gap-4">
                <div
                    class="relative aspect-video w-full overflow-hidden rounded-xl bg-white shadow-lg border border-slate-200">
                    <div id="productMainVideo" class="w-full h-full">
                        <iframe class="w-full h-full" src="{{ $product->video ?: 'https://www.youtube.com/embed/Y5ltBmPhyp0' }}" title="Product video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <img id="productMainImage" alt="{{ $productName }}" class="h-full w-full object-cover hidden"
                        src="{{ $mainImage }}" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                </div>

                <div class="grid grid-cols-4 gap-3 sm:gap-4">
                    @foreach ($imageItems as $img)
                        <button type="button"
                            class="productThumb aspect-video cursor-pointer overflow-hidden rounded-lg border-2 border-slate-200 ring-0 shadow-md transition-all hover:border-primary/70 focus:outline-none"
                            data-src="{{ $img }}">
                            <img alt="Thumbnail" class="h-full w-full object-cover opacity-100 hover:opacity-90"
                                src="{{ $img }}" />
                        </button>
                    @endforeach
                </div>

                <div class="mt-8 space-y-4">
                    <h3 class="text-xl font-bold text-slate-900">{{ $productName }}</h3>
                    <p class="text-slate-600 leading-relaxed">{!! $productDesc !!}</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach ($featureFlags as $flag)
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold {{ $flag['active'] ? 'bg-[var(--enterprise-blue)] text-white' : 'bg-slate-100 text-slate-500' }}">
                            {{ $flag['label'] }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-5">
                @php
                    $currentPrice = (float) $activePricing->price;
                    $originalPriceProduct =
                        $hasPricingTiers
                            ? (float) $pricingOptions->sortByDesc('price')->first()->price
                            : $currentPrice * 1.44;
                    $savingsPercentProduct =
                        $hasPricingTiers && $originalPriceProduct > 0 && $originalPriceProduct > $currentPrice
                            ? (int) round((1 - $currentPrice / $originalPriceProduct) * 100)
                            : 0;
                    $planGridCols = min(3, max(1, $pricingOptions->count()));
                @endphp
                <div class="sticky top-24 rounded-2xl bg-slate-50 p-6 sm:p-8 shadow-lg border border-slate-200">
                    {{-- Badge + Title --}}
                    <div class="mb-6">
                        <span
                            class="inline-block px-3 py-1 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-widest mb-3">Professional
                            Grade</span>
                        <h1 class="text-2xl sm:text-3xl font-black leading-tight tracking-tight text-slate-900 uppercase">
                            {{ strtoupper($productName) }}
                        </h1>
                    </div>

                    {{-- Product details: 2-column, label above value --}}
                    <div class="border-t border-slate-200 pt-6 pb-6">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                            @foreach ($specs as $spec)
                                @php
                                    $highlight =
                                        str_starts_with(strtolower($spec['label'] ?? ''), 'included') &&
                                        $spec['value'] !== '0 package(s)';
                                @endphp
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                        {{ $spec['label'] }}</p>
                                    <p class="text-sm font-bold text-slate-900 {{ $highlight ? 'text-emerald-600' : '' }}">
                                        {{ $spec['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($hasPricingTiers)
                        {{-- Subscription plan: show whenever product has pricing rows (1 or more) --}}
                        <div class="border-t border-slate-200 pt-6 pb-6">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-4">Select
                                subscription plan</p>
                            <div class="grid gap-3 {{ $planGridCols === 1 ? 'grid-cols-1' : ($planGridCols === 2 ? 'grid-cols-2' : 'grid-cols-3') }}">
                                @foreach ($pricingOptions as $option)
                                    @php
                                        $optionPrefix = $option->currency === 'EUR' ? '€' : $option->currency . ' ';
                                    @endphp
                                    <button type="button" aria-selected="{{ $loop->last ? 'true' : 'false' }}"
                                        class="productPeriodBtn rounded-lg border-2 py-3.5 text-sm font-bold transition-all {{ $loop->last ? 'bg-[var(--enterprise-blue)] border-[var(--enterprise-blue)] text-white' : 'bg-white border-slate-200 text-slate-700 hover:border-[var(--enterprise-blue)]/50' }}"
                                        data-price="{{ number_format((float) $option->price, 2, '.', '') }}"
                                        data-duration="{{ (int) $option->duration_months }}"
                                        data-currency="{{ $optionPrefix }}">
                                        {{ (int) $option->duration_months > 0 ? (int) $option->duration_months . ' MO' : 'One-time' }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price (always when pricing records exist) --}}
                        <div class="border-t border-slate-200 pt-6 pb-6 text-center">
                            @if ($savingsPercentProduct > 0)
                                <p class="text-sm text-slate-400 line-through mb-1">
                                    {{ $currencyPrefix }}{{ number_format($originalPriceProduct, 2) }}</p>
                            @endif
                            <p class="flex items-baseline justify-center gap-0.5">
                                <span
                                    class="text-2xl font-black text-slate-900 align-baseline">{{ trim($currencyPrefix) }}</span>
                                <span id="productPrice"
                                    class="text-4xl font-black text-slate-900 tracking-tight">{{ number_format($currentPrice, 2) }}</span>
                            </p>
                            @if ($savingsPercentProduct > 0)
                                <span
                                    class="inline-block mt-2 px-2.5 py-1 rounded-md bg-emerald-500 text-white text-[10px] font-bold uppercase tracking-wider">Save
                                    {{ $savingsPercentProduct }}% annually</span>
                            @endif
                            <span id="productDuration" class="sr-only"
                                aria-hidden="true">{{ (int) $activePricing->duration_months > 0 ? (int) $activePricing->duration_months . ' months' : 'one-time' }}</span>
                        </div>

                        {{-- CTAs + Guarantee --}}
                        <div class="space-y-3">
                            <button type="button"
                                class="addProductToCartBtn w-full flex items-center justify-center gap-2 rounded-xl border-2 bg-white py-4 text-base font-bold text-[var(--enterprise-blue)] transition-all hover:bg-blue-50 active:scale-[0.98]"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $productName }}"
                                data-product-detail-url="{{ route('product-detail', $product) }}">
                                <span class="material-symbols-outlined text-xl">add_shopping_cart</span>
                                <span>Add To Cart</span>
                            </button>
                            <button type="button"
                                class="buyNowProductBtn w-full flex items-center justify-center gap-2 rounded-xl bg-[var(--enterprise-blue)] py-4 text-base font-bold text-white transition-all hover:bg-blue-700 active:scale-[0.98] shadow-lg"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $productName }}"
                                data-product-detail-url="{{ route('product-detail', $product) }}">
                                <span class="material-symbols-outlined text-xl">shopping_cart</span>
                                <span>Buy Now</span>
                            </button>
                            <p class="flex items-center justify-center gap-2 text-xs text-slate-500">
                                <span class="material-symbols-outlined text-base">verified_user</span>
                                30-Day Money Back Guarantee
                            </p>
                        </div>
                    @else
                        {{-- No pricing rows: legacy fallback --}}
                        <div class="border-t border-slate-200 pt-6 pb-6 text-center">
                            @if ($savingsPercentProduct > 0)
                                <p class="text-sm text-slate-400 line-through mb-1">
                                    {{ $currencyPrefix }}{{ number_format($originalPriceProduct, 2) }}</p>
                            @endif
                            <p class="flex items-baseline justify-center gap-0.5">
                                <span
                                    class="text-2xl font-black text-slate-900 align-baseline">{{ trim($currencyPrefix) }}</span>
                                <span id="productPrice"
                                    class="text-4xl font-black text-slate-900 tracking-tight">{{ number_format($currentPrice, 2) }}</span>
                            </p>
                            @if ($savingsPercentProduct > 0)
                                <span
                                    class="inline-block mt-2 px-2.5 py-1 rounded-md bg-emerald-500 text-white text-[10px] font-bold uppercase tracking-wider">Save
                                    {{ $savingsPercentProduct }}% annually</span>
                            @endif
                            <span id="productDuration" class="sr-only"
                                aria-hidden="true">{{ (int) $activePricing->duration_months > 0 ? (int) $activePricing->duration_months . ' months' : 'one-time' }}</span>
                        </div>
                        <div class="space-y-3">
                            <button type="button"
                                class="addProductToCartBtn w-full flex items-center justify-center gap-2 rounded-xl border-2 bg-white py-4 text-base font-bold text-[var(--enterprise-blue)] transition-all hover:bg-blue-50 active:scale-[0.98]"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $productName }}"
                                data-product-detail-url="{{ route('product-detail', $product) }}">
                                <span class="material-symbols-outlined text-xl">add_shopping_cart</span>
                                <span>Add To Cart</span>
                            </button>
                            <button type="button"
                                class="buyNowProductBtn w-full flex items-center justify-center gap-2 rounded-xl bg-[var(--enterprise-blue)] py-4 text-base font-bold text-white transition-all hover:bg-blue-700 active:scale-[0.98] shadow-lg"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $productName }}"
                                data-product-detail-url="{{ route('product-detail', $product) }}">
                                <span class="material-symbols-outlined text-xl">shopping_cart</span>
                                <span>Buy Now</span>
                            </button>
                            <p class="flex items-center justify-center gap-2 text-xs text-slate-500">
                                <span class="material-symbols-outlined text-base">verified_user</span>
                                30-Day Money Back Guarantee
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if ($product->packages->count())
            <section class="mt-20">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Included In Packages</h2>
                        <p class="text-slate-600">Upgrade by bundle to unlock more tools.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                    @foreach ($product->packages as $pkg)
                        @include('components.cards.package-card', ['package' => $pkg, 'ctaSizeClass' => 'py-4'])
                    @endforeach
                </div>
            </section>
        @endif

        @if (!empty($relatedProducts) && $relatedProducts->count())
            <section class="mt-20 mb-20">
                <h2 class="text-2xl font-black mb-8">Related Products</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $idx => $item)
                        @include('components.cards.tool-card', [
                            'tool' => $item,
                            'idx' => $idx,
                            'imageSources' => [
                                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                            ],
                            'isClickable' => true,
                            'productId' => $item->id,
                            'detailUrl' => route('product-detail', $item),
                        ])
                    @endforeach
                </div>
            </section>
        @endif
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const $mainImg = $('#productMainImage');
            const $mainVideo = $('#productMainVideo');
            const $videoIframe = $('#productMainVideo iframe');
            const $thumbs = $('.productThumb');

            if ($thumbs.length) {
                $thumbs.first().addClass('border-primary ring-2 ring-primary ring-offset-2').removeClass(
                    'border-slate-200 ring-0');
            }

            const showImage = (src) => {
                $mainVideo.addClass('hidden');
                $videoIframe.attr('src', '');
                $mainImg.removeClass('hidden').attr('src', src);
            };

            $thumbs.on('click', function() {
                const $btn = $(this);
                const src = $btn.data('src');
                if (!src) return;

                $thumbs.removeClass('border-primary ring-2 ring-primary ring-offset-2').addClass(
                    'border-slate-200 ring-0');
                $btn.addClass('border-primary ring-2 ring-primary ring-offset-2').removeClass(
                    'border-slate-200 ring-0');
                showImage(src);
            });

            const $periodBtns = $('.productPeriodBtn');
            const $priceEl = $('#productPrice');
            const $durationEl = $('#productDuration');

            var selectedClass = 'bg-[var(--enterprise-blue)] border-[var(--enterprise-blue)] text-white';
            var unselectedClass =
                'bg-white border-slate-200 text-slate-700 hover:border-[var(--enterprise-blue)]/50';

            $periodBtns.on('click', function() {
                const $btn = $(this);
                $periodBtns.removeClass(selectedClass).addClass(unselectedClass).attr('aria-selected',
                    'false');
                $btn.removeClass(unselectedClass).addClass(selectedClass).attr('aria-selected', 'true');

                const price = Number($btn.data('price') || 0).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                const duration = Number($btn.data('duration') || 0);
                $priceEl.text(price);
                if ($durationEl.length) $durationEl.text(duration > 0 ? `${duration} months` : 'one-time');
            });

            const getSelectedPricing = () => {
                const $selected = $('.productPeriodBtn[aria-selected="true"]').length ? $(
                    '.productPeriodBtn[aria-selected="true"]').last() : $('.productPeriodBtn').last();
                if ($selected.length) {
                    const duration = Number($selected.data('duration') || 0);
                    return {
                        price: Number($selected.data('price') || 0),
                        period: duration > 0 ? `${duration} months` : 'one-time'
                    };
                }

                const rawPrice = '{{ number_format((float) $activePricing->price, 2, '.', '') }}';
                const rawDuration = {{ (int) $activePricing->duration_months }};
                return {
                    price: Number(rawPrice || 0),
                    period: rawDuration > 0 ? `${rawDuration} months` : 'one-time'
                };
            };

            const upsertProductToCart = ($btn) => {
                const id = String($btn.data('product-id') || '');
                const name = $btn.data('product-name') || 'Product';
                const detailUrl = $btn.data('product-detail-url') || '';
                const fromButton = $btn.data('product-price') !== undefined && $btn.data('product-price') !==
                    '';
                const price = fromButton ? Number($btn.data('product-price')) || 0 : getSelectedPricing().price;
                const period = fromButton ? ($btn.data('product-currency') || '').trim() : getSelectedPricing()
                    .period;
                const image = fromButton ? ($btn.data('product-image') || '') : ($('#productMainImage').attr(
                    'src') || '');

                const item = {
                    id: `product-${id}`,
                    name,
                    price,
                    period,
                    qty: 1,
                    type: 'product',
                    image,
                    detailUrl
                };
                if (window.CartCommon) {
                    window.CartCommon.addProductItem(item);
                }
                return name;
            };

            $('.addProductToCartBtn').on('click', function() {
                const name = upsertProductToCart($(this));
                if (window.CartCommon) {
                    window.CartCommon.notifyAdded(name);
                }
            });

            $('.buyNowProductBtn').on('click', function() {
                upsertProductToCart($(this));
                window.location.href = '/checkout';
            });

            $('.buyPackageNowBtn').on('click', function() {
                const rawId = $(this).data('package-id');
                const id = String(rawId ?? '');
                const name = $(this).data('bundle-name') || 'Package';
                const price = Number($(this).data('bundle-price')) || 0;
                const image = $(this).data('bundle-image') || '';
                const period = ($(this).data('bundle-period') || '').toString();
                const detailUrl = $(this).data('bundle-detail-url') || '';
                const item = {
                    id,
                    name,
                    price,
                    period,
                    qty: 1,
                    type: 'package',
                    image,
                    detailUrl
                };
                if (window.CartCommon) {
                    window.CartCommon.addPackageItem(item);
                }
                window.location.href = '/checkout';
            });
        });
    </script>
@endpush
