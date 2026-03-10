@php
    $product = $product ?? null;
    $isEdit = $product !== null;
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $product?->name) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-rose-500 @enderror"
                required />
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
            <select name="status" id="status" required
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
        <textarea name="description" id="description" rows="4"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-rose-500 @enderror">{{ old('description', $product?->description) }}</textarea>
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

    <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-4">Pricing (duration tiers)</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label for="duration_1" class="block text-xs font-semibold text-slate-600 dark:text-slate-400">Duration 1 (months)</label>
                <input type="number" name="duration_1" id="duration_1" min="0" value="{{ old('duration_1', $product?->duration_1) }}"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
            </div>
            <div class="space-y-2">
                <label for="price_duration_1" class="block text-xs font-semibold text-slate-600 dark:text-slate-400">Price 1</label>
                <input type="number" name="price_duration_1" id="price_duration_1" min="0" step="0.01" value="{{ old('price_duration_1', $product?->price_duration_1) }}"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
            </div>
            <div></div>
            <div class="space-y-2">
                <label for="duration_2" class="block text-xs font-semibold text-slate-600 dark:text-slate-400">Duration 2 (months)</label>
                <input type="number" name="duration_2" id="duration_2" min="0" value="{{ old('duration_2', $product?->duration_2) }}"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
            </div>
            <div class="space-y-2">
                <label for="price_duration_2" class="block text-xs font-semibold text-slate-600 dark:text-slate-400">Price 2</label>
                <input type="number" name="price_duration_2" id="price_duration_2" min="0" step="0.01" value="{{ old('price_duration_2', $product?->price_duration_2) }}"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
            </div>
            <div></div>
            <div class="space-y-2">
                <label for="duration_3" class="block text-xs font-semibold text-slate-600 dark:text-slate-400">Duration 3 (months)</label>
                <input type="number" name="duration_3" id="duration_3" min="0" value="{{ old('duration_3', $product?->duration_3) }}"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
            </div>
            <div class="space-y-2">
                <label for="price_duration_3" class="block text-xs font-semibold text-slate-600 dark:text-slate-400">Price 3</label>
                <input type="number" name="price_duration_3" id="price_duration_3" min="0" step="0.01" value="{{ old('price_duration_3', $product?->price_duration_3) }}"
                    class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="avatar" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Avatar URL</label>
            <input type="text" name="avatar" id="avatar" value="{{ old('avatar', $product?->avatar) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
        </div>
        <div>
            <label for="video" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Video URL</label>
            <input type="text" name="video" id="video" value="{{ old('video', $product?->video) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary" />
        </div>
    </div>
</div>
