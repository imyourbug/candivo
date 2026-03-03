@extends('layouts.main')
@section('title', 'Di-tool Premium Checkout')
@push('styles')
@endpush
@section('content')
    <main class="flex-1 flex items-center justify-center p-6 md:p-12">
        <div class="glass-card w-full max-w-6xl rounded-[2rem] overflow-hidden flex flex-col md:flex-row shadow-2xl">
            <div class="flex-[1.4] p-8 md:p-12 border-b md:border-b-0 md:border-r border-white/40">
                <div class="mb-10">
                    <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Checkout Details</h1>
                    <p class="text-slate-500 font-medium">Complete your purchase for Autodesk Inventor Add-ons</p>
                </div>
                <div class="space-y-10">
                    <section>
                        <div class="flex items-center gap-2 mb-5 text-blue-600">
                            <span class="material-symbols-outlined">alternate_email</span>
                            <h3 class="font-bold uppercase tracking-widest text-xs">Customer Information</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Email or Phone</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none focus:ring-2 focus:ring-blue-500/20 text-slate-900 placeholder:text-slate-400"
                                    placeholder="name@company.com" type="text" />
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="flex items-center gap-2 mb-5 text-blue-600">
                            <span class="material-symbols-outlined">local_shipping</span>
                            <h3 class="font-bold uppercase tracking-widest text-xs">Licensing Address</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2 md:col-span-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Full Name</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                    placeholder="John Doe" type="text" />
                            </div>
                            <div class="flex flex-col gap-2 md:col-span-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Street Address</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                    placeholder="123 Engineering Way" type="text" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-semibold text-slate-700 ml-1">City</label>
                                <input
                                    class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                    placeholder="San Francisco" type="text" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-semibold text-slate-700 ml-1">State</label>
                                    <input
                                        class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                        placeholder="CA" type="text" />
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-semibold text-slate-700 ml-1">Zip</label>
                                    <input
                                        class="glass-input h-14 rounded-xl px-4 outline-none text-slate-900 placeholder:text-slate-400"
                                        placeholder="94103" type="text" />
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="flex items-center gap-2 mb-5 text-blue-600">
                            <span class="material-symbols-outlined">payments</span>
                            <h3 class="font-bold uppercase tracking-widest text-xs">Payment Method</h3>
                        </div>
                        <div class="flex gap-4 mb-6">
                            <label class="relative flex-1 cursor-pointer group">
                                <input checked="" class="peer absolute opacity-0" name="payment" type="radio" />
                                <div
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-transparent bg-white/40 glass-input peer-checked:border-blue-600 peer-checked:bg-blue-50/50 transition-all">
                                    <span
                                        class="material-symbols-outlined text-slate-600 group-hover:text-blue-600 mb-1">account_balance_wallet</span>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-tighter text-slate-500">Paypal</span>
                                </div>
                            </label>
                            <label class="relative flex-1 cursor-pointer group">
                                <input class="peer absolute opacity-0" name="payment" type="radio" />
                                <div
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-transparent bg-white/40 glass-input peer-checked:border-blue-600 peer-checked:bg-blue-50/50 transition-all">
                                    <span
                                        class="material-symbols-outlined text-slate-600 group-hover:text-blue-600 mb-1">credit_card</span>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-tighter text-slate-500">Card</span>
                                </div>
                            </label>
                            <label class="relative flex-1 cursor-pointer group">
                                <input class="peer absolute opacity-0" name="payment" type="radio" />
                                <div
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-transparent bg-white/40 glass-input peer-checked:border-blue-600 peer-checked:bg-blue-50/50 transition-all">
                                    <span
                                        class="material-symbols-outlined text-slate-600 group-hover:text-blue-600 mb-1">ios</span>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-tighter text-slate-500">Apple</span>
                                </div>
                            </label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        </div>
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
                            <span class="text-emerald-600 font-bold">-$50.00</span>
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
                                <p class="text-emerald-500 font-black text-lg">$50.00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="flex items-center gap-2 text-slate-500 text-xs font-medium justify-center mb-6">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                        <span>Encrypted Secure Checkout</span>
                    </div>
                    <button
                        class="premium-button w-full h-16 rounded-2xl text-white font-extrabold text-lg flex items-center justify-center gap-3 active:scale-95">
                        <span>Place Your Order</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                    <p class="text-center text-[11px] text-slate-400 mt-6 leading-relaxed">
                        By placing this order, you agree to the Terms of Service. Your digital license will be sent to your
                        email immediately upon successful payment.
                    </p>
                </div>
            </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const summaryHeading = Array.from(document.querySelectorAll('h2')).find((el) => el.textContent
                .trim() ===
                'Order Summary');
            if (!summaryHeading) return;

            const summaryRoot = summaryHeading.closest('.mb-10');
            if (!summaryRoot) return;

            const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [c]));
            const formatPrice = (value) => `€ ${(Number(value) || 0).toFixed(2)}`;

            let items = [];
            try {
                const raw = localStorage.getItem('cart');
                items = raw ? JSON.parse(raw) : [];
            } catch (e) {
                items = [];
            }

            const staticCard = summaryRoot.querySelector('.glass-card');
            const priceBlock = summaryRoot.querySelector('.space-y-4.px-2');
            if (!staticCard || !priceBlock) return;

            const orderItemsEl = document.createElement('div');
            orderItemsEl.className = 'space-y-4 mb-8';

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

            const rows = Array.from(priceBlock.querySelectorAll('.flex.justify-between.items-center'));
            const originalPriceValue = rows[0]?.lastElementChild;
            const discountValue = rows[1]?.lastElementChild;
            const processingFeeValue = rows[2]?.lastElementChild;
            const totalAmountValue = priceBlock.querySelector('.text-4xl.font-black.text-slate-900.tracking-tight');
            const savingsValue = priceBlock.querySelector('.text-emerald-500.font-black.text-lg');
            const discount = 0;
            const processingFee = 0;

            function updateTotals(subtotal) {
                const total = subtotal - discount + processingFee;
                if (originalPriceValue) {
                    originalPriceValue.classList.remove('line-through', 'text-slate-400');
                    originalPriceValue.classList.add('text-slate-800');
                    originalPriceValue.textContent = formatPrice(subtotal);
                }
                if (discountValue) discountValue.textContent = formatPrice(discount);
                if (processingFeeValue) processingFeeValue.textContent = formatPrice(processingFee);
                if (totalAmountValue) totalAmountValue.textContent = formatPrice(total);
                if (savingsValue) savingsValue.textContent = formatPrice(discount);
            }

            function renderOrderSummary() {
                const items = getCart();
                let subtotal = 0;

                if (!items.length) {
                    orderItemsEl.innerHTML = `
                        <div class="glass-card !bg-white/80 p-5 rounded-2xl">
                            <p class="text-sm text-slate-500 font-medium">Your cart is empty.</p>
                        </div>
                    `;
                } else {
                    orderItemsEl.innerHTML = items.map((item, idx) => {
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
                }

                updateTotals(subtotal);

                orderItemsEl.querySelectorAll('.checkout-incr').forEach(btn => btn.addEventListener('click', function() {
                    const idx = Number(this.dataset.idx);
                    const items = getCart();
                    items[idx].qty = (items[idx].qty || 1) + 1;
                    setCart(items);
                    window.dispatchEvent(new Event('cart:updated'));
                    renderOrderSummary();
                }));
                orderItemsEl.querySelectorAll('.checkout-decr').forEach(btn => btn.addEventListener('click', function() {
                    const idx = Number(this.dataset.idx);
                    const items = getCart();
                    const currentQty = items[idx].qty || 1;
                    if (currentQty <= 1) {
                        items.splice(idx, 1);
                    } else {
                        items[idx].qty = currentQty - 1;
                    }
                    setCart(items);
                    window.dispatchEvent(new Event('cart:updated'));
                    renderOrderSummary();
                }));
                orderItemsEl.querySelectorAll('.checkout-remove').forEach(btn => btn.addEventListener('click', function() {
                    const idx = Number(this.dataset.idx);
                    const items = getCart();
                    items.splice(idx, 1);
                    setCart(items);
                    window.dispatchEvent(new Event('cart:updated'));
                    renderOrderSummary();
                }));
            }

            staticCard.replaceWith(orderItemsEl);
            renderOrderSummary();
        });
    </script>
@endpush
