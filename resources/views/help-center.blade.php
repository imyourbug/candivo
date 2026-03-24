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
            font-size: 1.125rem;
            color: #64748b;
        }

        .help-nav-tree .nav-expand-icon--open {
            display: none;
        }

        .help-nav-tree details[open]>summary .nav-expand-icon--closed {
            display: none;
        }

        .help-nav-tree details[open]>summary .nav-expand-icon--open {
            display: inline-flex;
        }

        .help-nav-tree .nav-leaf-icon {
            font-size: 1rem;
            color: #94a3b8;
        }

        /* Selected issue — vivid text + fill + edge accent (sidebar) */
        .help-nav-tree .js-issue-link.help-issue-active {
            color: #0055ff;
            font-weight: 600;
            background: linear-gradient(
                120deg,
                rgba(0, 120, 255, 0.28) 0%,
                rgba(0, 200, 255, 0.22) 50%,
                rgba(0, 140, 255, 0.18) 100%
            );
            box-shadow:
                inset 0 0 0 1px rgba(0, 140, 255, 0.55),
                inset 4px 0 0 0 #0090ff;
            border-radius: 0.375rem;
            text-shadow: 0 0 20px rgba(0, 140, 255, 0.35);
        }

        .dark .help-nav-tree .js-issue-link.help-issue-active {
            color: #7aebff;
            background: linear-gradient(
                120deg,
                rgba(56, 189, 248, 0.35) 0%,
                rgba(14, 165, 233, 0.22) 55%,
                rgba(34, 211, 238, 0.12) 100%
            );
            box-shadow:
                inset 0 0 0 1px rgba(56, 189, 248, 0.55),
                inset 4px 0 0 0 #22d3ee;
            text-shadow: 0 0 22px rgba(34, 211, 238, 0.45);
        }

        .help-nav-tree .js-issue-link.help-issue-active .nav-leaf-icon {
            color: #0090ff;
        }

        .dark .help-nav-tree .js-issue-link.help-issue-active .nav-leaf-icon {
            color: #22d3ee;
        }

        /* Video tutorial filter tabs */
        #videoTutorialTabs .video-tab {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 2px solid rgb(203 213 225);
            background: linear-gradient(to bottom, #f8fafc, #e2e8f0);
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s, color 0.2s;
        }

        .dark #videoTutorialTabs .video-tab {
            border-color: rgb(71 85 105);
            background: linear-gradient(to bottom, #475569, #334155);
            color: #f1f5f9;
        }

        #videoTutorialTabs .video-tab:hover:not(.video-tab--active) {
            border-color: #137fec;
            box-shadow: 0 4px 14px rgba(19, 127, 236, 0.28);
            color: #137fec;
        }

        .dark #videoTutorialTabs .video-tab:hover:not(.video-tab--active) {
            color: #93c5fd;
        }

        #videoTutorialTabs .video-tab--active {
            background: linear-gradient(135deg, #137fec 0%, #1a8cff 45%, #0b6efd 100%);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.35);
            font-weight: 700;
            box-shadow: 0 10px 28px -6px rgba(19, 127, 236, 0.55), 0 0 0 2px rgba(255, 255, 255, 0.25);
        }

        .dark #videoTutorialTabs .video-tab--active {
            box-shadow: 0 10px 28px -6px rgba(19, 127, 236, 0.6), 0 0 0 2px rgba(255, 255, 255, 0.12);
        }
    </style>
@endpush

@section('content')
    {{-- Golden top banner (image reference) --}}
    {{-- <div class="h-1.5 w-full bg-amber-400" aria-hidden="true"></div> --}}
    <section class="hero-pattern py-20 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight">How can we help you today?</h1>
            <p class="text-white/80 text-lg mb-10 font-medium">Search for video tutorials, FAQs, or technical documentation
                for Autodesk Inventor tools.</p>
            <div class="max-w-2xl mx-auto relative">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400">search</span>
                    </div>
                    <input id="help-hero-search-input"
                        class="block w-full pl-12 pr-32 py-4 bg-white border-0 rounded-xl shadow-xl focus:ring-2 focus:ring-primary text-slate-900 placeholder:text-slate-400 text-lg"
                        placeholder="Search for video tutorials or FAQs..." type="text" />
                    <button id="help-hero-search-btn" type="button"
                        class="absolute right-2 top-2 bottom-2 px-6 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors">
                        Search
                    </button>
                </div>
                <div id="help-hero-search-results"
                    class="hidden absolute left-0 right-0 top-full mt-2 z-30 text-left rounded-xl border border-slate-200 bg-white/95 backdrop-blur shadow-xl p-2 max-h-80 overflow-auto"></div>
            </div>
        </div>
    </section>

    <div class="flex min-h-[calc(100vh-4px)] bg-[#f6f7f8] dark:bg-slate-950">
        {{-- Sidebar Navigation (example + image style) --}}
        <aside
            class="w-72 flex-shrink-0 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col sticky top-0 h-[calc(100vh-6px)]">
            <nav class="help-nav-tree overflow-y-auto p-4 space-y-0 help-sidebar-scroll">
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">You can find your issue
                    here...</p>
                <div id="help-sidebar-nav" class="space-y-0">
                    @isset($allSidebarTools)
                        @if ($allSidebarTools->isNotEmpty())
                            <details class="help-nav-details mb-1" id="help-all-tools-sidebar">
                                <summary
                                    class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                                    <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                        aria-hidden="true">expand_more</span>
                                    <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                        aria-hidden="true">expand_less</span>
                                    <span class="font-semibold text-[#137fec] dark:text-[#5eb0ff]">All Tools</span>
                                </summary>
                                <div
                                    class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3 max-h-[min(60vh,28rem)] overflow-y-auto help-sidebar-scroll">
                                    @foreach ($allSidebarTools as $tool)
                                        <a href="#issue-{{ $tool->slug }}"
                                            class="flex items-center gap-2 py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm rounded px-1 hover:bg-slate-100 dark:hover:bg-slate-800 js-issue-link"
                                            data-issue-slug="{{ $tool->slug }}">
                                            <span class="material-symbols-outlined nav-expand-icon nav-leaf-icon"
                                                aria-hidden="true">label</span>
                                            <span>{{ $tool->name }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </details>
                        @endif
                    @endisset
                    {{-- Dynamic issue types tree (from admin) --}}
                    <div id="help-issue-types-tree" data-api-url="{{ route('api.issue-types.tree') }}"
                        data-api-detail-url="{{ route('api.issue-types.detail', ['slug' => '___SLUG___']) }}"></div>
                </div>
                <div id="help-issue-types-fallback">
                    {{-- Level 1 (collapsed) --}}
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>Di-tool What's New</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">2024 Release</a>
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">2024.1 Updates</a>
                        </div>
                    </details>
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>Release Notes</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Version History</a>
                        </div>
                    </details>
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>Get Started videos</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#video-tutorials">Quick Start</a>
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Installation</a>
                        </div>
                    </details>
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>Tutorials</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Part Modeling</a>
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Assembly</a>
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">iLogic</a>
                        </div>
                    </details>

                    {{-- Level 1 (expanded) – Help Topics --}}
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>Di-tool Help Topics</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            {{-- Level 2: Inventor Basics (expanded) --}}
                            <details class="help-nav-details">
                                <summary
                                    class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                                    <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                        aria-hidden="true">expand_more</span><span
                                        class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                        aria-hidden="true">expand_less</span>
                                    <span>Inventor Basics</span>
                                </summary>
                                <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                    {{-- Level 3: User Interface (expanded) --}}
                                    <details class="help-nav-details">
                                        <summary
                                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                                aria-hidden="true">expand_more</span><span
                                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                                aria-hidden="true">expand_less</span>
                                            <span>User Interface</span>
                                        </summary>
                                        <div
                                            class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                            {{-- Level 4: About Home (expanded) --}}
                                            <details class="help-nav-details">
                                                <summary
                                                    class="flex items-center gap-2 py-1.5 cursor-pointer text-[#137fec] bg-[#137fec]/10 hover:bg-[#137fec]/15 rounded px-1 text-sm font-semibold">
                                                    <span
                                                        class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                                        aria-hidden="true">expand_more</span><span
                                                        class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                                        aria-hidden="true">expand_less</span>
                                                    <span>About Home</span>
                                                </summary>
                                                <div
                                                    class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                                    {{-- Level 5: About the Ribbon (expanded) --}}
                                                    <details class="help-nav-details">
                                                        <summary
                                                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                                                            <span
                                                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                                                aria-hidden="true">expand_more</span><span
                                                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                                                aria-hidden="true">expand_less</span>
                                                            <span>About the Ribbon</span>
                                                        </summary>
                                                        <div
                                                            class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                                                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                                                href="#">To Work with the Ribbon</a>
                                                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                                                href="#">To Work with Icons, Tooltips</a>
                                                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                                                href="#">To Customize User Commands</a>
                                                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                                                href="#">To Highlight New and Updated Commands</a>
                                                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                                                href="#">Reference for Customize Dialog Ribbon
                                                                Tab</a>
                                                        </div>
                                                    </details>
                                                </div>
                                            </details>
                                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                                href="#about-ribbon">About the Ribbon</a>
                                        </div>
                                    </details>
                                    <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                        href="#">Reference for Customize Dialog Ribbon Tab</a>
                                    <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                        href="#">To Repeat the Last Command</a>
                                </div>
                            </details>
                        </div>
                    </details>

                    {{-- More Level 1 (collapsed) --}}
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>Di-tool Browser</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Browser Panel</a>
                        </div>
                    </details>
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>About Marking Menus</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Marking Menu Options</a>
                        </div>
                    </details>
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>To Work with the Navigation Bar</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Navigation Bar</a>
                        </div>
                    </details>
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>About Graphics Windows</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">Graphics Window</a>
                        </div>
                    </details>
                    <details class="help-nav-details">
                        <summary
                            class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">
                            <span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed"
                                aria-hidden="true">expand_more</span><span
                                class="material-symbols-outlined nav-expand-icon nav-expand-icon--open"
                                aria-hidden="true">expand_less</span>
                            <span>About InfoCenter</span>
                        </summary>
                        <div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">
                            <a class="block py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm"
                                href="#">InfoCenter</a>
                        </div>
                    </details>
                </div>
                <a class="flex items-center gap-2 py-1.5 pl-8 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#137fec] rounded px-1 text-sm"
                    href="#video-tutorials">Video Tutorials</a>
                <a class="flex items-center gap-2 py-1.5 pl-8 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#137fec] rounded px-1 text-sm"
                    href="#faq">FAQs</a>
                <a class="flex items-center gap-2 py-1.5 pl-8 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#137fec] rounded px-1 text-sm"
                    href="#documentation">Documentation</a>
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
                {{-- <div class="mb-6">
                    <button type="button"
                        class="flex items-center gap-1.5 text-[#137fec] text-sm font-bold hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Back to Search Results
                    </button>
                </div> --}}
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <h2 id="help-issue-title" class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ isset($issue) && $issue ? $issue->name : 'About Help Center' }}
                    </h2>
                    <a href="{{ request()->fullUrl() }}"
                        class="flex items-center gap-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm font-bold">
                        <span class="material-symbols-outlined text-lg">share</span>
                        SHARE
                    </a>
                </div>
                <hr class="border-slate-200 dark:border-slate-700 mb-8" />

                <div id="help-issue-video"
                    class="mb-8 mx-auto max-w-5xl rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm bg-black aspect-video @if (!isset($issue) || !$issue || empty($issue->video)) hidden @endif">
                    <iframe id="help-issue-video-iframe"
                        title="{{ isset($issue) && $issue ? $issue->name.' — video' : 'Help video' }}"
                        class="w-full h-full border-0"
                        @if (isset($issue) && $issue && !empty($issue->video))
                            src="{{ $issue->video }}"
                        @endif
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen loading="lazy"></iframe>
                </div>
                {{-- Manual screenshots / figures (after video) --}}
                <div id="help-issue-images"
                    class="help-issue-images space-y-4 mb-8 mx-auto max-w-5xl @if (!isset($issue) || !$issue || empty($issue->images)) hidden @endif">
                    @if (isset($issue) && $issue && !empty($issue->images))
                        @foreach ($issue->images as $img)
                            <figure
                                class="rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm bg-slate-50 dark:bg-slate-800/40">
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($img) }}"
                                    alt="{{ $issue->name }} — {{ $loop->iteration }}"
                                    class="w-full h-auto block max-h-[min(85vh,1200px)] object-contain bg-white dark:bg-slate-900"
                                    loading="lazy" />
                            </figure>
                        @endforeach
                    @endif
                </div>
                <div id="help-issue-description"
                    class="help-issue-description text-slate-700 dark:text-slate-300 leading-relaxed mb-10">
                    @if (isset($issue) && $issue && $issue->description)
                        {!! $issue->description !!}
                    @else
                        <p class="mb-0">Use the Help Center to search tutorials, open FAQs, and download documentation.</p>
                    @endif
                </div>

                {{-- Interactive card + numbered list (image: "Set Projects, Open files, Create New files") --}}
                {{-- <section class="mb-12">
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
                </section> --}}

                {{-- Video Tutorials --}}
                <section id="video-tutorials" class="mb-16">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Video Tutorials</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">Master Di-tool with our step-by-step visual guides.
                    </p>
                    <div class="flex gap-2.5 mb-6 flex-wrap items-center" id="videoTutorialTabs" role="tablist">
                        <button type="button" role="tab" aria-selected="true"
                            data-video-filter="all"
                            class="js-video-tab video-tab video-tab--active">
                            All tools
                        </button>
@foreach(($videoTutorialPackages ?? collect()) as $pkg)
                        <button type="button" role="tab" aria-selected="false"
                            data-video-filter="package"
                            data-package-id="{{ $pkg->id }}"
                            class="js-video-tab video-tab">
                            {{ $pkg->name }}
                        </button>
@endforeach
                    </div>
                    <div class="relative" id="videoTutorialsSliderWrap">
                        <div class="overflow-hidden rounded-xl" id="videoTutorialsSlider">
                            <div class="flex gap-4 md:gap-6 transition-transform duration-300 ease-out"
                                id="videoTutorialsTrack" style="transform: translateX(0);">
@forelse(($videoTutorials ?? collect()) as $tutorial)
                                <div class="video-slide flex-shrink-0 w-1/2 md:w-1/3 lg:w-1/4 px-1 md:px-2"
                                    data-package-ids="{{ e(json_encode($tutorial['package_ids'] ?? [])) }}">
                                    <div class="group cursor-pointer js-video-tutorial-item" data-issue-slug="{{ $tutorial['issue_slug'] ?? '' }}">
                                        <div class="relative aspect-video rounded-xl overflow-hidden mb-4 shadow-md bg-slate-200 dark:bg-slate-800">
                                            @if(!empty($tutorial['video']))
                                                <iframe src="{{ $tutorial['video'] }}" title="{{ $tutorial['name'] }}"
                                                    class="w-full h-full border-0" loading="lazy"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-500 dark:text-slate-400 text-sm font-medium">
                                                    Video not available
                                                </div>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-slate-900 dark:text-white group-hover:text-[#137fec] transition-colors text-lg mb-1">
                                            {{ $tutorial['name'] }}
                                        </h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">
                                            {{ $tutorial['short_description'] ?: 'No description available.' }}
                                        </p>
                                    </div>
                                </div>
@empty
                                <div class="video-slide flex-shrink-0 w-full px-1 md:px-2">
                                    <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6">
                                        <p class="text-slate-600 dark:text-slate-300">No tutorials available yet.</p>
                                    </div>
                                </div>
@endforelse
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

                {{-- Prev / Next issue navigation --}}
                <div class="pt-8 border-t border-slate-200 dark:border-slate-800 flex justify-between" id="issue-pager-wrap">
                    <button type="button" id="issuePagerPrev" class="group flex flex-col items-start gap-2 text-left hidden">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Previous</span>
                        <span
                            class="flex items-center gap-2 text-slate-700 dark:text-slate-200 font-bold group-hover:text-[#137fec] transition-colors">
                            <span class="material-symbols-outlined">arrow_back</span>
                            <span id="issuePagerPrevLabel">Previous issue</span>
                        </span>
                    </button>
                    <div class="text-xs text-slate-400 font-medium" id="issuePagerHint">Select an issue to navigate</div>
                    <button type="button" id="issuePagerNext" class="group flex flex-col items-end gap-2 text-right hidden ml-auto">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Next</span>
                        <span
                            class="flex items-center gap-2 text-slate-700 dark:text-slate-200 font-bold group-hover:text-[#137fec] transition-colors">
                            <span id="issuePagerNextLabel">Next issue</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </span>
                    </button>
                </div>
            </div>
        </main>
    </div>

    {{-- Floating Quick Support --}}
    <div class="fixed bottom-24 right-7 flex flex-col items-end gap-3 z-[100] group">
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
        // Help center tree + issue detail (jQuery)
        $(function() {
            var $container = $('#help-issue-types-tree');
            var $navRoot = $('#help-sidebar-nav');
            var $fallback = $('#help-issue-types-fallback');
            if (!$container.length) return;

            var apiUrl = $container.data('api-url');
            var apiDetailBase = $container.data('api-detail-url');
            if (!apiUrl) return;

            function escapeHtml(text) {
                var div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function renderNode(node) {
                var children = node.children || [];
                var hasChildren = children.length > 0;
                var name = escapeHtml(node.name || '');
                var slug = (node.slug || '').trim();
                var href = slug ? '#issue-' + slug : '#';
                var hasUrl = !!node.has_url;

                function labelContent() {
                    if (hasUrl) {
                        return '<a data-issue-slug="' + slug + '" href="' + href +
                            '" class="text-inherit hover:text-[#137fec] focus:outline-none js-issue-link" >' +
                            name + '</a>';
                    }
                    return '<span>' + name + '</span>';
                }

                if (hasChildren) {
                    var inner = children.map(renderNode).join('');
                    return '<details class="help-nav-details">' +
                        '<summary class="flex items-center gap-2 py-1.5 cursor-pointer text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded px-1 text-sm font-medium">' +
                        '<span class="material-symbols-outlined nav-expand-icon nav-expand-icon--closed" aria-hidden="true">expand_more</span><span class="material-symbols-outlined nav-expand-icon nav-expand-icon--open" aria-hidden="true">expand_less</span>' +
                        labelContent() +
                        '</summary>' +
                        '<div class="ml-5 mt-0.5 space-y-0 border-l border-slate-200 dark:border-slate-700 pl-3">' +
                        inner + '</div>' +
                        '</details>';
                }
                var leafIcon =
                    '<span class="material-symbols-outlined nav-expand-icon nav-leaf-icon" aria-hidden="true">label</span>';
                if (hasUrl) {
                    return '<a class="flex items-center gap-2 py-1.5 text-slate-600 dark:text-slate-400 hover:text-[#137fec] text-sm rounded px-1 hover:bg-slate-100 dark:hover:bg-slate-800 js-issue-link" data-issue-slug="' +
                        slug + '" href="' + href + '">' + leafIcon + '<span>' + name + '</span></a>';
                }
                return '<div class="flex items-center gap-2 py-1.5 text-slate-700 dark:text-slate-300 text-sm rounded px-1">' +
                    leafIcon + '<span>' + name + '</span></div>';
            }

            var issueSearchIndex = [];
            var clickableIssues = [];
            var currentIssueSlug = null;
            var clickHistoryStorageKey = 'help_center_issue_click_history_v1';
            var initialIssueSlug = @json(isset($issue) && $issue ? $issue->slug : null);
            var $heroSearchInput = $('#help-hero-search-input');
            var $heroSearchBtn = $('#help-hero-search-btn');
            var $heroSearchResults = $('#help-hero-search-results');
            var $issuePagerPrev = $('#issuePagerPrev');
            var $issuePagerNext = $('#issuePagerNext');
            var $issuePagerPrevLabel = $('#issuePagerPrevLabel');
            var $issuePagerNextLabel = $('#issuePagerNextLabel');
            var $issuePagerHint = $('#issuePagerHint');

            function flattenIssues(nodes) {
                var out = [];
                (nodes || []).forEach(function(node) {
                    if (!node) return;
                    out.push(node);
                    if (Array.isArray(node.children) && node.children.length) {
                        out = out.concat(flattenIssues(node.children));
                    }
                });
                return out;
            }

            function renderHeroResults(items, query) {
                if (!$heroSearchResults.length) return;
                if (!query) {
                    $heroSearchResults.empty().addClass('hidden');
                    return;
                }
                if (!items.length) {
                    $heroSearchResults
                        .html('<p class="px-3 py-2 text-sm text-slate-500">No related issue types found.</p>')
                        .removeClass('hidden');
                    return;
                }
                var html = items.map(function(item) {
                    var name = escapeHtml(item.name || 'Untitled');
                    var slug = escapeHtml(item.slug || '');
                    return '<button type="button" class="js-hero-search-result w-full text-left px-3 py-2 rounded-lg hover:bg-slate-100 text-slate-700 text-sm" data-issue-slug="' + slug + '">' +
                        '<span class="font-semibold">' + name + '</span>' +
                        (slug ? '<span class="text-slate-400 ml-2">/' + slug + '</span>' : '') +
                        '</button>';
                }).join('');
                $heroSearchResults.html(html).removeClass('hidden');
            }

            function runHeroSearch() {
                var q = ($heroSearchInput.val() || '').toString().trim().toLowerCase();
                if (!q) {
                    renderHeroResults([], '');
                    return;
                }
                var matches = issueSearchIndex.filter(function(item) {
                    var haystack = [item.name, item.slug, item.description]
                        .map(function(v) { return (v || '').toString().toLowerCase(); })
                        .join(' ');
                    return haystack.indexOf(q) !== -1;
                }).slice(0, 30);
                renderHeroResults(matches, q);
            }

            function saveIssueClickHistory(issue) {
                if (!issue || !issue.slug) return;
                var nowIso = new Date().toISOString();
                var history = {};
                try {
                    history = JSON.parse(localStorage.getItem(clickHistoryStorageKey) || '{}') || {};
                } catch (e) {
                    history = {};
                }
                var prev = history[issue.slug] || {};
                history[issue.slug] = {
                    slug: issue.slug,
                    name: issue.name || prev.name || issue.slug,
                    count: (Number(prev.count) || 0) + 1,
                    last_clicked_at: nowIso
                };
                localStorage.setItem(clickHistoryStorageKey, JSON.stringify(history));
            }

            function updateIssuePager() {
                if (!$issuePagerPrev.length || !$issuePagerNext.length) return;
                var idx = clickableIssues.findIndex(function(item) {
                    return item.slug === currentIssueSlug;
                });
                if (idx < 0) {
                    $issuePagerPrev.addClass('hidden').removeData('issueSlug');
                    $issuePagerNext.addClass('hidden').removeData('issueSlug');
                    if ($issuePagerHint.length) $issuePagerHint.removeClass('hidden').text('Select an issue to navigate');
                    return;
                }

                var prevItem = idx > 0 ? clickableIssues[idx - 1] : null;
                var nextItem = idx < clickableIssues.length - 1 ? clickableIssues[idx + 1] : null;

                if (prevItem) {
                    $issuePagerPrev.removeClass('hidden').data('issueSlug', prevItem.slug);
                    $issuePagerPrevLabel.text(prevItem.name || prevItem.slug);
                } else {
                    $issuePagerPrev.addClass('hidden').removeData('issueSlug');
                }

                if (nextItem) {
                    $issuePagerNext.removeClass('hidden').data('issueSlug', nextItem.slug);
                    $issuePagerNextLabel.text(nextItem.name || nextItem.slug);
                } else {
                    $issuePagerNext.addClass('hidden').removeData('issueSlug');
                }

                if ($issuePagerHint.length) {
                    $issuePagerHint.toggleClass('hidden', !!prevItem || !!nextItem);
                    if (!prevItem && !nextItem) {
                        $issuePagerHint.text('No previous/next issue for this item');
                    }
                }
            }

            $issuePagerPrev.on('click', function() {
                var slug = ($(this).data('issueSlug') || '').toString().trim();
                if (!slug) return;
                selectSidebarIssueBySlug(slug, 10);
            });

            $issuePagerNext.on('click', function() {
                var slug = ($(this).data('issueSlug') || '').toString().trim();
                if (!slug) return;
                selectSidebarIssueBySlug(slug, 10);
            });

            $.getJSON(apiUrl)
                .done(function(data) {
                    var tree = Array.isArray(data) ? data : [];
                    issueSearchIndex = flattenIssues(tree);
                    clickableIssues = issueSearchIndex.filter(function(item) {
                        var slug = (item && item.slug ? item.slug : '').toString().trim();
                        return !!slug && !!item.has_url;
                    });
                    if (tree.length > 0) {
                        $container.html(tree.map(renderNode).join(''));
                        if ($fallback.length) {
                            $fallback.hide();
                        }
                    }

                    if (initialIssueSlug) {
                        currentIssueSlug = initialIssueSlug;
                        updateIssuePager();
                        selectSidebarIssueBySlug(initialIssueSlug, 5);
                    } else {
                        updateIssuePager();
                    }
                });

            $heroSearchBtn.on('click', function() {
                runHeroSearch();
            });

            $heroSearchInput.on('input', function() {
                runHeroSearch();
            });

            $heroSearchInput.on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    runHeroSearch();
                }
                if (e.key === 'Escape') {
                    renderHeroResults([], '');
                }
            });

            $(document).on('click', '.js-hero-search-result', function() {
                var slug = ($(this).data('issue-slug') || '').toString().trim();
                if (!slug) return;
                renderHeroResults([], '');
                selectSidebarIssueBySlug(slug, 10);
            });

            /**
             * Close other top-level nav branches, then open the <details> chain to the active link.
             * Roots: "All Tools" (#help-all-tools-sidebar) + each package root inside #help-issue-types-tree.
             */
            function collapseOtherRootNavBranches($targetLink) {
                if (!$targetLink.length) return;
                function closeOtherRoots($scope) {
                    if (!$scope || !$scope.length) return;
                    $scope.children('details.help-nav-details').each(function() {
                        var $rootDetails = $(this);
                        if (!$targetLink.closest($rootDetails).length) {
                            $rootDetails.prop('open', false);
                        }
                    });
                }
                closeOtherRoots($navRoot);
                closeOtherRoots($container);
                $targetLink.parents('details').prop('open', true);
            }

            function selectSidebarIssueBySlug(slug, retries) {
                var cleanSlug = (slug || '').toString().trim();
                if (!cleanSlug) return;
                var $target = $('.js-issue-link').filter(function() {
                    return ($(this).data('issue-slug') || '').toString().trim() === cleanSlug;
                }).first();

                if (!$target.length) {
                    if ((retries || 0) > 0) {
                        setTimeout(function() {
                            selectSidebarIssueBySlug(cleanSlug, (retries || 0) - 1);
                        }, 200);
                    }
                    return;
                }

                $target.trigger('click');
                var sidebarEl = $target.get(0);
                if (sidebarEl && typeof sidebarEl.scrollIntoView === 'function') {
                    sidebarEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }

            $(document).on('click', '.js-video-tutorial-item', function(e) {
                if ($(e.target).closest('iframe').length) return;
                var slug = ($(this).data('issue-slug') || '').toString().trim();
                if (!slug) return;
                e.preventDefault();
                selectSidebarIssueBySlug(slug, 10);
            });

            // Handle click on dynamic issue links to load detail via API (no full reload)
            $(document).on('click', '.js-issue-link', function(e) {
                e.preventDefault();
                var $link = $(this);

                collapseOtherRootNavBranches($link);

                // Focus/active effect for selected issue link (styles: .help-issue-active)
                $('.js-issue-link').removeClass('help-issue-active');
                $link.addClass('help-issue-active');

                if (!apiDetailBase) return;
                var slug = ($link.data('issue-slug') || '').toString().trim();
                if (!slug) return;

                var url = apiDetailBase.replace('___SLUG___', encodeURIComponent(slug));
                currentIssueSlug = slug;
                var issueMeta = clickableIssues.find(function(item) { return item.slug === slug; }) || { slug: slug, name: slug };
                saveIssueClickHistory(issueMeta);
                updateIssuePager();

                $.getJSON(url)
                    .done(function(json) {
                        if (!json || !json.name) return;
                        var $titleEl = $('#help-issue-title');
                        var $descEl = $('#help-issue-description');
                        var $imgWrap = $('#help-issue-images');
                        if ($titleEl.length) {
                            $titleEl.text(json.name);
                        }
                        var $vidWrap = $('#help-issue-video');
                        var $vidFrame = $('#help-issue-video-iframe');
                        if ($vidWrap.length && $vidFrame.length) {
                            var v = (json.video || '').toString().trim();
                            if (v) {
                                $vidFrame.attr('src', v).attr('title', json.name + ' — video');
                                $vidWrap.removeClass('hidden');
                            } else {
                                $vidFrame.attr('src', '').attr('title', '');
                                $vidWrap.addClass('hidden');
                            }
                        }
                        if ($imgWrap.length) {
                            $imgWrap.empty();
                            var imgs = json.images || [];
                            if (imgs.length) {
                                $imgWrap.removeClass('hidden');
                                imgs.forEach(function(src, idx) {
                                    var $fig = $('<figure>').addClass(
                                        'rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm bg-slate-50 dark:bg-slate-800/40'
                                    );
                                    $fig.append(
                                        $('<img>')
                                            .attr('src', src)
                                            .attr('alt', json.name + ' — ' + (idx + 1))
                                            .attr('loading', 'lazy')
                                            .addClass(
                                                'w-full h-auto block max-h-[min(85vh,1200px)] object-contain bg-white dark:bg-slate-900'
                                            )
                                    );
                                    $imgWrap.append($fig);
                                });
                            } else {
                                $imgWrap.addClass('hidden');
                            }
                        }
                        if ($descEl.length) {
                            var raw = json.description ||
                                '<p class="mb-0">Use the Help Center to search tutorials, open FAQs, and download documentation.</p>';
                            // Seeded manual content is real HTML; legacy plain text gets escaped + line breaks.
                            var looksHtml = /<\/?[a-z][\s\S]*>/i.test(raw);
                            if (looksHtml) {
                                $descEl.html(raw);
                            } else {
                                $descEl.html($('<div/>').text(raw).html().replace(/\n/g, '<br>'));
                            }
                        }
                    });
            });
        });
        $(function() {
            var $wrap = $('#videoTutorialsSliderWrap');
            var $track = $('#videoTutorialsTrack');
            var $prevBtn = $('#videoSliderPrev');
            var $nextBtn = $('#videoSliderNext');
            var $dotsContainer = $('#videoSliderDots');

            if (!$track.length || !$wrap.length) return;

            var currentStep = 0;

            function getSlides() {
                return $track.children('.video-slide').filter(':not(.hidden)');
            }

            function getVisibleCount() {
                var w = $(window).width();
                if (w >= 1024) return 4;
                if (w >= 768) return 3;
                return 2;
            }

            function getStepSize() {
                var $first = getSlides().eq(0);
                return $first.length ? $first.outerWidth(true) : 0;
            }

            function getMaxStep() {
                var $slides = getSlides();
                var total = $slides.length;
                var visible = getVisibleCount();
                return Math.max(0, total - visible);
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

            function initVideoTutorialsSlider() {
                if (getSlides().length === 0) {
                    $track.css('transform', 'translateX(0)');
                    $dotsContainer.empty();
                    $prevBtn.addClass('opacity-50 pointer-events-none');
                    $nextBtn.addClass('opacity-50 pointer-events-none');
                    return;
                }
                currentStep = 0;
                buildDots();
                goTo(0);
            }

            $prevBtn.on('click', function() {
                goTo(currentStep - 1);
            });
            $nextBtn.on('click', function() {
                goTo(currentStep + 1);
            });

            $(document).on('click', '#videoTutorialTabs .js-video-tab', function() {
                var $btn = $(this);
                var filter = ($btn.data('video-filter') || 'all').toString();
                var pkgId = $btn.data('package-id');
                $('#videoTutorialTabs .js-video-tab').removeClass('video-tab--active').attr('aria-selected', 'false');
                $btn.addClass('video-tab--active').attr('aria-selected', 'true');

                $track.children('.video-slide').each(function() {
                    var $slide = $(this);
                    var raw = $slide.attr('data-package-ids');
                    var ids = [];
                    try {
                        ids = raw ? JSON.parse(raw) : [];
                    } catch (e) {
                        ids = [];
                    }
                    if (filter === 'all') {
                        $slide.removeClass('hidden');
                    } else {
                        var pid = Number(pkgId);
                        var show = Array.isArray(ids) && ids.some(function(id) {
                            return Number(id) === pid;
                        });
                        $slide.toggleClass('hidden', !show);
                    }
                });

                initVideoTutorialsSlider();
            });

            initVideoTutorialsSlider();

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
