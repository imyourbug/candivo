<!-- Download Modal Backdrop -->
<div id="downloadModal"
    class="download-modal fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <!-- Modal Container -->
    <div
        class="bg-white dark:bg-slate-900 w-full max-w-[520px] rounded-xl shadow-2xl overflow-hidden relative border border-slate-200 dark:border-slate-800">
        <!-- Close Button -->
        <button type="button"
            class="download-modal-close absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
        <!-- Header Section -->
        <div class="px-8 pt-10 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-600/10 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">download</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Download DI-Tools
                </h2>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                Enter your professional details below to receive the secure download links and installation guide
                directly in your inbox.
            </p>
        </div>
        <!-- Form Section -->
        <form class="p-8 space-y-5">
            <!-- Full Name -->
            {{-- <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Full name</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                    <input
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
                        placeholder="John Doe" type="text" />
                </div>
            </div> --}}
            <!-- Email Address -->
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email address</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                    <input
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
                        placeholder="john@company.com" type="email" />
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Inventor version</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">settings_input_component</span>
                    <select
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100">
                        <option disabled="" selected="" value="">Select version</option>
                        <option value="2024">Inventor 2024</option>
                        <option value="2023">Inventor 2023</option>
                        <option value="2022">Inventor 2022</option>
                        <option value="legacy">Legacy Versions</option>
                    </select>
                </div>
            </div>
            <button
                class="w-full premium-button text-white font-bold py-4 rounded-lg shadow-lg transition-all flex items-center justify-center gap-2 mt-4 group"
                type="submit">
                <span>Get Download</span>
                <span
                    class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
            <!-- Footer Info -->
            <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-6">
                By clicking download, you agree to our <a class="underline hover:text-primary" href="#">Terms
                    of Service</a> and <a class="underline hover:text-primary" href="#">Privacy Policy</a>.
            </p>
        </form>
    </div>
</div>
