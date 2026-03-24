@php
    $issueType = $issueType ?? null;
    $isEdit = $issueType !== null;
    $issueImagePaths = old('existing_images', $isEdit ? ($issueType->images ?? []) : []);
    if (! is_array($issueImagePaths)) {
        $issueImagePaths = [];
    }
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

    <div>
        <label for="video" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Video (embed URL)</label>
        <input type="url" name="video" id="video" value="{{ old('video', $issueType?->video) }}"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('video') border-rose-500 @enderror"
            placeholder="https://www.youtube.com/embed/..." />
        <p class="mt-1 text-xs text-slate-500">YouTube embed or other iframe-safe URL; leave empty if none.</p>
        @error('video')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
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

    <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Issue images</label>
        <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Upload multiple images for this issue type. New uploads are appended.</p>

        @if(count($issueImagePaths) > 0)
            <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">Current images</p>
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($issueImagePaths as $path)
                    @php $path = (string) $path; @endphp
                    @if($path !== '')
                        <input type="hidden" name="existing_images[]" value="{{ $path }}" />
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($path) }}" alt="" class="h-16 w-16 rounded-md object-cover border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800" />
                    @endif
                @endforeach
            </div>
        @endif

        <div data-admin-gallery-field class="space-y-2">
            <input type="file" name="images_files[]" id="issue_images_files" accept="image/*" multiple
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
