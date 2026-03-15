<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class IssueType extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'has_url',
        'sort_order',
    ];

    protected $casts = [
        'has_url' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(IssueType::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(IssueType::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get tree of issue types (root level with nested children).
     */
    public static function getTree()
    {
        return static::query()
            ->whereNull('parent_id')
            ->with('childrenRecursive')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get flat list for parent dropdown: [ ['id' => ?, 'name' => ?, 'depth' => ? ], ... ].
     * Exclude IDs (e.g. self and descendants) when editing.
     *
     * @param  array<int>  $excludeIds
     * @return \Illuminate\Support\Collection<int, array{id: int|null, name: string, depth: int}>
     */
    public static function getFlatListForSelect(array $excludeIds = []): \Illuminate\Support\Collection
    {
        $items = collect([['id' => null, 'name' => '— Root (top level) —', 'depth' => 0]]);
        $walk = function ($nodes, int $depth = 0) use (&$walk, &$items, $excludeIds) {
            foreach ($nodes as $node) {
                if (in_array($node->id, $excludeIds, true)) {
                    continue;
                }
                $items->push(['id' => $node->id, 'name' => $node->name, 'depth' => $depth]);
                $walk($node->childrenRecursive, $depth + 1);
            }
        };
        $walk(static::getTree());
        return $items;
    }

    /**
     * Get IDs of this node and all descendants.
     *
     * @return array<int>
     */
    public function getSelfAndDescendantIds(): array
    {
        $ids = [$this->id];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getSelfAndDescendantIds());
        }
        return $ids;
    }

    /**
     * Recursive children for tree.
     */
    public function childrenRecursive(): HasMany
    {
        return $this->hasMany(IssueType::class, 'parent_id')
            ->with('childrenRecursive')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    /**
     * Convert model to array for API tree (nested).
     */
    public function toTreeArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'has_url' => $this->has_url,
            'sort_order' => $this->sort_order,
            'children' => $this->children->map(fn ($child) => $child->toTreeArray())->values()->all(),
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (IssueType $model) {
            if (empty($model->slug) && ! empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function (IssueType $model) {
            if ($model->isDirty('name') && (empty($model->slug) || $model->slug === Str::slug($model->getOriginal('name')))) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
