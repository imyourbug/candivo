<nav class="hidden md:flex items-center gap-8">
    <!-- <div class="group relative">
        <button class="flex items-center gap-1 text-[#4c739a] hover:text-[#002b5c] text-sm font-semibold transition-colors">
            Solutions <span class="material-symbols-outlined text-xs group-hover:rotate-180 transition-transform">expand_more</span>
        </button>
        <div class="absolute left-0 mt-0 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <a href="#" class="block px-4 py-3 text-[#4c739a] hover:bg-blue-50 hover:text-[#002b5c] text-sm font-medium transition-colors border-b border-gray-100">Solution 1</a>
            <a href="#" class="block px-4 py-3 text-[#4c739a] hover:bg-blue-50 hover:text-[#002b5c] text-sm font-medium transition-colors border-b border-gray-100">Solution 2</a>
            <a href="#" class="block px-4 py-3 text-[#4c739a] hover:bg-blue-50 hover:text-[#002b5c] text-sm font-medium transition-colors">Solution 3</a>
        </div>
    </div> -->
    {{-- <a class="text-[#4c739a] hover:text-[#002b5c] text-sm font-semibold transition-colors"
        href="{{ route('home') }}">Home</a> --}}
    {{-- <a class="text-[#4c739a] hover:text-[#002b5c] text-sm font-semibold transition-colors"
        href="{{ route('combo') }}">Combo</a> --}}
    <!-- <a class="text-[#4c739a] hover:text-[#002b5c] text-sm font-semibold transition-colors" href="{{ route('checkout') }}">Payment</a> -->
    <a class="text-[#4c739a] hover:text-[#002b5c] text-base md:text-lg font-semibold transition-colors"
        href="{{ route('help-center') }}">Help Center</a>
    <a class="text-[#4c739a] hover:text-[#002b5c] text-base md:text-lg font-semibold transition-colors"
        href="{{ route('about') }}">About Us</a>
    <a class="text-[#4c739a] hover:text-[#002b5c] text-base md:text-lg font-semibold transition-colors cursor-pointer"
        onclick="document.getElementById('downloadModal').classList.remove('hidden')">Download</a>
    <!-- cart moved to header for right alignment -->
</nav>
