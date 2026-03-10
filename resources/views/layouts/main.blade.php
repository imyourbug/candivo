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
    {{-- <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script> --}}
    <script src="/js/tailwind.js"></script>
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
            background: linear-gradient(135deg, #10b981, #059669);
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

    {{-- Cart component (drawer + overlay) --}}
    @include('components.cart')

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

        $(document).on('click', '.download-modal-close', function() {
            $('#downloadModal').addClass('hidden');
        });
    </script>

    <script>
        // Cart behaviour: toggle, render from localStorage 'cart' array
        (function() {
            function qs(id) {
                return document.getElementById(id);
            }

            const cartToggle = qs('cartToggle');
            const cartDrawer = qs('cartDrawer');
            const cartOverlay = qs('cartOverlay');
            const cartClose = qs('cartClose');
            const cartItems = qs('cartItems');
            const cartTotal = qs('cartTotal');
            const checkoutBtn = qs('checkoutBtn');
            const cartCountBadge = qs('cartCountBadge');

            function openCart() {
                if (cartDrawer) cartDrawer.classList.remove('translate-x-full');
                if (cartOverlay) cartOverlay.classList.remove('hidden');
                if (cartToggle) cartToggle.setAttribute('aria-expanded', 'true');
                renderCart();
            }

            function closeCart() {
                if (cartDrawer) cartDrawer.classList.add('translate-x-full');
                if (cartOverlay) cartOverlay.classList.add('hidden');
                if (cartToggle) cartToggle.setAttribute('aria-expanded', 'false');
            }

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
                if (!cartCountBadge) return;
                const items = getCart();
                const totalQty = items.reduce((sum, it) => sum + (Number(it.qty) || 1), 0);
                cartCountBadge.textContent = String(totalQty);
                if (totalQty > 0) {
                    cartCountBadge.classList.remove('hidden');
                } else {
                    cartCountBadge.classList.add('hidden');
                }
            }

            function updateCheckoutState(items) {
                if (!checkoutBtn) return;
                checkoutBtn.disabled = !Array.isArray(items) || items.length === 0;
            }

            function formatPrice(p) {
                if (!p && p !== 0) return '\u20AC0.00';
                const n = Number(p) || 0;
                return '\u20AC' + n.toFixed(2);
            }

            function renderCart() {
                if (!cartItems) return;
                const items = getCart();
                cartItems.innerHTML = '';
                if (!items.length) {
                    cartItems.innerHTML = '<div class="text-sm text-slate-500">Your cart is empty.</div>';
                    cartTotal.textContent = '\u20AC0.00';
                    updateCartBadge();
                    updateCheckoutState(items);
                    return;
                }

                let total = 0;
                items.forEach((it, idx) => {
                    const qty = it.qty || 1;
                    const price = Number(it.price) || 0;
                    total += price * qty;

                    const itemEl = document.createElement('div');
                    itemEl.className = 'pb-6 mb-6 border-b border-slate-100 dark:border-slate-200';
                    itemEl.innerHTML = `
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
                        `;
                    cartItems.appendChild(itemEl);
                });

                cartTotal.textContent = formatPrice(total);
                updateCartBadge();
                updateCheckoutState(items);

                // attach listeners
                cartItems.querySelectorAll('.incr').forEach(btn => btn.addEventListener('click', function() {
                    const idx = Number(this.dataset.idx);
                    const items = getCart();
                    items[idx].qty = (items[idx].qty || 1) + 1;
                    setCart(items);
                    renderCart();
                }));
                cartItems.querySelectorAll('.decr').forEach(btn => btn.addEventListener('click', function() {
                    const idx = Number(this.dataset.idx);
                    const items = getCart();
                    const currentQty = items[idx].qty || 1;
                    if (currentQty <= 1) {
                        items.splice(idx, 1);
                    } else {
                        items[idx].qty = currentQty - 1;
                    }
                    setCart(items);
                    renderCart();
                }));
                cartItems.querySelectorAll('.remove').forEach(btn => btn.addEventListener('click', function() {
                    const idx = Number(this.dataset.idx);
                    const items = getCart();
                    items.splice(idx, 1);
                    setCart(items);
                    renderCart();
                }));
            }

            function escapeHtml(s) {
                return String(s).replace(/[&<>\"]/g, c => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;'
                } [c]));
            }

            if (cartToggle) cartToggle.addEventListener('click', openCart);
            if (cartClose) cartClose.addEventListener('click', closeCart);
            if (cartOverlay) cartOverlay.addEventListener('click', closeCart);
            if (checkoutBtn) checkoutBtn.addEventListener('click', function() {
                const items = getCart();
                if (!Array.isArray(items) || items.length === 0) return;
                window.location.href = '/checkout';
            });
            window.addEventListener('cart:updated', function() {
                updateCartBadge();
                updateCheckoutState(getCart());
            });
            window.addEventListener('storage', function(e) {
                if (e.key === 'cart') {
                    updateCartBadge();
                    updateCheckoutState(getCart());
                }
            });

            // initial render (if cart present)
            document.addEventListener('DOMContentLoaded', function() {
                renderCart();
                updateCartBadge();
                updateCheckoutState(getCart());
            });

            // Account dropdown: toggle behaviour
            const accountToggle = document.getElementById('accountToggle');
            const accountMenu = document.getElementById('accountMenu');
            if (accountToggle && accountMenu) {
                accountToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const open = accountMenu.classList.contains('opacity-100');
                    if (open) {
                        accountMenu.classList.add('invisible');
                        accountMenu.classList.remove('opacity-100');
                        accountToggle.setAttribute('aria-expanded', 'false');
                    } else {
                        accountMenu.classList.remove('invisible');
                        accountMenu.classList.add('opacity-100');
                        accountToggle.setAttribute('aria-expanded', 'true');
                    }
                });

                // close on outside click
                document.addEventListener('click', function(ev) {
                    if (!accountMenu.contains(ev.target) && !accountToggle.contains(ev.target)) {
                        accountMenu.classList.add('invisible');
                        accountMenu.classList.remove('opacity-100');
                        accountToggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        })();
    </script>

    @stack('scripts')
</body>

</html>

