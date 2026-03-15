@extends('layouts.main')
@section('title', 'Di-tool Help Center | Autodesk Inventor Solutions')

@push('styles')
    <style>
        .hero-pattern {
            background-color: #137fec;
            background-image: radial-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .help-sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .help-sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .help-nav-details summary {
            list-style: none;
        }

        .help-nav-details summary::-webkit-details-marker {
            display: none;
        }

        .help-nav-tree .nav-expand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.25rem;
            flex-shrink: 0;
            font-size: 0.875rem;
            font-weight: 700;
            color: #64748b;
        }

        .help-nav-tree .nav-expand-icon::before {
            content: '+';
        }

        .help-nav-tree details[open] > summary .nav-expand-icon::before {
            content: '−';
        }
    </style>
@endpush

@section('content')
    {{-- Golden top banner (image reference) --}}
    <div class="h-1.5 w-full bg-amber-400" aria-hidden="true"></div>
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

    <div class="flex min-h-[calc(100vh-4px)] bg-[#f6f7f8] dark:bg-slate-950">
        {{-- Sidebar Navigation (example + image style) --}}
        <aside
            class="w-72 flex-shrink-0 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col sticky top-0 h-[calc(100vh-6px)]">
            <nav class="help-nav-tree flex-1 overflow-y-auto p-4 space-y-0 help-sidebar-scroll">
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">You can find your issue here...</p>
                {{-- Level 1 (collapsed) --}}
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>Di-tool What's New</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">2024 Release</a>
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">2024.1 Updates</a>
                    </div>
                </details>
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>Release Notes</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Version History</a>
                    </div>
                </details>
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>Get Started videos</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#video-tutorials">Quick Start</a>
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Installation</a>
                    </div>
                </details>
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>Tutorials</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Part Modeling</a>
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Assembly</a>
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">iLogic</a>
                    </div>
                </details>

                {{-- Level 1 (expanded) – Help Topics --}}
                <details class="help-nav-details" open>
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>Di-tool Help Topics</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        {{-- Level 2: Inventor Basics (expanded) --}}
                        <details class="help-nav-details" open>
                            <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                                <span class="nav-expand-icon" aria-hidden="true"></span>
                                <span>Inventor Basics</span>
                            </summary>
                            <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                {{-- Level 3: User Interface (expanded) --}}
                                <details class="help-nav-details" open>
                                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                                        <span class="nav-expand-icon" aria-hidden="true"></span>
                                        <span>User Interface</span>
                                    </summary>
                                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                        {{-- Level 4: About Home (expanded) --}}
                                        <details class="help-nav-details" open>
                                            <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-[#137fec] bg-[#137fec]/10 hover:bg-[#137fec]/15 rounded px-1 text-sm font-semibold">
                                                <span class="nav-expand-icon" aria-hidden="true"></span>
                                                <span>About Home</span>
                                            </summary>
                                            <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                                {{-- Level 5: About the Ribbon (expanded) --}}
                                                <details class="help-nav-details" open>
                                                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                                                        <span class="nav-expand-icon" aria-hidden="true"></span>
                                                        <span>About the Ribbon</span>
                                                    </summary>
                                                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">To Work with the Ribbon</a>
                                                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">To Work with Icons, Tooltips</a>
                                                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">To Customize User Commands</a>
                                                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">To Highlight New and Updated Commands</a>
                                                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Reference for Customize Dialog Ribbon Tab</a>
                                                    </div>
                                                </details>
                                            </div>
                                        </details>
                                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#about-ribbon">About the Ribbon</a>
                                    </div>
                                </details>
                                <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Reference for Customize Dialog Ribbon Tab</a>
                                <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">To Repeat the Last Command</a>
                            </div>
                        </details>
                    </div>
                </details>

                {{-- More Level 1 (collapsed) --}}
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>Di-tool Browser</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Browser Panel</a>
                    </div>
                </details>
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>About Marking Menus</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Marking Menu Options</a>
                    </div>
                </details>
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>To Work with the Navigation Bar</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Navigation Bar</a>
                    </div>
                </details>
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>About Graphics Windows</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">Graphics Window</a>
                    </div>
                </details>
                <details class="help-nav-details">
                    <summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                        <span class="nav-expand-icon" aria-hidden="true"></span>
                        <span>About InfoCenter</span>
                    </summary>
                    <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                        <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm" href="#">InfoCenter</a>
                    </div>
                </details>
                <a class="flex items-center gap-2 py-1.5 pl-7 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#137fec] rounded px-1 text-sm" href="#video-tutorials">Video Tutorials</a>
                <a class="flex items-center gap-2 py-1.5 pl-7 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#137fec] rounded px-1 text-sm" href="#faq">FAQs</a>
                <a class="flex items-center gap-2 py-1.5 pl-7 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#137fec] rounded px-1 text-sm" href="#documentation">Documentation</a>
            </nav>
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                <button
                    class="w-full flex items-center justify-center gap-2 bg-[#137fec] hover:bg-[#137fec]/90 text-white font-bold py-2.5 px-4 rounded-lg text-sm transition-all shadow-sm">
                    <span class="material-symbols-outlined text-sm">confirmation_number</span>
                    Support Ticket
                </button>
            </div>
        </aside>

        {{-- Main content area --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-auto">
            <div class="max-w-6xl w-full mx-auto px-2 lg:px-2 py-8">
                {{-- Back + Title + SHARE (image style) --}}
                <div class="mb-6">
                    <button type="button"
                        class="flex items-center gap-1.5 text-[#137fec] text-sm font-bold hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Back to Search Results
                    </button>
                </div>
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <h2 id="about-help" class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">About Help
                        Center</h2>
                    <a href="#"
                        class="flex items-center gap-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm font-bold">
                        <span class="material-symbols-outlined text-lg">share</span>
                        SHARE
                    </a>
                </div>
                <hr class="border-slate-200 dark:border-slate-700 mb-8" />

                {{-- What's New (image: version links) --}}
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">
                    <span class="font-semibold text-slate-700 dark:text-slate-300">What's New:</span>
                    <a class="text-[#137fec] font-medium hover:underline" href="#">2024</a>,
                    <a class="text-[#137fec] font-medium hover:underline" href="#">2024.1</a>,
                    <a class="text-[#137fec] font-medium hover:underline" href="#">2024.2</a>
                </p>
                <p class="text-slate-700 dark:text-slate-300 leading-relaxed mb-10">
                    Use the Help Center to search tutorials, open FAQs, and download documentation.
                </p>

                {{-- Interactive card + numbered list (image: "Set Projects, Open files, Create New files") --}}
                <section class="mb-12">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Search, open tutorials, and get
                        support</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-4">Use this panel for quick access to help resources.
                    </p>
                    <div
                        class="bg-slate-100 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Di-tool Help Center</h4>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 flex-wrap">
                                <span
                                    class="flex items-center justify-center w-7 h-7 rounded-full bg-slate-700 text-white text-sm font-bold">1</span>
                                <div class="relative flex-1 min-w-[200px] max-w-md">
                                    <span
                                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                                    <input
                                        class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-[#137fec]/30"
                                        placeholder="Search tutorials or FAQs..." type="text" />
                                </div>
                                <button type="button"
                                    class="p-2 rounded-lg border border-slate-200 dark:border-slate-600 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                                    title="Settings"><span
                                        class="material-symbols-outlined text-lg">more_horiz</span></button>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <span
                                    class="flex items-center justify-center w-7 h-7 rounded-full bg-slate-700 text-white text-sm font-bold">2</span>
                                <button type="button"
                                    class="flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                    Open... <span class="material-symbols-outlined text-lg">arrow_drop_down</span>
                                </button>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <span
                                    class="flex items-center justify-center w-7 h-7 rounded-full bg-slate-700 text-white text-sm font-bold">3</span>
                                <button type="button"
                                    class="flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                    New... <span class="material-symbols-outlined text-lg">arrow_drop_down</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <ol class="mt-6 space-y-2 text-sm text-slate-700 dark:text-slate-300 list-decimal list-inside">
                        <li><strong>Search:</strong> Enter keywords to find video tutorials, FAQs, or technical
                            documentation.</li>
                        <li><strong>Open:</strong> Browse and open recent help articles or saved bookmarks.</li>
                        <li><strong>New:</strong> Start a new support request or open the documentation library.</li>
                    </ol>
                </section>

                {{-- Video Tutorials --}}
                <section id="video-tutorials" class="mb-16">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Video Tutorials</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">Master Di-tool with our step-by-step visual guides.
                    </p>
                    <div class="flex gap-2 mb-6 flex-wrap">
                        <button type="button"
                            class="px-4 py-1.5 rounded-full bg-[#137fec] text-white text-sm font-bold">All</button>
                        <button type="button"
                            class="px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:border-[#137fec]">Assembly</button>
                        <button type="button"
                            class="px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:border-[#137fec]">Drawing
                            Export</button>
                        <button type="button"
                            class="px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium hover:border-[#137fec]">API
                            / iLogic</button>
                    </div>
                    <div class="relative" id="videoTutorialsSliderWrap">
                        <div class="overflow-hidden rounded-xl" id="videoTutorialsSlider">
                            <div class="flex gap-4 md:gap-6 transition-transform duration-300 ease-out"
                                id="videoTutorialsTrack" style="transform: translateX(0);">
                                <div class="video-slide flex-shrink-0 w-1/2 md:w-1/3 lg:w-1/4 px-1 md:px-2">
                                    <div class="group cursor-pointer">
                                        <div
                                            class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200">
                                            <img alt="3D mechanical assembly"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBLqLTx0MHzpfC1ReXg6fImXeksiBW6VrpCR6iENn-hLUp6V7jtxnyVYsQfn8nSDo4NUDxC1tuWmBwCL0UHFP-gmcAzVjhL3DMtH6vlb6BYN-bEV7_MR_veuXkHDqZbe-JMvYRyHcto9YgqH5Okzjsad4vyjC1_GjMJkK3pTpwPoq-Sx_Y1B849OgPRMfL5DHJ_Hh-b0CWKiZnzBbmqbkcFeD6WIOHDpGL_66oJyO0VQfr0gWrqBKgyfFmzUAAmNyfzXwROml_TcwU" />
                                            <div
                                                class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity">play_circle</span>
                                            </div>
                                            <div
                                                class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-bold">
                                                12:45</div>
                                        </div>
                                        <h4
                                            class="font-bold text-slate-900 dark:text-white group-hover:text-[#137fec] transition-colors text-lg mb-1">
                                            Optimizing Assembly Performance</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Learn advanced
                                            techniques for large assemblies in Inventor.</p>
                                    </div>
                                </div>
                                <div class="video-slide flex-shrink-0 w-1/2 md:w-1/3 lg:w-1/4 px-1 md:px-2">
                                    <div class="group cursor-pointer">
                                        <div
                                            class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200">
                                            <img alt="Technical blueprint"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCIzwLHyDG-bom9lS_AdOCJz7x23yItyG1UBgff3xmr9ylPtwgnMbw05wDEwMdqMwBCI4QSk989vO0I9On9zCBfDIYEAHeHNB0ylbQ0bA8mRhLeBjUiEDryASybE9zU__58Q6QL0EfISKdW7h3Uv2uniuDZjRGI07YLLwPTRZDO9p4hR53OabgBxecaHvNMKDBLOublv13oOKiJetMBHut8D9yPPqyQNMLUxIFcVp0PppaWH5Xh0GFMPHNLi3SmAoJyMuhOJTr6rgc" />
                                            <div
                                                class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity">play_circle</span>
                                            </div>
                                            <div
                                                class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-bold">
                                                08:20</div>
                                        </div>
                                        <h4
                                            class="font-bold text-slate-900 dark:text-white group-hover:text-[#137fec] transition-colors text-lg mb-1">
                                            Automating Drawing Exports</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">One-click
                                            multi-format exports (PDF, DXF, DWG).</p>
                                    </div>
                                </div>
                                <div class="video-slide flex-shrink-0 w-1/2 md:w-1/3 lg:w-1/4 px-1 md:px-2">
                                    <div class="group cursor-pointer">
                                        <div
                                            class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200">
                                            <img alt="iLogic scripts"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVKgS9jlegl8Mr0_Yes8z7MddMF296IMRwaEektZescWruv0Dhoq11YHB2QC65WV_LHlzn_QXxjiL4fYlp_r-WhRlnyZi1-bDEhkkb8EsVE-CFY9y1zE-GkDw7x8BDa2AseXWjBfWq_cctZJLq6R2zu7F1oTuCbKBqHdd2EL8EM9LXSRkLoXvWkmEiAQvA_P3c7Frf7zC00OE_sFkjSp2m9FjVbdQrSYI_CF6pkCR2sSb3JJmSDvQpYevoeZHcbHG383BRXfPM5V4" />
                                            <div
                                                class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity">play_circle</span>
                                            </div>
                                            <div
                                                class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-bold">
                                                15:10</div>
                                        </div>
                                        <h4
                                            class="font-bold text-slate-900 dark:text-white group-hover:text-[#137fec] transition-colors text-lg mb-1">
                                            Getting Started with iLogic</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Introduction to
                                            the Di-tool API and your first script.</p>
                                    </div>
                                </div>
                                <div class="video-slide flex-shrink-0 w-1/2 md:w-1/3 lg:w-1/4 px-1 md:px-2">
                                    <div class="group cursor-pointer">
                                        <div
                                            class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200">
                                            <img alt="BOM and drawing"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBLqLTx0MHzpfC1ReXg6fImXeksiBW6VrpCR6iENn-hLUp6V7jtxnyVYsQfn8nSDo4NUDxC1tuWmBwCL0UHFP-gmcAzVjhL3DMtH6vlb6BYN-bEV7_MR_veuXkHDqZbe-JMvYRyHcto9YgqH5Okzjsad4vyjC1_GjMJkK3pTpwPoq-Sx_Y1B849OgPRMfL5DHJ_Hh-b0CWKiZnzBbmqbkcFeD6WIOHDpGL_66oJyO0VQfr0gWrqBKgyfFmzUAAmNyfzXwROml_TcwU" />
                                            <div
                                                class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity">play_circle</span>
                                            </div>
                                            <div
                                                class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-bold">
                                                10:30</div>
                                        </div>
                                        <h4
                                            class="font-bold text-slate-900 dark:text-white group-hover:text-[#137fec] transition-colors text-lg mb-1">
                                            BOM and Drawing Standards</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">Best practices
                                            for BOM and consistent drawing output.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="videoSliderPrev"
                            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-4 z-10 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white dark:bg-slate-800 shadow-lg border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
                            aria-label="Previous">
                            <span class="material-symbols-outlined text-2xl">chevron_left</span>
                        </button>
                        <button type="button" id="videoSliderNext"
                            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-4 z-10 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white dark:bg-slate-800 shadow-lg border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
                            aria-label="Next">
                            <span class="material-symbols-outlined text-2xl">chevron_right</span>
                        </button>
                        <div class="flex justify-center gap-2 mt-6" id="videoSliderDots"></div>
                    </div>
                </section>

                {{-- Recent Documents (image) --}}
                <section class="mb-16">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Recent Documents</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-4">Quick access to your recently viewed help articles.
                    </p>
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 divide-y divide-slate-100 dark:divide-slate-700">
                        <a href="#"
                            class="flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <span class="material-symbols-outlined text-slate-400">description</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200">User Manual v2.1</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <span class="material-symbols-outlined text-slate-400">play_circle</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Getting Started with
                                iLogic</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <span class="material-symbols-outlined text-slate-400">quiz</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Licensing and activation
                                FAQ</span>
                        </a>
                    </div>
                </section>

                {{-- FAQs --}}
                <section id="faq" class="mb-16">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Frequently Asked Questions</h3>
                    <div class="space-y-4">
                        <details
                            class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 open:ring-1 open:ring-[#137fec] overflow-hidden">
                            <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                                <span class="font-bold text-slate-800 dark:text-slate-100">How to update Di-tool to the
                                    latest Inventor version?</span>
                                <span
                                    class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <div
                                class="p-5 pt-0 text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 text-sm leading-relaxed">
                                To update Di-tool, close Autodesk Inventor, then run the Di-tool Installer. The installer
                                will automatically detect your Inventor versions (2022–2024) and apply the latest plugins.
                            </div>
                        </details>
                        <details
                            class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 open:ring-1 open:ring-[#137fec] overflow-hidden">
                            <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                                <span class="font-bold text-slate-800 dark:text-slate-100">Can I use Di-tool on multiple
                                    computers?</span>
                                <span
                                    class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <div
                                class="p-5 pt-0 text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 text-sm leading-relaxed">
                                Licensing is per-user. You can activate Di-tool on up to two devices as long as you are the
                                primary user of both.
                            </div>
                        </details>
                        <details
                            class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 open:ring-1 open:ring-[#137fec] overflow-hidden">
                            <summary class="flex items-center justify-between p-5 cursor-pointer list-none">
                                <span class="font-bold text-slate-800 dark:text-slate-100">Where are custom iLogic snippets
                                    stored?</span>
                                <span
                                    class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <div
                                class="p-5 pt-0 text-slate-600 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 text-sm leading-relaxed">
                                All snippets are stored in %AppData%/Roaming/Di-tool/iLogicScripts. You can sync this folder
                                with your team using OneDrive or Git.
                            </div>
                        </details>
                    </div>
                </section>

                {{-- Documentation --}}
                <section id="documentation" class="mb-16">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Documentation</h3>
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 divide-y divide-slate-100 dark:divide-slate-700">
                        <div
                            class="p-4 flex items-center justify-between group hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="bg-red-50 dark:bg-red-900/20 text-red-500 p-2 rounded-lg">
                                    <span class="material-symbols-outlined">description</span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">User Manual v2.1</p>
                                    <p class="text-xs text-slate-500">PDF • 4.2 MB</p>
                                </div>
                            </div>
                            <button type="button"
                                class="p-2 text-[#137fec] hover:bg-[#137fec]/10 rounded-full transition-colors">
                                <span class="material-symbols-outlined">download</span>
                            </button>
                        </div>
                        <div
                            class="p-4 flex items-center justify-between group hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-500 p-2 rounded-lg">
                                    <span class="material-symbols-outlined">architecture</span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">Standard Templates</p>
                                    <p class="text-xs text-slate-500">ZIP • 12.8 MB</p>
                                </div>
                            </div>
                            <button type="button"
                                class="p-2 text-[#137fec] hover:bg-[#137fec]/10 rounded-full transition-colors">
                                <span class="material-symbols-outlined">download</span>
                            </button>
                        </div>
                        <div
                            class="p-4 flex items-center justify-between group hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="bg-amber-50 dark:bg-amber-900/20 text-amber-500 p-2 rounded-lg">
                                    <span class="material-symbols-outlined">code</span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">iLogic Snippet Library
                                    </p>
                                    <p class="text-xs text-slate-500">JSON • 0.5 MB</p>
                                </div>
                            </div>
                            <button type="button"
                                class="p-2 text-[#137fec] hover:bg-[#137fec]/10 rounded-full transition-colors">
                                <span class="material-symbols-outlined">download</span>
                            </button>
                        </div>
                    </div>
                    <div class="mt-8 p-6 bg-[#137fec]/10 rounded-xl border border-[#137fec]/20">
                        <h4 class="font-extrabold text-[#137fec] mb-2">Need a custom tool?</h4>
                        <p class="text-slate-700 dark:text-slate-300 text-sm mb-4">Our engineering team can develop custom
                            Autodesk Inventor plugins tailored to your workflow.</p>
                        <a class="inline-flex items-center text-sm font-bold text-[#137fec] hover:underline"
                            href="#">
                            Contact Engineering
                            <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                        </a>
                    </div>
                </section>

                {{-- Prev / Next (example style) --}}
                <div class="pt-8 border-t border-slate-200 dark:border-slate-800 flex justify-between">
                    <a class="group flex flex-col items-start gap-2" href="#">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Previous</span>
                        <div
                            class="flex items-center gap-2 text-slate-700 dark:text-slate-200 font-bold group-hover:text-[#137fec] transition-colors">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Inventor Basics
                        </div>
                    </a>
                    <a class="group flex flex-col items-end gap-2" href="#">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Next</span>
                        <div
                            class="flex items-center gap-2 text-slate-700 dark:text-slate-200 font-bold group-hover:text-[#137fec] transition-colors">
                            About the Ribbon
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    {{-- Floating Quick Support --}}
    <div class="fixed bottom-6 right-6 flex flex-col items-end gap-3 z-[100] group">
        <div
            class="hidden group-hover:block bg-white dark:bg-slate-800 shadow-2xl rounded-xl p-4 border border-slate-200 dark:border-slate-700 mb-2 w-64 animate-in fade-in slide-in-from-bottom-2">
            <p class="font-bold text-slate-900 dark:text-white mb-1">How can we help?</p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">Our support team typically responds within 2 hours
                during business hours.</p>
            <button type="button"
                class="w-full py-2 bg-[#137fec] text-white text-xs font-bold rounded hover:bg-[#137fec]/90 transition-all">Open
                Support Ticket</button>
        </div>
        <button type="button"
            class="size-14 bg-[#137fec] text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
            <span class="material-symbols-outlined text-3xl">question_answer</span>
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            var $wrap = $('#videoTutorialsSliderWrap');
            var $track = $('#videoTutorialsTrack');
            var $prevBtn = $('#videoSliderPrev');
            var $nextBtn = $('#videoSliderNext');
            var $dotsContainer = $('#videoSliderDots');

            if (!$track.length || !$wrap.length) return;

            var $slides = $track.children('.video-slide');
            var totalSlides = $slides.length;
            if (totalSlides === 0) return;

            var currentStep = 0;

            function getVisibleCount() {
                var w = $(window).width();
                if (w >= 1024) return 4;
                if (w >= 768) return 3;
                return 2;
            }

            function getStepSize() {
                var $first = $slides.eq(0);
                return $first.length ? $first.outerWidth(true) : 0;
            }

            function getMaxStep() {
                var visible = getVisibleCount();
                return Math.max(0, totalSlides - visible);
            }

            function getTotalSteps() {
                return getMaxStep() + 1;
            }

            function getOffset() {
                return -currentStep * getStepSize();
            }

            function buildDots() {
                var totalSteps = getTotalSteps();
                $dotsContainer.empty();
                if (totalSteps <= 1) {
                    $prevBtn.addClass('opacity-50 pointer-events-none');
                    $nextBtn.addClass('opacity-50 pointer-events-none');
                    return;
                }
                $prevBtn.removeClass('opacity-50 pointer-events-none');
                $nextBtn.removeClass('opacity-50 pointer-events-none');
                for (var i = 0; i < totalSteps; i++) {
                    var $dot = $(
                        '<button type="button" class="video-slider-dot w-2.5 h-2.5 rounded-full transition-all" data-index="' +
                        i + '" aria-label="Go to step ' + (i + 1) + '"></button>');
                    $dotsContainer.append($dot);
                }
                $dotsContainer.find('.video-slider-dot').on('click', function() {
                    goTo(parseInt($(this).data('index'), 10));
                });
                updateDots();
            }

            function updateDots() {
                $dotsContainer.find('.video-slider-dot').each(function(i) {
                    var $dot = $(this);
                    $dot.toggleClass('bg-[#137fec]', i === currentStep);
                    $dot.toggleClass('bg-slate-300 dark:bg-slate-600', i !== currentStep);
                    $dot.toggleClass('w-8', i === currentStep);
                    $dot.toggleClass('w-2.5', i !== currentStep);
                });
                $prevBtn.toggleClass('opacity-50 pointer-events-none', currentStep <= 0);
                $nextBtn.toggleClass('opacity-50 pointer-events-none', currentStep >= getMaxStep());
            }

            function goTo(step) {
                var maxStep = getMaxStep();
                currentStep = Math.max(0, Math.min(step, maxStep));
                $track.css('transform', 'translateX(' + getOffset() + 'px)');
                updateDots();
            }

            $prevBtn.on('click', function() {
                goTo(currentStep - 1);
            });
            $nextBtn.on('click', function() {
                goTo(currentStep + 1);
            });

            buildDots();
            goTo(0);

            $(window).on('resize', function() {
                var maxStep = getMaxStep();
                currentStep = Math.min(currentStep, maxStep);
                currentStep = Math.max(0, currentStep);
                $track.css('transform', 'translateX(' + getOffset() + 'px)');
                buildDots();
            });
        });
    </script>
@endpush
