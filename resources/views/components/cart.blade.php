<div id="cartOverlay" class="fixed inset-0 bg-black/40 hidden z-40"></div>

<aside id="cartDrawer"
    class="fixed right-0 top-0 h-full w-full sm:w-[420px] max-w-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex flex-col h-full">
        <div class="px-6 py-6 border-b border-slate-100 dark:border-slate-250 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-slate-900 dark:text-blue">Your Cart</h3>
            <button id="cartClose" class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div id="cartItems" class="p-6 overflow-y-auto flex-1">
            <!-- Items will be rendered here by JS -->
            <div class="text-sm text-slate-500">Your cart is empty.</div>
        </div>

        <div class="p-6 border-t border-slate-100 dark:border-slate-250">
            <div class="flex items-center justify-between mb-4">
                <span class="text-lg font-bold">Total</span>
                <span id="cartTotal" class="text-lg font-bold">&#8364;0.00</span>
            </div>
            <button id="checkoutBtn" disabled
                class="w-full bg-[var(--enterprise-blue)] text-white py-3 rounded-lg font-bold hover:bg-blue-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-[var(--enterprise-blue)]">Checkout</button>
        </div>
    </div>
</aside>
