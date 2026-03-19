@php
    $package = $package ?? null;
    $isEdit = $package !== null;
    $selectedProductIds = collect(old('product_ids', $isEdit ? $package->products->pluck('id')->all() : []))
        ->map(fn ($id) => (int) $id)
        ->all();

    $tierRows = old('pricing_tiers');
    if ($tierRows === null) {
        if ($isEdit) {
            $pricingCollection = $package->pricing->sortBy('duration_months')->values();
            if ($pricingCollection->isNotEmpty()) {
                $tierRows = $pricingCollection
                    ->map(function ($p) {
                        return [
                            'duration_months' => $p->duration_months,
                            'price' => $p->price,
                            'currency' => $p->currency ?? 'EUR',
                        ];
                    })
                    ->all();
            } else {
                $tierRows = [['duration_months' => '', 'price' => '', 'currency' => 'EUR']];
            }
        } else {
            $tierRows = [['duration_months' => '', 'price' => '', 'currency' => 'EUR']];
        }
    }
    if (! is_array($tierRows) || count($tierRows) === 0) {
        $tierRows = [['duration_months' => '', 'price' => '', 'currency' => 'EUR']];
    }
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $package?->name) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-rose-500 @enderror" />
            @error('name')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="slug" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Slug (URL)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $package?->slug) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-rose-500 @enderror"
                placeholder="auto-generated if empty" />
            @error('slug')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="package_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Package ID</label>
            <input type="text" name="package_id" id="package_id" value="{{ old('package_id', $package?->package_id) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" />
        </div>
        <div>
            <label for="type_code" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Type</label>
            <select name="type_code" id="type_code"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('type_code') border-rose-500 @enderror">
                <option value="">— None —</option>
                @foreach($types as $type)
                    <option value="{{ $type->code }}" {{ old('type_code', $package?->type_code) === $type->code ? 'selected' : '' }}>{{ $type->name }} ({{ $type->code }})</option>
                @endforeach
            </select>
            @error('type_code')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="level" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Level</label>
            <input type="number" name="level" id="level" min="0" step="1" value="{{ old('level', $package?->level) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('level') border-rose-500 @enderror" />
            @error('level')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Description</label>
        <textarea name="description" id="description" rows="6"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-rose-500 @enderror">{{ old('description', $package?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="avatar" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Avatar URL</label>
            <input type="text" name="avatar" id="avatar" value="{{ old('avatar', $package?->avatar) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
        </div>
        <div>
            <label for="video" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Video URL</label>
            <input type="text" name="video" id="video" value="{{ old('video', $package?->video) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
        </div>
    </div>

    <div>
        <label for="images" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Images (comma separated URLs)</label>
        <textarea name="images" id="images" rows="2"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary">{{ old('images', is_array($package?->images) ? implode(',', $package->images) : '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Products in package</label>
        <div id="package-product-picker" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900">
                <div class="p-3 border-b border-slate-200 dark:border-slate-700">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Available products (<span id="available-products-count">0</span>)</p>
                    <input type="text" id="package-products-search-available" placeholder="Search by name or slug..."
                        class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary text-sm" />
                    <div class="mt-2">
                        <button type="button" id="package-products-add-all"
                            class="inline-flex items-center gap-1 rounded-lg border border-primary text-primary px-2.5 py-1.5 text-xs font-semibold hover:bg-primary/10">
                            <span class="material-symbols-outlined text-base">playlist_add</span>Add all
                        </button>
                    </div>
                </div>
                <div id="available-products-list" class="max-h-72 overflow-auto p-2 space-y-2"></div>
            </div>
            <div class="border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900">
                <div class="p-3 border-b border-slate-200 dark:border-slate-700">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Selected products (<span id="selected-products-count">0</span>)</p>
                    <input type="text" id="package-products-search-selected" placeholder="Search selected..."
                        class="w-full mt-2 px-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary text-sm" />
                    <div class="mt-2">
                        <button type="button" id="package-products-remove-all"
                            class="inline-flex items-center gap-1 rounded-lg border border-rose-300 text-rose-600 px-2.5 py-1.5 text-xs font-semibold hover:bg-rose-50">
                            <span class="material-symbols-outlined text-base">playlist_remove</span>Remove all
                        </button>
                    </div>
                </div>
                <div id="selected-products-list" class="max-h-72 overflow-auto p-2 space-y-2"></div>
            </div>
        </div>
        <div id="selected-product-hidden-inputs"></div>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Use search then Add/Remove. Selected items are submitted as <code>product_ids[]</code>.</p>
        @error('product_ids')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
        @error('product_ids.*')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
        <script type="application/json" id="package-products-data">@json(
            $products->map(fn ($p) => ['id' => (int) $p->id, 'name' => $p->name, 'slug' => $p->slug])->values()
        )</script>
        <script type="application/json" id="package-selected-products-data">@json($selectedProductIds)</script>
    </div>

    <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
            <div>
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Pricing (duration tiers)</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Add one row per billing period. Duplicate month values are merged (last wins).</p>
            </div>
            <button type="button" id="package-pricing-add-row"
                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-primary text-primary text-sm font-semibold hover:bg-primary/10 transition-colors shrink-0">
                <span class="material-symbols-outlined text-lg">add</span>
                Add tier
            </button>
        </div>

        <div id="package-pricing-rows" class="space-y-3">
            @foreach ($tierRows as $idx => $tier)
                <div class="pricing-tier-row flex flex-col sm:flex-row sm:items-end gap-3 p-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/40">
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Period (months)</label>
                        <input type="number" data-field="duration_months" name="pricing_tiers[{{ $idx }}][duration_months]" min="0" step="1"
                            value="{{ old('pricing_tiers.' . $idx . '.duration_months', $tier['duration_months'] ?? '') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary @error('pricing_tiers.' . $idx . '.duration_months') border-rose-500 @enderror"
                            placeholder="e.g. 12" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Price</label>
                        <input type="number" data-field="price" name="pricing_tiers[{{ $idx }}][price]" min="0" step="0.01"
                            value="{{ old('pricing_tiers.' . $idx . '.price', $tier['price'] ?? '') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary @error('pricing_tiers.' . $idx . '.price') border-rose-500 @enderror"
                            placeholder="0.00" />
                    </div>
                    <div class="w-full sm:w-28 shrink-0">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Currency</label>
                        <select data-field="currency" name="pricing_tiers[{{ $idx }}][currency]"
                            class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary text-sm">
                            @php $cur = old('pricing_tiers.' . $idx . '.currency', $tier['currency'] ?? 'EUR'); @endphp
                            <option value="EUR" {{ $cur === 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="USD" {{ $cur === 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                    </div>
                    <div class="flex sm:pb-0.5">
                        <button type="button" class="pricing-tier-remove inline-flex items-center justify-center p-2 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-500 hover:bg-rose-50 hover:border-rose-200 hover:text-rose-600 dark:hover:bg-slate-700 transition-colors"
                            title="Remove tier" aria-label="Remove tier">
                            <span class="material-symbols-outlined text-xl">delete</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <template id="package-pricing-row-template">
        <div class="pricing-tier-row flex flex-col sm:flex-row sm:items-end gap-3 p-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/40">
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Period (months)</label>
                <input type="number" data-field="duration_months" min="0" step="1"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary"
                    placeholder="e.g. 12" />
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Price</label>
                <input type="number" data-field="price" min="0" step="0.01"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary"
                    placeholder="0.00" />
            </div>
            <div class="w-full sm:w-28 shrink-0">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Currency</label>
                <select data-field="currency" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary text-sm">
                    <option value="EUR" selected>EUR</option>
                    <option value="USD">USD</option>
                </select>
            </div>
            <div class="flex sm:pb-0.5">
                <button type="button" class="pricing-tier-remove inline-flex items-center justify-center p-2 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-500 hover:bg-rose-50 hover:border-rose-200 hover:text-rose-600 dark:hover:bg-slate-700 transition-colors"
                    title="Remove tier" aria-label="Remove tier">
                    <span class="material-symbols-outlined text-xl">delete</span>
                </button>
            </div>
        </div>
    </template>
</div>

@push('admin-scripts')
    <script>
        (function() {
            const container = document.getElementById('package-pricing-rows');
            const addBtn = document.getElementById('package-pricing-add-row');
            const tpl = document.getElementById('package-pricing-row-template');
            if (!container || !addBtn || !tpl) return;

            function reindexRows() {
                const rows = container.querySelectorAll('.pricing-tier-row');
                rows.forEach(function(row, i) {
                    row.querySelectorAll('[name]').forEach(function(el) {
                        el.removeAttribute('name');
                    });
                    row.querySelector('[data-field="duration_months"]').setAttribute('name', 'pricing_tiers[' + i + '][duration_months]');
                    row.querySelector('[data-field="price"]').setAttribute('name', 'pricing_tiers[' + i + '][price]');
                    row.querySelector('[data-field="currency"]').setAttribute('name', 'pricing_tiers[' + i + '][currency]');
                });
            }

            function bindRemove(row) {
                const btn = row.querySelector('.pricing-tier-remove');
                if (!btn) return;
                btn.addEventListener('click', function() {
                    const rows = container.querySelectorAll('.pricing-tier-row');
                    if (rows.length <= 1) return;
                    row.remove();
                    reindexRows();
                });
            }

            container.querySelectorAll('.pricing-tier-row').forEach(bindRemove);

            addBtn.addEventListener('click', function() {
                const node = tpl.content.cloneNode(true);
                const row = node.querySelector('.pricing-tier-row');
                container.appendChild(row);
                reindexRows();
                bindRemove(row);
            });
        })();

        (function() {
            const allProductsEl = document.getElementById('package-products-data');
            const selectedProductsEl = document.getElementById('package-selected-products-data');
            const availableList = document.getElementById('available-products-list');
            const selectedList = document.getElementById('selected-products-list');
            const searchAvailableInput = document.getElementById('package-products-search-available');
            const searchSelectedInput = document.getElementById('package-products-search-selected');
            const hiddenContainer = document.getElementById('selected-product-hidden-inputs');
            const addAllBtn = document.getElementById('package-products-add-all');
            const removeAllBtn = document.getElementById('package-products-remove-all');
            const availableCountEl = document.getElementById('available-products-count');
            const selectedCountEl = document.getElementById('selected-products-count');

            if (!allProductsEl || !selectedProductsEl || !availableList || !selectedList || !searchAvailableInput || !searchSelectedInput || !hiddenContainer || !addAllBtn || !removeAllBtn || !availableCountEl || !selectedCountEl) {
                return;
            }

            let allProducts = [];
            let selectedIds = [];
            let availableSearchTerm = '';
            let selectedSearchTerm = '';

            try {
                allProducts = JSON.parse(allProductsEl.textContent || '[]');
                selectedIds = (JSON.parse(selectedProductsEl.textContent || '[]') || []).map(function(v) { return Number(v); });
            } catch (e) {
                allProducts = [];
                selectedIds = [];
            }

            function escapeHtml(text) {
                return String(text)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function isSelected(id) {
                return selectedIds.indexOf(Number(id)) !== -1;
            }

            function addProduct(id) {
                id = Number(id);
                if (!isSelected(id)) {
                    selectedIds.push(id);
                    render();
                }
            }

            function removeProduct(id) {
                id = Number(id);
                selectedIds = selectedIds.filter(function(item) {
                    return Number(item) !== id;
                });
                render();
            }

            function getFilteredAvailableProducts() {
                const q = availableSearchTerm.trim().toLowerCase();
                return allProducts.filter(function(p) {
                    if (isSelected(p.id)) return false;
                    if (!q) return true;
                    return p.name.toLowerCase().includes(q) || p.slug.toLowerCase().includes(q);
                });
            }

            function renderHiddenInputs() {
                hiddenContainer.innerHTML = selectedIds.map(function(id) {
                    return '<input type="hidden" name="product_ids[]" value="' + id + '">';
                }).join('');
            }

            function renderAvailable() {
                const available = getFilteredAvailableProducts();

                if (available.length === 0) {
                    availableCountEl.textContent = '0';
                    availableList.innerHTML = '<p class="text-sm text-slate-500 px-2 py-3">No matching products.</p>';
                    return;
                }

                availableCountEl.textContent = String(available.length);
                addAllBtn.disabled = available.length === 0;
                addAllBtn.classList.toggle('opacity-50', available.length === 0);
                addAllBtn.classList.toggle('cursor-not-allowed', available.length === 0);

                availableList.innerHTML = available.map(function(p) {
                    return '' +
                        '<div class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 dark:border-slate-700 p-2">' +
                            '<div class="min-w-0">' +
                                '<p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">' + escapeHtml(p.name) + '</p>' +
                                '<p class="text-xs text-slate-500 truncate">' + escapeHtml(p.slug) + '</p>' +
                            '</div>' +
                            '<button type="button" data-add-id="' + p.id + '" class="shrink-0 inline-flex items-center gap-1 rounded-lg border border-primary text-primary px-2 py-1 text-xs font-semibold hover:bg-primary/10">' +
                                '<span class="material-symbols-outlined text-base">add</span>Add' +
                            '</button>' +
                        '</div>';
                }).join('');
            }

            function renderSelected() {
                const selected = selectedIds
                    .map(function(id) { return allProducts.find(function(p) { return Number(p.id) === Number(id); }); })
                    .filter(function(p) { return !!p; });
                const q = selectedSearchTerm.trim().toLowerCase();
                const selectedFiltered = selected.filter(function(p) {
                    if (!q) return true;
                    return p.name.toLowerCase().includes(q) || p.slug.toLowerCase().includes(q);
                });

                selectedCountEl.textContent = String(selected.length);

                if (selected.length === 0) {
                    removeAllBtn.disabled = true;
                    removeAllBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    selectedList.innerHTML = '<p class="text-sm text-slate-500 px-2 py-3">No selected products.</p>';
                    return;
                }
                removeAllBtn.disabled = false;
                removeAllBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                if (selectedFiltered.length === 0) {
                    selectedList.innerHTML = '<p class="text-sm text-slate-500 px-2 py-3">No matching selected products.</p>';
                    return;
                }

                selectedList.innerHTML = selectedFiltered.map(function(p) {
                    return '' +
                        '<div class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 dark:border-slate-700 p-2 bg-slate-50 dark:bg-slate-800/30">' +
                            '<div class="min-w-0">' +
                                '<p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">' + escapeHtml(p.name) + '</p>' +
                                '<p class="text-xs text-slate-500 truncate">' + escapeHtml(p.slug) + '</p>' +
                            '</div>' +
                            '<button type="button" data-remove-id="' + p.id + '" class="shrink-0 inline-flex items-center gap-1 rounded-lg border border-rose-300 text-rose-600 px-2 py-1 text-xs font-semibold hover:bg-rose-50">' +
                                '<span class="material-symbols-outlined text-base">remove</span>Remove' +
                            '</button>' +
                        '</div>';
                }).join('');
            }

            function render() {
                renderAvailable();
                renderSelected();
                renderHiddenInputs();
            }

            searchAvailableInput.addEventListener('input', function() {
                availableSearchTerm = searchAvailableInput.value || '';
                renderAvailable();
            });

            searchSelectedInput.addEventListener('input', function() {
                selectedSearchTerm = searchSelectedInput.value || '';
                renderSelected();
            });

            availableList.addEventListener('click', function(e) {
                const btn = e.target.closest('[data-add-id]');
                if (!btn) return;
                addProduct(btn.getAttribute('data-add-id'));
            });

            selectedList.addEventListener('click', function(e) {
                const btn = e.target.closest('[data-remove-id]');
                if (!btn) return;
                removeProduct(btn.getAttribute('data-remove-id'));
            });

            addAllBtn.addEventListener('click', function() {
                const available = getFilteredAvailableProducts();
                if (available.length === 0) return;
                const toAdd = available.map(function(p) { return Number(p.id); });
                selectedIds = selectedIds.concat(toAdd);
                render();
            });

            removeAllBtn.addEventListener('click', function() {
                if (selectedIds.length === 0) return;
                selectedIds = [];
                render();
            });

            render();
        })();
    </script>
@endpush
