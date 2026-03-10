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

        $belongsToCoreFree = $product->packages->contains(function ($pkg) {
            return $pkg->type?->name === \App\Constants\GlobalConstant::TYPE_CORE_FREE;
        });

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
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/ArfewyEeXZA" title="Product video"
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
                        $pricingOptions->count() > 0
                            ? (float) $pricingOptions->sortByDesc('price')->first()->price
                            : $currentPrice * 1.44;
                    $savingsPercentProduct =
                        $originalPriceProduct > 0 && $originalPriceProduct > $currentPrice
                            ? (int) round((1 - $currentPrice / $originalPriceProduct) * 100)
                            : 0;
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

                    @if (!$belongsToCoreFree && $pricingOptions->count() > 1)
                        {{-- Subscription plan (only when multiple options to choose from) --}}
                        <div class="border-t border-slate-200 pt-6 pb-6">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-4">Select
                                subscription plan</p>
                            <div class="grid grid-cols-3 gap-3">
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
                    @endif

                    @if ($belongsToCoreFree)
                        {{-- Core Free tools: no pricing, only download CTA via Core Free package --}}
                        <div class="border-t border-slate-200 pt-6 space-y-4 text-center">
                            <button type="button"
                                class="getCoreFreeBtn w-full flex items-center justify-center gap-2 rounded-xl bg-[var(--enterprise-blue)] py-4 text-base font-bold text-white transition-all hover:bg-blue-700 active:scale-[0.98] shadow-lg">
                                <span class="material-symbols-outlined text-xl">download</span>
                                <span>Get Download</span>
                            </button>
                        </div>
                    @else
                        {{-- Price --}}
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
                        @php
                            $pricing = $pkg->pricing->sortBy('price')->first();
                            $price = $pricing ? (float) $pricing->price : 0;
                            $currency = $pricing?->currency ?? 'EUR';
                            $currencySymbol = $currency === 'EUR' ? '€' : $currency . ' ';
                            $badge = 'Package';
                            $fallbackImage =
                                $pkg->avatar ?:
                                'https://lh3.googleusercontent.com/aida-public/AB6AXuD0xn8klFRg-K-wRgdq9BzT8p7YQbk6CjpWvfNLtc2vdCkRslFovVEeXhTTPi8n6Wg4kQk6g5XGMAA9Eje2zDvPqgmIT-5DGhYHSfGg8_3ikow9PiqSqnjhbl4vKZrJGIdPvdSeyLeVSba8OMJLs1VMbFXsof6nhoC7sGi9QImZ1nT5NHC9Go5RlZWKq_GowsX26ajNPYPCPWaol77sCdSPRs-kfLoBSSMaOb37ctMPwcUx8bTWWT9eDcj23XJ1ltEnAAZOQQvyBjI';
                            $desc = $pkg->description ?: 'Curated tools for rapid deployment and consistent results.';
                            $isCoreFree = $pkg->type?->name === App\Constants\GlobalConstant::TYPE_CORE_FREE;
                            $badgeLabel = $isCoreFree ? 'Free' : $badge;
                        @endphp
                        <div class="group flex flex-col rounded-[32px] overflow-hidden transition-all duration-500 cursor-pointer {{ $isCoreFree ? 'core-free-card shadow-lg' : 'pro-card shadow-2xl hover:scale-[1.02] ring-1 ring-blue-500/30' }}"
                            onclick="window.location.href='{{ route('package-detail', $pkg) }}'" role="button"
                            tabindex="0"
                            onkeydown="if(event.key==='Enter') window.location.href='{{ route('package-detail', $pkg) }}'">
                            <div
                                class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px] {{ $isCoreFree ? 'bg-slate-50' : '' }}">
                                <img alt="{{ $pkg->name }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    src="{{ $fallbackImage }}" />
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="{{ $isCoreFree ? 'bg-blue-600 text-white' : 'bg-gradient-to-r from-blue-400 to-blue-600 text-white' }} px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                                        {{ $badgeLabel }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-8 pt-4 flex flex-col flex-1 text-center">
                                <h3
                                    class="text-xl {{ $isCoreFree ? 'font-black text-[var(--enterprise-blue)]' : 'font-black text-white' }}">
                                    {{ $pkg->name }}
                                </h3>
                                @if ($isCoreFree)
                                    <p class="text-slate-600 text-sm mt-3 leading-relaxed">
                                        {{ $desc }}
                                    </p>
                                @else
                                    <div class="mt-4 flex justify-center">
                                        <ul class="space-y-2 text-xs text-blue-100/70 font-medium text-left inline-block">
                                            @forelse ($pkg->products->take(4) as $prod)
                                                <li class="flex items-center gap-2">
                                                    <span
                                                        class="material-symbols-outlined glow-check text-base">check_circle</span>
                                                    <span
                                                        class="text-xs text-blue-50 font-semibold tracking-wide uppercase leading-snug">
                                                        {{ $prod->name }}
                                                    </span>
                                                </li>
                                            @empty
                                                <li class="text-blue-100/70">{{ $desc }}</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                @endif
                                <div class="mt-auto pt-8 flex flex-col items-center">
                                    @if (!$isCoreFree && $pricing)
                                        <div class="flex flex-col items-center mb-6">
                                            <span
                                                class="{{ $isCoreFree ? 'text-3xl text-[var(--enterprise-blue)]' : 'text-4xl text-white' }} font-black tracking-tight">
                                                {{ $currencySymbol }}{{ number_format($price, 2) }}
                                            </span>
                                        </div>
                                        <button type="button" onclick="event.stopPropagation();"
                                            class="buyPackageNowBtn w-full py-4 text-sm font-black rounded-2xl transition-all shadow-lg hover:bg-blue-700 bg-[#137fec] text-white"
                                            data-package-id="{{ $pkg->id }}" data-bundle-name="{{ $pkg->name }}"
                                            data-bundle-price="{{ $price }}"
                                            data-bundle-image="{{ $fallbackImage }}"
                                            data-bundle-period="{{ $pricing?->duration_months ?? '' }}"
                                            data-bundle-detail-url="{{ route('package-detail', $pkg) }}"
                                            data-bundle-items="{{ $pkg->products->pluck('name')->implode(',') }}">
                                            <span class="inline-flex items-center gap-2">
                                                <span>BUY NOW</span>
                                                <span class="material-symbols-outlined text-lg">shopping_cart</span>
                                            </span>
                                        </button>
                                    @endif
                                    @if (!$isCoreFree && !$pricing)
                                        <button type="button"
                                            onclick="window.location.href='{{ route('package-detail', $pkg) }}'"
                                            class="w-full py-4 text-sm font-black rounded-2xl transition-all shadow-lg hover:bg-blue-700 bg-[#137fec] text-white">
                                            <span>COMING SOON</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- @if (!empty($includedTools) && $includedTools->count())
            <section class="mt-20">
                <h2 class="text-2xl font-black mb-8">Included Tools</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($includedTools as $tool)
                        @php
                            $toolPricing = $tool->pricing->sortBy('price')->first();
                            $toolCurrency = $toolPricing?->currency === 'EUR' ? 'EUR ' : (($toolPricing?->currency ?? 'USD') . ' ');
                            $toolImage = $tool->avatar ?: 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png';
                            $toolPrice = $toolPricing ? (float) $toolPricing->price : 0;
                        @endphp
                        <div
                            class="group bg-white border-2 border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                            <a href="{{ route('product-detail', $tool) }}" class="block">
                                <div class="aspect-square bg-slate-100 p-4">
                                    <img class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition-transform"
                                        alt="{{ $tool->name }}" src="{{ $toolImage }}" />
                                </div>
                            </a>
                            <div class="p-4">
                                <h4 class="font-bold text-sm mb-1 truncate">{{ $tool->name }}</h4>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[var(--enterprise-blue)] font-bold text-sm">
                                        {{ $toolPricing ? $toolCurrency . number_format($toolPrice, 2) : 'Contact us' }}
                                    </span>
                                    <button
                                        class="addProductToCartBtn w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all"
                                        data-product-id="{{ $tool->id }}" data-product-name="{{ $tool->name }}"
                                        data-product-price="{{ number_format($toolPrice, 2, '.', '') }}"
                                        data-product-currency="{{ $toolCurrency }}" data-product-image="{{ $toolImage }}">
                                        <span class="material-symbols-outlined !text-sm">add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif --}}

        @if (!empty($relatedProducts) && $relatedProducts->count())
            <section class="mt-20 mb-20">
                <h2 class="text-2xl font-black mb-8">Related Products</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $item)
                        @php
                            $itemPricing = $item->pricing->sortBy('price')->first();
                            $itemCurrency =
                                $itemPricing?->currency === 'EUR' ? 'EUR ' : ($itemPricing?->currency ?? 'USD') . ' ';
                            $itemImage =
                                $item->avatar ?:
                                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png';
                            $itemPrice = $itemPricing ? (float) $itemPricing->price : 0;
                            $itemPeriod =
                                $itemPricing && $itemPricing->duration_months
                                    ? $itemPricing->duration_months . ' months'
                                    : '';
                        @endphp
                        <div class="group bg-white border-2 border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition-all cursor-pointer"
                            onclick="window.location.href='{{ route('product-detail', $item) }}'" role="button"
                            tabindex="0"
                            onkeydown="if(event.key==='Enter') window.location.href='{{ route('product-detail', $item) }}';">
                            <div class="aspect-square bg-slate-100 p-4">
                                <img class="w-full h-full object-contain opacity-80 group-hover:scale-110 transition-transform"
                                    alt="{{ $item->name }}" src="{{ $itemImage }}" />
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-sm mb-1 truncate">{{ $item->name }}</h4>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[var(--enterprise-blue)] font-bold text-sm">
                                        {{ $itemPricing ? $itemCurrency . number_format($itemPrice, 2) : 'Contact us' }}
                                    </span>
                                    @if ($itemPricing)
                                        <button type="button"
                                            class="addProductToCartBtn w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all flex-shrink-0"
                                            onclick="event.stopPropagation();" data-product-id="{{ $item->id }}"
                                            data-product-name="{{ $item->name }}"
                                            data-product-price="{{ number_format($itemPrice, 2, '.', '') }}"
                                            data-product-currency="{{ $itemPeriod }}"
                                            data-product-image="{{ $itemImage }}"
                                            data-product-detail-url="{{ route('product-detail', $item) }}">
                                            <span class="material-symbols-outlined !text-sm">add</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
@endsection

@push('scripts')
    <script>
        window.showAddToCartToast = window.showAddToCartToast || function(message) {
            let container = document.getElementById('cartToastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'cartToastContainer';
                container.className = 'fixed top-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className =
                'pointer-events-auto min-w-[220px] max-w-[320px] rounded-lg border border-green-700 bg-green-600 px-4 py-3 text-sm font-medium text-white shadow-lg opacity-0 translate-y-[-8px] transition-all duration-300';
            toast.textContent = message;
            container.appendChild(toast);

            requestAnimationFrame(() => toast.classList.remove('opacity-0', 'translate-y-[-8px]'));
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-[-8px]');
                setTimeout(() => toast.remove(), 300);
            }, 1800);
        };

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

            const getCart = () => {
                try {
                    const raw = localStorage.getItem('cart');
                    return raw ? JSON.parse(raw) : [];
                } catch (e) {
                    return [];
                }
            };

            const setCart = (items) => {
                try {
                    localStorage.setItem('cart', JSON.stringify(items));
                } catch (e) {}
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

                const items = getCart();
                const existingIdx = items.findIndex(it =>
                    String(it.type || 'product') === 'product' &&
                    String(it.id || '') === String(item.id)
                );

                if (existingIdx >= 0) {
                    items[existingIdx].qty = (items[existingIdx].qty || 1) + 1;
                    items[existingIdx].price = item.price;
                    items[existingIdx].period = item.period;
                } else {
                    items.push(item);
                }

                setCart(items);
                window.dispatchEvent(new Event('cart:updated'));
                return name;
            };

            $('.addProductToCartBtn').on('click', function() {
                const name = upsertProductToCart($(this));
                window.showAddToCartToast(`${name} added to cart`);
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
                const items = getCart();
                const existingIdx = items.findIndex(it =>
                    String(it.type || 'package') === 'package' &&
                    String(it.id ?? '') === item.id &&
                    String(it.period ?? '') === item.period
                );
                if (existingIdx >= 0) {
                    items[existingIdx].qty = (items[existingIdx].qty || 1) + 1;
                } else {
                    items.push(item);
                }
                setCart(items);
                window.dispatchEvent(new Event('cart:updated'));
                window.location.href = '/checkout';
            });
        });
    </script>
    <script>
        // Open Core Free download popup when clicking "Get Download"
        $(document).on('click', '.getCoreFreeBtn', function() {
            $('#downloadModal').removeClass('hidden');
        });
    </script>
@endpush
