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
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" />
    {{-- <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script> --}}
    <script src="/js/tailwind.js?v=1"></script>
    <script>
        tailwind.config = {
          darkMode: 'class', 
        }
      </script>
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

        .premium-button {
            background: linear-gradient(135deg, var(--accent-blue), #004AEE);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 102, 255, 0.4);
        }

        .premium-button:hover {
            box-shadow: 0 6px 25px rgba(0, 102, 255, 0.6);
            transform: translateY(-2px);
        }

        .premium-button:active {
            transform: translateY(0);
        }

        .discount-badge {
            background: #4c739a;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
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

    <!-- Download Modal Component -->
    @component('components.download-popup')
    @endcomponent
    
    <!-- Schedule Modal Component -->
    @include('components.schedule-modal')

    {{-- Cart component (drawer + overlay) --}}
    @include('components.cart')

    <!-- Back to top button -->
    <button id="backToTopBtn"
        class="fixed bottom-6 right-6 z-40 hidden rounded-full bg-[var(--accent-blue)] text-white shadow-lg px-6 py-5 text-sm font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
        ↑
    </button>

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

            function closeAnnouncementPopup() {
                if ($('#dontAskAgain').is(':checked')) {
                    localStorage.setItem(popupKey, 'true');
                }
                $('#announcementPopup').fadeOut(300);
            }

            $('#announcementPopup').on('click', '.popup-close, .popup-dismiss', function() {
                closeAnnouncementPopup();
            });

            $('#announcementPopup').on('click', '.announcement-popup-backdrop', function(e) {
                if (e.target === this) {
                    closeAnnouncementPopup();
                }
            });
        });

        $(document).on('click', '.download-modal-close', function() {
            $('#downloadModal').addClass('hidden');
        });
    </script>

    <script>
        // Global toast utility for all pages.
        window.showToast = function(message, type = 'success') {
            if (!message) return;

            let container = document.getElementById('globalToastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'globalToastContainer';
                container.className = 'fixed top-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            const variants = {
                success: 'border-green-700 bg-green-600 text-white',
                error: 'border-red-700 bg-red-600 text-white',
                warning: 'border-amber-700 bg-amber-500 text-white',
                info: 'border-blue-700 bg-blue-600 text-white',
            };
            const variantClass = variants[type] || variants.success;
            toast.className =
                `pointer-events-auto min-w-[220px] max-w-[320px] rounded-lg border px-4 py-3 text-sm font-medium shadow-lg opacity-0 translate-y-[-8px] transition-all duration-300 ${variantClass}`;
            toast.textContent = message;
            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-[-8px]');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-[-8px]');
                setTimeout(() => toast.remove(), 300);
            }, 2200);
        };

        // Backward compatible helper used by existing pages.
        window.showAddToCartToast = function(message) {
            window.showToast(message, 'success');
        };

        // Shared cart utilities for pages that add items to cart.
        window.CartCommon = window.CartCommon || {
            getCart() {
                try {
                    const raw = localStorage.getItem('cart');
                    return raw ? JSON.parse(raw) : [];
                } catch (e) {
                    return [];
                }
            },
            setCart(items) {
                try {
                    localStorage.setItem('cart', JSON.stringify(items));
                } catch (e) {}
            },
            emitUpdated() {
                window.dispatchEvent(new Event('cart:updated'));
            },
            addProductItem(item) {
                const items = this.getCart();
                const existingIdx = items.findIndex(it =>
                    String(it.type || 'product') === 'product' &&
                    String(it.id ?? '') === String(item.id)
                );
                if (existingIdx >= 0) {
                    items[existingIdx].qty = (items[existingIdx].qty || 1) + 1;
                    items[existingIdx].price = item.price;
                    items[existingIdx].period = item.period;
                } else {
                    items.push(item);
                }
                this.setCart(items);
                this.emitUpdated();
            },
            addPackageItem(item) {
                const items = this.getCart();
                const existingIdx = items.findIndex(it =>
                    String(it.type || 'package') === 'package' &&
                    String(it.id ?? '') === String(item.id) &&
                    String(it.period ?? '') === String(item.period ?? '')
                );
                if (existingIdx >= 0) {
                    items[existingIdx].qty = (items[existingIdx].qty || 1) + 1;
                } else {
                    items.push(item);
                }
                this.setCart(items);
                this.emitUpdated();
            },
            notifyAdded(name) {
                if (typeof window.showToast === 'function') {
                    window.showToast(`${name} added to cart`, 'success');
                }
            }
        };
    </script>

    <script>
        // Back to top behaviour (jQuery)
        $(function() {
            const $btn = $('#backToTopBtn');
            if ($btn.length === 0) return;

            const $header = $('header, #siteHeader').first();
            let threshold = 120;
            if ($header.length) {
                threshold = $header.outerHeight() || threshold;
            }

            $(window).on('scroll', function() {
                if ($(this).scrollTop() > threshold) {
                    $btn.removeClass('hidden');
                } else {
                    $btn.addClass('hidden');
                }
            });

            $btn.on('click', function() {
                $('html, body').animate({ scrollTop: 0 }, 400);
            });
        });
    </script>

    <script>
        // Cart behaviour: toggle, render from localStorage 'cart' array (jQuery version)
        $(function() {
            const $cartToggle = $('#cartToggle');
            const $cartDrawer = $('#cartDrawer');
            const $cartOverlay = $('#cartOverlay');
            const $cartClose = $('#cartClose');
            const $cartItems = $('#cartItems');
            const $cartTotal = $('#cartTotal');
            const $checkoutBtn = $('#checkoutBtn');
            const $cartCountBadge = $('#cartCountBadge');

            function getCart() {
                try {
                    const raw = localStorage.getItem('cart');
                    return raw ? JSON.parse(raw) : [];
                } catch (e) {
                    return [];
                }
            }

            function setCart(items) {
                try {
                    localStorage.setItem('cart', JSON.stringify(items));
                } catch (e) {}
            }

            function updateCartBadge() {
                if ($cartCountBadge.length === 0) return;
                const items = getCart();
                const totalQty = items.reduce((sum, it) => sum + (Number(it.qty) || 1), 0);
                $cartCountBadge.text(String(totalQty));
                if (totalQty > 0) {
                    $cartCountBadge.removeClass('hidden');
                } else {
                    $cartCountBadge.addClass('hidden');
                }
            }

            function updateCheckoutState(items) {
                if ($checkoutBtn.length === 0) return;
                $checkoutBtn.prop('disabled', !Array.isArray(items) || items.length === 0);
            }

            function formatPrice(p) {
                if (!p && p !== 0) return '\u20AC0.00';
                const n = Number(p) || 0;
                return '\u20AC' + n.toFixed(2);
            }

            function escapeHtml(s) {
                return String(s).replace(/[&<>\"]/g, c => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;'
                } [c]));
            }

            function renderCart() {
                if ($cartItems.length === 0) return;
                const items = getCart();
                $cartItems.empty();

                if (!items.length) {
                    $cartItems.html('<div class="text-sm text-slate-500">Your cart is empty.</div>');
                    $cartTotal.text('\u20AC0.00');
                    updateCartBadge();
                    updateCheckoutState(items);
                    return;
                }

                let total = 0;
                items.forEach((it, idx) => {
                    const qty = it.qty || 1;
                    const price = Number(it.price) || 0;
                    total += price * qty;

                    const html = `
                        <div class="pb-6 mb-6 border-b border-slate-100 dark:border-slate-200">
                            <div class="flex justify-between items-start">
                                <div class="max-w-[65%]">
                                    <h4 class="font-bold text-slate-900 dark:text-[var(--enterprise-blue)]">${escapeHtml(it.name || 'Item')}</h4>
                                    <div class="text-slate-500 text-sm mt-1">${formatPrice(price)}${it.period ? ' \u2022 ' + it.period : ''}</div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-2">
                                        <button data-idx="${idx}" class="decr inline-flex items-center justify-center w-8 h-8 bg-slate-100 rounded-md">-</button>
                                        <div class="px-2">${qty}</div>
                                        <button data-idx="${idx}" class="incr inline-flex items-center justify-center w-8 h-8 bg-slate-100 rounded-md">+</button>
                                    </div>
                                    <button data-idx="${idx}" class="remove mt-3 text-sm text-red-500">Remove</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $cartItems.append(html);
                });

                $cartTotal.text(formatPrice(total));
                updateCartBadge();
                updateCheckoutState(items);
            }

            function openCart() {
                if ($cartDrawer.length) $cartDrawer.removeClass('translate-x-full');
                if ($cartOverlay.length) $cartOverlay.removeClass('hidden');
                if ($cartToggle.length) $cartToggle.attr('aria-expanded', 'true');
                renderCart();
            }

            function closeCart() {
                if ($cartDrawer.length) $cartDrawer.addClass('translate-x-full');
                if ($cartOverlay.length) $cartOverlay.addClass('hidden');
                if ($cartToggle.length) $cartToggle.attr('aria-expanded', 'false');
            }

            // Event bindings
            $cartToggle.on('click', openCart);
            $cartClose.on('click', closeCart);
            $cartOverlay.on('click', closeCart);

            $checkoutBtn.on('click', function() {
                const items = getCart();
                if (!Array.isArray(items) || items.length === 0) return;
                window.location.href = '/checkout';
            });

            // Delegate item actions
            $cartItems.on('click', '.incr', function() {
                const idx = Number($(this).data('idx'));
                const items = getCart();
                items[idx].qty = (items[idx].qty || 1) + 1;
                setCart(items);
                renderCart();
            });

            $cartItems.on('click', '.decr', function() {
                const idx = Number($(this).data('idx'));
                const items = getCart();
                const currentQty = items[idx].qty || 1;
                if (currentQty <= 1) {
                    items.splice(idx, 1);
                } else {
                    items[idx].qty = currentQty - 1;
                }
                setCart(items);
                renderCart();
            });

            $cartItems.on('click', '.remove', function() {
                const idx = Number($(this).data('idx'));
                const items = getCart();
                items.splice(idx, 1);
                setCart(items);
                renderCart();
            });

            // Listen for external cart updates
            $(window).on('cart:updated', function() {
                const items = getCart();
                updateCartBadge();
                updateCheckoutState(items);
            });

            $(window).on('storage', function(e) {
                if (e.originalEvent && e.originalEvent.key === 'cart') {
                    const items = getCart();
                    updateCartBadge();
                    updateCheckoutState(items);
                }
            });

            // Initial render
            renderCart();
            updateCartBadge();
            updateCheckoutState(getCart());

            // Account dropdown: toggle behaviour
            const $accountToggle = $('#accountToggle');
            const $accountMenu = $('#accountMenu');

            if ($accountToggle.length && $accountMenu.length) {
                $accountToggle.on('click', function(e) {
                    e.stopPropagation();
                    const open = $accountMenu.hasClass('opacity-100');
                    if (open) {
                        $accountMenu.addClass('invisible').removeClass('opacity-100');
                        $accountToggle.attr('aria-expanded', 'false');
                    } else {
                        $accountMenu.removeClass('invisible').addClass('opacity-100');
                        $accountToggle.attr('aria-expanded', 'true');
                    }
                });

                // close on outside click
                $(document).on('click', function(ev) {
                    if (
                        !$accountMenu.is(ev.target) &&
                        $accountMenu.has(ev.target).length === 0 &&
                        !$accountToggle.is(ev.target) &&
                        $accountToggle.has(ev.target).length === 0
                    ) {
                        $accountMenu.addClass('invisible').removeClass('opacity-100');
                        $accountToggle.attr('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>

