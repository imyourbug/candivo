<?php

namespace App\Http\Controllers;

use App\Models\IssueType;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class HelpCenterController extends Controller
{
    public function index()
    {
        $issueSlugByManualName = self::issueSlugByManualNameLookup();

        $videoTutorialPackages = Package::query()
            ->orderByDesc('level')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'level']);

        $videoTutorials = Product::query()
            ->with(['packages:id'])
            ->select(['id', 'name', 'slug', 'description', 'video'])
            ->orderBy('name')
            ->get()
            ->map(function (Product $item) use ($issueSlugByManualName): array {
                $plain = trim(strip_tags((string) $item->description));
                $lookupName = self::productNameToIssueManualName($item->name);
                $issueSlug = $issueSlugByManualName[strtoupper($lookupName)] ?? null;

                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug,
                    'issue_slug' => $issueSlug,
                    'video' => $item->video,
                    'short_description' => Str::limit($plain, 120),
                    'package_ids' => $item->packages->pluck('id')->values()->all(),
                ];
            });

        return view('help-center', [
            'issue' => null,
            'videoTutorials' => $videoTutorials,
            'videoTutorialPackages' => $videoTutorialPackages,
            'allSidebarTools' => self::allSidebarToolsForNav(),
        ]);
    }

    /**
     * Issue manual title (uppercase) → first matching issue slug for help links / product mapping.
     *
     * @return array<string, string>
     */
    private static function issueSlugByManualNameLookup(): array
    {
        $map = [];
        foreach (IssueType::query()
            ->where('has_url', true)
            ->whereNotNull('parent_id')
            ->orderBy('id')
            ->cursor() as $issue) {
            $key = strtoupper($issue->name);
            if (! isset($map[$key])) {
                $map[$key] = $issue->slug;
            }
        }

        return $map;
    }

    /**
     * Uppercase package name → tier level (1, 2, 3, …) for sidebar ordering.
     *
     * @return array<string, int>
     */
    private static function packageLevelByUpperName(): array
    {
        $map = [];
        foreach (Package::query()->get(['name', 'level']) as $pkg) {
            $key = strtoupper(trim((string) $pkg->name));
            if ($key === '') {
                continue;
            }
            $level = (int) $pkg->level;
            if (! isset($map[$key]) || $level < $map[$key]) {
                $map[$key] = $level;
            }
        }

        return $map;
    }

    /**
     * All Tools sidebar: one row per product, linked by mapped IssueType slug (same rules as video tutorials).
     * Rows are ordered by minimum package level (1 → 2 → 3), then product name.
     *
     * @return \Illuminate\Support\Collection<int, object{name: string, slug: string}>
     */
    private static function allSidebarToolsForNav()
    {
        $issueSlugByManualName = self::issueSlugByManualNameLookup();

        return Product::query()
            ->with(['packages:id,level'])
            ->get(['id', 'name'])
            ->map(function (Product $product) use ($issueSlugByManualName): ?array {
                $lookupName = self::productNameToIssueManualName($product->name);
                $issueSlug = $issueSlugByManualName[strtoupper($lookupName)] ?? null;
                if ($issueSlug === null) {
                    return null;
                }
                $minLevel = $product->packages->min('level');

                return [
                    'name' => $product->name,
                    'slug' => $issueSlug,
                    'min_level' => $minLevel !== null ? (int) $minLevel : 9999,
                ];
            })
            ->filter()
            ->sortBy(fn (array $row) => [$row['min_level'], $row['name']])
            ->values()
            ->map(fn (array $row) => (object) [
                'name' => $row['name'],
                'slug' => $row['slug'],
            ]);
    }

    /**
     * Map CSV product name (Column1) to IssueType manual title when they differ.
     */
    private static function productNameToIssueManualName(string $name): string
    {
        return match (strtoupper(trim($name))) {
            'QUICK IPROPERTIES' => 'IPROPERTIES',
            'SAVE AND REPLACE COMPONENTS' => 'SAVE AND REPLACE COMPOENTS',
            default => $name,
        };
    }

    /**
     * Return issue types as nested tree for client sidebar.
     * Root groups (packages) are ordered by Package.level ascending (1, 2, 3), then sort_order, then name.
     */
    public function issueTypesTree(): JsonResponse
    {
        $levelByName = self::packageLevelByUpperName();

        $tree = IssueType::getTree()
            ->sortBy(function (IssueType $node) use ($levelByName): array {
                $key = strtoupper(trim($node->name));
                $level = $levelByName[$key] ?? 9999;

                return [$level, (int) ($node->sort_order ?? 0), $node->name];
            })
            ->values()
            ->map(fn (IssueType $node) => $node->toTreeArray());

        return response()->json($tree);
    }

    /**
     * Return JSON detail for a specific issue type by slug (AJAX).
     */
    public function issueDetail(string $slug): JsonResponse
    {
        $issue = IssueType::where('slug', $slug)->firstOrFail();

        $images = collect($issue->images ?? [])
            ->filter(fn ($path) => is_string($path) && $path !== '')
            ->map(fn (string $path) => Storage::disk('public')->url($path))
            ->values()
            ->all();

        return response()->json([
            'id' => $issue->id,
            'name' => $issue->name,
            'slug' => $issue->slug,
            'description' => $issue->description,
            'images' => $images,
            'video' => $issue->video,
        ]);
    }

    /**
     * Show detail page for a specific issue type by slug.
     */
    public function detail(string $slug)
    {
        $issue = IssueType::where('slug', $slug)->firstOrFail();

        return view('help-center', [
            'issue' => $issue,
            'allSidebarTools' => self::allSidebarToolsForNav(),
        ]);
    }

    public function sendScheduleRequestMail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'company' => ['nullable', 'string', 'max:190'],
            'datetime' => ['required', 'date'],
            'agenda' => ['nullable', 'string', 'max:2000'],
        ]);

        $recipient = (string) (config('mail.from.address') ?? '');
        if ($recipient === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Mail recipient is not configured.',
            ], 500);
        }

        try {
            $payload = [
                'full_name' => (string) ($validated['full_name'] ?? ''),
                'email' => (string) ($validated['email'] ?? ''),
                'company' => (string) ($validated['company'] ?? ''),
                'datetime' => (string) ($validated['datetime'] ?? ''),
                'agenda' => (string) ($validated['agenda'] ?? ''),
                'submitted_at' => now()->toDateTimeString(),
            ];

            Mail::send('mail.mail-schedule', $payload, function ($message) use ($payload, $recipient) {
                $name = trim($payload['full_name']) !== '' ? $payload['full_name'] : 'Unknown';
                $message
                    ->to($recipient)
                    ->replyTo($payload['email'], $name)
                    ->subject('New Schedule Meeting Request');
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Schedule request sent successfully.',
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send schedule request email', [
                'email' => $validated['email'] ?? null,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send schedule request. Please try again.',
            ], 500);
        }
    }
}
