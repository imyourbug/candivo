@extends('layouts.main')

@section('title', 'Premium Di-tool Experience | Enterprise CAD Solutions')

@push('styles')
@endpush

@section('content')
    <section class="relative h-[850px] w-full overflow-hidden bg-slate-900 group" id="heroCarousel">
        <!-- Slide 1 -->
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-100" data-slide="0">
            <img alt="Industrial Engineering" class="absolute inset-0 w-full h-full object-cover"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaaOCAJfB_wQimtec2AgHNqZ7hLUljB046ysVnbgyvG3BsckvZW2X71gbSJDiQ7aBsXAJHMlY1eQ31iqEsardnfjSExfkOaoGffufIKKKoUjf0CNLTae1BjkX-dY7AS6h5Mdel2N4slAaeWbnOBt4COwMznqCfxUezTwKhZjqPpIqNNIEsvFMk8hrNgIMM68Gvf8Gsm9y3o7442M9wKvejJKI_8OsfFiPd9h3aNq0KehFce4kUx9Xvmcrl-Hrvn84ofKyx9q5fTA4" />
            <div
                class="absolute inset-0 bg-gradient-to-r from-[var(--enterprise-blue)]/90 via-[var(--enterprise-blue)]/40 to-transparent">
            </div>
            <div class="relative h-full max-w-7xl mx-auto px-10 lg:px-16 flex flex-col justify-center">
                <div class="max-w-3xl">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold tracking-widest uppercase mb-8 border border-blue-500/20">
                        <span class="size-1.5 bg-blue-400 rounded-full animate-pulse"></span>
                        Next-Gen CAD Solutions
                    </span>
                    <h1 class="text-6xl lg:text-8xl font-black text-white leading-[0.95] tracking-tighter mb-8">
                        Engineered for <br /><span class="text-blue-400">Performance.</span>
                    </h1>
                    <p class="text-blue-50/80 text-xl lg:text-2xl max-w-xl mb-12 leading-relaxed">
                        The definitive toolkit for Autodesk Inventor professionals. Automate complexities and drive
                        innovation at scale.
                    </p>
                    <div class="flex items-center gap-6">
                        <button
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all">
                            Get Started Now
                        </button>
                        <button
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all">
                            Watch Demo
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="1">
            <img alt="Precision Engineering" class="absolute inset-0 w-full h-full object-cover"
                src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2070" />
            <div
                class="absolute inset-0 bg-gradient-to-r from-[var(--enterprise-blue)]/90 via-[var(--enterprise-blue)]/40 to-transparent">
            </div>
            <div class="relative h-full max-w-7xl mx-auto px-10 lg:px-16 flex flex-col justify-center">
                <div class="max-w-3xl">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold tracking-widest uppercase mb-8 border border-blue-500/20">
                        <span class="size-1.5 bg-blue-400 rounded-full"></span>
                        Unmatched Precision
                    </span>
                    <h1 class="text-6xl lg:text-8xl font-black text-white leading-[0.95] tracking-tighter mb-8">
                        Mastering <br /><span class="text-blue-400">Complexity.</span>
                    </h1>
                    <p class="text-blue-50/80 text-xl lg:text-2xl max-w-xl mb-12 leading-relaxed">
                        Deploy advanced logic and modeling tools that handle the most intricate industrial designs with
                        surgical accuracy.
                    </p>
                    <div class="flex items-center gap-6">
                        <button
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all">
                            Learn More
                        </button>
                        <button
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all">
                            View Case Studies
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="2">
            <img alt="Digital Twin Automation" class="absolute inset-0 w-full h-full object-cover"
                src="https://images.unsplash.com/photo-1537462715879-360eeb61a0ad?auto=format&fit=crop&q=80&w=2070" />
            <div
                class="absolute inset-0 bg-gradient-to-r from-[var(--enterprise-blue)]/90 via-[var(--enterprise-blue)]/40 to-transparent">
            </div>
            <div class="relative h-full max-w-7xl mx-auto px-10 lg:px-16 flex flex-col justify-center">
                <div class="max-w-3xl">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold tracking-widest uppercase mb-8 border border-blue-500/20">
                        <span class="size-1.5 bg-blue-400 rounded-full"></span>
                        Intelligent Workflows
                    </span>
                    <h1 class="text-6xl lg:text-8xl font-black text-white leading-[0.95] tracking-tighter mb-8">
                        Automate <br /><span class="text-blue-400">Excellence.</span>
                    </h1>
                    <p class="text-blue-50/80 text-xl lg:text-2xl max-w-xl mb-12 leading-relaxed">
                        Transform manual tasks into high-speed automated pipelines. Redefine what your engineering team can
                        achieve in a day.
                    </p>
                    <div class="flex items-center gap-6">
                        <button
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all">
                            Explore Automation
                        </button>
                        <button
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all">
                            Request Demo
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="3">
            <img alt="Industrial Scalability" class="absolute inset-0 w-full h-full object-cover"
                src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&q=80&w=2070" />
            <div
                class="absolute inset-0 bg-gradient-to-r from-[var(--enterprise-blue)]/90 via-[var(--enterprise-blue)]/40 to-transparent">
            </div>
            <div class="relative h-full max-w-7xl mx-auto px-10 lg:px-16 flex flex-col justify-center">
                <div class="max-w-3xl">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold tracking-widest uppercase mb-8 border border-blue-500/20">
                        <span class="size-1.5 bg-blue-400 rounded-full"></span>
                        Global Infrastructure
                    </span>
                    <h1 class="text-6xl lg:text-8xl font-black text-white leading-[0.95] tracking-tighter mb-8">
                        Scale at <br /><span class="text-blue-400">Velocity.</span>
                    </h1>
                    <p class="text-blue-50/80 text-xl lg:text-2xl max-w-xl mb-12 leading-relaxed">
                        The enterprise backbone for global design teams. Seamless integration across multiple sites and
                        cloud ecosystems.
                    </p>
                    <div class="flex items-center gap-6">
                        <button
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all">
                            Solutions Overview
                        </button>
                        <button
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all">
                            Contact Sales
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navigation Arrows -->
        <button
            class="carousel-prev absolute left-8 top-1/2 -translate-y-1/2 size-16 rounded-full bg-white/10 backdrop-blur-lg border border-white/20 text-white flex items-center justify-center hover:bg-white/20 hover:scale-110 transition-all z-20 opacity-0 group-hover:opacity-100">
            <span class="material-symbols-outlined text-3xl">chevron_left</span>
        </button>
        <button
            class="carousel-next absolute right-8 top-1/2 -translate-y-1/2 size-16 rounded-full bg-white/10 backdrop-blur-lg border border-white/20 text-white flex items-center justify-center hover:bg-white/20 hover:scale-110 transition-all z-20 opacity-0 group-hover:opacity-100">
            <span class="material-symbols-outlined text-3xl">chevron_right</span>
        </button>
        <!-- Dot Indicators -->
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex gap-4 z-20" id="paginationDots">
            <button class="carousel-dot w-12 h-1.5 bg-white rounded-full transition-all cursor-pointer"
                data-slide="0"></button>
            <button class="carousel-dot w-3 h-1.5 bg-white/30 rounded-full hover:bg-white/50 transition-all cursor-pointer"
                data-slide="1"></button>
            <button class="carousel-dot w-3 h-1.5 bg-white/30 rounded-full hover:bg-white/50 transition-all cursor-pointer"
                data-slide="2"></button>
            <button class="carousel-dot w-3 h-1.5 bg-white/30 rounded-full hover:bg-white/50 transition-all cursor-pointer"
                data-slide="3"></button>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            let currentSlide = 0;
            const $slides = $('.carousel-slide');
            const totalSlides = $slides.length;
            const $dots = $('.carousel-dot');
            let autoSlideTimer;

            function showSlide(n) {
                $slides.each(function(index) {
                    $(this).toggleClass('opacity-100', index === n)
                        .toggleClass('opacity-0', index !== n)
                        .toggleClass('pointer-events-none', index !== n);
                });

                $dots.each(function(index) {
                    if (index === n) {
                        $(this).css('width', '48px').removeClass('w-3').addClass('w-12').css(
                            'background-color', 'white').css('opacity', '1');
                    } else {
                        $(this).css('width', '12px').removeClass('w-12').addClass('w-3').css(
                            'background-color', 'rgba(255,255,255,0.3)').css('opacity', '0.5');
                    }
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
                resetAutoSlide();
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(currentSlide);
                resetAutoSlide();
            }

            function resetAutoSlide() {
                clearInterval(autoSlideTimer);
                autoSlideTimer = setInterval(nextSlide, 5000);
            }

            $('.carousel-next').on('click', nextSlide);
            $('.carousel-prev').on('click', prevSlide);

            $dots.on('click', function() {
                currentSlide = $(this).data('slide');
                showSlide(currentSlide);
                resetAutoSlide();
            });

            // Initialize
            showSlide(0);
            autoSlideTimer = setInterval(nextSlide, 5000);
        });
    </script>
    <section class="relative py-24 bg-white combo-grid-pattern">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <span
                        class="text-[var(--accent-blue)] text-xs font-black uppercase tracking-widest mb-3 block">Optimized
                        Workflows</span>
                    <h2 class="text-4xl font-black text-[var(--enterprise-blue)] tracking-tight">Featured Combos</h2>
                </div>
                <a class="group flex items-center gap-2 text-[var(--enterprise-blue)] font-bold text-sm hover:text-[var(--accent-blue)] transition-colors"
                    href="#">
                    Explore all Combos
                    <span
                        class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_right_alt</span>
                </a>
            </div>
            <div class="grid grid-cols-1 gap-8">
                <div
                    class="group relative flex flex-col lg:flex-row bg-white rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="lg:w-1/3 relative h-64 lg:h-auto overflow-hidden">
                        <img alt="Starter Combo"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0xn8klFRg-K-wRgdq9BzT8p7YQbk6CjpWvfNLtc2vdCkRslFovVEeXhTTPi8n6Wg4kQk6g5XGMAA9Eje2zDvPqgmIT-5DGhYHSfGg8_3ikow9PiqSqnjhbl4vKZrJGIdPvdSeyLeVSba8OMJLs1VMbFXsof6nhoC7sGi9QImZ1nT5NHC9Go5RlZWKq_GowsX26ajNPYPCPWaol77sCdSPRs-kfLoBSSMaOb37ctMPwcUx8bTWWT9eDcj23XJ1ltEnAAZOQQvyBjI" />
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent"></div>
                    </div>
                    <div class="flex-1 p-10 lg:p-12 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                        <div class="max-w-md">
                            <div
                                class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-[var(--accent-blue)] text-[10px] font-extrabold uppercase tracking-widest mb-4">
                                Foundation Pack</div>
                            <h3 class="text-3xl font-black text-[var(--enterprise-blue)] mb-4">Starter Combo</h3>
                            <div class="flex flex-wrap items-center gap-3 text-slate-500">
                                <span
                                    class="flex items-center gap-1.5 py-1 px-3 bg-slate-50 rounded-lg text-xs font-semibold">Modeling
                                    Suite</span>
                                <span class="material-symbols-outlined text-slate-300 text-sm">add</span>
                                <span
                                    class="flex items-center gap-1.5 py-1 px-3 bg-slate-50 rounded-lg text-xs font-semibold">Simulation
                                    Lite</span>
                                <span class="material-symbols-outlined text-slate-300 text-sm">add</span>
                                <span
                                    class="flex items-center gap-1.5 py-1 px-3 bg-slate-50 rounded-lg text-xs font-semibold">Cloud
                                    Sync</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center lg:items-end lg:text-right min-w-[200px]">
                            <div class="mb-6 text-center lg:text-right">
                                <span class="text-slate-300 text-sm line-through font-medium block mb-1">$849.00</span>
                                <span
                                    class="text-4xl font-black text-[var(--enterprise-blue)] tracking-tight">$649.00</span>
                            </div>
                            <button
                                class="buyBundleBtn w-full lg:w-auto px-10 py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all shadow-lg shadow-blue-900/10 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-xl">shopping_cart</span>
                                Buy Bundle
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="group relative flex flex-col lg:flex-row bg-white rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="lg:w-1/3 relative h-64 lg:h-auto overflow-hidden">
                        <img alt="Enterprise Stack"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuABiuR3EtpFe7mIKUqtUleN7jxNUwJHyaX4f444l0nXna-mbpS_TTTQFVYxdzPcL7zZ5KLSiZ0JQxUE-0-AQlofogRoRXJq6v8YtmeS9ZqI3AHDN1fVnkMQLLFMfOfeG2vQIwR6dtsbCTCWYvl6gfnmu9Iv9wjXbFKH-Z5hXsifmpNlzii0TKZOUs-sDUXiUCvQVzX-RosgPdyc8Am5nR8-JnDje3cBRFe2-eoFa2Ruv9AeD8XaIuLfCnL6EU69DDsNvgybAgrNsFs" />
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent"></div>
                        <div class="absolute top-6 left-6">
                            <span
                                class="bg-blue-600 text-white px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-xl">Top
                                Choice</span>
                        </div>
                    </div>
                    <div class="flex-1 p-10 lg:p-12 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                        <div class="max-w-md">
                            <div
                                class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-[var(--accent-blue)] text-[10px] font-extrabold uppercase tracking-widest mb-4">
                                Advanced Workflow</div>
                            <h3 class="text-3xl font-black text-[var(--enterprise-blue)] mb-4">Enterprise Stack</h3>
                            <div class="flex flex-wrap items-center gap-3 text-slate-500">
                                <span
                                    class="flex items-center gap-1.5 py-1 px-3 bg-slate-50 rounded-lg text-xs font-semibold">Automation
                                    Pro</span>
                                <span class="material-symbols-outlined text-slate-300 text-sm">add</span>
                                <span
                                    class="flex items-center gap-1.5 py-1 px-3 bg-slate-50 rounded-lg text-xs font-semibold">Data
                                    Manager</span>
                                <span class="material-symbols-outlined text-slate-300 text-sm">add</span>
                                <span
                                    class="flex items-center gap-1.5 py-1 px-3 bg-slate-50 rounded-lg text-xs font-semibold">API
                                    Access</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center lg:items-end lg:text-right min-w-[200px]">
                            <div class="mb-6 text-center lg:text-right">
                                <span class="text-slate-300 text-sm line-through font-medium block mb-1">$1,649.00</span>
                                <span
                                    class="text-4xl font-black text-[var(--enterprise-blue)] tracking-tight">$1,299.00</span>
                            </div>
                            <button
                                class="buyBundleBtn w-full lg:w-auto px-10 py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all shadow-lg shadow-blue-900/10 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-xl">shopping_cart</span>
                                Buy Bundle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @foreach ($allTypes as $type)
        @if (!$loop->first)
            <div class="max-w-7xl mx-auto px-10 lg:px-16">
                <div class="my-10 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
            </div>
        @endif
        <section class="max-w-7xl mx-auto px-10 lg:px-16">
            @php
                $packages = $type->packages;
            @endphp
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-10 gap-8">
                <div class="max-w-2xl">
                    {{-- <span
                        class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 bg-slate-50 border border-slate-100 px-3 py-1 rounded-full mb-4">
                        Category
                    </span> --}}
                    <h2 class="text-4xl lg:text-5xl font-black text-[var(--enterprise-blue)] tracking-tight">
                        {{ $type->name }}
                    </h2>
                    <p class="text-slate-500 text-lg mt-6 leading-relaxed">Precision-engineered packages tailored to
                        specific
                        engineering roles, from rapid prototyping to enterprise data management.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10 mb-10">
                @forelse ($packages as $package)
                    @php
                        $pricing = $package->pricing->sortBy('price')->first();
                        $price = $pricing ? (float) $pricing->price : 0;
                        $currency = $pricing?->currency ?? 'EUR';
                        $currencySymbol = $currency === 'EUR' ? '€' : $currency . ' ';
                        $badge = 'Package';
                        $fallbackImage =
                            $package->avatar ?:
                            'https://lh3.googleusercontent.com/aida-public/AB6AXuD0xn8klFRg-K-wRgdq9BzT8p7YQbk6CjpWvfNLtc2vdCkRslFovVEeXhTTPi8n6Wg4kQk6g5XGMAA9Eje2zDvPqgmIT-5DGhYHSfGg8_3ikow9PiqSqnjhbl4vKZrJGIdPvdSeyLeVSba8OMJLs1VMbFXsof6nhoC7sGi9QImZ1nT5NHC9Go5RlZWKq_GowsX26ajNPYPCPWaol77sCdSPRs-kfLoBSSMaOb37ctMPwcUx8bTWWT9eDcj23XJ1ltEnAAZOQQvyBjI';
                        $desc = $package->description ?: 'Curated tools for rapid deployment and consistent results.';
                    @endphp
                    <div
                        class="group flex flex-col glass-card rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-blue-1900/10 transition-all duration-500">
                        <div class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px]">
                            <img alt="{{ $package->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                src="{{ $fallbackImage }}" />
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/95 backdrop-blur-sm text-[var(--enterprise-blue)] px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                                    {{ $badge }}
                                </span>
                            </div>
                        </div>
                        <div class="p-8 pt-4 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-[var(--enterprise-blue)]">{{ $package->name }}</h3>
                            <p class="text-slate-500 text-sm mt-3 leading-relaxed">
                                {{ $desc }}
                            </p>
                            <div class="mt-auto pt-8 flex flex-col items-center">
                                <div class="flex flex-col items-center mb-6">
                                    <span class="text-3xl font-black text-[var(--enterprise-blue)] tracking-tight">
                                        {{ $currencySymbol }}{{ number_format($price, 2) }}
                                    </span>
                                </div>
                                <button onclick="window.location.href='{{ route('package-detail', $package) }}'"
                                    class="w-full py-4 bg-white text-[var(--enterprise-blue)] text-sm font-bold rounded-2xl hover:bg-gray-200 transition-all active:scale-[0.98] shadow-lg shadow-blue-900/10 mb-4 border-slate-200 border inline-flex items-center justify-center gap-2 whitespace-nowrap leading-none"
                                    data-bundle-name="{{ $package->name }}" data-bundle-price="{{ $price }}"
                                    data-bundle-image="{{ $fallbackImage }}"
                                    data-bundle-items="{{ $package->products->pluck('name')->implode(',') }}">
                                    <span class="inline-flex items-center gap-2">
                                        <span>View Package</span>
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </span>
                                </button>
                                @if ($type->name !== App\Constants\GlobalConstant::TYPE_CORE_FREE)
                                    <button
                                        class="buyPackageNowBtn w-full py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all active:scale-[0.98] shadow-lg shadow-blue-900/10"
                                        data-package-id="{{ $package->id }}" data-bundle-name="{{ $package->name }}"
                                        data-bundle-price="{{ $price }}" data-bundle-image="{{ $fallbackImage }}"
                                        data-bundle-period="{{ $pricing?->duration_months ?? '' }}"
                                        data-bundle-items="{{ $package->products->pluck('name')->implode(',') }}">
                                        <span class="inline-flex items-center gap-2">
                                            <span>Buy Now</span>
                                            <span class="material-symbols-outlined text-lg">shopping_cart</span>
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-slate-500">No packages found for this category.</div>
                @endforelse
            </div>
            {{-- <div class="flex justify-center mt-16">
            <button id="loadMoreBtn"
                class="px-12 py-4 bg-[var(--enterprise-blue)] text-white font-bold text-lg rounded-2xl shadow-lg shadow-blue-900/10 hover:bg-blue-600 transition-all active:scale-[0.98] flex items-center gap-2">
                <span class="material-symbols-outlined">add_circle</span>
                Load More Products
            </button>
        </div> --}}
        </section>
    @endforeach
    <section class="bg-[#002d5b] py-2">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div
                class="bg-[#002d5b] rounded-md px-6 py-3 flex flex-col md:flex-row items-center justify-center gap-4 md:gap-6">
                <p class="text-white text-xl font-bold">Take the next step</p>
                <a href="#"
                    class="inline-flex items-center justify-center rounded-full bg-[#137fec] px-8 py-2.5 text-white text-2xl font-black tracking-tight hover:bg-blue-700 transition-colors">
                    DI-TOOLS Free Trial
                </a>
                <a href="#"
                    class="inline-flex items-center justify-center rounded-full bg-white px-8 py-2.5 text-[#137fec] text-2xl font-black tracking-tight hover:bg-slate-100 transition-colors">
                    Buy DI-TOOLS
                </a>
            </div>
        </div>
    </section>
    <section class="bg-slate-50 py-32 px-10 lg:px-16">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-4xl lg:text-5xl font-black text-[var(--enterprise-blue)] tracking-tight mb-6">Trusted by
                    Industry Leaders</h2>
                <p class="text-slate-500 text-xl">Powering the design workflows of global engineering firms.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-10 bg-white rounded-[32px] shadow-sm border border-slate-100 flex flex-col">
                    <div class="flex gap-1 text-yellow-400 mb-6">
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                    </div>
                    <p class="text-slate-600 italic text-lg mb-8 leading-relaxed">"The Automation Pro suite reduced our
                        design turnaround time by 40%. It's an indispensable part of our Inventor ecosystem now."</p>
                    <div class="mt-auto flex items-center gap-4">
                        <div class="size-14 rounded-full bg-slate-200 overflow-hidden">
                            <img alt="CAD Manager" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCoYH66do9h7uxk1Ffx8OaZ5jc8zxTXUMae61hpmfO0hjQGCsDvuvGcCiouhA7IwzFgUiP3fLTwsS5pmHxHq2FrfI9gvCDmjv3Q4VpOQU-zYU4aqPWEzSIfp0O7FUvfGFC5pTBzhIa5AHNxkLF1Yg7alxULV4Kz8w8BKgmMyqfHTMpLcVHnK5oQX4n9VqLmHV9335Q4IxtJOManBxBSt7D10b56pHW6k3LirsmYqvfiRy8WOT9nFxjrEjbdnX6eqb9MG1CuKFgYqTE" />
                        </div>
                        <div>
                            <h4 class="font-bold text-[var(--enterprise-blue)]">Marcus Thorne</h4>
                            <p class="text-slate-400 text-sm uppercase font-bold tracking-widest">CAD Manager</p>
                        </div>
                    </div>
                </div>
                <div class="p-10 bg-white rounded-[32px] shadow-sm border border-slate-100 flex flex-col">
                    <div class="flex gap-1 text-yellow-400 mb-6">
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                    </div>
                    <p class="text-slate-600 italic text-lg mb-8 leading-relaxed">"Di-tool provides the most robust
                        simulation modules we've tested. Integration is seamless and the results are consistently accurate."
                    </p>
                    <div class="mt-auto flex items-center gap-4">
                        <div class="size-14 rounded-full bg-slate-200 overflow-hidden">
                            <img alt="Design Engineer" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDDzW4Gk16j8AXdQ9uZdq9z8aIZ2Y9l-Ir6HQnKMgKz2f-2eZ9SauF6BQLIh2azUJtAHi8AScH6ABHiWLv_P-3NXEoxBmWH__6oH1Z4oq3qH8FoCiE8O1bHhY8OQvRBWvLA9r_28vXrrBOPvJfeNGGc4LiBTwIwY-hxauPwraryQmfuSC70r_mhuYLiqzVLsmgpe-KLbCzMNCafc_Sru_0AvSXvzTUxcf5Zl0AeVYCJhGFsboXSUuUp2FwzYnJl8u8LU1nMRE3HhNc" />
                        </div>
                        <div>
                            <h4 class="font-bold text-[var(--enterprise-blue)]">Sarah Jenkins</h4>
                            <p class="text-slate-400 text-sm uppercase font-bold tracking-widest">Senior Design Engineer
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-10 bg-white rounded-[32px] shadow-sm border border-slate-100 flex flex-col">
                    <div class="flex gap-1 text-yellow-400 mb-6">
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                    </div>
                    <p class="text-slate-600 italic text-lg mb-8 leading-relaxed">"Switching to Di-tool's data management
                        was the best decision for our global team. Coordination is now effortless across timezones."</p>
                    <div class="mt-auto flex items-center gap-4">
                        <div class="size-14 rounded-full bg-slate-200 overflow-hidden">
                            <img alt="CTO" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCHprD3TRIZ1El70UrHj-SzqpyaCMKfaQjV4JzW1j_MSLXjgftqCp2X-l1MO2ylfldgSdCHvqUyRriCdL8pcEoN9Fv54BE36DnbueBGc1sJqGJbkq91KZ0YOuh2vTODvTc7fOlKZeiQb-5hSbsm2chmkKpK_GSYPWJQ6PeFeuZdo4ph6LZsU9UNjD4l3X2XlF3fBNsv5KrX1HE0T2HMDNfBLWxoDB0588Izds7Yix5M1OWo5nFiarc-i8rIzh22ujG_bG8LpECEw9w" />
                        </div>
                        <div>
                            <h4 class="font-bold text-[var(--enterprise-blue)]">David Chen</h4>
                            <p class="text-slate-400 text-sm uppercase font-bold tracking-widest">Technical Director</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-[#002d5b] py-10">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-4 text-white text-2xl font-black mb-10">
                <span>CAMELBAK</span>
                <span>Vermeer</span>
                <span>KNAPHEIDE</span>
                <span>RESEMIN</span>
                <span>KONICA MINOLTA</span>
                <span>ColdSnap</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <article class="bg-white rounded-lg p-5 flex gap-4 shadow-lg">
                    <img alt="Customer Story Metalworks" class="w-36 h-28 rounded object-cover flex-shrink-0"
                        src="https://www.3ds.com/assets/invest/styles/card/public/2025-08/metalworks-banner.png.webp?itok=Pa3I3qDD">
                    <div>
                        <p class="text-slate-500 uppercase tracking-wider text-xs font-bold">Customer Story</p>
                        <h3 class="text-4xl leading-tight font-black text-slate-900">How Metalworks ...</h3>
                        <p class="text-slate-600 mt-2">Metalworks, Inc. slashes ...</p>
                    </div>
                </article>
                <article class="bg-white rounded-lg p-5 flex gap-4 shadow-lg">
                    <img alt="Customer Story Resemin" class="w-36 h-28 rounded object-cover flex-shrink-0"
                        src="https://www.3ds.com/assets/invest/styles/card/public/2023-01/resemin-customer-story-banner.jpg.webp?itok=wG1lKOqS">
                    <div>
                        <p class="text-slate-500 uppercase tracking-wider text-xs font-bold">Customer Story</p>
                        <h3 class="text-4xl leading-tight font-black text-slate-900">Resemin ...</h3>
                        <p class="text-slate-600 mt-2">DI-TOOLS and 3DEXPERIENCE ...</p>
                    </div>
                </article>
                <article class="bg-white rounded-lg p-5 flex gap-4 shadow-lg">
                    <img alt="Customer Story BestTugs" class="w-36 h-28 rounded object-cover flex-shrink-0"
                        src="https://www.3ds.com/assets/invest/styles/card/public/2025-08/best-tug-top-banner.jpg.webp?itok=cwyJ69xX">
                    <div>
                        <p class="text-slate-500 uppercase tracking-wider text-xs font-bold">Customer Story</p>
                        <h3 class="text-4xl leading-tight font-black text-slate-900">Best Tugs Takes the ...</h3>
                        <p class="text-slate-600 mt-2">BestTugs brings hybrid vehicle ...</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="relative py-24 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img alt="Customer Story Background" class="w-full h-full object-cover opacity-10"
                src="https://www.solidworks.com/sites/default/filesd10/styles/webp/public/2025-10/solidworks-customer-one-wheel-banner-2_0.jpg.webp?itok=_-nEDcQW">
        </div>
        <div class="max-w-7xl mx-auto px-10 lg:px-16 relative z-10">
            <h2 class="text-5xl font-black text-[var(--enterprise-blue)] mb-16">Customer Stories</h2>
            <div class="flex flex-col lg:flex-row gap-12 items-center">
                <div class="lg:w-1/2 p-12 border-l-4 border-blue-600 bg-white shadow-2xl rounded-r-2xl">
                    <h3 class="text-3xl font-bold text-slate-900 mb-6">How Future Motion Created Onewheel</h3>
                    <p class="text-slate-600 text-lg mb-8 leading-relaxed">From a rough prototype to a radical ride, Future
                        Motion relied on DI-TOOL for every phase of design, simulation, and production.</p>
                    <div class="space-y-4">
                        <a class="flex items-center gap-2 text-[#137fec] font-bold hover:underline" href="#">
                            <span class="material-symbols-outlined">arrow_circle_right</span> Read Future Motion customer
                            story
                        </a>
                        <a class="flex items-center gap-2 text-[#137fec] font-bold hover:underline" href="#">
                            <span class="material-symbols-outlined">arrow_circle_right</span> All customer stories
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 relative rounded-3xl overflow-hidden shadow-2xl">
                    <iframe class="w-full aspect-video" src="https://www.youtube.com/watch?v=hnTQoO-VQrU&t"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-[#002d5b] py-2">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div
                class="bg-[#002d5b] rounded-md px-6 py-3 flex flex-col md:flex-row items-center justify-center gap-4 md:gap-6">
                <p class="text-white text-xl font-bold">Stay up to date with the latest SOLIDWORKS news on SOLIDWORKS Live
                </p>
                <a href="#"
                    class="inline-flex items-center justify-center rounded-full bg-white px-8 py-2.5 text-[#137fec] text-2xl font-black tracking-tight hover:bg-slate-100 transition-colors">
                    Watch Now
                </a>
            </div>
        </div>
    </section>
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <h2 class="text-5xl font-black text-[var(--enterprise-blue)] mb-12">Community</h2>
            <div class="flex flex-col lg:flex-row gap-12 mb-20">
                <div class="lg:w-1/3 p-10 border-l-4 border-blue-600">
                    <h3 class="text-2xl font-bold mb-4">Community is at our core.</h3>
                    <p class="text-slate-600 leading-relaxed mb-6">DI-TOOL has a passionate, engaged community of more than
                        8 million users from every corner of the world. Discover the DI-TOOL community and the variety of
                        programs available for all of our users.</p>
                    <div class="flex flex-wrap gap-6 font-bold text-[#137fec]">
                        <a class="flex items-center gap-2 hover:underline" href="#"><span
                                class="material-symbols-outlined">arrow_circle_right</span> Find out more</a>
                        <a class="flex items-center gap-2 hover:underline" href="#"><span
                                class="material-symbols-outlined">arrow_circle_right</span> DI-TOOL User Group Network</a>
                    </div>
                </div>
                <div class="lg:w-2/3">
                    <img alt="Community Events" class="rounded-3xl shadow-xl w-full"
                        src="https://d1yei2z3i6k35z.cloudfront.net/11186306/67d438b1af9b6_2025-03-14_21h09_01.png">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-slate-100 overflow-hidden">
                        <img alt="Students" class="w-full h-full object-cover"
                            src="https://www.solidworks.com/sites/default/filesd10/styles/og_image/public/migration/2022-11/solidworks-students-hero-3.jpg?itok=QOWmm9P9">
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-xl mb-3">DI-TOOL for Students</h4>
                        <p class="text-slate-500 text-sm">As the industry standard for design and engineering, DI-TOOL is
                            the perfect software platform...</p>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-slate-100 overflow-hidden">
                        <img alt="Makers" class="w-full h-full object-cover"
                            src="https://www.solidworks.com/sites/default/filesd10/styles/og_image/public/2025-01/solidworks-makers-card-thumb.jpg?itok=HM7Y7HF_">
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-xl mb-3">DI-TOOL for Makers</h4>
                        <p class="text-slate-500 text-sm">DI-TOOL for Makers provides full-functionality 3D CAD tools for
                            personal use. Just $48 USD a ...</p>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-slate-100 overflow-hidden">
                        <img alt="Startups" class="w-full h-full object-cover"
                            src="https://www.solidworks.com/sites/default/filesd10/styles/og_image/public/migration/opengraph_startup_drone_example1.jpg?itok=U6fjCCos">
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-xl mb-3">DI-TOOL for Startups Program</h4>
                        <p class="text-slate-500 text-sm">Industry-leading 3D design tools for hardware startups at nominal
                            cost</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="max-w-7xl mx-auto px-10 py-32">
        <div class="relative p-16 lg:p-24 bg-[var(--enterprise-blue)] rounded-[60px] overflow-hidden text-center">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 rounded-full blur-[100px] -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full blur-[100px] -ml-48 -mb-48"></div>
            </div>
            <div class="relative z-10">
                <h2 class="text-4xl lg:text-6xl font-black text-white mb-8 tracking-tight">Scale Your Engineering
                    <br />Infrastructure Today
                </h2>
                <p class="text-blue-100 text-xl max-w-2xl mx-auto mb-12 font-medium">Connect with our solution architects
                    to build a bespoke automation strategy for your manufacturing pipeline.</p>
                <div class="flex flex-wrap justify-center gap-6">
                    <button
                        class="px-12 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-xl hover:scale-105 transition-all">
                        Request Custom Proposal
                    </button>
                    <button
                        class="px-12 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all">
                        Talk to an Expert
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const $buyPackageNowBtn = $('.buyPackageNowBtn');
            if ($buyPackageNowBtn.length === 0) return;

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

            $buyPackageNowBtn.on('click', function() {
                const rawId = $(this).data('package-id');
                const id = String(rawId ?? '');
                const name = $(this).data('bundle-name') || 'Package';
                const price = Number($(this).data('bundle-price')) || 0;
                const image = $(this).data('bundle-image') || '';
                const period = ($(this).data('bundle-period') || '').toString();

                const item = {
                    id,
                    name,
                    price,
                    period,
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
                window.location.href = '/checkout';
            });
        });
    </script>
@endpush
