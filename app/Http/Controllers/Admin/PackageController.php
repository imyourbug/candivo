<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Pricing;
use App\Models\Product;
use App\Models\Type;
use App\Services\AdminImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Package::query()->with(['type'])->withCount(['products', 'pricing']);

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%")
                    ->orWhere('package_id', 'like', "%{$term}%");
            });
        }

        if ($request->filled('type_code')) {
            $query->where('type_code', $request->type_code);
        }

        $packages = $query->latest()->paginate(15)->withQueryString();
        $types = Type::query()->orderBy('name')->get();

        return view('admin.package.list', compact('packages', 'types'));
    }

    public function create(): View
    {
        $types = Type::query()->orderBy('name')->get();
        $products = Product::query()->orderBy('name')->get();

        return view('admin.package.create', compact('types', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePackage($request);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        if (empty($validated['package_id'])) {
            $validated['package_id'] = $this->generatePackageId($validated['name'], $validated['slug']);
        }

        $pricingTiers = $validated['pricing_tiers'] ?? [];
        $productIds = $validated['product_ids'] ?? [];
        unset($validated['pricing_tiers'], $validated['product_ids']);

        $this->applyPackageUploadedMedia($request, $validated);

        $package = Package::create($validated);
        $package->products()->sync($productIds);
        $this->syncPackagePricing($package, $pricingTiers);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    public function edit(Package $package): View
    {
        $package->load(['pricing', 'products']);
        $types = Type::query()->orderBy('name')->get();
        $products = Product::query()->orderBy('name')->get();

        return view('admin.package.edit', compact('package', 'types', 'products'));
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $this->validatePackage($request, $package);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        if (empty($validated['package_id'])) {
            $validated['package_id'] = $this->generatePackageId($validated['name'], $validated['slug']);
        }

        $pricingTiers = $validated['pricing_tiers'] ?? [];
        $productIds = $validated['product_ids'] ?? [];
        unset($validated['pricing_tiers'], $validated['product_ids']);

        $this->applyPackageUploadedMedia($request, $validated);

        $package->update($validated);
        $package->products()->sync($productIds);
        $this->syncPackagePricing($package, $pricingTiers);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->pricing()->delete();
        $package->products()->detach();
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    private function validatePackage(Request $request, ?Package $package = null): array
    {
        $slugRule = ['nullable', 'string', 'max:255'];
        if ($package) {
            $slugRule[] = 'unique:packages,slug,'.$package->id;
        } else {
            $slugRule[] = 'unique:packages,slug';
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => $slugRule,
            'package_id' => ['nullable', 'string', 'max:100'],
            'type_code' => ['nullable', 'exists:types,code'],
            'level' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'avatar' => ['nullable', 'string'],
            'avatar_file' => AdminImageUploadService::adminAvatarFileRules(),
            'video' => ['nullable', 'string'],
            'images' => ['nullable', 'string'],
            'images_files' => ['nullable', 'array'],
            'images_files.*' => AdminImageUploadService::adminGalleryItemRules(),
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'exists:products,id'],
            'pricing_tiers' => ['nullable', 'array'],
            'pricing_tiers.*.duration_months' => ['nullable', 'integer', 'min:0'],
            'pricing_tiers.*.price' => ['nullable', 'numeric', 'min:0'],
            'pricing_tiers.*.currency' => ['nullable', 'string', 'max:10'],
        ], [
            'name.required' => 'Package name is required.',
            'slug.unique' => 'This URL slug is already in use.',
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function applyPackageUploadedMedia(Request $request, array &$data): void
    {
        unset($data['avatar_file'], $data['images_files']);

        $disk = Storage::disk('public');

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('packages/avatars', 'public');
            $data['avatar'] = $disk->url($path);
        }

        $uploadedUrls = [];
        foreach ($request->file('images_files', []) ?: [] as $file) {
            if ($file && $file->isValid()) {
                $uploadedUrls[] = $disk->url($file->store('packages/gallery', 'public'));
            }
        }

        $existing = array_filter(array_map('trim', explode(',', (string) ($data['images'] ?? ''))));
        $data['images'] = implode(',', array_values(array_unique(array_merge($existing, $uploadedUrls))));
    }

    /**
     * @param  array<int, array<string, mixed>>|null  $tiers
     */
    private function syncPackagePricing(Package $package, ?array $tiers): void
    {
        $package->pricing()->delete();

        $rows = [];
        foreach ($tiers ?? [] as $row) {
            $months = isset($row['duration_months']) && $row['duration_months'] !== '' && $row['duration_months'] !== null
                ? (int) $row['duration_months']
                : null;
            $priceRaw = $row['price'] ?? null;
            $price = $priceRaw !== null && $priceRaw !== '' ? (float) $priceRaw : null;
            $currency = isset($row['currency']) && is_string($row['currency']) && $row['currency'] !== ''
                ? $row['currency']
                : 'EUR';

            if ($months === null || $months < 0) {
                continue;
            }
            if ($price === null || $price < 0) {
                continue;
            }

            $rows[$months] = [
                'duration_months' => $months,
                'price' => $price,
                'currency' => $currency,
            ];
        }

        $sorted = array_values($rows);
        usort($sorted, fn ($a, $b) => $a['duration_months'] <=> $b['duration_months']);

        foreach ($sorted as $r) {
            Pricing::create([
                'entity_id' => $package->id,
                'entity_type' => 'package',
                'duration_months' => $r['duration_months'],
                'price' => $r['price'],
                'currency' => $r['currency'],
            ]);
        }
    }

    private function generatePackageId(string $name, string $slug): string
    {
        $nameUpper = strtoupper(Str::slug($name, '_'));
        $nameUpper = $nameUpper !== '' ? $nameUpper : 'PACKAGE';
        $slugPart = $slug !== '' ? $slug : Str::slug($name);

        return "PKG-{$nameUpper}-{$slugPart}";
    }
}
