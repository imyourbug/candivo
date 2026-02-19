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
        <div class="container mx-auto px-6 relative z-20 text-center max-w-4xl">
            <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-[-0.033em] mb-6">
                Revolutionizing Autodesk Inventor Workflows
            </h1>
            <p class="text-white/90 text-lg md:text-xl font-normal leading-relaxed mb-8 max-w-2xl mx-auto">
                Empowering mechanical engineers with precision-engineered software tools designed for the future of CAD and
                digital manufacturing.
            </p>
            <button
                class="bg-primary text-white px-8 py-4 rounded-lg font-bold text-lg hover:brightness-110 transition-all shadow-lg">
                Meet Our Team
            </button>
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
                    <p class="text-[#4c739a] text-lg leading-relaxed">
                        From our origins as a niche engineering consultancy to a global software powerhouse, Di-tool has
                        always been engineer-centric. We started with a simple observation: repetitive tasks were stifling
                        innovation in the mechanical design world.
                    </p>
                    <p class="text-[#4c739a] text-lg leading-relaxed">
                        Today, we provide seamless, high-performance plugins that eliminate friction in Autodesk Inventor,
                        allowing engineers to focus on what they do best—creating the next generation of physical products.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div class="p-4 border border-primary/20 rounded-xl bg-primary/5">
                            <div class="text-primary mb-2"><span
                                    class="material-symbols-outlined text-3xl">rocket_launch</span></div>
                            <h4 class="font-bold text-[#0d141b]">Our Mission</h4>
                            <p class="text-sm text-[#4c739a]">High-performance plugins that eliminate workflow friction.</p>
                        </div>
                        <div class="p-4 border border-primary/20 rounded-xl bg-primary/5">
                            <div class="text-primary mb-2"><span
                                    class="material-symbols-outlined text-3xl">visibility</span></div>
                            <h4 class="font-bold text-[#0d141b]">Our Vision</h4>
                            <p class="text-sm text-[#4c739a]">Setting the global standard for CAD efficiency.</p>
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
            <div class="grid md:grid-cols-4 gap-8">
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-xl mb-4 shadow-sm z-10">
                        2015</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">Founded</h4>
                    <p class="text-sm text-[#4c739a] mt-2">Born as a specialized CAD consulting firm in Berlin.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-xl mb-4 shadow-sm z-10">
                        2018</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">First Plugin</h4>
                    <p class="text-sm text-[#4c739a] mt-2">Launched "BatchExport Pro" for Inventor, saving users 40+
                        hours/month.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-xl mb-4 shadow-sm z-10">
                        2021</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">10k Users</h4>
                    <p class="text-sm text-[#4c739a] mt-2">Reached global adoption across 50 countries and 12 industries.
                    </p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-white border-4 border-primary flex items-center justify-center text-primary font-bold text-xl mb-4 shadow-sm z-10">
                        2024</div>
                    <h4 class="font-bold text-[#0d141b] text-lg">AI-Integration</h4>
                    <p class="text-sm text-[#4c739a] mt-2">Pioneering generative design helpers for Autodesk Inventor.</p>
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
                    <p class="text-[#4c739a] mb-8">We understand the rigor of mechanical engineering. Our tools aren't just
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
                        <p class="text-[#4c739a] text-sm">Calculations and automation logic tested against ISO and ANSI
                            standards for zero-error outputs.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow">
                        <span class="material-symbols-outlined text-primary text-4xl mb-4">bolt</span>
                        <h4 class="font-bold text-xl mb-2">Built for Speed</h4>
                        <p class="text-[#4c739a] text-sm">Lightweight architecture ensures zero impact on Inventor’s startup
                            or run-time performance.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow">
                        <span class="material-symbols-outlined text-primary text-4xl mb-4">hub</span>
                        <h4 class="font-bold text-xl mb-2">Native Integration</h4>
                        <p class="text-[#4c739a] text-sm">Feels like a part of Autodesk Inventor, not an add-on. Familiar
                            UI/UX patterns reduce the learning curve.</p>
                    </div>
                    <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-shadow">
                        <span class="material-symbols-outlined text-primary text-4xl mb-4">support_agent</span>
                        <h4 class="font-bold text-xl mb-2">24/7 Expert Support</h4>
                        <p class="text-[#4c739a] text-sm">Support tickets are handled by actual engineers, not generic
                            customer service bots.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Values Section -->
    <section class="py-20 bg-slate-900 text-white">
        <div class="container mx-auto px-6 max-w-[1100px] text-center">
            <h2 class="text-3xl font-black mb-16">Our Core Values</h2>
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
