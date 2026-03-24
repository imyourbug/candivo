@extends('layouts.main')

@section('title', 'Premium Di-tool Experience | Enterprise CAD Solutions')

@push('styles')
    <style type="text/tailwindcss">
        .pro-card {
            background: linear-gradient(145deg, #001a33 100%, #000d1a 100%);
            border: 1px solid rgba(0, 102, 255, 0.3);
            box-shadow: 0 0 40px rgba(0, 102, 255, 0.15);
        }

        .pro-card:hover {
            box-shadow: 0 0 60px rgba(0, 102, 255, 0.25);
        }

        .glow-check {
            color: #00d4ff;
            text-shadow: 0 0 8px rgba(0, 212, 255, 0.8);
        }

        .premium-gold-btn {
            background: linear-gradient(135deg, #137fec 0%, #137fec 100%);
            color: #001a33 !important;
            box-shadow: 0 10px 20px rgba(255, 165, 0, 0.2);
        }

        .premium-gold-btn:hover {
            background: linear-gradient(135deg, #878ddb 0%, #878ddb 100%);
            transform: translateY(-2px);
        }

        .type-tab-btn {
            background: transparent;
            color: #4f6786;
            border: 1px solid transparent;
            min-width: 130px;
        }

        .type-tab-btn.is-active {
            background: #1e79dc;
            color: #ffffff;
            border-color: #1e79dc;
            box-shadow: 0 8px 16px rgba(30, 121, 220, 0.28);
        }

        .core-free-card {
            border: 1px solid rgba(30, 121, 220, 0.4);
            background: #eff6ff;
        }

        .core-free-card:hover {
            border-color: rgba(30, 121, 220, 0.6);
        }
    </style>
@endpush
@section('content')
    <section class="relative h-[850px] w-full overflow-hidden bg-slate-900 group" id="heroCarousel">
        <!-- Slide 1 -->
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-100" data-slide="0">
            <img alt="Industrial Engineering" class="absolute inset-0 w-full h-full object-cover" src="/images/slides/1.png" />
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
                        <a href="{{ route('home', ['tab' => 'Package']) }}"
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all inline-flex items-center justify-center">
                            Get Started Now
                        </a>
                        <a href="{{ route('help-center') }}"
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all inline-flex items-center justify-center">
                            Watch Demo
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="1">
            <img alt="Precision Engineering" class="absolute inset-0 w-full h-full object-cover"
                src="/images/slides/2.png" />
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
                        <a href="{{ route('about') }}"
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all inline-flex items-center justify-center">
                            Learn More
                        </a>
                        <a href="{{ route('home') }}"
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all inline-flex items-center justify-center">
                            View Case Studies
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="2">
            <img alt="Digital Twin Automation" class="absolute inset-0 w-full h-full object-cover"
                src="/images/slides/3.jpg" />
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
                        <a href="{{ route('home', ['tab' => 'Stand-Alone']) }}"
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all inline-flex items-center justify-center">
                            Explore Automation
                        </a>
                        <a href="{{ route('help-center') }}"
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all inline-flex items-center justify-center">
                            Request Demo
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="3">
            <img alt="Industrial Scalability" class="absolute inset-0 w-full h-full object-cover"
                src="/images/slides/4.png" />
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
                        <a href="{{ route('home', ['tab' => 'Core-Free']) }}"
                            class="px-10 py-5 bg-white text-[var(--enterprise-blue)] rounded-2xl font-bold text-lg shadow-2xl hover:scale-[1.05] transition-all inline-flex items-center justify-center">
                            Solutions Overview
                        </a>
                        <a href="{{ route('about') }}"
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all inline-flex items-center justify-center">
                            Contact Sales
                        </a>
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
    <br />
    <br />
    @php
        $hasActiveTab = $allTypes->contains('name', $tab);
    @endphp
    <section class="max-w-7xl mx-auto px-6 lg:px-16 py-10">
        <div
            class="flex w-full flex-wrap items-center justify-center gap-2 p-1.5 bg-white border border-slate-200 rounded-2xl shadow-sm mb-10 max-w-max mx-auto">
            @foreach ($allTypes as $type)
                @php
                    $isActiveTab = $hasActiveTab ? $type->name === $tab : $loop->first;
                @endphp
                <button type="button"
                    class="type-tab-btn {{ $isActiveTab ? 'is-active' : '' }} px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                    data-target="type-panel-{{ $loop->index }}" aria-selected="{{ $isActiveTab ? 'true' : 'false' }}">
                    {{ $type->name }}
                </button>
            @endforeach
        </div>

        @foreach ($allTypes as $type)
            @php
                $isActivePanel = $hasActiveTab ? $type->name === $tab : $loop->first;
            @endphp
            <div id="type-panel-{{ $loop->index }}" class="type-panel {{ $isActivePanel ? '' : 'hidden' }}">
                @php
                    $featuredPackage = $type->packages->first();
                    $sectionTitle = $type->name;
                    $sectionDescription =
                        $featuredPackage?->description ?:
                        'High-end extensions for Autodesk Inventor. Streamline your workflow with powerful CAD automation tools.';
                @endphp
                <div class="max-w-4xl mx-auto text-center mb-10">
                    <h2 class="text-4xl lg:text-6xl font-black text-[var(--enterprise-blue)] leading-[1.05] tracking-tight">
                        {{ $sectionTitle }}
                    </h2>
                    {{-- <p class="text-slate-500 text-lg mt-5 leading-relaxed max-w-3xl mx-auto">
                        {{ $sectionDescription }}
                    </p> --}}
                </div>
                @php
                    $packagesByLevel = $type->packages->groupBy('level')->sortKeys();
                @endphp
                @forelse ($packagesByLevel as $level => $levelPackages)
                    <div class="mb-10">
                        {{-- @if (!is_null($level))
                            <div class="mb-4 flex items-center justify-between">
                                <span class="text-xs font-bold tracking-[0.2em] uppercase text-slate-400">
                                    Level {{ $level }}
                                </span>
                            </div>
                        @endif --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                            @foreach ($levelPackages as $package)
                                @include('components.cards.package-card', [
                                    'package' => $package,
                                    'ctaSizeClass' => 'h-12',
                                ])
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10 mb-10">
                        <div class="col-span-full text-center text-slate-500">No packages found for this category.</div>
                    </div>
                @endforelse

                @php
                    $isStandAloneType = $type->name === App\Constants\GlobalConstant::TYPE_STAND_ALONE;
                @endphp

                @if ($isStandAloneType)
                    @php
                        $standAloneToolImageSources = [
                            'https://lh3.googleusercontent.com/aida-public/AB6AXuADz2fKqgxIvjaTj5-lGjwoNT8MCRI9OeB4VkBT9SfnOC-ejIGeSk2nZSzNi2tc9JY93KvGyMOmiKy8tcO0x3xjIw5jGCzLUci29fvhdZu98X_1JxqPLpbXHZ3Ym4g-7Cl4fUuzlgFhK4dZ2l2swKfmJbPbHDofoao3kqPWr2q94KpXn6N5Qv4CxRwEuB5YLgYmO9Pc1wu_Vi97_Egr6ITV3YeNLW5timi7sAh0xCzyu4iTEQKofUhBqDK_sasUb1I0nsMoYPf8AvQ',
                            'https://lh3.googleusercontent.com/aida-public/AB6AXuA9u23NQRZqmg3IXYfIWNTXAFL7WsUsGqHdoGVLnNdK7IR6NMfqnxmfJ2129c5BEcdDq4ks2W9JKqUKWOmDOKk5cxuBmZlxgqmMvXxJTuq6SPcmruZIWUuDvt3lrP7KkmdtHLj_bzhmC2C66RWM2kgjbnQh-APZToYvnUXF6zKJ46TRkyzrfckVOzzj6S3m5HVpJEgHJUa9ud3-WaHYg-za064cNSOi6VpxM4OaDjBv1VTf8HX2g8VUf_vzzExLjwXkItLbAcjksQQ',
                            'https://lh3.googleusercontent.com/aida-public/AB6AXuA9I9gE16lI_z4bFCY2M0qEe9EU-Dv3T8j4_cpEc1n3ronut_jQ_LX-_hwf47yXpe2xuYOTtR5FbQiuoYbMJiRSppBvJOQVPfDMuMvm-sSYIoFX37p4o7NrO56SddRIC3-kKN_sR9NQbsW3jpodY1phzOfvHpzuqqRm3mYZ06rvtNB3To6dH7Qn2QdtXtQtK5MMeHk4DDn-USfNovMi9Df3n5CXRcQVHvRl1wfaoZC4dhaP3oEZdZvs-7oRXwBmsdFDfUKifMcqI70',
                            'https://lh3.googleusercontent.com/aida-public/AB6AXuD8lbZUTGd1GLg5HcHiZ1PADrs7-7Pw0CU5rwiAISq3Khpqu_ufOto0OrYiTpHuhdopfYOXwa98et43_8But4Xsrogiqw8AZeDDmZj9BXMePNe7aHPEBGkLfOdICIXHYu7FNHq8hmOM12r-TqQWmGl5HUX8i8GzNaGyUFsn2R2skZAu_N0-HqMkEQFLoSM9D4yeKMNkVoX9dzUHRM1nxM1DrycLtmy5QsL51Zzk7Iqf0RktXPVlV99_bGeM4zeIrTVLTt6N6ubZQos',
                        ];
                    @endphp

                    @if (isset($allTools) && $allTools->isNotEmpty())
                        <div class="mt-12 w-full">
                            <div
                                class="h-[10px] w-full bg-gradient-to-r from-transparent via-[#137fec]/60 to-transparent mb-10">
                            </div>
                            <div class="flex items-center justify-center mb-10">
                                <h2 class="text-3xl font-bold flex items-center justify-center gap-3 tracking-tight">
                                    <span class="material-symbols-outlined text-primary text-4xl">inventory_2</span>
                                    All Stand-Alone Tools
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach ($allTools as $idx => $tool)
                                    @include('components.cards.tool-card', [
                                        'tool' => $tool,
                                        'idx' => $idx,
                                        'imageSources' => $standAloneToolImageSources,
                                        'isClickable' => true,
                                        'productId' => $tool->id,
                                    ])
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </section>
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
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <h2 class="text-5xl font-black text-[var(--enterprise-blue)] mb-12">Community</h2>
            <div class="flex flex-col lg:flex-row gap-12 mb-20">
                <div class="lg:w-1/3 p-10 border-l-4 border-blue-600">
                    <h3 class="text-2xl font-bold mb-4">Community is at our core.</h3>
                    <p class="text-slate-600 leading-relaxed mb-6">DI-TOOL has a passionate, engaged community of more than
                        5,000+ users from every corner of the world. Discover the DI-TOOL community and the variety of
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
                @forelse ($homePostsCommunity as $post)
                    @php
                        $blogCardImage = $post->avatar_url ?? $post->featured_image_url;
                    @endphp
                    <a href="{{ route('post-detail', $post) }}"
                        class="group bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow block text-left">
                        <div class="h-48 bg-slate-100 overflow-hidden">
                            @if ($blogCardImage)
                                <img alt="{{ $post->title }}" width="480" height="192" loading="lazy" decoding="async"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    src="{{ $blogCardImage }}">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-[#137fec] to-[#002d5b] flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-6xl opacity-90">article</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h4 class="font-bold text-xl mb-3 text-slate-900 group-hover:text-[#137fec] transition-colors">
                                {{ $post->title }}</h4>
                            <p class="text-slate-500 line-clamp-3 text-sm">
                                {{ $post->home_preview_text }}
                            </p>
                        </div>
                    </a>
                @empty
                    <p class="md:col-span-3 text-slate-500 text-center py-8">No blog posts yet. Publish posts in the admin
                        to show them here.</p>
                @endforelse
            </div>
        </div>
    </section>
    <section class="bg-[#002d5b] py-10">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            @if ($homePostsStories->isEmpty())
                @if (! $homePostsCommunity->isEmpty())
                    <p class="text-blue-100 text-center py-4 text-sm">Add more published posts to fill this row (posts 4–6
                        by home order).</p>
                @endif
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($homePostsStories as $post)
                        @php
                            $blogCardImage = $post->avatar_url ?? $post->featured_image_url;
                        @endphp
                        <a href="{{ route('post-detail', $post) }}"
                            class="bg-white rounded-lg p-5 flex gap-4 shadow-lg hover:shadow-xl transition-shadow group min-w-0">
                            @if ($blogCardImage)
                                <img alt="{{ $post->title }}" width="144" height="112" loading="lazy" decoding="async"
                                    class="h-28 w-36 flex-shrink-0 rounded object-cover" src="{{ $blogCardImage }}">
                            @else
                                <div
                                    class="w-36 h-28 rounded flex-shrink-0 bg-gradient-to-br from-[#137fec] to-[#002d5b] flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-4xl opacity-90">article</span>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="text-slate-500 uppercase tracking-wider text-xs font-bold">Blog</p>
                                <h3
                                    class="text-xl md:text-2xl leading-snug font-black text-slate-900 group-hover:text-[#137fec] transition-colors">
                                    {{ $post->title }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($post->home_preview_text, 120) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
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
    <section class="max-w-7xl mx-auto px-10 py-8">
        <div class="relative p-8 lg:p-12 bg-[var(--enterprise-blue)] rounded-[30px] overflow-hidden text-center">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 right-0 w-48 h-48 bg-blue-400 rounded-full blur-[50px] -mr-24 -mt-24"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-600 rounded-full blur-[50px] -ml-24 -mb-24"></div>
            </div>
            <div class="relative z-10">
                <h2 class="text-2xl lg:text-3xl font-black text-white mb-4 tracking-tight">Scale Your Engineering
                    <br />Infrastructure Today
                </h2>
                <p class="text-blue-100 text-base max-w-xl mx-auto mb-6 font-medium">Connect with our solution architects
                    to build a bespoke automation strategy for your manufacturing pipeline.</p>
                <div class="flex flex-wrap justify-center gap-3">
                    <button type="button"
                        class="schedule-modal-open px-6 py-2.5 bg-white text-[var(--enterprise-blue)] rounded-xl font-bold text-base shadow-xl hover:scale-105 transition-all">
                        Request Custom Proposal
                    </button>
                    <button type="button"
                        class="schedule-modal-open px-6 py-2.5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-xl font-bold text-base hover:bg-white/20 transition-all">
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
            const $typeTabs = $('.type-tab-btn');
            const $typePanels = $('.type-panel');
            if ($typeTabs.length === 0 || $typePanels.length === 0) return;

            let typeTabAutoTimer;

            function activateTypeTab($tab) {
                const target = $tab.data('target');
                if (!target) return;

                $typeTabs.removeClass('is-active').attr('aria-selected', 'false');
                $tab.addClass('is-active').attr('aria-selected', 'true');

                $typePanels.addClass('hidden');
                $('#' + target).removeClass('hidden');
            }

            function getActiveTypeTabIndex() {
                const $active = $typeTabs.filter('.is-active');
                if ($active.length) return $typeTabs.index($active);
                return 0;
            }

            function advanceTypeTab() {
                const next = (getActiveTypeTabIndex() + 1) % $typeTabs.length;
                activateTypeTab($typeTabs.eq(next));
            }

            function resetTypeTabAutoAdvance() {
                clearInterval(typeTabAutoTimer);
                // typeTabAutoTimer = setInterval(advanceTypeTab, 5000);
                typeTabAutoTimer = setInterval(advanceTypeTab, 30000);
            }

            $typeTabs.on('click', function() {
                activateTypeTab($(this));
                resetTypeTabAutoAdvance();
            });

            resetTypeTabAutoAdvance();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.getCoreFreeBtn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('#downloadModal').removeClass('hidden');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const $buyPackageNowBtn = $('.buyPackageNowBtn');
            if ($buyPackageNowBtn.length === 0) return;

            $buyPackageNowBtn.on('click', function() {
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
    <script>
        $(document).ready(function() {
            const $addProductBtn = $('.addProductToCartBtn');
            if ($addProductBtn.length === 0) return;

            $addProductBtn.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

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
                if (window.CartCommon) {
                    window.CartCommon.addProductItem(item);
                    window.CartCommon.notifyAdded(name);
                }
            });
        });
    </script>
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
@endpush
