<header class="h-20 flex items-center justify-between px-8 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-10">
    <div class="flex items-center flex-1 max-w-xl">
        <div class="relative w-full">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input class="w-full pl-10 pr-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/50 text-sm"
                placeholder="Search data, orders, or users..." type="text" />
        </div>
    </div>
    <div class="flex items-center gap-6">
        <div class="flex items-center gap-2">
            <button id="admin-theme-toggle" type="button"
                class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"
                title="Toggle theme">
                <span id="admin-theme-toggle-icon" class="material-symbols-outlined">dark_mode</span>
            </button>
            <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg relative">
                <span class="material-symbols-outlined">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full border-2 border-white dark:border-slate-900"></span>
            </button>
            <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                <span class="material-symbols-outlined">chat_bubble</span>
            </button>
        </div>
        <div class="h-8 w-[1px] bg-slate-200 dark:border-slate-800"></div>
        <div class="flex items-center gap-3 pl-2">
            <div class="text-right hidden sm:block">
                @auth
                    <p class="text-sm font-bold leading-none">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-500 font-medium">{{ auth()->user()->email }}</p>
                @else
                    <p class="text-sm font-bold leading-none">Guest</p>
                    <p class="text-xs text-slate-500 font-medium">—</p>
                @endauth
            </div>
            <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border-2 border-primary/20">
                <img alt="User Profile" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBF_XbIyuvZYOaLAQj-E09yf38vlvH3pVotoP4Blp-aEU18yKU8d21uaRl-B2H_zZieULuhPrZuQGyR8auhUKvJ7B50-HhELZP-cM4lUrNKNvaUlujiF_go0SkMPu6Igxkzyl9h5SCTjyZpSxsxhwmf2D1c5dQZeWTkBaHGyG82juujRii4Rw_CrCI9ggf0lnneoKKCjDTkZ7HsPG8GM4Kq2ysPlq6OZlAPVXQNQeAURGHWnofAS3kVcO9K9Juw_yV450AkNaBbDA0" />
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                @csrf
                <button type="submit" class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors" title="Logout">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </div>
    </div>
</header>
