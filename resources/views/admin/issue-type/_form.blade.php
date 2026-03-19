@php
    $issueType = $issueType ?? null;
    $isEdit = $issueType !== null;
@endphp

<div class="space-y-6">
    <div>
        <label for="parent_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Parent</label>
        <select name="parent_id" id="parent_id"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('parent_id') border-rose-500 @enderror">
            @foreach($parentOptions as $opt)
                <option value="{{ $opt['id'] ?? '' }}" {{ old('parent_id', $issueType?->parent_id) == $opt['id'] ? 'selected' : '' }}>
                    {{ str_repeat(' ', $opt['depth'] ?? 0) }}{{ $opt['name'] }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $issueType?->name) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-rose-500 @enderror"
                />
            @error('name')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="slug" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $issueType?->slug) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-rose-500 @enderror"
                placeholder="auto from name" />
            @error('slug')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center gap-4">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="has_url" value="0" />
            <input type="checkbox" name="has_url" value="1" id="has_url" {{ old('has_url', $issueType?->has_url) ? 'checked' : '' }}
                class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary" />
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Has URL (wrap label as link in sidebar)</span>
        </label>
    </div>
    @error('has_url')
        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
    @enderror

    <div>
        <label for="sort_order" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Sort order</label>
        <input type="number" name="sort_order" id="sort_order" min="0" value="{{ old('sort_order', $issueType?->sort_order ?? 0) }}"
            class="w-full max-w-[140px] px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('sort_order') border-rose-500 @enderror" />
        @error('sort_order')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="issue-type-description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Description</label>
        <textarea name="description" id="issue-type-description" rows="6"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-rose-500 @enderror">{{ old('description', $issueType?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>
</div>

@push('admin-scripts')
    <script>
        $(function() {
            const $form = $('#issue-type-form');
            if (!$form.length) return;

            const $name = $('#name');

            function setIssueErr($field, msg) {
                $field.toggleClass('border-rose-500', !!msg);
                let $p = $field.siblings('.js-issue-client-error');
                if (!$p.length) {
                    $p = $('<p class="js-issue-client-error text-sm text-rose-500 mt-1"></p>');
                    $field.after($p);
                }
                $p.text(msg || '');
                if (!msg) { $p.remove(); }
            }

            function validateIssueName() {
                const v = ($name.val() || '').trim();
                if (!v) {
                    setIssueErr($name, 'Name is required.');
                    return false;
                }
                setIssueErr($name, '');
                return true;
            }

            $name.on('input blur', function() { validateIssueName(); });

            $form.on('submit', function(e) {
                const $desc = $('#issue-type-description');
                if ($desc.length && typeof $.fn.summernote === 'function') {
                    $desc.val($desc.summernote('code'));
                }
                if (!validateIssueName()) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endpush
