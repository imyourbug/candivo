<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.partials.sidebar')
        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-background-light dark:bg-background-dark">
            @include('admin.partials.header')
            <div class="p-8 space-y-8 flex-1">
                @yield('content')
            </div>
            @include('admin.partials.footer')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        (function() {
            const KEY = 'admin-theme';
            const root = document.documentElement;
            const btn = document.getElementById('admin-theme-toggle');
            const icon = document.getElementById('admin-theme-toggle-icon');
            if (!btn || !icon) return;

            function currentTheme() {
                return root.classList.contains('dark') ? 'dark' : 'light';
            }

            function applyButtonState(theme) {
                const isDark = theme === 'dark';
                icon.textContent = isDark ? 'light_mode' : 'dark_mode';
                btn.setAttribute('title', isDark ? 'Switch to light mode' : 'Switch to dark mode');
                btn.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
            }

            function setTheme(theme) {
                root.classList.toggle('dark', theme === 'dark');
                root.setAttribute('data-theme', theme);
                localStorage.setItem(KEY, theme);
                applyButtonState(theme);
            }

            applyButtonState(currentTheme());

            btn.addEventListener('click', function() {
                setTheme(currentTheme() === 'dark' ? 'light' : 'dark');
            });
        })();
    </script>
    @stack('admin-scripts')
</body>
</html>
