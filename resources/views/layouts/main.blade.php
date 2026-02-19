<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <title>@yield('title', 'Di-tool - Premium CAD Solutions')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('styles')
    <style type="text/tailwindcss">
        :root {
            --enterprise-blue: #002D5B;
            --accent-blue: #0066FF;
            --surface-grey: #F1F5F9;
            --glass-bg: rgba(255, 255, 255, 0.65);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFFFFF;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
        }

        .slider-gradient {
            background: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.8) 40%, rgba(255, 255, 255, 0) 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--enterprise-blue), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .combo-grid-pattern {
            background-image: radial-gradient(circle at 2px 2px, #e2e8f0 1px, transparent 0);
            background-size: 24px 24px;
        }

        @layer utilities {
            .bg-modal-overlay {
                background: linear-gradient(135deg, rgba(19, 127, 236, 0.95) 0%, rgba(15, 25, 34, 0.9) 100%);
            }
        }
    </style>
</head>

<body class="text-slate-900 overflow-x-hidden selection:bg-blue-100 selection:text-[var(--enterprise-blue)]">
    <div class="relative flex min-h-screen w-full flex-col">
        @include('layouts.header')
        <main class="flex-1">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>

    <!-- Popup Component -->
    <div id="announcementPopup" class="fixed inset-0 z-50" style="display: none;">
        @component('components.popup')
        @endcomponent
    </div>

    <script>
        $(document).ready(function() {
            const popupKey = 'announcementPopupDismissed';

            // Check if user has selected "Don't ask again"
            if (localStorage.getItem(popupKey) === 'true') {
                // Keep it hidden
                return;
            }

            // Show popup on page load if not dismissed
            $('#announcementPopup').fadeIn(300);

            // Close popup on close button or dismiss button
            $('#announcementPopup').on('click', '.popup-close, .popup-dismiss', function() {
                // Check if "Don't ask again" is checked
                if ($('#dontAskAgain').is(':checked')) {
                    localStorage.setItem(popupKey, 'true');
                }
                $('#announcementPopup').fadeOut(300);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
