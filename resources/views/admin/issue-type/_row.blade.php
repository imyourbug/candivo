@php
    $node = $node ?? null;
    $depth = $depth ?? 0;
    if (!$node) return;
@endphp
<tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
    <td class="px-6 py-4">
        <div class="flex items-center gap-2" style="padding-left: {{ $depth * 20 }}px;">
            @if($depth > 0)
                <span class="text-slate-300 dark:text-slate-600">└</span>
            @endif
            <div class="h-8 w-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-lg">{{ $node->childrenRecursive->isEmpty() ? 'label' : 'folder' }}</span>
            </div>
            <div>
                <p class="font-semibold text-slate-900 dark:text-white">{{ $node->name }}</p>
                @if($node->description)
                    <p class="text-xs text-slate-500 line-clamp-1">{{ Str::limit($node->description, 60) }}</p>
                @endif
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <span class="text-slate-600 dark:text-slate-400 text-sm">{{ $node->slug ?: '—' }}</span>
    </td>
    <td class="px-6 py-4 text-right font-medium text-slate-600 dark:text-slate-400">{{ $node->sort_order }}</td>
    <td class="px-6 py-4 text-right">
        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.issue-types.edit', $node) }}" class="p-1.5 text-slate-400 hover:text-primary transition-colors" title="Edit">
                <span class="material-symbols-outlined text-xl">edit</span>
            </a>
            <form action="{{ route('admin.issue-types.destroy', $node) }}" method="post" class="inline" onsubmit="return confirm('Delete this issue type?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 transition-colors" title="Delete" @if($node->childrenRecursive->isNotEmpty()) disabled title="Remove children first" @endif>
                    <span class="material-symbols-outlined text-xl">delete</span>
                </button>
            </form>
        </div>
    </td>
</tr>
@foreach($node->childrenRecursive as $child)
    @include('admin.issue-type._row', ['node' => $child, 'depth' => $depth + 1])
@endforeach
