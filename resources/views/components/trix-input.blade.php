@props(['id', 'name', 'value' => ''])

<input
    type="hidden"
    name="{{ $name }}"
    id="{{ $id }}_input"
    value="{{ $value }}"
/>

<trix-toolbar
    class="trix-toolbar border border-b-0 border-slate-200 dark:border-slate-600 rounded-t-lg bg-slate-50 dark:bg-slate-800 [&_.trix-button]:bg-white dark:[&_.trix-button]:bg-slate-700 [&_.trix-button.trix-active]:bg-slate-200 dark:[&_.trix-button.trix-active]:bg-slate-600"
    id="{{ $id }}_toolbar"
></trix-toolbar>

<trix-editor
    id="{{ $id }}"
    toolbar="{{ $id }}_toolbar"
    input="{{ $id }}_input"
    {{ $attributes->merge(['class' => 'trix-content min-h-[220px] border border-slate-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 shadow-sm focus:ring-2 focus:ring-primary focus:border-primary dark:[&_pre]:!bg-slate-800 dark:[&_pre]:rounded dark:[&_pre]:!text-white']) }}
></trix-editor>
