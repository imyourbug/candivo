@extends('layouts.main')
@section('title', 'Di-tool Premium Checkout')
@push('styles')
    <style>
        @keyframes place-order-spin {
            to { transform: rotate(360deg); }
        }
        .place-order-spinner {
            animation: place-order-spin 0.9s linear infinite;
        }
    </style>
@endpush
@section('content')
    <main class="flex-1 flex items-center justify-center p-6 md:p-12">
        <div class="glass-card w-full max-w-6xl rounded-[2rem] overflow-hidden flex flex-col md:flex-row shadow-2xl">
            <div class="flex-[1.4] p-8 md:p-12 border-b md:border-b-0 md:border-r border-white/40">
                @if (session('success'))
                    <div id="payment-status-success"
                        class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div id="payment-status-error"
                        class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mb-10">
                    <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Checkout Details</h1>
                    <p class="text-slate-500 font-medium">Complete your purchase for Autodesk Inventor Add-ons</p>
                </div>
                <div class="space-y-10">
                    <section>
                        <div class="flex items-center gap-2 mb-5 text-[#4c739a]">
                            <span class="material-symbols-outlined">alternate_email</span>
                            <h3 class="font-bold uppercase tracking-widest text-xs">Customer Information</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Email</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none focus:ring-2 focus:ring-blue-500/20 text-slate-900 placeholder:text-slate-400"
                                    name="customer_contact" placeholder="name@company.com" type="text" autocomplete="email" />
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="flex items-center gap-2 mb-5 text-[#4c739a]">
                            <span class="material-symbols-outlined">local_shipping</span>
                            <h3 class="font-bold uppercase tracking-widest text-xs">Licensing Address</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2 md:col-span-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Country</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                    name="country" placeholder="United States" type="text" autocomplete="country-name" />
                            </div>
                            <div class="flex flex-col gap-2 md:col-span-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Major</label>
                                <select
                                    class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900"
                                    name="customer_major">
                                    <option value="" selected>Select your major</option>
                                    <option value="computer_science">Computer Science</option>
                                    <option value="information_technology">Information Technology</option>
                                    <option value="business_administration">Business Administration</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="finance">Finance</option>
                                    <option value="engineering">Engineering</option>
                                    <option value="design">Design</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                        </div>
                    </section>
                    <section>
                        <div class="flex items-center gap-2 mb-5 text-[#4c739a]">
                            <span class="material-symbols-outlined">payments</span>
                            <h3 class="font-bold uppercase tracking-widest text-xs">Payment Method</h3>
                        </div>
                        <div class="flex gap-4 mb-6">
                            <label class="relative flex-1 cursor-pointer group">
                                <input checked="" class="peer absolute opacity-0" name="payment_method" type="radio" value="paypal" />
                                <div
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-transparent bg-white/40 glass-input peer-checked:border-blue-600 peer-checked:bg-blue-50/50 transition-all">
                                    <span
                                        class="material-symbols-outlined text-slate-600 group-hover:text-[#4c739a] mb-1">account_balance_wallet</span>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-tighter text-slate-500">Paypal</span>
                                </div>
                            </label>
                            <label class="relative flex-1 cursor-pointer group">
                                <input class="peer absolute opacity-0" name="payment_method" type="radio" value="mollie" />
                                <div
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-transparent bg-white/40 glass-input peer-checked:border-blue-600 peer-checked:bg-blue-50/50 transition-all">
                                    <span
                                        class="material-symbols-outlined text-slate-600 group-hover:text-[#4c739a] mb-1">credit_card</span>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-tighter text-slate-500">Mollie</span>
                                </div>
                            </label>
                        </div>
                        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2 md:col-span-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Card Number</label>
                                <div class="relative">
                                    <input
                                        class="glass-input h-14 w-full rounded-xl px-4 pl-12 outline-none text-slate-900 placeholder:text-slate-400"
                                        placeholder="0000 0000 0000 0000" type="text" />
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">lock</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Expiry Date</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                    placeholder="MM / YY" type="text" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">CVV</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                    placeholder="***" type="password" />
                            </div>
                        </div> --}}
                    </section>
                </div>
            </div>
            <div class="flex-1 bg-white/30 p-8 md:p-12 flex flex-col">
                <div class="mb-10">
                    <h2 class="text-2xl font-extrabold text-slate-900 mb-6">Order Summary</h2>
                    <div class="glass-card !bg-white/80 p-5 rounded-2xl flex gap-4 mb-8">
                        <div class="w-20 h-20 rounded-xl overflow-hidden shadow-inner flex-shrink-0">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAt5sRLGvFwN3uG0Ve_NPyH0hNMtrZpdtLY4UjmMWuvL83IZmLp2uw3PUgvfwPqCFX95HjAhVM_Y8AMV4BZM2CdqrWeyWFMUcAWnCrPW8rQkQxTgpVyYh3BFLjOdY-WBHwB3i-Zpwsai9vZbZgLCAEowJL2ihCfYfz8TzT5N0pe1jXNNVy4AzBX4-KhHEO18v8_Zs9JGGlhDXqqTgJmJHbirslJ58lnv0av6CFSOFzC4nrvj-ioVQfHYNh5qDJEIJ6QlaRqGN8rnhI" />
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="font-bold text-slate-800 text-lg leading-tight">Essential Di-tool Package</h4>
                            <p class="text-sm text-slate-500 font-medium">Digital License â€¢ 1 Item</p>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">Lifetime
                                    Access</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 px-2">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Original Price</span>
                            <span class="text-slate-400 font-medium line-through">$199.00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500 font-medium">Flash Discount</span>
                                <span
                                    class="discount-badge text-[10px] text-white font-black px-1.5 py-0.5 rounded uppercase tracking-wide">SAVE
                                    25%</span>
                            </div>
                            <span class="text-[#4c739a] font-bold">-$50.00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Processing Fee</span>
                            <span class="text-slate-800 font-medium">$0.00</span>
                        </div>
                        <div class="h-px bg-slate-200 my-4"></div>
                        <div class="flex justify-between items-end pt-2">
                            <div>
                                <span class="text-slate-500 text-sm font-medium">Total Amount</span>
                                <div class="text-4xl font-black text-slate-900 tracking-tight">$149.00</div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Total
                                    Savings</p>
                                <p class="text-[#4c739a] font-black text-lg">$50.00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <form id="paypal-checkout-form" method="POST" action="{{ route('paypal.handle') }}" class="checkout-form" novalidate>
                        @csrf
                        <input type="hidden" name="order_total" id="order_total" value="0">
                        <input type="hidden" name="cart_data" id="cart_data_paypal" value="">
                        <input type="hidden" name="customer_contact" id="customer_contact_paypal" value="">
                        <input type="hidden" name="country" id="country_paypal" value="">
                        <input type="hidden" name="customer_major" id="customer_major_paypal" value="">
                    </form>
                    <form id="mollie-checkout-form" method="POST" action="{{ route('mollie.handle') }}" class="checkout-form" novalidate>
                        @csrf
                        <input type="hidden" name="order_total" id="order_total_mollie" value="0">
                        <input type="hidden" name="cart_data" id="cart_data_mollie" value="">
                        <input type="hidden" name="customer_contact" id="customer_contact_mollie" value="">
                        <input type="hidden" name="country" id="country_mollie" value="">
                        <input type="hidden" name="customer_major" id="customer_major_mollie" value="">
                    </form>
                    <div class="flex items-center gap-2 text-slate-500 text-xs font-medium justify-center mb-6">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                        <span>Encrypted Secure Checkout</span>
                    </div>
                    <button type="button" id="place-order-btn"
                        class="premium-button w-full h-16 rounded-2xl text-white font-extrabold text-lg flex items-center justify-center gap-3 active:scale-95"
                        data-empty-url="{{ route('home', ['tab' => 'Package']) }}">
                        <span class="place-order-loading hidden items-center gap-2">
                            <span class="material-symbols-outlined place-order-spinner" style="font-size: 1.5rem;">progress_activity</span>
                            <span>Processing...</span>
                        </span>
                        <span class="place-order-content flex items-center gap-3">
                            <span class="place-order-label">Place Your Order</span>
                            <span class="material-symbols-outlined place-order-icon">arrow_forward</span>
                        </span>
                    </button>
                    <p class="text-center text-[11px] text-slate-400 mt-6 leading-relaxed">
                        By placing this order, you agree to the Terms of Service. Your digital license will be sent to
                        your
                        email immediately upon successful payment.
                    </p>
                </div>
            </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(function() {
            if ($('#payment-status-success').length) {
                try {
                    localStorage.removeItem('cart');
                    window.dispatchEvent(new Event('cart:updated'));
                } catch (e) {}
            }

            const $summaryHeading = $('h2').filter(function() {
                return $(this).text().trim() === 'Order Summary';
            }).first();
            if (!$summaryHeading.length) return;

            const $summaryRoot = $summaryHeading.closest('.mb-10');
            if (!$summaryRoot.length) return;

            const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[c]));
            const formatPrice = (value) => `$ ${(Number(value) || 0).toFixed(2)}`;

            const $priceBlock = $summaryRoot.find('.space-y-4.px-2');
            if (!$priceBlock.length) return;

            const $orderItemsEl = $('<div/>').addClass('space-y-4 mb-8');
            const $placeOrderBtn = $('#place-order-btn');
            const $contactInput = $('input[name="customer_contact"]');
            const $countryInput = $('input[name="country"]');
            const $majorSelect = $('select[name="customer_major"]');

            /** Last successful checkout details (browser localStorage; same device/profile returns here). */
            const CHECKOUT_CUSTOMER_STORAGE_KEY = 'candivo_checkout_customer';

            function applyCheckoutCustomerFromStorage() {
                try {
                    const raw = localStorage.getItem(CHECKOUT_CUSTOMER_STORAGE_KEY);
                    if (!raw) return;
                    const data = JSON.parse(raw);
                    if (!data || typeof data !== 'object') return;
                    if (data.customer_contact && $contactInput.length) {
                        $contactInput.val(String(data.customer_contact));
                    }
                    if (data.country && $countryInput.length) {
                        $countryInput.val(String(data.country));
                    }
                    if (data.customer_major && $majorSelect.length) {
                        $majorSelect.val(String(data.customer_major));
                    }
                    if (data.payment_method) {
                        const pm = String(data.payment_method);
                        if (pm === 'paypal' || pm === 'mollie') {
                            $('input[name="payment_method"][value="' + pm + '"]').prop('checked', true);
                        }
                    }
                } catch (e) {}
            }

            function saveCheckoutCustomerToStorage() {
                try {
                    const payload = {
                        customer_contact: String($contactInput.val() || '').trim(),
                        country: String($countryInput.val() || '').trim(),
                        customer_major: String($majorSelect.val() || '').trim(),
                        payment_method: String($('input[name="payment_method"]:checked').val() || 'paypal')
                    };
                    localStorage.setItem(CHECKOUT_CUSTOMER_STORAGE_KEY, JSON.stringify(payload));
                } catch (e) {}
            }

            function setFieldError($field, message) {
                if (!$field.length) return;
                $field.toggleClass('ring-2 ring-red-400/40 border-red-400', !!message);
                // Ensure error appears directly below the field block.
                const $wrapper = $field.closest('div.flex.flex-col, div.flex-col').first().length ?
                    $field.closest('div.flex.flex-col, div.flex-col').first() :
                    $field.parent();

                let $error = $wrapper.children('.field-error').first();
                if (!$error.length) {
                    $error = $('<p class="field-error text-xs text-red-500 mt-1"></p>');
                    $wrapper.append($error);
                }

                $error.text(message || '');
                if (!message) $error.remove();
            }

            function validateCheckoutForm(showErrors = true) {
                let isValid = true;
                const email = String($contactInput.val() || '').trim();
                const country = String($countryInput.val() || '').trim();
                const major = String($majorSelect.val() || '').trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    isValid = false;
                    if (showErrors) setFieldError($contactInput, 'Please enter a valid email address.');
                } else if (showErrors) {
                    setFieldError($contactInput, '');
                }

                if (!country) {
                    isValid = false;
                    if (showErrors) setFieldError($countryInput, 'Country is required.');
                } else if (showErrors) {
                    setFieldError($countryInput, '');
                }

                if (!major) {
                    isValid = false;
                    if (showErrors) setFieldError($majorSelect, 'Please select your major.');
                } else if (showErrors) {
                    setFieldError($majorSelect, '');
                }

                return isValid;
            }

            applyCheckoutCustomerFromStorage();
            validateCheckoutForm(false);

            $contactInput.on('input blur change', () => validateCheckoutForm(true));
            $countryInput.on('input blur change', () => validateCheckoutForm(true));
            $majorSelect.on('change blur', () => validateCheckoutForm(true));

            const getCart = () => {
                try {
                    const raw = localStorage.getItem('cart');
                    return raw ? JSON.parse(raw) : [];
                } catch (e) {
                    return [];
                }
            };
            const setCart = (items) => {
                try {
                    localStorage.setItem('cart', JSON.stringify(items));
                } catch (e) {}
            };

            const $rows = $priceBlock.find('.flex.justify-between.items-center');
            const $originalPriceValue = $rows.eq(0).children().last();
            const $discountValue = $rows.eq(1).children().last();
            const $processingFeeValue = $rows.eq(2).children().last();
            const $totalAmountValue = $priceBlock.find('.text-4xl.font-black.text-slate-900.tracking-tight').first();
            const $savingsValue = $priceBlock.find('.text-emerald-500.font-black.text-lg').first();
            const discount = 0;
            const processingFee = 0;

            function updateTotals(subtotal) {
                const total = subtotal - discount + processingFee;
                const totalStr = (Number(total) || 0).toFixed(2);
                $('#order_total').val(totalStr);
                $('#order_total_mollie').val(totalStr);
                if ($originalPriceValue.length) {
                    $originalPriceValue
                        .removeClass('line-through text-slate-400')
                        .addClass('text-slate-800')
                        .text(formatPrice(subtotal));
                }
                if ($discountValue.length) {
                    $discountValue.text(formatPrice(discount));
                }
                if ($processingFeeValue.length) {
                    $processingFeeValue.text(formatPrice(processingFee));
                }
                if ($totalAmountValue.length) {
                    $totalAmountValue.text(formatPrice(total));
                }
                if ($savingsValue.length) {
                    $savingsValue.text(formatPrice(discount));
                }

                if ($placeOrderBtn.length) {
                    if (subtotal <= 0) {
                        $placeOrderBtn.prop('disabled', false)
                            .removeClass('opacity-60 cursor-not-allowed')
                            .addClass('active:scale-95');
                        $placeOrderBtn.find('.place-order-label').text("Let's Buy Something");
                        $placeOrderBtn.find('.place-order-icon').text('shopping_cart');
                    } else {
                        $placeOrderBtn.prop('disabled', false)
                            .removeClass('opacity-60 cursor-not-allowed')
                            .addClass('active:scale-95');
                        $placeOrderBtn.find('.place-order-label').text('Place Your Order');
                        $placeOrderBtn.find('.place-order-icon').text('arrow_forward');
                    }
                    $placeOrderBtn.find('.place-order-loading').addClass('hidden');
                    $placeOrderBtn.find('.place-order-content').removeClass('hidden');
                }
            }

            function renderOrderSummary() {
                const items = getCart();
                let subtotal = 0;

                if (!items.length) {
                    $orderItemsEl.html(`
                        <div class="glass-card !bg-white/80 p-5 rounded-2xl">
                            <p class="text-sm text-slate-500 font-medium">Your cart is empty.</p>
                        </div>
                    `);
                } else {
                    const html = items.map((item, idx) => {
                        const qty = Number(item.qty) || 1;
                        const price = Number(item.price) || 0;
                        const lineTotal = qty * price;
                        subtotal += lineTotal;
                        const image = item.image || 'https://placehold.co/80x80/e2e8f0/475569?text=Tool';
                        const detailUrl = (item.detailUrl || '').trim();
                        const leftContent = `
                            <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0">
                                <img src="${escapeHtml(image)}" alt="${escapeHtml(item.name || 'Item')}" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-lg leading-tight">${escapeHtml(item.name || 'Item')}</h4>
                                <p class="text-sm text-slate-500 font-medium">${formatPrice(price)} ${item.period ? '• ' + escapeHtml(item.period) : ''}</p>
                            </div>
                        `;
                        const leftWrap = detailUrl
                            ? `<a href="${escapeHtml(detailUrl)}" class="flex items-start gap-3 flex-1 min-w-0" title="View details">${leftContent}</a>`
                            : `<div class="flex items-start gap-3 flex-1 min-w-0">${leftContent}</div>`;
                        return `
                            <div class="glass-card !bg-white/80 p-5 rounded-2xl flex items-start justify-between gap-4 flex-wrap">
                                ${leftWrap}
                                <div class="flex flex-col items-end gap-2">
                                    <div class="flex items-center gap-2">
                                        <button type="button" data-idx="${idx}" class="checkout-decr inline-flex items-center justify-center w-8 h-8 bg-slate-100 hover:bg-slate-200 rounded-md text-slate-700 font-bold">−</button>
                                        <span class="min-w-[1.5rem] text-center font-medium text-slate-800">${qty}</span>
                                        <button type="button" data-idx="${idx}" class="checkout-incr inline-flex items-center justify-center w-8 h-8 bg-slate-100 hover:bg-slate-200 rounded-md text-slate-700 font-bold">+</button>
                                    </div>
                                    <p class="font-bold text-slate-900">${formatPrice(lineTotal)}</p>
                                    <button type="button" data-idx="${idx}" class="checkout-remove text-sm text-red-500 hover:text-red-600 font-medium">Remove</button>
                                </div>
                            </div>
                        `;
                    }).join('');
                    $orderItemsEl.html(html);
                }

                updateTotals(subtotal);

                $orderItemsEl.find('.checkout-incr').off('click').on('click', function() {
                    const idx = Number($(this).data('idx'));
                    const items = getCart();
                    items[idx].qty = (items[idx].qty || 1) + 1;
                    setCart(items);
                    $(window).trigger('cart:updated');
                    renderOrderSummary();
                });

                $orderItemsEl.find('.checkout-decr').off('click').on('click', function() {
                    const idx = Number($(this).data('idx'));
                    const items = getCart();
                    const currentQty = items[idx].qty || 1;
                    if (currentQty <= 1) {
                        items.splice(idx, 1);
                    } else {
                        items[idx].qty = currentQty - 1;
                    }
                    setCart(items);
                    $(window).trigger('cart:updated');
                    renderOrderSummary();
                });

                $orderItemsEl.find('.checkout-remove').off('click').on('click', function() {
                    const idx = Number($(this).data('idx'));
                    const items = getCart();
                    items.splice(idx, 1);
                    setCart(items);
                    $(window).trigger('cart:updated');
                    renderOrderSummary();
                });
            }

            $summaryRoot.find('.glass-card').first().replaceWith($orderItemsEl);
            renderOrderSummary();

            $('#place-order-btn').on('click', function() {
                const $btn = $(this);
                const cart = getCart();
                if (!cart || cart.length === 0) {
                    const url = $btn.data('empty-url');
                    if (url) window.location.href = url;
                    return;
                }
                if ($btn.prop('disabled')) return;
                const method = $('input[name="payment_method"]:checked').val();
                if (method !== 'mollie' && method !== 'paypal') {
                    if (typeof window.showToast === 'function') {
                        window.showToast('Please select PayPal or Mollie to place your order.', 'warning');
                    }
                    return;
                }

                if (!validateCheckoutForm(true)) {
                    if (typeof window.showToast === 'function') {
                        window.showToast('Please complete all required fields before placing your order.', 'error');
                    }
                    return;
                }

                saveCheckoutCustomerToStorage();

                $btn.find('.place-order-content').addClass('hidden');
                $btn.find('.place-order-loading').removeClass('hidden').addClass('flex');
                $btn.prop('disabled', true);

                let totalStr = $('#order_total').val();
                const cartStr = JSON.stringify(cart);
                $('#order_total_mollie').val(totalStr);
                $('#cart_data_paypal').val(cartStr);
                $('#cart_data_mollie').val(cartStr);
                $('#customer_contact_paypal').val(String($contactInput.val() || '').trim());
                $('#customer_contact_mollie').val(String($contactInput.val() || '').trim());
                $('#country_paypal').val(String($countryInput.val() || '').trim());
                $('#country_mollie').val(String($countryInput.val() || '').trim());
                $('#customer_major_paypal').val(String($majorSelect.val() || '').trim());
                $('#customer_major_mollie').val(String($majorSelect.val() || '').trim());
                if (method === 'mollie') {
                    $('#mollie-checkout-form').submit();
                } else {
                    $('#order_total').val(totalStr);
                    $('#paypal-checkout-form').submit();
                }
            });
        });
    </script>
@endpush
