<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssueType;
use App\Services\AdminImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IssueTypeController extends Controller
{
    public function index(Request $request): View
    {
        $query = IssueType::query()->with('parent')->withCount('children');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $tree = IssueType::getTree();
        $total = IssueType::count();
        $roots = IssueType::whereNull('parent_id')->count();

        return view('admin.issue-type.list', compact('tree', 'total', 'roots'));
    }

    public function create(): View
    {
        $parentOptions = IssueType::getFlatListForSelect();

        return view('admin.issue-type.create', compact('parentOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'exists:issue_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video' => ['nullable', 'string', 'max:2048'],
            'has_url' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'existing_images' => ['nullable', 'array'],
            'existing_images.*' => ['nullable', 'string'],
            'images_files' => ['nullable', 'array'],
            'images_files.*' => AdminImageUploadService::adminGalleryItemRules(),
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['has_url'] = ! empty($request->input('has_url'));
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['video'] = isset($validated['video']) && $validated['video'] !== ''
            ? $validated['video']
            : null;

        $validated['images'] = $this->collectIssueImages($request, $validated['existing_images'] ?? []);
        unset($validated['existing_images'], $validated['images_files']);

        IssueType::create($validated);

        return redirect()->route('admin.issue-types.index')
            ->with('success', 'Issue type created successfully.');
    }

    public function edit(IssueType $issueType): View
    {
        $excludeIds = $issueType->getSelfAndDescendantIds();
        $parentOptions = IssueType::getFlatListForSelect($excludeIds);

        return view('admin.issue-type.edit', compact('issueType', 'parentOptions'));
    }

    public function update(Request $request, IssueType $issueType): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'exists:issue_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video' => ['nullable', 'string', 'max:2048'],
            'has_url' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'existing_images' => ['nullable', 'array'],
            'existing_images.*' => ['nullable', 'string'],
            'images_files' => ['nullable', 'array'],
            'images_files.*' => AdminImageUploadService::adminGalleryItemRules(),
        ]);

        $validated['has_url'] = ! empty($request->input('has_url'));
        $validated['video'] = isset($validated['video']) && $validated['video'] !== ''
            ? $validated['video']
            : null;

        $validated['images'] = $this->collectIssueImages($request, $validated['existing_images'] ?? ($issueType->images ?? []));
        unset($validated['existing_images'], $validated['images_files']);

        if ($validated['parent_id'] == $issueType->id) {
            return back()->withErrors(['parent_id' => 'An issue type cannot be its own parent.']);
        }
        if ($validated['parent_id'] && $this->isDescendant($issueType->id, $validated['parent_id'])) {
            return back()->withErrors(['parent_id' => 'Cannot set a descendant as parent.']);
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $issueType->update($validated);

        return redirect()->route('admin.issue-types.index')
            ->with('success', 'Issue type updated successfully.');
    }

    public function destroy(IssueType $issueType): RedirectResponse
    {
        if ($issueType->children()->exists()) {
            return redirect()->route('admin.issue-types.index')
                ->with('error', 'Cannot delete: this issue type has children. Remove or reassign them first.');
        }
        $issueType->delete();

        return redirect()->route('admin.issue-types.index')
            ->with('success', 'Issue type deleted successfully.');
    }

    /**
     * @param  array<int, string>  $existing
     * @return array<int, string>
     */
    private function collectIssueImages(Request $request, array $existing): array
    {
        $kept = array_values(array_filter(array_map('strval', $existing), fn (string $v) => $v !== ''));

        $uploaded = [];
        foreach ($request->file('images_files', []) ?: [] as $file) {
            if ($file && $file->isValid()) {
                $uploaded[] = $file->store('issue-types/images', 'public');
            }
        }

        return array_values(array_unique(array_merge($kept, $uploaded)));
    }

    private function isDescendant(int $ancestorId, int $possibleDescendantId): bool
    {
        $current = IssueType::find($possibleDescendantId);
        while ($current && $current->parent_id) {
            if ((int) $current->parent_id === $ancestorId) {
                return true;
            }
            $current = $current->parent;
        }

        return false;
    }
}
