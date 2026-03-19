@php
    $pricing = $package->pricing->sortBy('price')->first();
    $price = $pricing ? (float) $pricing->price : 0;
    $currency = $pricing?->currency ?? 'EUR';
    $currencySymbol = $currency === 'EUR' ? '€' : $currency . ' ';
    $fallbackImage =
        $package->avatar ?:
        'https://lh3.googleusercontent.com/aida-public/AB6AXuD0xn8klFRg-K-wRgdq9BzT8p7YQbk6CjpWvfNLtc2vdCkRslFovVEeXhTTPi8n6Wg4kQk6g5XGMAA9Eje2zDvPqgmIT-5DGhYHSfGg8_3ikow9PiqSqnjhbl4vKZrJGIdPvdSeyLeVSba8OMJLs1VMbFXsof6nhoC7sGi9QImZ1nT5NHC9Go5RlZWKq_GowsX26ajNPYPCPWaol77sCdSPRs-kfLoBSSMaOb37ctMPwcUx8bTWWT9eDcj23XJ1ltEnAAZOQQvyBjI';
    $desc = $package->description ?: 'Curated tools for rapid deployment and consistent results.';
    $isCoreFree = $package->type?->name === App\Constants\GlobalConstant::TYPE_CORE_FREE;
    $badgeLabel = $isCoreFree ? 'Free' : 'Package';
    $ctaSizeClass = $ctaSizeClass ?? 'h-12';
@endphp

<div
    class="group flex flex-col rounded-[32px] overflow-hidden transition-all duration-500 cursor-pointer {{ $isCoreFree ? 'core-free-card shadow-lg' : 'pro-card shadow-2xl hover:scale-[1.02] ring-1 ring-blue-500/30' }}"
    onclick="if (event.target.closest('button')) return; window.location.href='{{ route('package-detail', $package) }}'" role="button" tabindex="0"
    onkeydown="if (event.key === 'Enter' && !event.target.closest('button')) window.location.href='{{ route('package-detail', $package) }}'">
    <div class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px] {{ $isCoreFree ? 'bg-slate-50' : '' }}">
        <img alt="{{ $package->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            src="{{ $fallbackImage }}" />
        <div class="absolute top-4 left-4">
            <span
                class="{{ $isCoreFree ? 'bg-blue-600 text-white' : 'bg-gradient-to-r from-blue-400 to-blue-600 text-white' }} px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                {{ $badgeLabel }}
            </span>
        </div>
    </div>
    <div class="p-8 pt-4 flex flex-col flex-1 text-center">
        <h3 class="text-xl {{ $isCoreFree ? 'font-black text-[var(--enterprise-blue)]' : 'font-black text-white' }}">
            {{ $package->name }}
        </h3>
        @if ($isCoreFree)
            <p class="text-slate-600 text-sm mt-3 leading-relaxed">
                {{ $desc }}
            </p>
        @else
            <div class="mt-4 flex justify-center">
                <ul class="space-y-2 text-xs text-blue-100/70 font-medium text-left inline-block">
                    @forelse ($package->products->take(4) as $product)
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined glow-check text-base">check_circle</span>
                            <span class="text-xs text-blue-50 font-semibold tracking-wide uppercase leading-snug">
                                {{ $product->name }}
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
                    <span class="text-4xl text-white font-black tracking-tight">
                        {{ $currencySymbol }}{{ number_format($price, 2) }}
                    </span>
                </div>
                <button type="button"
                    class="buyPackageNowBtn w-full {{ $ctaSizeClass }} text-sm font-black rounded-2xl transition-all shadow-lg hover:bg-blue-700 bg-[#137fec] text-white flex items-center justify-center"
                    data-package-id="{{ $package->id }}" data-bundle-name="{{ $package->name }}"
                    data-bundle-price="{{ $price }}" data-bundle-image="{{ $fallbackImage }}"
                    data-bundle-period="{{ $pricing?->duration_months ?? '' }}"
                    data-bundle-detail-url="{{ route('package-detail', $package) }}"
                    data-bundle-items="{{ $package->products->pluck('name')->implode(',') }}">
                    <span class="inline-flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">shopping_cart</span>
                        <span>BUY NOW</span>
                    </span>
                </button>
            @elseif ($isCoreFree)
                <button type="button"
                    class="getCoreFreeBtn w-full {{ $ctaSizeClass }} text-sm font-black rounded-2xl transition-all shadow-lg hover:bg-blue-700 bg-[#137fec] text-white flex items-center justify-center gap-2"
                    data-download-entity-type="package" data-download-entity-id="{{ $package->id }}"
                    data-download-entity-name="{{ $package->name }}">
                    <span class="material-symbols-outlined text-lg">download</span>
                    <span>GET CORE-FREE</span>
                </button>
            @else
                <button type="button" onclick="window.location.href='{{ route('package-detail', $package) }}'"
                    class="w-full {{ $ctaSizeClass }} text-sm font-black rounded-2xl transition-all shadow-lg hover:bg-blue-700 bg-[#137fec] text-white flex items-center justify-center">
                    <span>COMING SOON</span>
                </button>
            @endif
        </div>
    </div>
</div>
