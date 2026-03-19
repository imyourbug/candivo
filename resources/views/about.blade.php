@extends('layouts.main')
@section('title', 'About Us | Di-tool - Engineering the Future of CAD')
@section('content')
    <!-- Hero Section -->
    <section class="relative w-full h-[500px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-slate-900/60 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center"
            data-alt="Close up of high precision industrial robotic arm and CAD monitor"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD9r1swNDdY9wr-cA636Bpv6hiknKAXwOf-7GhonPj9nhux-gmF07c1BkgrfyjrksKOZo4hB3_2ctCHOzt8BQCX9O8M3Eu_pn-ytTc2xlbDEzQ1ExYazo0DfDJfTyy8P_5GMngiPTjUhQmlkk_EXBcpjRoQZu4ZKP-_QnLY9dsKKO44PXd0iy1VSVsw-4i0j8PHETl5zQ4nK5fruPwgFtxZ6oiXlUcuSYxXR7s2wNvJbg-9ETfyAMEGEpeTHCW1JkhNL9T_RlsKrqg");'>
        </div>
        <div class="container mx-auto px-6 relative z-20 text-left max-w-4xl">
            <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-[-0.033em] mb-6">
                Revolutionizing Autodesk Inventor Workflows
            </h1>
            <p class="text-white/90 text-lg md:text-xl font-normal leading-relaxed mb-8 max-w-2xl text-left">
                Empowering mechanical engineers with precision-engineered software tools designed for the future of CAD and
                digital manufacturing.
            </p>
            <button
                class="bg-[#1e79dc] text-white px-8 py-4 rounded-lg font-bold text-lg hover:brightness-110 transition-all shadow-lg">
                Meet Our Team
            </button>
        </div>
    </section>

    {{-- <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6 max-w-[1100px]">
            <h2 class="text-[#0d141b] text-3xl md:text-4xl font-black tracking-tight mb-10 lg:mb-12">ABOUT US</h2>
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-start">
                <div class="space-y-6 text-[#0d141b] text-base md:text-lg leading-relaxed text-left">
                    <p>
                        I started DaCu3D as a technical drafting company focused on CAD work and engineering. Over the years, the
                        company grew beyond just drafting. We now develop smart automation, configurators, and tools that help
                        businesses work faster and more efficiently. This evolution called for a name that better reflects what we
                        do. That's how CADINVO was born.
                    </p>
                    <p class="font-semibold">The name CADINVO stands for:</p>
                    <ul class="text-left space-y-3 list-none">
                        <li class="flex gap-3 items-start">
                            <span class="material-symbols-outlined text-primary shrink-0 text-xl">check_circle</span>
                            <span><strong class="font-bold">CAD</strong> – the foundation of our work.</span>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="material-symbols-outlined text-primary shrink-0 text-xl">check_circle</span>
                            <span><strong class="font-bold">INVO</strong> – a combination of Inventor (the software we use),
                                Involvement (our commitment to projects), and Innovation (our focus on smart solutions).</span>
                        </li>
                    </ul>
                    <p>
                        CADINVO is a trade name under DaCu3D.bv, keeping our roots visible while showcasing our broader focus.
                    </p>
                    <p>
                        Today, CADINVO represents much more than just drafting. We provide innovative CAD solutions and automated
                        tools that streamline and simplify processes.
                    </p>
                    <p>
                        Our mission remains the same: helping businesses work smarter, faster, and more efficiently.
                    </p>
                </div>
                <div class="order-1 lg:order-2">
                    @php
                        $portraitPath = public_path('images/aboutus1.jpg');
                        $hasPortrait = file_exists($portraitPath);
                    @endphp
                    @if ($hasPortrait)
                        <img src="{{ asset('images/aboutus1.jpg') }}"
                            alt="Daniël Cuperus, founder of DaCu3D and CADINVO"
                            class="w-full max-w-md mx-auto lg:max-w-none rounded-2xl shadow-xl object-cover aspect-[4/5] lg:aspect-auto lg:min-h-[680px]" />
                    @else
                        <div
                            class="w-full max-w-md mx-auto lg:max-w-none rounded-2xl shadow-lg border border-slate-200/80 bg-white/50 flex items-center justify-center aspect-[4/5] lg:min-h-[480px]">
                            <span class="material-symbols-outlined text-7xl text-slate-400">person</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section> --}}

    <section class="py-16 md:py-24 bg-[#d7e2ed]">
        <div class="container mx-auto px-6 max-w-[1100px]">
            <h2 class="text-[#0d141b] text-3xl md:text-4xl font-black tracking-tight mb-10 lg:mb-12">Who is Daniël Cuperus?
            </h2>
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-start">
                <div class="space-y-5 text-[#0d141b] text-base md:text-lg leading-relaxed order-2 lg:order-1">
                    <p>
                        Daniël Cuperus is the founder and owner of DaCu3D, a technical drafting company, and the creator of
                        CADINVO, a brand focused on smart CAD automation, solutions, and project execution. Born in Burgum,
                        the Netherlands, in 1979, Daniël has a strong background in construction engineering, having
                        completed
                        both MBO and HBO studies in the field.
                    </p>
                    <p>
                        Throughout his career, Daniël has gained extensive international experience, working in countries
                        like
                        Germany, Austria, and Singapore, where he led major construction projects. This global exposure
                        strengthened his leadership skills and deepened his passion for technical innovation.
                    </p>
                    <p>
                        In 2018, Daniël founded DaCu3D, combining his expertise in CAD design with a vision to help
                        companies in
                        the manufacturing industry work more efficiently. What started as a traditional drafting company has
                        since evolved. Today, through CADINVO, Daniël focuses on developing smart automation, configurators,
                        and
                        tools, and managing complete CAD projects from start to finish.
                    </p>
                    <p>
                        Known for his strategic thinking, goal-oriented approach, and decisiveness, Daniël is committed to
                        delivering practical, efficient solutions that make a real impact. He leads an international team of
                        engineers based in the Netherlands, Belgium, and Vietnam, ensuring high-quality work, flexible
                        capacity,
                        and comprehensive project management for clients.
                    </p>
                    <p class="font-semibold">
                        His mission? To help companies transform technical challenges into practical, efficient solutions
                        while
                        fostering meaningful partnerships and delivering high-quality CAD projects.
                    </p>
                </div>
                {{-- Portrait: place image at public/images/daniel.png --}}
                <div class="order-1 lg:order-2">
                    @php
                        $portraitPath = public_path('images/daniel.png');
                        $hasPortrait = file_exists($portraitPath);
                    @endphp
                    @if ($hasPortrait)
                        <img src="{{ asset('images/daniel.png') }}" alt="Daniël Cuperus, founder of DaCu3D and CADINVO"
                            class="w-full max-w-md mx-auto lg:max-w-none rounded-2xl shadow-xl object-cover aspect-[4/5] lg:aspect-auto lg:min-h-[880px]" />
                    @else
                        <div
                            class="w-full max-w-md mx-auto lg:max-w-none rounded-2xl shadow-lg border border-slate-200/80 bg-white/50 flex items-center justify-center aspect-[4/5] lg:min-h-[480px]">
                            <span class="material-symbols-outlined text-7xl text-slate-400">person</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story & Mission -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-[1100px]">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="flex flex-col gap-6">
                    <span class="text-primary font-bold tracking-widest uppercase text-sm">Our Legacy</span>
                    <h2 class="text-[#0d141b] text-4xl font-black leading-tight tracking-[-0.033em]">
                        Engineering a Better Workflow
                    </h2>
                    <p class="text-[#295eb0] text-lg leading-relaxed">
                        From our origins as a niche engineering consultancy to a global software powerhouse, Di-tool has
                        always been engineer-centric. We started with a simple observation: repetitive tasks were stifling
                        innovation in the mechanical design world.
                    </p>
                    <p class="text-[#295eb0] text-lg leading-relaxed">
                        Today, we provide seamless, high-performance plugins that eliminate friction in Autodesk Inventor,
                        allowing engineers to focus on what they do best—creating the next generation of physical products.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div class="p-4 border border-primary/20 rounded-xl bg-primary/5">
                            <div class="text-primary mb-2"><span
                                    class="material-symbols-outlined text-3xl">rocket_launch</span></div>
                            <h4 class="font-bold text-[#0d141b]">Our Mission</h4>
                            <p class="text-sm text-[#295eb0]">High-performance plugins that eliminate workflow friction.</p>
                        </div>
                        <div class="p-4 border border-primary/20 rounded-xl bg-primary/5">
                            <div class="text-primary mb-2"><span
                                    class="material-symbols-outlined text-3xl">visibility</span></div>
                            <h4 class="font-bold text-[#0d141b]">Our Vision</h4>
                            <p class="text-sm text-[#295eb0]">Setting the global standard for CAD efficiency.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-primary/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-primary/10 rounded-full blur-3xl"></div>
                    <img alt="" class="rounded-2xl shadow-2xl relative z-10 object-cover aspect-square"
                        data-alt="Modern office with engineering blueprints and high-end workstations"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpQizN4ci_FUIlV-DfE2IYnxixvjZUSdUf23W70dK6M6ulpiCZDLxrmwg0HbxLFTA5C8QDNnVysgCYCDBtVB5rBZHq_tdTVLwp9sJ3Aq7DHajy2LIny5F2jI67s8NB0sXmjDcqjygh0KbxqT634sag6PK1RtyIqNSHbfLa_AUULYKcQJmqwSOJXRHvaOBu26ZH3BPTLNjQ-i2cOlZuOXkDsnFa_dXOZiytzrfHyhbXCypZd2HLxELvoRAIYymx7l-_n2nbUTVRqj8" />
                </div>
            </div>
        </div>
    </section>
    <!-- Milestones Section -->
    <section class="py-20 bg-background-light">
        <div class="container mx-auto px-6 max-w-[1100px]">
            <div class="text-center mb-16">
                <h2 class="text-[#0d141b] text-3xl font-black mb-4">Key Engineering Milestones</h2>
                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-xl mb-4 shadow-sm z-10">
                        2018</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">Founded</h4>
                    <p class="text-sm text-[#295eb0] mt-2">Company established—building on a foundation of engineering
                        excellence.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-lg mb-4 shadow-sm z-10 leading-tight px-1">
                        600+</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">Projects completed</h4>
                    <p class="text-sm text-[#295eb0] mt-2">Over 600 projects successfully delivered for our clients.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-xl mb-4 shadow-sm z-10">
                        30+</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">Active clients</h4>
                    <p class="text-sm text-[#295eb0] mt-2">More than 30 active clients rely on our expertise.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-xl mb-4 shadow-sm z-10">
                        20+</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">Expert team</h4>
                    <p class="text-sm text-[#295eb0] mt-2">Experts based in the Netherlands, Belgium, Latvia, and Vietnam.
                    </p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-sm mb-4 shadow-sm z-10 px-1 leading-tight text-center">
                        CAD</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">Engineering focus</h4>
                    <p class="text-sm text-[#295eb0] mt-2">CAD engineering support, automation, and configurators.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Professionals Choose Us -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-[1100px]">
            <div class="flex flex-col lg:flex-row gap-16 items-start">
                <div class="lg:w-1/3">
                    <h2 class="text-[#0d141b] text-4xl font-black leading-tight mb-6">Why professional engineers choose
                        Di-tool</h2>
                    <p class="text-[#295eb0] mb-8">We understand the rigor of mechanical engineering. Our tools aren't just
                        software; they are precision instruments.</p>
                    <button class="flex items-center gap-2 text-primary font-bold hover:gap-4 transition-all">
                        <span>Explore our solutions</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
                <div class="lg:w-2/3 grid sm:grid-cols-2 gap-8">
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow">
                        <span class="material-symbols-outlined text-primary text-4xl mb-4">precision_manufacturing</span>
                        <h4 class="font-bold text-xl mb-2">Unmatched Precision</h4>
                        <p class="text-[#295eb0] text-sm">Calculations and automation logic tested against ISO and ANSI
                            standards for zero-error outputs.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow">
                        <span class="material-symbols-outlined text-primary text-4xl mb-4">bolt</span>
                        <h4 class="font-bold text-xl mb-2">Built for Speed</h4>
                        <p class="text-[#295eb0] text-sm">Lightweight architecture ensures zero impact on Inventor’s startup
                            or run-time performance.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow">
                        <span class="material-symbols-outlined text-primary text-4xl mb-4">hub</span>
                        <h4 class="font-bold text-xl mb-2">Native Integration</h4>
                        <p class="text-[#295eb0] text-sm">Feels like a part of Autodesk Inventor, not an add-on. Familiar
                            UI/UX patterns reduce the learning curve.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow">
                        <span class="material-symbols-outlined text-primary text-4xl mb-4">support_agent</span>
                        <h4 class="font-bold text-xl mb-2">24/7 Expert Support</h4>
                        <p class="text-[#295eb0] text-sm">Support tickets are handled by actual engineers, not generic
                            customer service bots.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Values Section -->
    <section class="py-10 bg-slate-900 text-white">
        <div class="container mx-auto px-6 max-w-[1100px] text-center">
            <h2 class="text-3xl font-black mb-4">Our Core Values</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="group">
                    <div
                        class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-primary transition-colors">
                        <span class="material-symbols-outlined text-4xl text-primary group-hover:text-white">biotech</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Innovation</h3>
                    <p class="text-white/60 text-sm">Constantly pushing the boundaries of what's possible in parametric
                        modeling.</p>
                </div>
                <div class="group">
                    <div
                        class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-primary transition-colors">
                        <span
                            class="material-symbols-outlined text-4xl text-primary group-hover:text-white">architecture</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Integrity</h3>
                    <p class="text-white/60 text-sm">Building reliable tools that engineers can trust with their most
                        critical projects.</p>
                </div>
                <div class="group">
                    <div
                        class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-primary transition-colors">
                        <span class="material-symbols-outlined text-4xl text-primary group-hover:text-white">groups</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Collaboration</h3>
                    <p class="text-white/60 text-sm">Listening to our user community to shape the future of our product
                        roadmap.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
