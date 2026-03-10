@extends('layouts.main')

@section('title', ($package->name ?? 'Package Detail') . ' - Di-tool')

@section('content')
    @php
        $packageName = $package->name ?? 'Premium Package';
        $packageDesc =
            $package->description ?? 'A curated suite of professional tools tailored to high-impact workflows.';
        $packageImage =
            $package->avatar ??
            'https://lh3.googleusercontent.com/aida-public/AB6AXuDFiyfW16BqlTlp5m2Ic-34IvbXp4xo83UR5S6FBGhs_myfMUKK0zOD6-D5soN1dZ7I9ufcUPBqKA26S3YoFLE-PgwIOhbecYeIge6Cg5pEqBgWT0_SLslgpPzlfJn3gerNqxvgMfpPMkf96vf2ksZMWLHcGOyAoh2EzMbKeGQo5-IgD76WYpw3RytOSh4mLaxLP7A6CEnSy8eRUumlB3oTOOKmSkJiXmHjnezLGBeK3ZXh_TlM_KSElNndF0uwUb5_Gz_qJxG8DhM';
        $packagePricing = $package->pricing->sortBy('price')->first();
        $packagePrice = $packagePricing ? (float) $packagePricing->price : 239;
        $packageDuration = $packagePricing ? (int) $packagePricing->duration_months : 12;
        $packageCurrency = $packagePricing?->currency ?? 'EUR';
        $currencySymbol = $packageCurrency === 'EUR' ? '€' : $packageCurrency . ' ';
        $fakeSpecs = [
            ['label' => 'Platform', 'value' => 'Autodesk Inventor'],
            ['label' => 'License Type', 'value' => 'Single / Floating'],
            ['label' => 'Industry', 'value' => 'Mechanical Eng.'],
            ['label' => 'Updates', 'value' => 'Included', 'highlight' => true],
        ];
        $fallbackTools = [
            [
                'name' => 'Drawing & Export',
                'desc' => 'Automate technical drawings and multi-format exports.',
                'icon' => 'draw',
            ],
            ['name' => 'Batch Tooling', 'desc' => 'Process hundreds of assemblies simultaneously.', 'icon' => 'layers'],
            [
                'name' => 'Auto BOM',
                'desc' => 'Generate BOMs with configurable rules.',
                'icon' => 'format_list_bulleted',
            ],
            ['name' => 'Smart Update', 'desc' => 'Keep models consistent across revisions.', 'icon' => 'autorenew'],
        ];
        $toolImageSources = [
            'https://lh3.googleusercontent.com/aida-public/AB6AXuADz2fKqgxIvjaTj5-lGjwoNT8MCRI9OeB4VkBT9SfnOC-ejIGeSk2nZSzNi2tc9JY93KvGyMOmiKy8tcO0x3xjIw5jGCzLUci29fvhdZu98X_1JxqPLpbXHZ3Ym4g-7Cl4fUuzlgFhK4dZ2l2swKfmJbPbHDofoao3kqPWr2q94KpXn6N5Qv4CxRwEuB5YLgYmO9Pc1wu_Vi97_Egr6ITV3YeNLW5timi7sAh0xCzyu4iTEQKofUhBqDK_sasUb1I0nsMoYPf8AvQ',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuA9u23NQRZqmg3IXYfIWNTXAFL7WsUsGqHdoGVLnNdK7IR6NMfqnxmfJ2129c5BEcdDq4ks2W9JKqUKWOmDOKk5cxuBmZlxgqmMvXxJTuq6SPcmruZIWUuDvt3lrP7KkmdtHLj_bzhmC2C66RWM2kgjbnQh-APZToYvnUXF6zKJ46TRkyzrfckVOzzj6S3m5HVpJEgHJUa9ud3-WaHYg-za064cNSOi6VpxM4OaDjBv1VTf8HX2g8VUf_vzzExLjwXkItLbAcjksQQ',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuA9I9gE16lI_z4bFCY2M0qEe9EU-Dv3T8j4_cpEc1n3ronut_jQ_LX-_hwf47yXpe2xuYOTtR5FbQiuoYbMJiRSppBvJOQVPfDMuMvm-sSYIoFX37p4o7NrO56SddRIC3-kKN_sR9NQbsW3jpodY1phzOfvHpzuqqRm3mYZ06rvtNB3To6dH7Qn2QdtXtQtK5MMeHk4DDn-USfNovMi9Df3n5CXRcQVHvRl1wfaoZC4dhaP3oEZdZvs-7oRXwBmsdFDfUKifMcqI70',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuD8lbZUTGd1GLg5HcHiZ1PADrs7-7Pw0CU5rwiAISq3Khpqu_ufOto0OrYiTpHuhdopfYOXwa98et43_8But4Xsrogiqw8AZeDDmZj9BXMePNe7aHPEBGkLfOdICIXHYu7FNHq8hmOM12r-TqQWmGl5HUX8i8GzNaGyUFsn2R2skZAu_N0-HqMkEQFLoSM9D4yeKMNkVoX9dzUHRM1nxM1DrycLtmy5QsL51Zzk7Iqf0RktXPVlV99_bGeM4zeIrTVLTt6N6ubZQos',
        ];
    @endphp
    <div class="bg-[#f8fafc]  min-h-screen">
        <style>
            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
        </style>
        <div class="mx-auto w-full max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400">
                <a class="hover:text-primary transition-colors" href="#">Home</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <a class="hover:text-primary transition-colors" href="#">Autodesk Inventor</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-slate-900 ">{{ $packageName }}</span>
            </nav>
        </div>

        <main class="mx-auto w-full max-w-7xl grow px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
                <div class="lg:col-span-7 flex flex-col gap-4">
                    <div
                        class="relative aspect-video w-full overflow-hidden rounded-xl bg-white  shadow-lg border border-slate-200 ">
                        <div id="packageMainVideo" class="w-full h-full">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/ArfewyEeXZA"
                                title="Package video" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <img id="packageMainImage" alt="Product Main View" class="h-full w-full object-cover hidden"
                            data-alt="Main product interface screenshot for Drawing and Export tool"
                            src="{{ $packageImage }}" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-3 sm:gap-4" id="packageThumbGrid">
                        @foreach ($package->images as $item)
                            <button type="button"
                                class="packageThumb aspect-video cursor-pointer overflow-hidden rounded-lg border-2 border-slate-200 ring-0 shadow-md transition-all hover:border-primary/70 focus:outline-none"
                                data-src="{{ '/' . $item }}">
                                <img alt="Thumbnail" class="h-full w-full object-cover opacity-100 hover:opacity-90"
                                    src="{{ '/' . $item }}" />
                            </button>
                        @endforeach
                    </div>
                    <div class="mt-8 space-y-4">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-slate-900">{{ $packageName }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {!! $packageDesc !!}
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    @php
                        $pricingOptions = $package->pricing->sortBy('duration_months')->values();
                        $activePricing =
                            $pricingOptions->first() ??
                            (object) [
                                'price' => $packagePrice,
                                'duration_months' => $packageDuration,
                                'currency' => $packageCurrency,
                            ];
                        $activeCurrencySymbol =
                            $activePricing->currency === 'EUR' ? '€' : $activePricing->currency . ' ';
                        $isCoreFreeType = $package->type?->name !== App\Constants\GlobalConstant::TYPE_CORE_FREE;
                        $currentPrice = (float) $activePricing->price;
                        $originalPrice =
                            $pricingOptions->count() > 0
                                ? (float) $pricingOptions->sortByDesc('price')->first()->price
                                : $currentPrice * 1.44;
                        $savingsPercent =
                            $originalPrice > 0 ? (int) round((1 - $currentPrice / $originalPrice) * 100) : 0;
                    @endphp
                    <div
                        class="sticky top-24 rounded-2xl bg-slate-50 dark:bg-slate-800/30 p-6 sm:p-8 shadow-lg border border-slate-200 dark:border-slate-600">
                        {{-- Badge + Title --}}
                        <div class="mb-6">
                            <span
                                class="inline-block px-3 py-1 rounded-md bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-[10px] font-bold uppercase tracking-widest mb-3">{{ $package->type?->name ?? 'Professional Grade' }}</span>
                            <h1
                                class="text-2xl sm:text-3xl font-black leading-tight tracking-tight text-slate-900 dark:text-white uppercase">
                                {{ strtoupper($packageName) }}
                            </h1>
                        </div>

                        {{-- Product details: 2-column layout, label above value --}}
                        <div class="border-t border-slate-200 dark:border-slate-600 pt-6 pb-6">
                            <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                                @foreach ($fakeSpecs as $spec)
                                    <div>
                                        <p
                                            class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">
                                            {{ $spec['label'] }}</p>
                                        <p
                                            class="text-sm font-bold text-slate-900 dark:text-slate-100 {{ !empty($spec['highlight']) ? 'text-emerald-600 dark:text-emerald-400' : '' }}">
                                            {{ $spec['value'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($isCoreFreeType)
                            @if ($pricingOptions->count() > 0)
                                {{-- Subscription plan (only when multiple options to choose from) --}}
                                <div class="border-t border-slate-200 dark:border-slate-600 pt-6 pb-6">
                                    <p
                                        class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-4">
                                        Select subscription plan</p>
                                    <div class="grid grid-cols-3 gap-3">
                                        @foreach ($pricingOptions as $option)
                                            @php
                                                $isActive = $loop->first;
                                                $optionCurrencySymbol =
                                                    $option->currency === 'EUR' ? '€' : $option->currency . ' ';
                                            @endphp
                                            <button type="button" aria-selected="{{ $isActive ? 'true' : 'false' }}"
                                                class="periodBtn rounded-lg border-2 py-3.5 text-sm font-bold transition-all {{ $isActive ? 'bg-[var(--enterprise-blue)] border-[var(--enterprise-blue)] text-white' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:border-[var(--enterprise-blue)]/50' }}"
                                                data-price="{{ number_format((float) $option->price, 2, '.', '') }}"
                                                data-duration="{{ (int) $option->duration_months }}"
                                                data-currency="{{ $optionCurrencySymbol }}">
                                                {{ (int) $option->duration_months }} MO
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Price: original struck, current prominent, savings badge --}}
                            <div class="border-t border-slate-200 dark:border-slate-600 pt-6 pb-6 text-center">
                                @if ($savingsPercent > 0)
                                    <p class="text-sm text-slate-400 dark:text-slate-500 line-through mb-1">
                                        {{ $activeCurrencySymbol }}{{ number_format($originalPrice, 2) }}</p>
                                @endif
                                <p class="flex items-baseline justify-center gap-0.5">
                                    <span
                                        class="text-2xl font-black text-slate-900 dark:text-white align-baseline">{{ $activeCurrencySymbol }}</span>
                                    <span id="packagePrice"
                                        class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">{{ number_format($currentPrice, 2) }}</span>
                                </p>
                                <span id="packageDuration" class="sr-only"
                                    aria-hidden="true">{{ (int) $activePricing->duration_months }} months</span>
                                @if ($savingsPercent > 0)
                                    <span
                                        class="inline-block mt-2 px-2.5 py-1 rounded-md bg-emerald-500 text-white text-[10px] font-bold uppercase tracking-wider">Save
                                        {{ $savingsPercent }}% annually</span>
                                @endif
                            </div>

                            {{-- Buy Now + Guarantee --}}
                            <div class="space-y-4">
                                <button type="button"
                                    class="buyNowPackageBtn w-full flex items-center justify-center gap-2 rounded-xl bg-[var(--enterprise-blue)] py-4 text-base font-bold text-white transition-all hover:bg-blue-700 active:scale-[0.98] shadow-lg"
                                    data-package-id="{{ $package->id }}" data-package-name="{{ $packageName }}"
                                    data-package-detail-url="{{ route('package-detail', $package) }}"
                                    data-package-price="{{ number_format($currentPrice, 2, '.', '') }}"
                                    data-package-period="{{ (int) $activePricing->duration_months }}">
                                    <span class="material-symbols-outlined text-xl">shopping_cart</span>
                                    <span>Buy Now</span>
                                </button>
                                <p
                                    class="flex items-center justify-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="material-symbols-outlined text-base">verified_user</span>
                                    30-Day Money Back Guarantee
                                </p>
                            </div>
                        @else
                            {{-- Core-free: no subscription/price block, just CTA --}}
                            <div class="border-t border-slate-200 dark:border-slate-600 pt-6 space-y-4">
                                <button type="button"
                                    class="getCoreFreeBtn w-full flex items-center justify-center gap-2 rounded-xl bg-[var(--enterprise-blue)] py-4 text-base font-bold text-white transition-all hover:bg-blue-700 active:scale-[0.98] shadow-lg"
                                    data-package-id="{{ $package->id }}" data-package-name="{{ $packageName }}">
                                    <span>Get {{ $packageName }}</span>
                                </button>
                                <p
                                    class="flex items-center justify-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="material-symbols-outlined text-base">verified_user</span>
                                    30-Day Money Back Guarantee
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- <div
            class="flex flex-wrap justify-center items-center gap-8 md:gap-16 py-8 border-y border-slate-200  mb-20 opacity-60">
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">verified</span>
                <span class="font-bold text-lg tracking-tight">AUTODESK CERTIFIED</span>
            </div>
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">security</span>
                <span class="font-bold text-lg tracking-tight">ISO 27001 SECURE</span>
            </div>
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">engineering</span>
                <span class="font-bold text-lg tracking-tight">PRO-ENGINEER GRADE</span>
            </div>
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">public</span>
                <span class="font-bold text-lg tracking-tight">USED BY 500+ FIRMS</span>
            </div>
        </div> --}}
            <div class="w-full py-20">
                <div class="w-full">
                    <div class="flex items-center justify-between mb-10">
                        <h2 class="text-3xl font-bold text-center flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined text-primary text-4xl">inventory_2</span>
                            Included Professional Tools
                        </h2>
                    </div>
                    @php
                        $toolItems = $package->products->count() ? $package->products : collect($fallbackTools);
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div id="toolsCarousel" class="contents">
                            @foreach ($toolItems as $idx => $item)
                                @php
                                    $isModel = is_object($item);
                                    $toolName = $isModel ? $item->name : $item['name'];
                                    $toolPrice = 0;
                                    $toolCurrencySymbol = '€';
                                    if ($isModel) {
                                        $toolPricing = $item->pricing->sortBy('price')->first();
                                        $toolPrice = $toolPricing ? (float) $toolPricing->price : 0;
                                        $toolCurrency = $toolPricing?->currency ?? 'EUR';
                                        $toolCurrencySymbol = $toolCurrency === 'EUR' ? '€' : $toolCurrency . ' ';
                                        // $toolImage = $toolImageSources[$idx % count($toolImageSources)];
                                        $toolImage =
                                            env('APP_URL') . '/' . trim($item?->avatar) ??
                                            $toolImageSources[$idx % count($toolImageSources)];
                                    }
                                @endphp
                                <div class="group bg-white  border-2 border-slate-200  rounded-xl overflow-hidden hover:shadow-lg transition-all {{ $isModel ? 'cursor-pointer' : '' }}"
                                    @if ($isModel) onclick="window.location.href='{{ route('product-detail', $item) }}'"
                                        role="link" tabindex="0"
                                        onkeydown="if(event.key === 'Enter'){ window.location.href='{{ route('product-detail', $item) }}'; }" @endif>
                                    <div class="aspect-square bg-slate-100  p-4">
                                        <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                                            alt="{{ $toolName }}" src="{{ $toolImage }}" />
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-bold text-sm mb-1 truncate">{{ $toolName }}</h4>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[var(--enterprise-blue)] font-bold">
                                                {{ $toolCurrencySymbol }}{{ number_format($toolPrice, 2) }}
                                            </span>
                                            <button
                                                class="addProductToCartBtn w-8 h-8 rounded-full border border-slate-200  flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all"
                                                onclick="event.stopPropagation();"
                                                data-product-id="{{ $isModel ? $item->id : $idx }}"
                                                data-product-name="{{ $toolName }}"
                                                data-product-price="{{ number_format((float) $toolPrice, 2, '.', '') }}"
                                                data-product-currency="{{ $toolCurrencySymbol }}"
                                                data-product-image="{{ $toolImage }}"
                                                data-product-detail-url="{{ $isModel ? route('product-detail', $item) : '' }}">
                                                <span class="material-symbols-outlined !text-sm">add</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- <section class="mb-24">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-black mb-4">Technical Excellence Redefined</h2>
                <p class="text-slate-600 dark:text-slate-400">Specifically engineered for professional CAD designers who
                    demand extreme performance without compromising on detail.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-8 bg-white  border border-slate-200  rounded-2xl hover:border-[var(--enterprise-blue)] transition-all">
                    <div
                        class="w-12 h-12 bg-[var(--enterprise-blue)]/10 text-[var(--enterprise-blue)] rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">bolt</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">40% Faster Rendering</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Proprietary GXL-Acceleration
                        engine reduces compute overhead, allowing real-time viewport feedback even on complex assemblies.
                    </p>
                </div>
                <div
                    class="p-8 bg-white  border border-slate-200  rounded-2xl hover:border-[var(--enterprise-blue)] transition-all">
                    <div
                        class="w-12 h-12 bg-[var(--enterprise-blue)]/10 text-[var(--enterprise-blue)] rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">architecture</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Precision Surfacing</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Advanced G2 and G3 continuity
                        algorithms for automotive-grade surfaces and perfect curvature analysis directly within Inventor.
                    </p>
                </div>
                <div
                    class="p-8 bg-white  border border-slate-200  rounded-2xl hover:border-[var(--enterprise-blue)] transition-all">
                    <div
                        class="w-12 h-12 bg-[var(--enterprise-blue)]/10 text-[var(--enterprise-blue)] rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">history</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Parametric History</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Fully non-destructive editing
                        workflow. Modify upstream features and watch your surfacing adapt instantly without errors.</p>
                </div>
            </div>
        </section> --}}

            <section class="mb-24">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Save More with Bundles</h2>
                        <p class="text-slate-600 dark:text-slate-400">Maximize your toolset while minimizing your costs.
                        </p>
                    </div>
                    <a class="text-[var(--enterprise-blue)] font-bold text-sm flex items-center gap-1 hover:underline"
                        href="#">
                        View All Bundles <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div
                        class="group relative overflow-hidden rounded-2xl border-2 border-slate-200 bg-[var(--enterprise-blue)]/5 p-1 transition-all hover:shadow-2xl hover:shadow-blue-900/10">
                        <div class="absolute top-4 right-4 z-10">
                            <span
                                class="bg-[var(--enterprise-blue)] text-white text-[10px] font-black px-2 py-1 rounded uppercase tracking-tighter">Most
                                Popular</span>
                        </div>
                        <div class="bg-white  p-8 rounded-xl h-full flex flex-col">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-2xl font-black text-slate-900 ">Automation Master Pack</h3>
                                    <p class="text-slate-500 text-sm mt-1 italic">Includes Modeling Suite 2.0 + 4 others
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-slate-400 line-through text-sm">$899</p>
                                    <p class="text-3xl font-black text-[var(--enterprise-blue)]">$549</p>
                                </div>
                            </div>
                            <ul class="space-y-3 mb-8 flex-grow">
                                <li class="flex items-center gap-2 text-sm">
                                    <span class="material-symbols-outlined text-green-500 !text-lg">check_circle</span>
                                    <span>Modeling Suite 2.0 (Full Version)</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm">
                                    <span class="material-symbols-outlined text-green-500 !text-lg">check_circle</span>
                                    <span>Scripting Engine Pro</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm">
                                    <span class="material-symbols-outlined text-green-500 !text-lg">check_circle</span>
                                    <span>Batch Export Toolkit</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm text-slate-400">
                                    <span class="material-symbols-outlined !text-lg">add</span>
                                    <span>2 additional automation tools</span>
                                </li>
                            </ul>
                            <button
                                class="w-full bg-[var(--enterprise-blue)] text-white py-3 rounded-lg font-bold hover:brightness-110 transition-all">
                                Upgrade to Bundle
                            </button>
                        </div>
                    </div>
                    <div
                        class="group relative overflow-hidden rounded-2xl border-2 border-slate-200  bg-slate-100/50 /50 p-8 transition-all hover:shadow-xl">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 ">Ultimate Inventor Suite</h3>
                                <p class="text-slate-500 text-sm mt-1 italic">Complete tool catalog access</p>
                            </div>
                            <div class="text-right">
                                <p class="text-slate-400 line-through text-sm">$1,499</p>
                                <p class="text-3xl font-black text-slate-900 ">$999</p>
                            </div>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[var(--enterprise-blue)] !text-lg">token</span>
                                <span>Every DI-TOOL ever released</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[var(--enterprise-blue)] !text-lg">token</span>
                                <span>Priority 24/7 Technical Support</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[var(--enterprise-blue)] !text-lg">token</span>
                                <span>Enterprise Multi-seat Licensing</span>
                            </li>
                        </ul>
                        <button
                            class="w-full bg-slate-900 dark:bg-white dark:text-slate-900 text-white py-3 rounded-lg font-bold hover:opacity-90 transition-all">
                            Buy Ultimate Suite
                        </button>
                    </div>
                </div>
            </section>

            <section class="mb-20">
                <h2 class="text-2xl font-black mb-8">Frequently Bought Together</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div
                        class="group bg-white  border-2 border-slate-200  rounded-xl overflow-hidden hover:shadow-lg transition-all">
                        <div class="aspect-square bg-slate-100  p-4">
                            <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                                data-alt="Technical icon for a rendering engine plugin"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuADz2fKqgxIvjaTj5-lGjwoNT8MCRI9OeB4VkBT9SfnOC-ejIGeSk2nZSzNi2tc9JY93KvGyMOmiKy8tcO0x3xjIw5jGCzLUci29fvhdZu98X_1JxqPLpbXHZ3Ym4g-7Cl4fUuzlgFhK4dZ2l2swKfmJbPbHDofoao3kqPWr2q94KpXn6N5Qv4CxRwEuB5YLgYmO9Pc1wu_Vi97_Egr6ITV3YeNLW5timi7sAh0xCzyu4iTEQKofUhBqDK_sasUb1I0nsMoYPf8AvQ" />
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-sm mb-1 truncate">RenderPro Engine</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-[var(--enterprise-blue)] font-bold">$79</span>
                                <button
                                    class="w-8 h-8 rounded-full border border-slate-200  flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                    <span class="material-symbols-outlined !text-sm">add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white  border-2 border-slate-200  rounded-xl overflow-hidden hover:shadow-lg transition-all">
                        <div class="aspect-square bg-slate-100  p-4">
                            <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                                data-alt="Technical dashboard UI representing data analysis tool"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9u23NQRZqmg3IXYfIWNTXAFL7WsUsGqHdoGVLnNdK7IR6NMfqnxmfJ2129c5BEcdDq4ks2W9JKqUKWOmDOKk5cxuBmZlxgqmMvXxJTuq6SPcmruZIWUuDvt3lrP7KkmdtHLj_bzhmC2C66RWM2kgjbnQh-APZToYvnUXF6zKJ46TRkyzrfckVOzzj6S3m5HVpJEgHJUa9ud3-WaHYg-za064cNSOi6VpxM4OaDjBv1VTf8HX2g8VUf_vzzExLjwXkItLbAcjksQQ" />
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-sm mb-1 truncate">Material Library XL</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-[var(--enterprise-blue)] font-bold">$49</span>
                                <button
                                    class="w-8 h-8 rounded-full border border-slate-200  flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                    <span class="material-symbols-outlined !text-sm">add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white  border-2 border-slate-200  rounded-xl overflow-hidden hover:shadow-lg transition-all">
                        <div class="aspect-square bg-slate-100  p-4">
                            <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                                data-alt="Abstract hardware chip representing optimization plugin"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9I9gE16lI_z4bFCY2M0qEe9EU-Dv3T8j4_cpEc1n3ronut_jQ_LX-_hwf47yXpe2xuYOTtR5FbQiuoYbMJiRSppBvJOQVPfDMuMvm-sSYIoFX37p4o7NrO56SddRIC3-kKN_sR9NQbsW3jpodY1phzOfvHpzuqqRm3mYZ06rvtNB3To6dH7Qn2QdtXtQtK5MMeHk4DDn-USfNovMi9Df3n5CXRcQVHvRl1wfaoZC4dhaP3oEZdZvs-7oRXwBmsdFDfUKifMcqI70" />
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-sm mb-1 truncate">Constraint Solver Pro</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-[var(--enterprise-blue)] font-bold">$129</span>
                                <button
                                    class="w-8 h-8 rounded-full border border-slate-200  flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                    <span class="material-symbols-outlined !text-sm">add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white  border-2 border-slate-200  rounded-xl overflow-hidden hover:shadow-lg transition-all">
                        <div class="aspect-square bg-slate-100  p-4">
                            <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                                data-alt="Network server representing cloud integration tool"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuD8lbZUTGd1GLg5HcHiZ1PADrs7-7Pw0CU5rwiAISq3Khpqu_ufOto0OrYiTpHuhdopfYOXwa98et43_8But4Xsrogiqw8AZeDDmZj9BXMePNe7aHPEBGkLfOdICIXHYu7FNHq8hmOM12r-TqQWmGl5HUX8i8GzNaGyUFsn2R2skZAu_N0-HqMkEQFLoSM9D4yeKMNkVoX9dzUHRM1nxM1DrycLtmy5QsL51Zzk7Iqf0RktXPVlV99_bGeM4zeIrTVLTt6N6ubZQos" />
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-sm mb-1 truncate">Cloud Sync Utility</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-[var(--enterprise-blue)] font-bold">$29</span>
                                <button
                                    class="w-8 h-8 rounded-full border border-slate-200  flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                    <span class="material-symbols-outlined !text-sm">add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
@push('scripts')
    <script>
        // $(document).on('click', '.periodBtn', function() {
        //     const $btn = $(this);
        //     const price = $btn.data('price') ?? '0.00';
        //     const duration = $btn.data('duration') ?? '0';
        //     const currency = $btn.data('currency') ?? '';
        //     const formatted = Number(price).toLocaleString(undefined, {
        //         minimumFractionDigits: 2,
        //         maximumFractionDigits: 2
        //     });

        //     console.log(`Price: ${price}, Duration: ${duration}, Currency: ${currency}, Formatted: ${formatted}`);
        //     $('#packagePrice').text(`${currency}${formatted}`);
        //     $('#packageDuration').text(`/ ${duration} months`);
        // });

        $(document).ready(function() {
            const $priceEl = $('#packagePrice');
            const $durationEl = $('#packageDuration');
            const $buttons = $('.periodBtn');
            if ($priceEl.length === 0 || $durationEl.length === 0 || $buttons.length === 0) return;

            var selectedClass = 'bg-[var(--enterprise-blue)] border-[var(--enterprise-blue)] text-white';
            var unselectedClass =
                'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:border-[var(--enterprise-blue)]/50';

            $buttons.on('click', function() {
                const $btn = $(this);
                $buttons.removeClass(selectedClass).addClass(unselectedClass).attr('aria-selected',
                    'false');
                $btn.removeClass(unselectedClass).addClass(selectedClass).attr('aria-selected', 'true');

                const price = $btn.data('price') ?? '0.00';
                const duration = $btn.data('duration') ?? '0';
                const currency = $btn.data('currency') ?? '';
                const formatted = Number(price).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $priceEl.text(formatted);
                if (typeof $durationEl.text === 'function') $durationEl.text(duration > 0 ?
                    `/ ${duration} months` : 'one-time');
            });

            // Default to first period option on load
            $buttons.first().trigger('click');
        });
    </script>
    <script>
        // Lightweight top-right toast for add-to-cart feedback.
        window.showAddToCartToast = function(message) {
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

            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-[-8px]');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-[-8px]');
                setTimeout(() => toast.remove(), 300);
            }, 1800);
        };
    </script>
    <script>
        $(document).ready(function() {
            const $addBtn = $('.addToCartBtn');
            if ($addBtn.length === 0) return;

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

            $addBtn.on('click', function() {
                const $selected = $('.periodBtn.border-primary');
                const price = $selected.data('price') ?? 0;
                const duration = ($selected.data('duration') ?? '').toString();
                const name = $(this).data('package-name') || 'Package';
                const rawId = $(this).data('package-id') || null;
                const id = String(rawId ?? '');
                const image = $('#packageMainImage').attr('src') || '';

                const item = {
                    id,
                    name,
                    price: Number(price) || 0,
                    period: duration,
                    qty: 1,
                    type: 'package',
                    image
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

                if (typeof window.showAddToCartToast === 'function') {
                    window.showAddToCartToast(`${name} added to cart`);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const $addProductBtn = $('.addProductToCartBtn');
            if ($addProductBtn.length === 0) return;

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

            $addProductBtn.on('click', function() {
                const id = $(this).data('product-id');
                const name = $(this).data('product-name') || 'Product';
                const price = Number($(this).data('product-price')) || 0;
                const period = ($(this).data('product-currency') || '').trim();
                const image = $(this).data('product-image') || '';
                const detailUrl = $(this).data('product-detail-url') || '';

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
                    String(it.id ?? '') === String(item.id)
                );
                if (existingIdx >= 0) {
                    items[existingIdx].qty = (items[existingIdx].qty || 1) + 1;
                } else {
                    items.push(item);
                }
                setCart(items);
                window.dispatchEvent(new Event('cart:updated'));

                if (typeof window.showAddToCartToast === 'function') {
                    window.showAddToCartToast(`${name} added to cart`);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const $buyNowBtn = $('.buyNowPackageBtn');
            if ($buyNowBtn.length === 0) return;

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

            $buyNowBtn.on('click', function() {
                const $selected = $('.periodBtn[aria-selected="true"]').length ? $(
                    '.periodBtn[aria-selected="true"]') : $('.periodBtn').first();
                const hasPeriodButtons = $('.periodBtn').length > 0;
                const price = hasPeriodButtons ? ($selected.data('price') ?? 0) : ($(this).data(
                    'package-price') ?? $('#packagePrice').text() || 0);
                const duration = hasPeriodButtons ? ($selected.data('duration') ?? '').toString() : ($(this)
                    .data('package-period') ?? '').toString();
                const name = $(this).data('package-name') || 'Package';
                const rawId = $(this).data('package-id') || null;
                const id = String(rawId ?? '');
                const image = $('#packageMainImage').attr('src') || '';
                const detailUrl = $(this).data('package-detail-url') || '';

                const item = {
                    id,
                    name,
                    price: Number(price) || 0,
                    period: duration,
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
        $(document).ready(function() {
            const $mainImg = $('#packageMainImage');
            const $mainVideo = $('#packageMainVideo');
            const $videoIframe = $('#packageMainVideo iframe');
            const $thumbs = $('.packageThumb');

            const clearActive = () => {
                $thumbs.removeClass('border-primary ring-2 ring-primary ring-offset-2')
                    .addClass('border-slate-200 ring-0');
            };

            const showImage = (src) => {
                $mainVideo.addClass('hidden');
                $videoIframe.attr('src', '');
                $mainImg.removeClass('hidden').attr('src', src);
            };

            const showVideo = (src) => {
                $mainImg.addClass('hidden');
                $mainVideo.removeClass('hidden');
                if (src) {
                    $videoIframe.attr('src', src);
                }
            };

            if ($thumbs.length) {
                clearActive();
                $thumbs.first().addClass('border-primary ring-2 ring-primary ring-offset-2')
                    .removeClass('border-slate-200 ring-0');
            }

            $thumbs.on('click', function() {
                const $btn = $(this);
                const src = $btn.data('src');
                if (!src) return;
                clearActive();
                $btn.addClass('border-primary ring-2 ring-primary ring-offset-2')
                    .removeClass('border-slate-200 ring-0');
                showImage(src);
            });
        });

        $(document).on('click', '.getCoreFreeBtn', function() {
            $('#downloadModal').removeClass('hidden');
        });
    </script>
@endpush
