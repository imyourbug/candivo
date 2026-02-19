<header class="sticky top-0 z-50 w-full border-b border-[#e7edf3] bg-white/95 backdrop-blur-sm px-6 md:px-20 py-4">
    <div class="max-w-[1200px] mx-auto flex items-center justify-between gap-8">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2 text-[#002b5c] hover:cursor-pointer" onclick="window.location.href='{{ route('home') }}'">
                <div class="bg-[#002b5c] text-white p-1 rounded">
                    <svg class="size-4" fill="currentColor" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M24 4C25.7818 14.2173 33.7827 22.2182 44 24C33.7827 25.7818 25.7818 33.7827 24 44C22.2182 33.7827 14.2173 25.7818 4 24C14.2173 22.2182 22.2182 14.2173 24 4Z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-[#002b5c] text-xl font-black uppercase tracking-tighter">DI-TOOL</h2>
            </div>
            @include('layouts.menu')
        </div>
        <div class="flex items-center gap-6 flex-1 justify-end">
            <div class="hidden lg:flex items-center text-[#4c739a] border-r border-[#e7edf3] pr-6 gap-2">
                <span class="material-symbols-outlined text-lg">search</span>
                <input class="bg-transparent border-none text-sm focus:ring-0 placeholder:text-[#4c739a]"
                    placeholder="Search enterprise tools..." type="text" />
            </div>

            <!-- Cart button (right aligned) -->
            <button id="cartToggle" aria-expanded="false" title="Open cart"
                class="relative mr-4 text-[#4c739a] hover:text-[#002b5c] p-2 rounded-lg">
                <span class="material-symbols-outlined text-lg">shopping_cart</span>
                <span id="cartCountBadge"
                    class="hidden absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-red-600 text-white text-[11px] leading-[18px] text-center font-bold">0</span>
            </button>

            <!-- Account dropdown (replaces Shop Portal) -->
            {{-- <div class="relative">
                <button id="accountToggle" aria-expanded="false"
                    class="flex items-center gap-2 bg-white border border-[#e7edf3] px-4 py-2 rounded-lg text-sm font-semibold hover:shadow-sm">
                    <span class="material-symbols-outlined">person</span>
                    <span>Account</span>
                </button>
                <div id="accountMenu"
                    class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-[#e7edf3] py-2 invisible opacity-0 transform scale-95 transition-all">
                    <a href="{{ '#' }}"
                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
                    <a href="{{ '#' }}"
                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Orders</a>
                    <a href="{{ '#' }}"
                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Account Settings</a>
                    <form method="POST" action="{{ '#' }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-50">Sign out</button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
</header>
