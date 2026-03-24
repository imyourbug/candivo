@php
    $product = $product ?? null;
    $isEdit = $product !== null;

    $tierRows = old('pricing_tiers');
    if ($tierRows === null) {
        if ($isEdit) {
            $pricingCollection = $product->pricing->sortBy('duration_months')->values();
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

    $productImageUrls = [];
    if ($isEdit && filled($product->images)) {
        $productImageUrls = array_values(array_filter(array_map('trim', explode(',', $product->images))));
    }
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $product?->name) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-rose-500 @enderror"
                />
            @error('name')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="slug" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Slug (URL)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $product?->slug) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-rose-500 @enderror"
                placeholder="auto-generated if empty" />
            @error('slug')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="category_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Category</label>
            <select name="category_id" id="category_id"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">— None —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product?->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Status <span class="text-rose-500">*</span></label>
            <select name="status" id="status"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('status') border-rose-500 @enderror">
                <option value="draft" {{ old('status', $product?->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ old('status', $product?->status) === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $product?->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Description</label>
        <textarea name="description" id="description" rows="8"
            class="summernote w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-rose-500 @enderror">{{ old('description', $product?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="is_free" value="0" />
            <input type="checkbox" name="is_free" value="1" {{ old('is_free', $product?->is_free) ? 'checked' : '' }}
                class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary" />
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Free product</span>
        </label>
    </div>

    <div class="border-t border-slate-200 dark:border-slate-800 pt-6 space-y-6">
        <div>
            <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Media</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload an avatar and gallery images, or paste external URLs. Uploaded files are stored and their public URLs are saved.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-3">
                <span class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Avatar</span>
                @if($isEdit && filled(old('avatar', $product?->avatar)))
                    <p class="text-xs font-semibold text-slate-600 dark:text-slate-400">Saved avatar</p>
                    <div class="flex items-start gap-3">
                        <img src="{{ old('avatar', $product->avatar) }}" alt="" class="h-20 w-20 rounded-lg object-cover border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800" />
                    </div>
                @endif
                <input type="file" name="avatar_file" id="avatar_file" accept="image/*"
                    class="js-admin-avatar-file block w-full text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 @error('avatar_file') ring-2 ring-rose-500 rounded-lg @enderror" />
                @error('avatar_file')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
                <div class="hidden mt-2 space-y-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/40 p-3" data-admin-avatar-staging>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Preview (submitted when you save)</p>
                    <div class="relative inline-block shrink-0">
                        <img data-admin-avatar-staging-img src="" alt="" class="hidden h-20 w-20 rounded-lg object-cover border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800" />
                        <button type="button" data-admin-avatar-corner-clear class="absolute -right-1.5 -top-1.5 z-10 hidden h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-primary text-white shadow-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:border-slate-900" title="Remove selected image" aria-label="Remove selected image">
                            <span class="material-symbols-outlined text-lg leading-none">close</span>
                        </button>
                    </div>
                    <p data-admin-avatar-error class="text-sm text-rose-500 min-h-[1.25rem]"></p>
                </div>
                <div>
                    <label for="avatar" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Or avatar URL</label>
                    <input type="text" name="avatar" id="avatar" value="{{ old('avatar', $product?->avatar) }}"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
                </div>
            </div>
            <div>
                <label for="video" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Video URL</label>
                <input type="text" name="video" id="video" value="{{ old('video', $product?->video) }}"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
            </div>
        </div>

        <div>
            <span class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Gallery images</span>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-2">Choose multiple files; they are appended to the comma-separated list after save.</p>
            <div data-admin-gallery-field class="space-y-2">
                <input type="file" name="images_files[]" id="images_files" accept="image/*" multiple
                    class="js-admin-gallery-file block w-full text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
                @foreach ($errors->keys() as $imgErrKey)
                    @if (str_starts_with($imgErrKey, 'images_files.'))
                        <p class="text-sm text-rose-500">{{ $errors->first($imgErrKey) }}</p>
                        @break
                    @endif
                @endforeach
                <p data-admin-gallery-error class="text-sm text-rose-500 min-h-[1.25rem]"></p>
                <div data-admin-gallery-staging class="hidden flex flex-wrap gap-2"></div>
                <button type="button" data-admin-gallery-clear class="hidden text-xs font-semibold text-primary hover:underline">Clear file selection</button>
            </div>
            <div class="mt-3">
                <label for="images" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Image URLs (comma-separated)</label>
                <textarea name="images" id="images" rows="3"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary @error('images') border-rose-500 @enderror">{{ old('images', $isEdit ? ($product->images ?? '') : '') }}</textarea>
                @error('images')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            @if(count($productImageUrls) > 0)
                <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mt-3 mb-2">Current gallery</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($productImageUrls as $url)
                        <img src="{{ $url }}" alt="" class="h-16 w-16 rounded-md object-cover border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
            <div>
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Pricing (duration tiers)</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Add one row per billing period. Duplicate month values are merged (last wins).</p>
            </div>
            <button type="button" id="product-pricing-add-row"
                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-primary text-primary text-sm font-semibold hover:bg-primary/10 transition-colors shrink-0">
                <span class="material-symbols-outlined text-lg">add</span>
                Add tier
            </button>
        </div>

        @error('pricing_tiers')
            <p class="mb-3 text-sm text-rose-500">{{ $message }}</p>
        @enderror

        <div id="product-pricing-rows" class="space-y-3">
            @foreach ($tierRows as $idx => $tier)
                <div class="pricing-tier-row flex flex-col sm:flex-row sm:items-end gap-3 p-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/40">
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Period (months)</label>
                        <input type="number" data-field="duration_months" name="pricing_tiers[{{ $idx }}][duration_months]" min="0" step="1"
                            value="{{ old('pricing_tiers.' . $idx . '.duration_months', $tier['duration_months'] ?? '') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary @error('pricing_tiers.' . $idx . '.duration_months') border-rose-500 @enderror"
                            placeholder="e.g. 12" />
                        @error('pricing_tiers.' . $idx . '.duration_months')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Price</label>
                        <input type="number" data-field="price" name="pricing_tiers[{{ $idx }}][price]" min="0" step="0.01"
                            value="{{ old('pricing_tiers.' . $idx . '.price', $tier['price'] ?? '') }}"
                            class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary @error('pricing_tiers.' . $idx . '.price') border-rose-500 @enderror"
                            placeholder="0.00" />
                        @error('pricing_tiers.' . $idx . '.price')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
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

    <template id="product-pricing-row-template">
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

    @push('admin-styles')
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
        <style>
            .note-editor .note-editing-area .note-editable {
                min-height: 220px;
            }
        </style>
    @endpush

    @push('admin-scripts')
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
        <script>
            (function() {
                const container = document.getElementById('product-pricing-rows');
                const addBtn = document.getElementById('product-pricing-add-row');
                const tpl = document.getElementById('product-pricing-row-template');
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

            $(function() {
                const $form = $('#admin-product-form');
                if (!$form.length) return;

                const $name = $('#name');
                const $description = $('#description');

                if ($description.length && typeof $.fn.summernote === 'function') {
                    $description.summernote({
                        height: 220,
                        tabsize: 2
                    });
                }

                function setClientErr($field, msg) {
                    $field.toggleClass('border-rose-500', !!msg);
                    let $p = $field.siblings('.js-client-error');
                    if (!$p.length) {
                        $p = $('<p class="js-client-error text-sm text-rose-500 mt-1"></p>');
                        $field.after($p);
                    }
                    $p.text(msg || '');
                    if (!msg) {
                        $p.remove();
                    }
                }

                function validateProductName() {
                    const v = ($name.val() || '').trim();
                    if (!v) {
                        setClientErr($name, 'Name is required.');
                        return false;
                    }
                    setClientErr($name, '');
                    return true;
                }

                $name.on('input blur', function() {
                    validateProductName();
                });

                $form.on('submit', function(e) {
                    if ($description.length && typeof $.fn.summernote === 'function') {
                        $description.val($description.summernote('code'));
                    }
                    if (!validateProductName()) {
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    @endpush
</div>
