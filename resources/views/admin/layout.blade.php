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
    @stack('admin-scripts')
</body>
</html>
