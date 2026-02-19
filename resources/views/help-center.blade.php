@extends('layouts.main')
@section('title', 'Di-tool Help Center | Autodesk Inventor Solutions')
@push('styles')
    <style>
        .hero-pattern {
            background-color: #137fec;
            background-image: radial-gradient(#ffffff33 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
@endpush
@section('content')
    <!-- Hero Section -->
    <section class="hero-pattern py-20 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight">How can we help you today?</h1>
            <p class="text-white/80 text-lg mb-10 font-medium">Search for video tutorials, FAQs, or technical documentation
                for Autodesk Inventor tools.</p>
            <div class="relative max-w-2xl mx-auto">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-slate-400">search</span>
                </div>
                <input
                    class="block w-full pl-12 pr-32 py-4 bg-white border-0 rounded-xl shadow-xl focus:ring-2 focus:ring-primary text-slate-900 placeholder:text-slate-400 text-lg"
                    placeholder="Search for video tutorials or FAQs..." type="text" />
                <button
                    class="absolute right-2 top-2 bottom-2 px-6 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors">
                    Search
                </button>
            </div>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Video Tutorials Section -->
        <section class="mb-20">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Video Tutorials</h2>
                    <p class="text-slate-500 dark:text-slate-400">Master Di-tool with our step-by-step visual guides.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button class="px-4 py-1.5 rounded-full bg-primary text-white text-sm font-bold">All</button>
                    <button
                        class="px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:border-primary">Assembly</button>
                    <button
                        class="px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:border-primary">Drawing
                        Export</button>
                    <button
                        class="px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:border-primary">API/iLogic</button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Video Card 1 -->
                <div class="group cursor-pointer">
                    <div class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200">
                        <img alt=""
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            data-alt="3D mechanical assembly in CAD software"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBLqLTx0MHzpfC1ReXg6fImXeksiBW6VrpCR6iENn-hLUp6V7jtxnyVYsQfn8nSDo4NUDxC1tuWmBwCL0UHFP-gmcAzVjhL3DMtH6vlb6BYN-bEV7_MR_veuXkHDqZbe-JMvYRyHcto9YgqH5Okzjsad4vyjC1_GjMJkK3pTpwPoq-Sx_Y1B849OgPRMfL5DHJ_Hh-b0CWKiZnzBbmqbkcFeD6WIOHDpGL_66oJyO0VQfr0gWrqBKgyfFmzUAAmNyfzXwROml_TcwU" />
                        <div
                            class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                            <span
                                class="material-symbols-outlined text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity">play_circle</span>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-bold">
                            12:45</div>
                    </div>
                    <h3
                        class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors text-lg mb-1">
                        Optimizing Assembly Performance</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Learn advanced techniques for
                        handling large assemblies in Inventor without performance drops.</p>
                </div>
                <!-- Video Card 2 -->
                <div class="group cursor-pointer">
                    <div class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200">
                        <img alt=""
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            data-alt="Technical blueprint with digital overlays"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCIzwLHyDG-bom9lS_AdOCJz7x23yItyG1UBgff3xmr9ylPtwgnMbw05wDEwMdqMwBCI4QSk989vO0I9On9zCBfDIYEAHeHNB0ylbQ0bA8mRhLeBjUiEDryASybE9zU__58Q6QL0EfISKdW7h3Uv2uniuDZjRGI07YLLwPTRZDO9p4hR53OabgBxecaHvNMKDBLOublv13oOKiJetMBHut8D9yPPqyQNMLUxIFcVp0PppaWH5Xh0GFMPHNLi3SmAoJyMuhOJTr6rgc" />
                        <div
                            class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                            <span
                                class="material-symbols-outlined text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity">play_circle</span>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-bold">
                            08:20</div>
                    </div>
                    <h3
                        class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors text-lg mb-1">
                        Automating Drawing Exports</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Streamline your documentation
                        workflow with one-click multi-format exports (PDF, DXF, DWG).</p>
                </div>
                <!-- Video Card 3 -->
                <div class="group cursor-pointer">
                    <div class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200">
                        <img alt=""
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            data-alt="Code on a screen representing iLogic scripts"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVKgS9jlegl8Mr0_Yes8z7MddMF296IMRwaEektZescWruv0Dhoq11YHB2QC65WV_LHlzn_QXxjiL4fYlp_r-WhRlnyZi1-bDEhkkb8EsVE-CFY9y1zE-GkDw7x8BDa2AseXWjBfWq_cctZJLq6R2zu7F1oTuCbKBqHdd2EL8EM9LXSRkLoXvWkmEiAQvA_P3c7Frf7zC00OE_sFkjSp2m9FjVbdQrSYI_CF6pkCR2sSb3JJmSDvQpYevoeZHcbHG383BRXfPM5V4" />
                        <div
                            class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                            <span
                                class="material-symbols-outlined text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity">play_circle</span>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-bold">
                            15:10</div>
                    </div>
                    <h3
                        class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors text-lg mb-1">
                        Getting Started with iLogic</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">An introduction to the Di-tool API
                        and how to write your first iLogic automation script.</p>
                </div>
            </div>
        </section>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- FAQ Section -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-8">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    <details
                        class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 open:ring-1 open:ring-primary overflow-hidden"
                        open="">
                        <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                            <span class="font-bold text-slate-800 dark:text-slate-100">How to update Di-tool to the latest
                                Inventor version?</span>
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div
                            class="p-5 pt-0 text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 text-sm leading-relaxed">
                            To update Di-tool, close Autodesk Inventor, then run the Di-tool Installer. The installer will
                            automatically detect your Inventor versions (2022-2024) and apply the latest plugins. No manual
                            folder moving is required.
                        </div>
                    </details>
                    <details
                        class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 open:ring-1 open:ring-primary overflow-hidden">
                        <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                            <span class="font-bold text-slate-800 dark:text-slate-100">Can I use Di-tool on multiple
                                computers?</span>
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div
                            class="p-5 pt-0 text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 text-sm leading-relaxed">
                            Licensing is per-user. You can activate Di-tool on up to two devices (e.g., your office
                            workstation and a laptop) as long as you are the primary user of both.
                        </div>
                    </details>
                    <details
                        class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 open:ring-1 open:ring-primary overflow-hidden">
                        <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                            <span class="font-bold text-slate-800 dark:text-slate-100">Where are the custom iLogic snippets
                                stored?</span>
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div
                            class="p-5 pt-0 text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 text-sm leading-relaxed">
                            All snippets are stored in %AppData%/Roaming/Di-tool/iLogicScripts. You can sync this folder
                            with your team using OneDrive or Git for collaborative automation.
                        </div>
                    </details>
                </div>
            </div>
            <!-- Documentation Section -->
            <aside>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-8">Documentation</h2>
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 divide-y divide-slate-100 dark:divide-slate-700">
                    <!-- Doc Item -->
                    <div
                        class="p-4 flex items-center justify-between group hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-50 text-red-500 p-2 rounded-lg">
                                <span class="material-symbols-outlined">description</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">User Manual v2.1</p>
                                <p class="text-xs text-slate-500">PDF • 4.2 MB</p>
                            </div>
                        </div>
                        <button class="p-2 text-primary hover:bg-primary/10 rounded-full transition-colors">
                            <span class="material-symbols-outlined">download</span>
                        </button>
                    </div>
                    <!-- Doc Item -->
                    <div
                        class="p-4 flex items-center justify-between group hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-50 text-blue-500 p-2 rounded-lg">
                                <span class="material-symbols-outlined">architecture</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">Standard Templates</p>
                                <p class="text-xs text-slate-500">ZIP • 12.8 MB</p>
                            </div>
                        </div>
                        <button class="p-2 text-primary hover:bg-primary/10 rounded-full transition-colors">
                            <span class="material-symbols-outlined">download</span>
                        </button>
                    </div>
                    <!-- Doc Item -->
                    <div
                        class="p-4 flex items-center justify-between group hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="bg-amber-50 text-amber-500 p-2 rounded-lg">
                                <span class="material-symbols-outlined">code</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">iLogic Snippet Library</p>
                                <p class="text-xs text-slate-500">JSON • 0.5 MB</p>
                            </div>
                        </div>
                        <button class="p-2 text-primary hover:bg-primary/10 rounded-full transition-colors">
                            <span class="material-symbols-outlined">download</span>
                        </button>
                    </div>
                </div>
                <div class="mt-8 p-6 bg-primary/10 rounded-xl border border-primary/20">
                    <h4 class="font-extrabold text-primary mb-2">Need a custom tool?</h4>
                    <p class="text-slate-700 dark:text-slate-300 text-sm mb-4">Our engineering team can develop custom
                        Autodesk Inventor plugins tailored to your company's workflow.</p>
                    <a class="inline-flex items-center text-sm font-bold text-primary hover:underline" href="#">
                        Contact Engineering
                        <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                    </a>
                </div>
            </aside>
        </div>
    </div>

    <!-- Floating Quick Support Button -->
    <div class="fixed bottom-6 right-6 flex flex-col items-end gap-3 z-[100]">
        <div
            class="hidden group-hover:block bg-white dark:bg-slate-800 shadow-2xl rounded-xl p-4 border border-slate-200 dark:border-slate-700 mb-2 w-64 animate-in fade-in slide-in-from-bottom-2">
            <p class="font-bold text-slate-900 dark:text-white mb-1">How can we help?</p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">Our support team typically responds within 2 hours
                during business hours.</p>
            <button
                class="w-full py-2 bg-primary text-white text-xs font-bold rounded hover:bg-primary/90 transition-all">Open
                Support Ticket</button>
        </div>
        <button
            class="size-14 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95 group">
            <span class="material-symbols-outlined text-3xl">question_answer</span>
        </button>
    </div>
@endsection

@push('scripts')
@endpush
