@extends('layouts.main')
@section('title', 'Di-tool Combo Bundles')
@section('content')
    <!-- Page Heading -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-12">
        <div class="max-w-2xl">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-4">
                <span class="material-symbols-outlined text-sm">auto_awesome</span>
                Exclusive Offers
            </div>
            <h1 class="text-[#0d141b] dark:text-white text-5xl font-black leading-tight tracking-tight mb-4">Software Combo
                Bundles</h1>
            <p class="text-[#4c739a] dark:text-slate-400 text-lg leading-relaxed">
                Supercharge your Autodesk Inventor workflow. Save up to 40% when you purchase our curated power-user suites.
            </p>
        </div>
        <div class="flex gap-3">
            <button
                class="flex items-center gap-2 bg-[#e7edf3] dark:bg-slate-800 text-[#0d141b] dark:text-white px-6 py-3 rounded-lg font-bold text-sm hover:bg-[#d7e1ea] transition-all">
                <span class="material-symbols-outlined text-lg">filter_list</span>
                All Bundles
            </button>
        </div>
    </div>
    <!-- Savings Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        <div
            class="flex flex-col gap-2 rounded-xl p-8 bg-white dark:bg-slate-900 border border-[#e7edf3] dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-3 text-primary mb-1">
                <span class="material-symbols-outlined">trending_down</span>
                <p class="text-sm font-bold uppercase tracking-wide">Max Discount</p>
            </div>
            <p class="text-[#0d141b] dark:text-white text-4xl font-black">40% OFF</p>
            <p class="text-[#4c739a] text-sm">Compared to individual licenses</p>
        </div>
        <div
            class="flex flex-col gap-2 rounded-xl p-8 bg-white dark:bg-slate-900 border border-[#e7edf3] dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-3 text-primary mb-1">
                <span class="material-symbols-outlined">groups</span>
                <p class="text-sm font-bold uppercase tracking-wide">Community</p>
            </div>
            <p class="text-[#0d141b] dark:text-white text-4xl font-black">15k+ Users</p>
            <p class="text-[#4c739a] text-sm">Trust Di-tool daily</p>
        </div>
        <div
            class="flex flex-col gap-2 rounded-xl p-8 bg-white dark:bg-slate-900 border border-[#e7edf3] dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-3 text-primary mb-1">
                <span class="material-symbols-outlined">savings</span>
                <p class="text-sm font-bold uppercase tracking-wide">Average Savings</p>
            </div>
            <p class="text-[#0d141b] dark:text-white text-4xl font-black">$299</p>
            <p class="text-[#4c739a] text-sm">Saved per bundle purchase</p>
        </div>
    </div>
    <!-- Combo Bundles Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
        <!-- Bundle Card 1 (Large/Featured) -->
        <div
            class="lg:col-span-2 group relative bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-[#e7edf3] dark:border-slate-800 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex flex-col @container xl:flex-row h-full">
                <div class="w-full xl:w-2/5 h-64 xl:h-auto relative">
                    <div class="absolute inset-0 bg-center bg-no-repeat bg-cover transition-transform duration-500 group-hover:scale-105"
                        data-alt="High tech software interface preview showing engineering tools"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBwhUTeZGT_rN9Q1lrhZ7c0W-1-v1quGUweAhFxUw6sN2Y_EtV4ikGsj1vAC2Y6p2VuzqRZhAQIYgExQOIQ42VXIjTH2xgUlqjK5xiTEvoWaB9AusVCWRdilkbxz4jTxF5DeDyPXNHL25Y82iRT96_sx7EpBZuHHVX7EplGW5udm1NIB1N8pILBZwZfGDOZ6EPB9xKd95Mp23bwjD0EteDK697oXlPLnYA3AHqTUg-fhmGZEkIHTyy0kcgpU8clU2-PE5nPlaQYFIQ')">
                    </div>
                    <div
                        class="absolute top-4 left-4 bg-primary text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">
                        Most Popular</div>
                </div>
                <div class="flex-1 p-8 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-black text-[#0d141b] dark:text-white mb-2">Ultimate Inventor Suite
                                </h3>
                                <p class="text-[#4c739a] dark:text-slate-400">The definitive collection for professional
                                    mechanical designers.</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[#4c739a] line-through text-lg font-medium">$599</span>
                                <div class="text-3xl font-black text-primary">$359</div>
                            </div>
                        </div>
                        <div
                            class="bg-background-light dark:bg-slate-800/50 rounded-xl p-6 mb-8 border border-dashed border-[#cfdbe7] dark:border-slate-700">
                            <p class="text-xs font-bold text-[#4c739a] dark:text-slate-500 uppercase tracking-widest mb-4">
                                What's Included</p>
                            <div class="flex flex-wrap items-center gap-4">
                                <div
                                    class="flex items-center gap-3 bg-white dark:bg-slate-800 px-4 py-2 rounded-lg border border-slate-100 dark:border-slate-700 shadow-sm">
                                    <span class="material-symbols-outlined text-primary">layers</span>
                                    <span class="text-sm font-semibold">Sheet Metal Pro</span>
                                </div>
                                <span class="material-symbols-outlined text-slate-300">add</span>
                                <div
                                    class="flex items-center gap-3 bg-white dark:bg-slate-800 px-4 py-2 rounded-lg border border-slate-100 dark:border-slate-700 shadow-sm">
                                    <span class="material-symbols-outlined text-primary">picture_as_pdf</span>
                                    <span class="text-sm font-semibold">PDF Exporter</span>
                                </div>
                                <span class="material-symbols-outlined text-slate-300">add</span>
                                <div
                                    class="flex items-center gap-3 bg-white dark:bg-slate-800 px-4 py-2 rounded-lg border border-slate-100 dark:border-slate-700 shadow-sm">
                                    <span class="material-symbols-outlined text-primary">terminal</span>
                                    <span class="text-sm font-semibold">iLogic Suite</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-6 border-t border-[#e7edf3] dark:border-slate-800">
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-2">
                                <div class="size-8 rounded-full border-2 border-white dark:border-slate-900 bg-cover"
                                    data-alt="User avatar 1"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA-8X53qG15kOFbT8aheq1PGfj5VxkqeB3TVpHAzthBNNCxIVdjYF8njcwDcPHc7nRih3I3u2AnIKgIscqEWjO1GWXYuBZ2K36B6EEfUJkRgqcbwbLosmDigtScCBeStcJyPM_jr0AHHBS80wdpFdJyuc1pEq1K62tC3CwQReCHjcjfecgs8aExqMMB_hiwTU8-gr0liTy7EYd5YwKDJNOSeB6ms70dskWOedD3LJj7CTB3IEP5YVbUHu3QCOvi3hWQ4eOvJnq6AHk')">
                                </div>
                                <div class="size-8 rounded-full border-2 border-white dark:border-slate-900 bg-cover"
                                    data-alt="User avatar 2"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB-DuDbtjC4qN8_UxEggguiLr0z8Pc-avN4LAd8_9Tg8dFp-uQTx_6Q8piFrl6CT9DOOKO9ZaJriv8x7Lz5GMa8iY2A8zZls2Q3StaJhk_YebiYId8bTL6FNouOml_ImpQ57QDJ-EnD5j8GWMH-G8KCDU4XN5REy6OucgTeEjjl7iIQoS5P65RwRXy7cil9aCu5ZGM_oWT6bxoYwlrUklfjz3kBAqG71sJxR8eeGbjtNrqad8TS_mFPw3-na1CIcAkE2NNr7CMbjPQ')">
                                </div>
                                <div class="size-8 rounded-full border-2 border-white dark:border-slate-900 bg-cover"
                                    data-alt="User avatar 3"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCGlTQfeJggUSiz-myW0wjQA2Tso4mQ1zhgxmbhn-njOnD1rmaIWrVp7OD2HQ15efMCbKT2LIlK0h4aNx3_z7zvvq8xOMZAyCNujlAcLTlOA8S0EhQzqXvxzWZiMRXTMlahyc9msCDddfuWdsNLrnFiy4ttOQ5J8MaxKgy5RUUqW8qiFBAK8gY9B5aySobJe6Ie5j4qFK6l5oT5xHvyHFC5mRFu5J-msUotG-cBwcX86J2fu8dF5JNjQz7B8dAU__tu3r7X5XAGYLo')">
                                </div>
                            </div>
                            <span class="text-sm font-medium text-[#4c739a]">2,450+ licenses sold</span>
                        </div>
                        <button
                            class="w-full sm:w-auto min-w-[200px] bg-primary hover:bg-primary/90 text-white font-black py-4 px-8 rounded-xl flex items-center justify-center gap-3 transition-all shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Buy Combo
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bundle Card 2 -->
        <div
            class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-[#e7edf3] dark:border-slate-800 shadow-md hover:shadow-xl transition-all p-8 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-6">
                    <div class="size-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl">settings_suggest</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[#4c739a] line-through text-sm">$320</span>
                        <div class="text-2xl font-black text-[#0d141b] dark:text-white leading-none">$199</div>
                    </div>
                </div>
                <h3 class="text-xl font-black text-[#0d141b] dark:text-white mb-2">Automation Master Pack</h3>
                <p class="text-[#4c739a] dark:text-slate-400 text-sm mb-6 leading-relaxed">Streamline repetitive tasks with
                    our core automation tools.</p>
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>Batch Processing Tool</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>File Renamer Pro</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>Cleanup Utility</span>
                    </div>
                </div>
            </div>
            <div>
                <div class="mb-4 flex items-center gap-2">
                    <div class="h-1.5 flex-1 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-primary w-3/4"></div>
                    </div>
                    <span class="text-[10px] font-bold text-[#4c739a] uppercase">850 Sold</span>
                </div>
                <button
                    class="w-full bg-primary/10 hover:bg-primary text-primary hover:text-white font-bold py-3 px-6 rounded-xl transition-all duration-200">
                    Buy Combo
                </button>
            </div>
        </div>
        <!-- Bundle Card 3 -->
        <div
            class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-[#e7edf3] dark:border-slate-800 shadow-md hover:shadow-xl transition-all p-8 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-6">
                    <div class="size-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl">ios_share</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[#4c739a] line-through text-sm">$250</span>
                        <div class="text-2xl font-black text-[#0d141b] dark:text-white leading-none">$149</div>
                    </div>
                </div>
                <h3 class="text-xl font-black text-[#0d141b] dark:text-white mb-2">Design &amp; Export Bundle</h3>
                <p class="text-[#4c739a] dark:text-slate-400 text-sm mb-6 leading-relaxed">Perfect for getting designs from
                    Inventor to manufacturing.</p>
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>DXF Multi-Exporter</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>BOM Manager</span>
                    </div>
                </div>
            </div>
            <div>
                <div class="mb-4 flex items-center gap-2">
                    <div class="h-1.5 flex-1 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-primary w-full"></div>
                    </div>
                    <span class="text-[10px] font-bold text-[#4c739a] uppercase">2,100 Sold</span>
                </div>
                <button
                    class="w-full bg-primary/10 hover:bg-primary text-primary hover:text-white font-bold py-3 px-6 rounded-xl transition-all duration-200">
                    Buy Combo
                </button>
            </div>
        </div>
    </div>
    <!-- Call to Action Footer -->
    <div
        class="bg-primary rounded-2xl p-10 flex flex-col md:flex-row items-center justify-between gap-8 text-white relative overflow-hidden">
        <div
            class="absolute right-0 top-0 translate-x-1/4 -translate-y-1/4 size-64 bg-white/10 rounded-full blur-3xl pointer-events-none">
        </div>
        <div class="z-10 text-center md:text-left">
            <h2 class="text-3xl font-black mb-2">Custom Suite Needed?</h2>
            <p class="text-white/80 max-w-md">Contact our sales team for custom volume discounts and enterprise bundle
                configurations tailored to your team's size.</p>
        </div>
        <div class="z-10 flex gap-4">
            <button
                class="bg-white text-primary font-black px-8 py-4 rounded-xl hover:bg-slate-100 transition-all shadow-lg">
                Contact Sales
            </button>
        </div>
    </div>
@endsection
