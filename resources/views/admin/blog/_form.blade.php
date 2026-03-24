@php
    $post = $post ?? null;
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label for="title" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Title <span class="text-rose-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title', $post?->title) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-rose-500 @enderror"
                />
            @error('title')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="slug" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Slug (URL)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $post?->slug) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-rose-500 @enderror"
                placeholder="auto-generated if empty" />
            @error('slug')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Status <span class="text-rose-500">*</span></label>
            <select name="status" id="status"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary @error('status') border-rose-500 @enderror">
                <option value="draft" {{ old('status', $post?->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $post?->status) === 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ old('status', $post?->status) === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="order" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Home column order</label>
            <input type="number" name="order" id="order" min="0" step="1"
                value="{{ old('order', $post?->order ?? 0) }}"
                class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('order') border-rose-500 @enderror"
                placeholder="0" />
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Lower numbers appear first. First 6 published posts are shown on the home page (3 + 3).</p>
            @error('order')
                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="avatar" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Home card image</label>
        <p class="mb-2 text-xs text-slate-500 dark:text-slate-400">Shown on the home page blog cards. If empty, the first image in the content is used.</p>
        @if (!empty($post?->avatar))
            <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">Saved image</p>
            <div class="mb-3 flex items-center gap-4">
                <img src="{{ $post->avatar_url }}" alt="" class="h-20 w-32 rounded-lg border border-slate-200 object-cover dark:border-slate-700" width="128" height="80" />
            </div>
        @endif
        <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp,image/gif,image/avif"
            data-max-kilobytes="{{ \App\Services\AdminImageUploadService::POST_AVATAR_MAX_KILOBYTES }}"
            class="js-admin-avatar-file js-admin-post-avatar-file block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-primary/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary hover:file:bg-primary/20 dark:text-slate-300 dark:file:bg-slate-800 dark:file:text-primary" />
        @error('avatar')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
        <div class="hidden mt-2 space-y-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/40 p-3" data-admin-avatar-staging>
            <p class="text-xs text-slate-500 dark:text-slate-400">Preview (submitted when you save)</p>
            <div class="relative inline-block shrink-0">
                <img data-admin-avatar-staging-img src="" alt="" class="hidden h-20 w-32 rounded-lg object-cover border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800" width="128" height="80" />
                <button type="button" data-admin-avatar-corner-clear class="absolute -right-1.5 -top-1.5 z-10 hidden h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-primary text-white shadow-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:border-slate-900" title="Remove selected image" aria-label="Remove selected image">
                    <span class="material-symbols-outlined text-lg leading-none">close</span>
                </button>
            </div>
            <p data-admin-avatar-error class="text-sm text-rose-500 min-h-[1.25rem]"></p>
        </div>
    </div>

    <div>
        <label for="excerpt" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Excerpt</label>
        <input type="text" name="excerpt" id="excerpt" value="{{ old('excerpt', $post?->excerpt) }}"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary"
            placeholder="Short summary for listings" />
        @error('excerpt')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Content</label>
        <textarea name="content" id="content" rows="12"
            class="summernote w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('content') border-rose-500 @enderror">{{ old('content', $post?->content) }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>
</div>
