<!DOCTYPE html>
<html class="light" lang="en">
<head>
    @include('admin.partials.head')
</head>
<body class="bg-background-light dark:bg-background-dark min-h-screen flex flex-col font-display text-slate-900 dark:text-slate-100">
    @include('admin.partials.guest-header')
    <main class="flex-grow flex items-center justify-center p-6 @yield('main-class', '')">
        @yield('content')
    </main>
    @hasSection('guest-footer')
        @yield('guest-footer')
    @endif
    @stack('admin-scripts')
</body>
</html>
