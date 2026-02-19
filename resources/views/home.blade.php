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
    <section class="max-w-7xl mx-auto px-10 lg:px-16 py-32">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-20 gap-8">
            <div class="max-w-2xl">
                <h2 class="text-4xl lg:text-5xl font-black text-[var(--enterprise-blue)] tracking-tight">The Software Suite
                </h2>
                <p class="text-slate-500 text-lg mt-6 leading-relaxed">Precision-engineered packages tailored to specific
                    engineering roles, from rapid prototyping to enterprise data management.</p>
            </div>
            <div class="flex items-center gap-4 bg-slate-50 p-2 rounded-2xl">
                <button class="px-6 py-2 bg-white shadow-sm rounded-xl text-sm font-bold text-[var(--enterprise-blue)]">All
                    Packages</button>
                <button
                    class="px-6 py-2 hover:bg-white/50 rounded-xl text-sm font-bold text-slate-400 transition-all">Automation</button>
                <button
                    class="px-6 py-2 hover:bg-white/50 rounded-xl text-sm font-bold text-slate-400 transition-all">Analysis</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            <div
                class="group flex flex-col glass-card rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500">
                <div class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px]">
                    <img alt="Modeling Suite"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0xn8klFRg-K-wRgdq9BzT8p7YQbk6CjpWvfNLtc2vdCkRslFovVEeXhTTPi8n6Wg4kQk6g5XGMAA9Eje2zDvPqgmIT-5DGhYHSfGg8_3ikow9PiqSqnjhbl4vKZrJGIdPvdSeyLeVSba8OMJLs1VMbFXsof6nhoC7sGi9QImZ1nT5NHC9Go5RlZWKq_GowsX26ajNPYPCPWaol77sCdSPRs-kfLoBSSMaOb37ctMPwcUx8bTWWT9eDcj23XJ1ltEnAAZOQQvyBjI" />
                    <div class="absolute top-4 left-4">
                        <span
                            class="bg-white/95 backdrop-blur-sm text-[var(--enterprise-blue)] px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                            High Demand
                        </span>
                    </div>
                </div>
                <div class="p-8 pt-4 flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-[var(--enterprise-blue)]">Modeling Suite</h3>
                    <p class="text-slate-500 text-sm mt-3 leading-relaxed">Parametric efficiency for high-complexity 3D
                        models.</p>
                    <div class="mt-auto pt-8 flex flex-col items-center">
                        <div class="flex flex-col items-center mb-6">
                            <span class="text-slate-300 text-sm line-through font-medium mb-1">$599.00</span>
                            <span class="text-3xl font-black text-[var(--enterprise-blue)] tracking-tight">$449.00</span>
                        </div>
                        <button
                            class="quickBuyBtn w-full py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all active:scale-[0.98] shadow-lg shadow-blue-900/10"
                            data-product-name="Modeling Suite" data-product-price="449" data-product-old-price="599"
                            data-product-image="https://lh3.googleusercontent.com/aida-public/AB6AXuD0xn8klFRg-K-wRgdq9BzT8p7YQbk6CjpWvfNLtc2vdCkRslFovVEeXhTTPi8n6Wg4kQk6g5XGMAA9Eje2zDvPqgmIT-5DGhYHSfGg8_3ikow9PiqSqnjhbl4vKZrJGIdPvdSeyLeVSba8OMJLs1VMbFXsof6nhoC7sGi9QImZ1nT5NHC9Go5RlZWKq_GowsX26ajNPYPCPWaol77sCdSPRs-kfLoBSSMaOb37ctMPwcUx8bTWWT9eDcj23XJ1ltEnAAZOQQvyBjI">
                            Quick Buy
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="group flex flex-col glass-card rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500">
                <div class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px]">
                    <img alt="Automation Pro"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuABiuR3EtpFe7mIKUqtUleN7jxNUwJHyaX4f444l0nXna-mbpS_TTTQFVYxdzPcL7zZ5KLSiZ0JQxUE-0-AQlofogRoRXJq6v8YtmeS9ZqI3AHDN1fVnkMQLLFMfOfeG2vQIwR6dtsbCTCWYvl6gfnmu9Iv9wjXbFKH-Z5hXsifmpNlzii0TKZOUs-sDUXiUCvQVzX-RosgPdyc8Am5nR8-JnDje3cBRFe2-eoFa2Ruv9AeD8XaIuLfCnL6EU69DDsNvgybAgrNsFs" />
                    <div class="absolute top-4 left-4">
                        <span
                            class="bg-blue-600 text-white px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                            Best Value
                        </span>
                    </div>
                </div>
                <div class="p-8 pt-4 flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-[var(--enterprise-blue)]">Automation Pro</h3>
                    <p class="text-slate-500 text-sm mt-3 leading-relaxed">iLogic-driven logic for rapid design iteration
                        workflows.</p>
                    <div class="mt-auto pt-8 flex flex-col items-center">
                        <div class="flex flex-col items-center mb-6">
                            <span class="text-slate-300 text-sm line-through font-medium mb-1">$899.00</span>
                            <span class="text-3xl font-black text-[var(--enterprise-blue)] tracking-tight">$699.00</span>
                        </div>
                        <button
                            class="quickBuyBtn w-full py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all active:scale-[0.98] shadow-lg shadow-blue-900/10"
                            data-product-name="Automation Pro" data-product-price="699" data-product-old-price="899"
                            data-product-image="https://lh3.googleusercontent.com/aida-public/AB6AXuABiuR3EtpFe7mIKUqtUleN7jxNUwJHyaX4f444l0nXna-mbpS_TTTQFVYxdzPcL7zZ5KLSiZ0JQxUE-0-AQlofogRoRXJq6v8YtmeS9ZqI3AHDN1fVnkMQLLFMfOfeG2vQIwR6dtsbCTCWYvl6gfnmu9Iv9wjXbFKH-Z5hXsifmpNlzii0TKZOUs-sDUXiUCvQVzX-RosgPdyc8Am5nR8-JnDje3cBRFe2-eoFa2Ruv9AeD8XaIuLfCnL6EU69DDsNvgybAgrNsFs">
                            Quick Buy
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="group flex flex-col glass-card rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500">
                <div class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px]">
                    <img alt="Simulation Toolkit"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5ypRmi7k6qRIULbfebvTvm4YLkotQAsl0fuvoVN3_ey3_lN1103cSN3sDrhqQaZl2-_QjOBauKYx99stjEOciMbxxQaf456cwpxJa0ZflS6ToVT08SkHN0Fj6Ce0BayX--RufQQ8SZ06e_XUA8zjBxJeiJq_M72LEfFsst-ZZEjy4ROAvrLG4dcE6G6vU3oI7DqstMnFZH6jpQA3ogsb9OyyZ46SOxmk1_Jnc-o35PvEHeXvk1SGDdLlj-uvLiLJg-c-8D4buEHA" />
                    <div class="absolute top-4 left-4">
                        <span
                            class="bg-white/95 text-[var(--enterprise-blue)] px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                            New Arrival
                        </span>
                    </div>
                </div>
                <div class="p-8 pt-4 flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-[var(--enterprise-blue)]">Simulation Kit</h3>
                    <p class="text-slate-500 text-sm mt-3 leading-relaxed">Advanced FEA modules for stress testing
                        validation.</p>
                    <div class="mt-auto pt-8 flex flex-col items-center">
                        <div class="flex flex-col items-center mb-6">
                            <span class="text-slate-300 text-sm line-through font-medium mb-1">$1,299.00</span>
                            <span class="text-3xl font-black text-[var(--enterprise-blue)] tracking-tight">$999.00</span>
                        </div>
                        <button
                            class="quickBuyBtn w-full py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all active:scale-[0.98] shadow-lg shadow-blue-900/10"
                            data-product-name="Simulation Kit" data-product-price="999" data-product-old-price="1299"
                            data-product-image="https://lh3.googleusercontent.com/aida-public/AB6AXuA5ypRmi7k6qRIULbfebvTvm4YLkotQAsl0fuvoVN3_ey3_lN1103cSN3sDrhqQaZl2-_QjOBauKYx99stjEOciMbxxQaf456cwpxJa0ZflS6ToVT08SkHN0Fj6Ce0BayX--RufQQ8SZ06e_XUA8zjBxJeiJq_M72LEfFsst-ZZEjy4ROAvrLG4dcE6G6vU3oI7DqstMnFZH6jpQA3ogsb9OyyZ46SOxmk1_Jnc-o35PvEHeXvk1SGDdLlj-uvLiLJg-c-8D4buEHA">
                            Quick Buy
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="group flex flex-col glass-card rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500">
                <div class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px]">
                    <img alt="Data Management"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfGGGqCcjGOwLyeLuLmIRlJq9Zn1MxNLSqJKqPA6x97tONidMOdo5r6MGwyaCxQpWAcU9VyfCurG_26Wi1yalEuauitJr9fgE2904hioT2Z9ojg_nfhQwacSPiX3nkCURAxSrtdkp8HJFz7UhgfMloaDB5whaFAjCzX6Hjnh4NVkd3PBp37Pvr0s5jDKRbplLCMynvBnxUYgzhjpFCUSM81QaRI-8z6BXkATRcNOgvaDgX_v_l_Hg3X1iFWzpcNkJJRNVbgUXQ5cw" />
                    <div class="absolute top-4 left-4">
                        <span
                            class="bg-white/95 text-[var(--enterprise-blue)] px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                            Enterprise
                        </span>
                    </div>
                </div>
                <div class="p-8 pt-4 flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-[var(--enterprise-blue)]">Data Manager</h3>
                    <p class="text-slate-500 text-sm mt-3 leading-relaxed">PDM solutions for assembly synchronization.</p>
                    <div class="mt-auto pt-8 flex flex-col items-center">
                        <div class="flex flex-col items-center mb-6">
                            <span class="text-slate-300 text-sm line-through font-medium mb-1">$750.00</span>
                            <span class="text-3xl font-black text-[var(--enterprise-blue)] tracking-tight">$550.00</span>
                        </div>
                        <button
                            class="quickBuyBtn w-full py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all active:scale-[0.98] shadow-lg shadow-blue-900/10"
                            data-product-name="Data Manager" data-product-price="550" data-product-old-price="750"
                            data-product-image="https://lh3.googleusercontent.com/aida-public/AB6AXuAfGGGqCcjGOwLyeLuLmIRlJq9Zn1MxNLSqJKqPA6x97tONidMOdo5r6MGwyaCxQpWAcU9VyfCurG_26Wi1yalEuauitJr9fgE2904hioT2Z9ojg_nfhQwacSPiX3nkCURAxSrtdkp8HJFz7UhgfMloaDB5whaFAjCzX6Hjnh4NVkd3PBp37Pvr0s5jDKRbplLCMynvBnxUYgzhjpFCUSM81QaRI-8z6BXkATRcNOgvaDgX_v_l_Hg3X1iFWzpcNkJJRNVbgUXQ5cw">
                            Quick Buy
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-16">
            <button id="loadMoreBtn"
                class="px-12 py-4 bg-[var(--enterprise-blue)] text-white font-bold text-lg rounded-2xl shadow-lg shadow-blue-900/10 hover:bg-blue-600 transition-all active:scale-[0.98] flex items-center gap-2">
                <span class="material-symbols-outlined">add_circle</span>
                Load More Products
            </button>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fakeProducts = [{
                    name: 'Advanced Rendering',
                    description: 'Photorealistic visualization for design presentations.',
                    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuD0xn8klFRg-K-wRgdq9BzT8p7YQbk6CjpWvfNLtc2vdCkRslFovVEeXhTTPi8n6Wg4kQk6g5XGMAA9Eje2zDvPqgmIT-5DGhYHSfGg8_3ikow9PiqSqnjhbl4vKZrJGIdPvdSeyLeVSba8OMJLs1VMbFXsof6nhoC7sGi9QImZ1nT5NHC9Go5RlZWKq_GowsX26ajNPYPCPWaol77sCdSPRs-kfLoBSSMaOb37ctMPwcUx8bTWWT9eDcj23XJ1ltEnAAZOQQvyBjI',
                    oldPrice: '$449.00',
                    newPrice: '$349.00',
                    badge: 'Premium',
                    badgeBg: 'bg-purple-600'
                },
                {
                    name: 'Assembly Optimizer',
                    description: 'Streamline complex assemblies with intelligent automation.',
                    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuABiuR3EtpFe7mIKUqtUleN7jxNUwJHyaX4f444l0nXna-mbpS_TTTQFVYxdzPcL7zZ5KLSiZ0JQxUE-0-AQlofogRoRXJq6v8YtmeS9ZqI3AHDN1fVnkMQLLFMfOfeG2vQIwR6dtsbCTCWYvl6gfnmu9Iv9wjXbFKH-Z5hXsifmpNlzii0TKZOUs-sDUXiUCvQVzX-RosgPdyc8Am5nR8-JnDje3cBRFe2-eoFa2Ruv9AeD8XaIuLfCnL6EU69DDsNvgybAgrNsFs',
                    oldPrice: '$599.00',
                    newPrice: '$449.00',
                    badge: 'Popular',
                    badgeBg: 'bg-green-600'
                },
                {
                    name: 'Blueprint Manager',
                    description: 'Centralized documentation and design versioning.',
                    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA5ypRmi7k6qRIULbfebvTvm4YLkotQAsl0fuvoVN3_ey3_lN1103cSN3sDrhqQaZl2-_QjOBauKYx99stjEOciMbxxQaf456cwpxJa0ZflS6ToVT08SkHN0Fj6Ce0BayX--RufQQ8SZ06e_XUA8zjBxJeiJq_M72LEfFsst-ZZEjy4ROAvrLG4dcE6G6vU3oI7DqstMnFZH6jpQA3ogsb9OyyZ46SOxmk1_Jnc-o35PvEHeXvk1SGDdLlj-uvLiLJg-c-8D4buEHA',
                    oldPrice: '$699.00',
                    newPrice: '$549.00',
                    badge: 'Sale',
                    badgeBg: 'bg-red-600'
                },
                {
                    name: 'Material Database',
                    description: 'Extensive material properties and specifications library.',
                    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAfGGGqCcjGOwLyeLuLmIRlJq9Zn1MxNLSqJKqPA6x97tONidMOdo5r6MGwyaCxQpWAcU9VyfCurG_26Wi1yalEuauitJr9fgE2904hioT2Z9ojg_nfhQwacSPiX3nkCURAxSrtdkp8HJFz7UhgfMloaDB5whaFAjCzX6Hjnh4NVkd3PBp37Pvr0s5jDKRbplLCMynvBnxUYgzhjpFCUSM81QaRI-8z6BXkATRcNOgvaDgX_v_l_Hg3X1iFWzpcNkJJRNVbgUXQ5cw',
                    oldPrice: '$399.00',
                    newPrice: '$299.00',
                    badge: 'Featured',
                    badgeBg: 'bg-indigo-600'
                }
            ];

            function createProductCard(product) {
                return `
                            <div class="group flex flex-col glass-card rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500">
                                <div class="relative aspect-[5/4] overflow-hidden m-3 rounded-[24px]">
                                    <img alt="${product.name}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="${product.image}" />
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-white/95 backdrop-blur-sm text-[var(--enterprise-blue)] px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                                            ${product.badge}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-8 pt-4 flex flex-col flex-1">
                                    <h3 class="text-xl font-bold text-[var(--enterprise-blue)]">${product.name}</h3>
                                    <p class="text-slate-500 text-sm mt-3 leading-relaxed">${product.description}</p>
                                    <div class="mt-auto pt-8 flex flex-col items-center">
                                        <div class="flex flex-col items-center mb-6">
                                            <span class="text-slate-300 text-sm line-through font-medium mb-1">${product.oldPrice}</span>
                                            <span class="text-3xl font-black text-[var(--enterprise-blue)] tracking-tight">${product.newPrice}</span>
                                        </div>
                                        <button class="quickBuyBtn w-full py-4 bg-[var(--enterprise-blue)] text-white text-sm font-bold rounded-2xl hover:bg-blue-600 transition-all active:scale-[0.98] shadow-lg shadow-blue-900/10" data-product-name="${product.name}" data-product-price="${product.newPrice.replace('$', '').replace(/,/g, '')}" data-product-old-price="${product.oldPrice.replace('$', '').replace(/,/g, '')}" data-product-image="${product.image}">
                                            Quick Buy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
            }

            document.getElementById('loadMoreBtn').addEventListener('click', function() {
                const button = this;
                const section = button.closest('section');
                const grid = section.querySelector('.grid');

                // Disable button during loading
                button.disabled = true;
                button.style.opacity = '0.5';

                // Simulate loading delay
                setTimeout(() => {
                    fakeProducts.forEach(product => {
                        grid.insertAdjacentHTML('beforeend', createProductCard(product));
                    });

                    // Re-enable button
                    button.disabled = false;
                    button.style.opacity = '1';
                }, 500);
            });

            // Unified event delegation for product clicks — save product and go to product detail
            document.addEventListener('click', function(e) {
                // Direct button targets
                const quickBtn = e.target.closest('.quickBuyBtn');
                const bundleBtn = e.target.closest('.buyBundleBtn');

                // If user clicked somewhere on the card (not necessarily the button), find the nearest product card
                const card = e.target.closest('.group');

                let productData = null;

                if (quickBtn) {
                    productData = {
                        name: quickBtn.dataset.productName,
                        price: quickBtn.dataset.productPrice ? parseFloat(quickBtn.dataset
                            .productPrice) : null,
                        oldPrice: quickBtn.dataset.productOldPrice ? parseFloat(quickBtn.dataset
                            .productOldPrice) : null,
                        image: quickBtn.dataset.productImage || null
                    };
                } else if (bundleBtn) {
                    productData = {
                        name: bundleBtn.dataset.bundleName || null,
                        price: bundleBtn.dataset.bundlePrice ? parseFloat(bundleBtn.dataset
                            .bundlePrice) : null,
                        oldPrice: bundleBtn.dataset.bundleOldPrice ? parseFloat(bundleBtn.dataset
                            .bundleOldPrice) : null,
                        image: bundleBtn.dataset.bundleImage || null,
                        items: bundleBtn.dataset.bundleItems ? bundleBtn.dataset.bundleItems.split(
                            ',') : []
                    };
                } else if (card) {
                    // look for a quick/bundle button inside the card to extract product info
                    const innerQuick = card.querySelector('.quickBuyBtn');
                    const innerBundle = card.querySelector('.buyBundleBtn');
                    if (innerQuick) {
                        productData = {
                            name: innerQuick.dataset.productName,
                            price: innerQuick.dataset.productPrice ? parseFloat(innerQuick.dataset
                                .productPrice) : null,
                            oldPrice: innerQuick.dataset.productOldPrice ? parseFloat(innerQuick.dataset
                                .productOldPrice) : null,
                            image: innerQuick.dataset.productImage || null
                        };
                    } else if (innerBundle) {
                        productData = {
                            name: innerBundle.dataset.bundleName || null,
                            price: innerBundle.dataset.bundlePrice ? parseFloat(innerBundle.dataset
                                .bundlePrice) : null,
                            oldPrice: innerBundle.dataset.bundleOldPrice ? parseFloat(innerBundle
                                .dataset.bundleOldPrice) : null,
                            image: innerBundle.dataset.bundleImage || null,
                            items: innerBundle.dataset.bundleItems ? innerBundle.dataset.bundleItems
                                .split(',') : []
                        };
                    }
                }

                if (productData) {
                    try {
                        localStorage.setItem('selectedProduct', JSON.stringify(productData));
                    } catch (err) {
                        // ignore storage errors
                    }
                    // Redirect to product detail page
                    window.location.href = '/product-detail';
                }
            });
        });
    </script>
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
    <section class="max-w-7xl mx-auto px-10 py-32">
        <div class="relative p-16 lg:p-24 bg-[var(--enterprise-blue)] rounded-[60px] overflow-hidden text-center">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 rounded-full blur-[100px] -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full blur-[100px] -ml-48 -mb-48"></div>
            </div>
            <div class="relative z-10">
                <h2 class="text-4xl lg:text-6xl font-black text-white mb-8 tracking-tight">Scale Your Engineering
                    <br />Infrastructure Today</h2>
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
@endpush
