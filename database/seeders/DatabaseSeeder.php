<?php

namespace Database\Seeders;

use App\Constants\GlobalConstant;
use App\Models\Category;
use App\Models\IssueType;
use App\Models\Package;
use App\Models\Post;
use App\Models\Pricing;
use App\Models\Product;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $this->seedHomeBlogPosts($admin);

        // Create types
        $coreFreeType = Type::create(['name' => GlobalConstant::TYPE_CORE_FREE, 'code' => GlobalConstant::TYPE_CORE_FREE]);
        $packageType = Type::create(['name' => GlobalConstant::TYPE_PACKAGE, 'code' => GlobalConstant::TYPE_PACKAGE]);
        $standAloneType = Type::create(['name' => GlobalConstant::TYPE_STAND_ALONE, 'code' => GlobalConstant::TYPE_STAND_ALONE]);

        // create products and packages from CSV data
        $csvPath = public_path('Di-Tools.csv');
        if (! file_exists($csvPath)) {
            throw new RuntimeException('CSV file not found at: '.$csvPath);
        }

        $rows = array_map('str_getcsv', file($csvPath));
        $headerIndex = null;
        foreach ($rows as $idx => $row) {
            if (isset($row[0]) && strtoupper(trim($row[0])) === 'ID') {
                $headerIndex = $idx;
                break;
            }
        }
        if ($headerIndex === null) {
            throw new RuntimeException('CSV header row not found (expected ID column).');
        }

        $header = $rows[$headerIndex];
        $columns = array_flip($header);
        $dataRows = array_slice($rows, $headerIndex + 1);

        $toBool = function (?string $value): int {
            $value = strtoupper(trim((string) $value));

            return $value === 'TRUE' ? 1 : 0;
        };

        $toPrice = function (?string $value): float {
            $clean = preg_replace('/[^\d.\-]/', '', (string) $value);

            return $clean === '' ? 0.0 : (float) $clean;
        };

        $productRecords = [];
        $packageRecords = [];
        $usedProductSlugs = [];
        foreach ($dataRows as $row) {
            $name = trim($row[$columns['Column1']] ?? '');
            if ($name === '') {
                continue;
            }

            $baseProductSlug = Str::slug($name);
            $baseProductSlug = $baseProductSlug !== '' ? $baseProductSlug : 'product';
            $productSlug = $baseProductSlug;
            $productSuffix = 2;
            while (in_array($productSlug, $usedProductSlugs, true)) {
                $productSlug = $baseProductSlug.'-'.$productSuffix;
                $productSuffix++;
            }
            $usedProductSlugs[] = $productSlug;

            $parseDuration = function (?string $v): ?int {
                $v = trim((string) $v);

                return $v === '' ? null : (int) $v;
            };
            $parsePriceDuration = function (?string $v) use ($toPrice): ?float {
                $v = trim((string) $v);
                if ($v === '') {
                    return null;
                }

                return $toPrice($v) ?: null;
            };

            $duration1 = isset($columns['Duration 1']) ? $parseDuration($row[$columns['Duration 1']] ?? '') : null;
            $priceDuration1 = isset($columns['Price duration 1']) ? $parsePriceDuration($row[$columns['Price duration 1']] ?? '') : null;
            $duration2 = isset($columns['Duration 2']) ? $parseDuration($row[$columns['Duration 2']] ?? '') : null;
            $priceDuration2 = isset($columns['Price duration 2']) ? $parsePriceDuration($row[$columns['Price duration 2']] ?? '') : null;
            $duration3 = isset($columns['Duration 3']) ? $parseDuration($row[$columns['Duration 3']] ?? '') : null;
            $priceDuration3 = isset($columns['Price duration 3']) ? $parsePriceDuration($row[$columns['Price duration 3']] ?? '') : null;

            $isToolRaw = trim((string) ($row[$columns['IsTool']] ?? '1'));
            $isTool = $isToolRaw === '1';

            if ($isTool) {
                // Product (tool) row
                $categoryName = trim($row[$columns['Category']] ?? '');
                $category = null;
                if ($categoryName !== '') {
                    $category = Category::firstOrCreate(['name' => $categoryName]);
                }

                $isBasic = $toBool($row[$columns['Basic']] ?? '');
                $isProfessional = $toBool($row[$columns['Professional']] ?? '');
                $isPremium = $toBool($row[$columns['Premium']] ?? '');

                $productIdCode = 'PRD-'.strtoupper(Str::slug($name, '_')).'-'.$productSlug;
                $isFreeRaw = trim((string) ($row[$columns['IsFree']] ?? ''));
                $isFree = $isFreeRaw === '1' ? 1 : 0;

                // For free products, use 0 when price is empty
                if ($isFree && $priceDuration1 === null && $duration1 !== null) {
                    $priceDuration1 = 0.0;
                }
                if ($isFree && $priceDuration2 === null && $duration2 !== null) {
                    $priceDuration2 = 0.0;
                }
                if ($isFree && $priceDuration3 === null && $duration3 !== null) {
                    $priceDuration3 = 0.0;
                }

                $product = Product::create([
                    'product_id' => $productIdCode,
                    'category_id' => $category?->id,
                    'name' => $name,
                    'slug' => $productSlug,
                    'description' => trim($row[$columns['Description']] ?? '') ?: null,
                    'status' => 'active',
                    'value_status' => trim($row[$columns['Value status']] ?? ''),
                    'is_basic' => $isBasic ? GlobalConstant::IS_BASIC : GlobalConstant::IS_NOT_BASIC,
                    'is_professional' => $isProfessional ? GlobalConstant::IS_PROFESSIONAL : GlobalConstant::IS_NOT_PROFESSIONAL,
                    'is_premium' => $isPremium ? GlobalConstant::IS_PREMIUM : GlobalConstant::IS_NOT_PREMIUM,
                    'is_free' => $isFree,
                    'duration_1' => $duration1,
                    'price_duration_1' => $priceDuration1,
                    'duration_2' => $duration2,
                    'price_duration_2' => $priceDuration2,
                    'duration_3' => $duration3,
                    'price_duration_3' => $priceDuration3,
                    'cat_set' => trim($row[$columns['CAT set']] ?? '') ?: null,
                    'stand_set' => trim($row[$columns['Stand Set']] ?? '') ?: null,
                    'avatar' => trim($row[$columns['Avatar']] ?? '') ?: 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                    'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
                    'images' => implode(',', [
                        'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                        'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                    ]),
                ]);

                $productRecords[] = [
                    'model' => $product,
                    'price' => $toPrice($row[$columns['Value']] ?? ''),
                    'is_basic' => $isBasic,
                    'is_professional' => $isProfessional,
                    'is_premium' => $isPremium,
                    'is_core_free' => ($row[$columns['Value status']] ?? '') === 'Core-Free',
                    'duration_1' => $duration1,
                    'price_duration_1' => $priceDuration1,
                    'duration_2' => $duration2,
                    'price_duration_2' => $priceDuration2,
                    'duration_3' => $duration3,
                    'price_duration_3' => $priceDuration3,
                    'category' => trim($row[$columns['Category']] ?? ''),
                ];
            } else {
                // Package row (IsTool = 0)
                $packageIdCode = 'PKG-'.strtoupper(Str::slug($name, '_')).'-'.$productSlug;
                // dd($row[$columns['Avatar']], $row[$columns['Type']]);

                $package = Package::create([
                    'package_id' => $packageIdCode,
                    'name' => $name,
                    'slug' => $productSlug,
                    'level' => (int) trim($row[$columns['Level']] ?? 1),
                    'description' => trim($row[$columns['Description']] ?? '') ?: null,
                    'avatar' => trim($row[$columns['Avatar']] ?? '') ?: 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                    'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
                    'images' => implode(',', [
                        trim($row[$columns['Avatar']] ?? ''),
                    ]),
                    'type_code' => trim($row[$columns['Type']] ?? '') ?: null,
                ]);

                $packageRecords[] = [
                    'model' => $package,
                    'duration_1' => $duration1,
                    'price_duration_1' => $priceDuration1,
                    'duration_2' => $duration2,
                    'price_duration_2' => $priceDuration2,
                    'duration_3' => $duration3,
                    'price_duration_3' => $priceDuration3,
                ];
            }
        }

        // Add pricing for all products from price modeling (Duration 1–3 / Price duration 1–3)
        foreach ($productRecords as $record) {
            $product = $record['model'];
            $durations = [
                ['duration' => $record['duration_1'] ?? null, 'price' => $record['price_duration_1'] ?? null],
                ['duration' => $record['duration_2'] ?? null, 'price' => $record['price_duration_2'] ?? null],
                ['duration' => $record['duration_3'] ?? null, 'price' => $record['price_duration_3'] ?? null],
            ];
            foreach ($durations as $d) {
                if ($d['duration'] !== null && $d['price'] !== null) {
                    Pricing::create([
                        'entity_id' => $product->id,
                        'entity_type' => 'product',
                        'duration_months' => $d['duration'],
                        'price' => (float) $d['price'],
                        'currency' => 'EUR',
                    ]);
                }
            }
        }

        // Map tools to Basic / Expert / Premium Service Layer packages, based on CSV flags
        $basicProducts = [];
        $expertProducts = [];
        $premiumLayerProducts = [];
        $fileManagerProducts = [];
        $drawingExportProducts = [];
        $iPropertyQuantityProducts = [];
        $advancedToolsProducts = [];
        $assemblyModelingProducts = [];
        $revisionAndReplaceProducts = [];
        $pdfPublishingSetProducts = [];
        $productionDrawingSetProducts = [];
        $propertyEssentialsSetProducts = [];

        foreach ($productRecords as $record) {
            if ($record['is_basic']) {
                $basicProducts[] = $record['model']->id;
            }
            if ($record['is_professional']) {
                $expertProducts[] = $record['model']->id;
            }
            if ($record['is_premium']) {
                $premiumLayerProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'File Management')) {
                $fileManagerProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'Drawing & Export')) {
                $drawingExportProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'iProperty & Quantity')) {
                $iPropertyQuantityProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'Advanced Tools')) {
                $advancedToolsProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'Assembly & Modeling')) {
                $assemblyModelingProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'Revision & Replace Set')) {
                $revisionAndReplaceProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'PDF Publishing Set')) {
                $pdfPublishingSetProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'Production Drawing Set')) {
                $productionDrawingSetProducts[] = $record['model']->id;
            }
            if (str_contains($record['category'], 'Property Essentials Set')) {
                $propertyEssentialsSetProducts[] = $record['model']->id;
            }
        }

        // Find the corresponding packages created from CSV (IsTool = 0 rows)
        $basicPkg = Package::where('slug', 'basic')->first();
        $expertPkg = Package::where('slug', 'expert')->first();
        $premiumLayerPkg = Package::where('slug', 'premium-service-layer')->first();
        $fileManagerPkg = Package::where('slug', 'file-management')->first();
        $drawingExportPkg = Package::where('slug', 'drawing-export')->first();
        $iPropertyQuantityPkg = Package::where('slug', 'iproperty-quantity')->first();
        $advancedToolsPkg = Package::where('slug', 'advanced-tools')->first();
        $assemblyModelingPkg = Package::where('slug', 'assembly-modeling')->first();
        $revisionAndReplacePkg = Package::where('slug', 'revision-replace-set')->first();
        $pdfPublishingSetPkg = Package::where('slug', 'pdf-publishing-set')->first();
        $productionDrawingSetPkg = Package::where('slug', 'production-drawing-set')->first();
        $propertyEssentialsSetPkg = Package::where('slug', 'property-essentials-set')->first();

        if ($basicPkg && ! empty($basicProducts)) {
            $basicPkg->products()->attach($basicProducts);
        }
        if ($expertPkg && ! empty($expertProducts)) {
            $expertPkg->products()->attach($expertProducts);
        }
        if ($premiumLayerPkg && ! empty($premiumLayerProducts)) {
            $premiumLayerPkg->products()->attach($premiumLayerProducts);
        }
        if ($fileManagerPkg && ! empty($fileManagerProducts)) {
            $fileManagerPkg->products()->attach($fileManagerProducts);
        }
        if ($drawingExportPkg && ! empty($drawingExportProducts)) {
            $drawingExportPkg->products()->attach($drawingExportProducts);
        }
        if ($iPropertyQuantityPkg && ! empty($iPropertyQuantityProducts)) {
            $iPropertyQuantityPkg->products()->attach($iPropertyQuantityProducts);
        }
        if ($advancedToolsPkg && ! empty($advancedToolsProducts)) {
            $advancedToolsPkg->products()->attach($advancedToolsProducts);
        }
        if ($assemblyModelingPkg && ! empty($assemblyModelingProducts)) {
            $assemblyModelingPkg->products()->attach($assemblyModelingProducts);
        }
        if ($revisionAndReplacePkg && ! empty($revisionAndReplaceProducts)) {
            $revisionAndReplacePkg->products()->attach($revisionAndReplaceProducts);
        }
        if ($pdfPublishingSetPkg && ! empty($pdfPublishingSetProducts)) {
            $pdfPublishingSetPkg->products()->attach($pdfPublishingSetProducts);
        }
        if ($productionDrawingSetPkg && ! empty($productionDrawingSetProducts)) {
            $productionDrawingSetPkg->products()->attach($productionDrawingSetProducts);
        }
        if ($propertyEssentialsSetPkg && ! empty($propertyEssentialsSetProducts)) {
            $propertyEssentialsSetPkg->products()->attach($propertyEssentialsSetProducts);
        }

        // Add pricing for all packages from price modeling (Duration 1–3 / Price duration 1–3)
        foreach ($packageRecords as $record) {
            $package = $record['model'];
            $durations = [
                ['duration' => $record['duration_1'] ?? null, 'price' => $record['price_duration_1'] ?? null],
                ['duration' => $record['duration_2'] ?? null, 'price' => $record['price_duration_2'] ?? null],
                ['duration' => $record['duration_3'] ?? null, 'price' => $record['price_duration_3'] ?? null],
            ];
            foreach ($durations as $d) {
                if ($d['duration'] !== null && $d['price'] !== null) {
                    Pricing::create([
                        'entity_id' => $package->id,
                        'entity_type' => 'package',
                        'duration_months' => $d['duration'],
                        'price' => (float) $d['price'],
                        'currency' => 'EUR',
                    ]);
                }
            }
        }

        // Create the Core Free package and attach all Core-Free products
        $coreFreePkg = Package::create([
            'package_id' => 'PKG-'.strtoupper(Str::slug('Core Free', '_')).'-core-free',
            'name' => 'Core Free',
            'slug' => 'core-free',
            'level' => 1,
            'description' => 'Essential tools for Core Free Inventor operations.',
            'avatar' => '/images/package/core-free.png',
            'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
            'images' => implode(',', [
                '/images/package/core-free.png',
            ]),
            'type_code' => $coreFreeType->code,
        ]);

        $coreFreeProducts = [];
        foreach ($productRecords as $record) {
            if ($record['is_core_free']) {
                $coreFreeProducts[] = $record['model']->id;
            }
        }
        if (! empty($coreFreeProducts)) {
            $coreFreePkg->products()->attach($coreFreeProducts);
        }

        // Pricing for Core Free package (fixed durations and prices)
        Pricing::insert([
            [
                'entity_id' => $coreFreePkg->id,
                'entity_type' => 'package',
                'duration_months' => 3,
                'price' => 179.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $coreFreePkg->id,
                'entity_type' => 'package',
                'duration_months' => 6,
                'price' => 449.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $coreFreePkg->id,
                'entity_type' => 'package',
                'duration_months' => 12,
                'price' => 999.00,
                'currency' => 'EUR',
            ],
        ]);

        // Issue types tree for Help Center sidebar (up to level 5)
        $this->seedIssueTypes();
    }

    /**
     * Published posts: DI-TOOLS trio from *_detail_updated.html (order 0–2); CADINVO carousel B
     * from B_template_synced_final_*_matchC_nomargin.html (order 3–5). Home can show order 0–5.
     * Optional avatar_source: remote URL (480px) downloaded into storage/app/public/posts/avatars for post->avatar.
     */
    private function seedHomeBlogPosts(User $author): void
    {
        $legacySlugs = [
            'di-tool-for-students',
            'di-tool-for-makers',
            'di-tool-for-startups-program',
            'customer-story-metalworks',
            'customer-story-resemin',
            'customer-story-best-tugs',
        ];
        Post::query()->whereIn('slug', $legacySlugs)->delete();

        $posts = [
            [
                'title' => 'DI-TOOLS for Engineering Teams',
                'slug' => 'di-tools-for-engineering-teams',
                'excerpt' => 'Create a more consistent engineering environment where every team member follows the same structure, standards, and workflow logic.',
                'order' => 0,
                'avatar_source' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left -mx-2 sm:mx-0 text-slate-700">
<div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
<header class="border-b border-slate-200 bg-white px-6 py-10 md:px-10 md:py-14">
<div class="grid gap-8 items-center lg:grid-cols-2">
<div>
<span class="inline-flex items-center gap-2 rounded-full border border-[#137fec]/25 bg-[#137fec]/10 px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#137fec]">DI-TOOLS for Engineering Teams</span>
<h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 leading-tight md:text-5xl">Standardize workflows.<span class="block text-[#137fec]">Scale with confidence.</span></h2>
<p class="mt-4 max-w-xl text-lg text-slate-600">Create a more consistent engineering environment where every team member follows the same structure, standards, and workflow logic.</p>
</div>
<article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
<img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Engineering team collaborating" class="h-64 w-full object-cover md:h-[390px]" width="1400" height="390" />
<div class="border-t border-slate-100 bg-slate-50 p-6">
<h3 class="text-xl font-bold text-slate-900">One standard across the team</h3>
<p class="mt-2 text-sm text-slate-600">Give managers and team leads a clearer system for collaboration, onboarding, and project consistency.</p>
</div>
</article>
</div>
<div class="mt-10 grid gap-4 md:grid-cols-3">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Better alignment</strong>
<p class="mt-2 text-sm text-slate-600">Bring engineers under one shared way of working instead of relying on individual habits.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Easier onboarding</strong>
<p class="mt-2 text-sm text-slate-600">Help new engineers adapt faster with clear structure and shared expectations.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Scalable teamwork</strong>
<p class="mt-2 text-sm text-slate-600">Grow projects and teams without losing control over process and consistency.</p>
</div>
</div>
</header>
<div class="grid gap-6 bg-[#f6f7f8] p-6 md:grid-cols-3 md:gap-8 md:p-10">
<article class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 md:col-span-2 md:p-8">
<section>
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">The challenge</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">As teams grow, different working habits create inconsistency across projects. Team workflow, properties, and outputs start to vary from engineer to engineer, making collaboration harder and scaling more difficult.</p>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">What this helps improve</h2>
<ul class="mt-4 list-none space-y-3 p-0">
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">01</span><div><strong class="block text-base text-slate-900">Team workflow</strong><span class="text-sm text-slate-600">Keep everyone working under one shared process so projects stay more predictable.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">02</span><div><strong class="block text-base text-slate-900">Shared standards</strong><span class="text-sm text-slate-600">Reduce variation across engineers and create more consistency from one project to the next.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">03</span><div><strong class="block text-base text-slate-900">Team coordination</strong><span class="text-sm text-slate-600">Make collaboration smoother by giving the whole team a clearer structure to follow.</span></div></li>
</ul>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">The result</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">A more structured team workflow makes collaboration easier, onboarding faster, and engineering delivery more scalable. Instead of depending on personal habits, the whole team works with more consistency and control.</p>
</section>
</article>
<aside class="md:col-span-1">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Engineer working at workstation" class="mb-4 h-56 w-full rounded-2xl object-cover" width="1200" height="236" />
<h3 class="text-xl font-bold text-slate-900">Built for managers and growing teams</h3>
<p class="mt-2 text-sm text-slate-600">Support engineering managers with a clearer, more repeatable way to align teams across projects.</p>
<blockquote class="mt-4 border-l-4 border-[#137fec] rounded-r-2xl bg-[#137fec]/5 py-4 pl-5 pr-4 text-sm text-slate-700 not-italic"><strong class="text-slate-900">DI-TOOLS</strong> helps teams standardize workflows and eliminate manual errors without slowing down delivery.</blockquote>
</div>
</aside>
</div>
</div>
</div>
HTML,
            ],
            [
                'title' => 'DI-TOOLS for Manufacturing Output',
                'slug' => 'di-tools-for-manufacturing-output',
                'excerpt' => 'Create production-ready deliverables with cleaner exports, more complete handoff, and fewer output problems before release.',
                'order' => 1,
                'avatar_source' => 'https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left -mx-2 sm:mx-0 text-slate-700">
<div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
<header class="border-b border-slate-200 bg-white px-6 py-10 md:px-10 md:py-14">
<div class="grid gap-8 items-center lg:grid-cols-2">
<div>
<span class="inline-flex items-center gap-2 rounded-full border border-[#137fec]/25 bg-[#137fec]/10 px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#137fec]">DI-TOOLS for Manufacturing Output</span>
<h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 leading-tight md:text-5xl">Automate outputs.<span class="block text-[#137fec]">Deliver to production faster.</span></h2>
<p class="mt-4 max-w-xl text-lg text-slate-600">Create production-ready deliverables with cleaner exports, more complete handoff, and fewer output problems before release.</p>
</div>
<article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
<img src="https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Manufacturing workflow and production planning" class="h-64 w-full object-cover md:h-[390px]" width="1400" height="390" />
<div class="border-t border-slate-100 bg-slate-50 p-6">
<h3 class="text-xl font-bold text-slate-900">Built for production handoff</h3>
<p class="mt-2 text-sm text-slate-600">Give manufacturing and delivery teams the files they need with less ambiguity and fewer last-minute issues.</p>
</div>
</article>
</div>
<div class="mt-10 grid gap-4 md:grid-cols-3">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Cleaner delivery</strong>
<p class="mt-2 text-sm text-slate-600">Make sure production receives complete, organized deliverables instead of incomplete handoff packages.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Higher reliability</strong>
<p class="mt-2 text-sm text-slate-600">Reduce output mistakes that slow down manufacturing and create avoidable rework.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Smoother release</strong>
<p class="mt-2 text-sm text-slate-600">Move from design completion to production release with more confidence.</p>
</div>
</div>
</header>
<div class="grid gap-6 bg-[#f6f7f8] p-6 md:grid-cols-3 md:gap-8 md:p-10">
<article class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 md:col-span-2 md:p-8">
<section>
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">The challenge</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">Production teams do not need more CAD complexity. They need correct files, complete data, and reliable outputs. When exports are inconsistent or incomplete, small handoff issues quickly turn into manufacturing delays.</p>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">What this helps deliver</h2>
<ul class="mt-4 list-none space-y-3 p-0">
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">01</span><div><strong class="block text-base text-slate-900">Complete outputs</strong><span class="text-sm text-slate-600">Make sure required files are prepared in a clearer and more repeatable delivery process.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">02</span><div><strong class="block text-base text-slate-900">Reliable documentation</strong><span class="text-sm text-slate-600">Keep BOM and supporting information more consistent before handoff to production.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">03</span><div><strong class="block text-base text-slate-900">Production handoff</strong><span class="text-sm text-slate-600">Help manufacturing teams receive the right deliverables with less confusion and less rework.</span></div></li>
</ul>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">The result</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">The result is a cleaner path from design to manufacturing: fewer missing files, better delivery confidence, and more reliable production release.</p>
</section>
</article>
<aside class="md:col-span-1">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Engineer reviewing manufacturing output" class="mb-4 h-56 w-full rounded-2xl object-cover" width="1200" height="236" />
<h3 class="text-xl font-bold text-slate-900">Built for production teams</h3>
<p class="mt-2 text-sm text-slate-600">Support manufacturing readiness with a more dependable output and handoff process.</p>
<blockquote class="mt-4 border-l-4 border-[#137fec] rounded-r-2xl bg-[#137fec]/5 py-4 pl-5 pr-4 text-sm text-slate-700 not-italic"><strong class="text-slate-900">DI-TOOLS</strong> helps automate exports, BOM, and file delivery for production-ready outputs.</blockquote>
</div>
</aside>
</div>
</div>
</div>
HTML,
            ],
            [
                'title' => 'DI-TOOLS for CAD Automation',
                'slug' => 'di-tools-for-cad-automation',
                'excerpt' => 'Help engineers spend less time on repetitive CAD work and more time on actual design decisions.',
                'order' => 2,
                'avatar_source' => 'https://images.unsplash.com/photo-1581092335397-9583eb92d232?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left -mx-2 sm:mx-0 text-slate-700">
<div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
<header class="border-b border-slate-200 bg-white px-6 py-10 md:px-10 md:py-14">
<div class="grid gap-8 items-center lg:grid-cols-2">
<div>
<span class="inline-flex items-center gap-2 rounded-full border border-[#137fec]/25 bg-[#137fec]/10 px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#137fec]">DI-TOOLS for CAD Automation</span>
<h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 leading-tight md:text-5xl">Eliminate repetitive tasks.<span class="block text-[#137fec]">Automate your CAD workflow.</span></h2>
<p class="mt-4 max-w-xl text-lg text-slate-600">Help engineers spend less time on repetitive CAD work and more time on actual design decisions.</p>
</div>
<article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
<img src="https://images.unsplash.com/photo-1581092335397-9583eb92d232?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="CAD workflow and engineering automation" class="h-64 w-full object-cover md:h-[390px]" width="1400" height="390" />
<div class="border-t border-slate-100 bg-slate-50 p-6">
<h3 class="text-xl font-bold text-slate-900">Built for daily CAD work</h3>
<p class="mt-2 text-sm text-slate-600">Reduce the constant clicks, repeated steps, and manual updates that slow down everyday engineering work.</p>
</div>
</article>
</div>
<div class="mt-10 grid gap-4 md:grid-cols-3">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Less manual work</strong>
<p class="mt-2 text-sm text-slate-600">Take repetitive steps out of the workflow so engineers can focus on design.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">More productivity</strong>
<p class="mt-2 text-sm text-slate-600">Turn time-consuming CAD routines into a faster and more practical daily workflow.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Faster execution</strong>
<p class="mt-2 text-sm text-slate-600">Move through engineering tasks faster without wasting time on repeated actions.</p>
</div>
</div>
</header>
<div class="grid gap-6 bg-[#f6f7f8] p-6 md:grid-cols-3 md:gap-8 md:p-10">
<article class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 md:col-span-2 md:p-8">
<section>
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">The challenge</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">Engineers often spend too much time exporting files, renaming outputs, updating data, and repeating the same CAD actions again and again. These tasks do not add design value, but they consume time every day.</p>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">What this helps reduce</h2>
<ul class="mt-4 list-none space-y-3 p-0">
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">01</span><div><strong class="block text-base text-slate-900">Repeated steps</strong><span class="text-sm text-slate-600">Cut down repetitive actions that make everyday CAD work slower and more frustrating.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">02</span><div><strong class="block text-base text-slate-900">Manual updates</strong><span class="text-sm text-slate-600">Reduce time spent changing the same data over and over by hand.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">03</span><div><strong class="block text-base text-slate-900">Admin-heavy CAD work</strong><span class="text-sm text-slate-600">Spend less time on file handling and more time on real engineering work.</span></div></li>
</ul>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">The result</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">Engineers work faster, deal with less repetition, and spend more time designing instead of managing routine CAD tasks.</p>
</section>
</article>
<aside class="md:col-span-1">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Engineer working with CAD system" class="mb-4 h-56 w-full rounded-2xl object-cover" width="1200" height="236" />
<h3 class="text-xl font-bold text-slate-900">Built for engineers in daily use</h3>
<p class="mt-2 text-sm text-slate-600">Create a more practical workflow for engineers who want to move faster with less manual overhead.</p>
<blockquote class="mt-4 border-l-4 border-[#137fec] rounded-r-2xl bg-[#137fec]/5 py-4 pl-5 pr-4 text-sm text-slate-700 not-italic"><strong class="text-slate-900">DI-TOOLS</strong> helps eliminate repetitive CAD tasks and build scalable automation workflows.</blockquote>
</div>
</aside>
</div>
</div>
</div>
HTML,
            ],
            [
                'title' => 'CADINVO: 64% Faster from Request to Drawing',
                'slug' => 'cadinvo-64-percent-faster-request-to-drawing',
                'excerpt' => 'For drawing offices and Inventor teams—how CADINVO combines engineering support, automation, and process to shorten the path from request to drawing.',
                'order' => 3,
                'avatar_source' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left -mx-2 sm:mx-0 text-slate-700">
<div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
<header class="border-b border-slate-200 bg-white px-6 py-10 md:px-10 md:py-14">
<div class="grid gap-8 items-center lg:grid-cols-2">
<div>
<span class="inline-flex items-center gap-2 rounded-full border border-[#137fec]/25 bg-[#137fec]/10 px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#137fec]">For drawing offices &amp; Inventor teams</span>
<h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 leading-tight md:text-5xl">64% faster.<span class="block text-[#137fec]">From request to drawing.</span></h2>
<p class="mt-4 max-w-xl text-lg text-slate-600">How CADINVO combines engineering support, automation, and process so your team moves from customer request to released drawings with less friction.</p>
</div>
<article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
<img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Engineering drawings and planning" class="h-64 w-full object-cover md:h-[390px]" width="1400" height="390" />
<div class="border-t border-slate-100 bg-slate-50 p-6">
<h3 class="text-xl font-bold text-slate-900">Engineering, automation &amp; process—together</h3>
<p class="mt-2 text-sm text-slate-600">CADINVO is built for teams that need speed without sacrificing standards: one coherent path from intake to deliverable.</p>
</div>
</article>
</div>
<div class="mt-10 grid gap-4 md:grid-cols-3">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Faster turnaround</strong>
<p class="mt-2 text-sm text-slate-600">Shrink the gap between incoming work and drawings your shop can build from.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Repeatable flow</strong>
<p class="mt-2 text-sm text-slate-600">Replace ad-hoc handoffs with a process your whole office can rely on.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Inventor-native</strong>
<p class="mt-2 text-sm text-slate-600">Support tuned for Autodesk Inventor teams and drawing-office reality.</p>
</div>
</div>
</header>
<div class="grid gap-6 bg-[#f6f7f8] p-6 md:grid-cols-3 md:gap-8 md:p-10">
<article class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 md:col-span-2 md:p-8">
<section>
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">Why “request to drawing” matters</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">Every delay between a customer or internal request and a clean, buildable drawing costs capacity. CADINVO focuses on that span: engineering support where you need hands, automation where the work is repetitive, and process so the team stays aligned.</p>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">What you get</h2>
<ul class="mt-4 list-none space-y-3 p-0">
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">01</span><div><strong class="block text-base text-slate-900">Clear intake</strong><span class="text-sm text-slate-600">Structure how requests become work so nothing sits in email limbo.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">02</span><div><strong class="block text-base text-slate-900">Engineering muscle</strong><span class="text-sm text-slate-600">Modeling, assembly, and detailing support when your drawing office is at capacity.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">03</span><div><strong class="block text-base text-slate-900">Automation layer</strong><span class="text-sm text-slate-600">DI-TOOLS and iLogic-style routines to cut manual steps on every order.</span></div></li>
</ul>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">CADINVO in one line</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700"><strong class="text-slate-900">CADINVO</strong> — Engineering Support &amp; CAD Automation: help your drawing office deliver faster without burning out your team.</p>
</section>
</article>
<aside class="md:col-span-1">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Team collaboration in engineering office" class="mb-4 h-56 w-full rounded-2xl object-cover" width="1200" height="236" />
<h3 class="text-xl font-bold text-slate-900">Built for real drawing-office load</h3>
<p class="mt-2 text-sm text-slate-600">The carousel story is simple: less waiting, more throughput—measured from the moment a request lands to drawings your production can use.</p>
<blockquote class="mt-4 border-l-4 border-[#137fec] rounded-r-2xl bg-[#137fec]/5 py-4 pl-5 pr-4 text-sm text-slate-700 not-italic"><strong class="text-slate-900">64% faster</strong> from request to drawing—positioning for teams that live inside Inventor and tight delivery windows.</blockquote>
</div>
</aside>
</div>
</div>
</div>
HTML,
            ],
            [
                'title' => 'CADINVO: From Bottlenecks to Engineering Support',
                'slug' => 'cadinvo-bottlenecks-engineering-support',
                'excerpt' => 'Manual workflows and overload slow every drawing office. CADINVO removes bottlenecks with hands-on engineering support and scalable capacity.',
                'order' => 4,
                'avatar_source' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left -mx-2 sm:mx-0 text-slate-700">
<div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
<header class="border-b border-slate-200 bg-white px-6 py-10 md:px-10 md:py-14">
<div class="grid gap-8 items-center lg:grid-cols-2">
<div>
<span class="inline-flex items-center gap-2 rounded-full border border-[#137fec]/25 bg-[#137fec]/10 px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#137fec]">Bottlenecks → capacity</span>
<h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 leading-tight md:text-5xl">Manual workflows<span class="block text-[#137fec]">slow the whole team.</span></h2>
<p class="mt-4 max-w-xl text-lg text-slate-600">When requests stack up and every drawing is a custom firefight, your drawing office hits the same walls: rework, waiting, and stress. CADINVO is aimed at removing those bottlenecks through engineering support and automation—not generic IT projects.</p>
</div>
<article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
<img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Engineer at work in industrial environment" class="h-64 w-full object-cover md:h-[390px]" width="1400" height="390" />
<div class="border-t border-slate-100 bg-slate-50 p-6">
<h3 class="text-xl font-bold text-slate-900">Engineering support that scales with you</h3>
<p class="mt-2 text-sm text-slate-600">Modeling, assemblies, detailing, and revisions—extra hands when your backlog outruns headcount.</p>
</div>
</article>
</div>
<div class="mt-10 grid gap-4 md:grid-cols-3">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Fewer stalls</strong>
<p class="mt-2 text-sm text-slate-600">Address the queue before it becomes emergency overtime.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Consistent quality</strong>
<p class="mt-2 text-sm text-slate-600">Support that follows your standards—not one-off heroics.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Predictable load</strong>
<p class="mt-2 text-sm text-slate-600">Blend internal staff with CADINVO capacity for peak periods.</p>
</div>
</div>
</header>
<div class="grid gap-6 bg-[#f6f7f8] p-6 md:grid-cols-3 md:gap-8 md:p-10">
<article class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 md:col-span-2 md:p-8">
<section>
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">Where bottlenecks come from</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">Manual handoffs, unclear ownership, and repetitive CAD work eat hours that should go into engineering judgment. The B-template story is explicit: those patterns slow drawing offices and Inventor teams alike until the process—not just headcount—is addressed.</p>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">Engineering support you can plug in</h2>
<ul class="mt-4 list-none space-y-3 p-0">
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">01</span><div><strong class="block text-base text-slate-900">Part &amp; assembly modeling</strong><span class="text-sm text-slate-600">Build and maintain models that match how you manufacture.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">02</span><div><strong class="block text-base text-slate-900">Detailing &amp; revisions</strong><span class="text-sm text-slate-600">Keep drawing packages moving through change orders without losing control.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">03</span><div><strong class="block text-base text-slate-900">Drawing-office capacity</strong><span class="text-sm text-slate-600">Treat support as a lever for throughput, not a one-time rescue.</span></div></li>
</ul>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">The shift</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">You move from “we are always behind” to a controlled pipeline: engineering where humans add value, automation where machines should, and fewer surprise bottlenecks between request and released drawings.</p>
</section>
</article>
<aside class="md:col-span-1">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Engineer at workstation" class="mb-4 h-56 w-full rounded-2xl object-cover" width="1200" height="236" />
<h3 class="text-xl font-bold text-slate-900">CADINVO removes friction</h3>
<p class="mt-2 text-sm text-slate-600">Same narrative as the carousel: combine real engineering support with the automation stack (next article) so the office breathes again.</p>
<blockquote class="mt-4 border-l-4 border-[#137fec] rounded-r-2xl bg-[#137fec]/5 py-4 pl-5 pr-4 text-sm text-slate-700 not-italic"><strong class="text-slate-900">CADINVO</strong> — less pressure on your drawing office, more predictable delivery.</blockquote>
</div>
</aside>
</div>
</div>
</div>
HTML,
            ],
            [
                'title' => 'CADINVO: Automation, Process & Time Saved',
                'slug' => 'cadinvo-automation-process-and-results',
                'excerpt' => 'DI-TOOLS plus iLogic-style automation, standardized exports and QC—and a real example: from three hours of manual work to fifteen minutes per order.',
                'order' => 5,
                'avatar_source' => 'https://images.unsplash.com/photo-1581092335397-9583eb92d232?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left -mx-2 sm:mx-0 text-slate-700">
<div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm">
<header class="border-b border-slate-200 bg-white px-6 py-10 md:px-10 md:py-14">
<div class="grid gap-8 items-center lg:grid-cols-2">
<div>
<span class="inline-flex items-center gap-2 rounded-full border border-[#137fec]/25 bg-[#137fec]/10 px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#137fec]">Automation &amp; process</span>
<h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 leading-tight md:text-5xl">Standardize the boring work.<span class="block text-[#137fec]">Keep the engineering.</span></h2>
<p class="mt-4 max-w-xl text-lg text-slate-600">CAD automation with DI-TOOLS and iLogic: exports, naming, BOM, and QC checkpoints—so repetitive tasks become automated workflows with fewer errors and more control.</p>
</div>
<article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
<img src="https://images.unsplash.com/photo-1581092335397-9583eb92d232?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="CAD and automation" class="h-64 w-full object-cover md:h-[390px]" width="1400" height="390" />
<div class="border-t border-slate-100 bg-slate-50 p-6">
<h3 class="text-xl font-bold text-slate-900">Process optimization</h3>
<p class="mt-2 text-sm text-slate-600">Turn recurring steps into repeatable flows—aligned with how your drawing office actually ships work.</p>
</div>
</article>
</div>
<div class="mt-10 grid gap-4 md:grid-cols-3">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Measurable time</strong>
<p class="mt-2 text-sm text-slate-600">Carousel benchmark: <strong class="text-slate-900">64%</strong> time saved—<strong class="text-slate-900">3 hours → 15 minutes</strong> per order in the example flow.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">What you gain</strong>
<p class="mt-2 text-sm text-slate-600">Less stress, stable planning, higher output, fewer mistakes, faster team performance.</p>
</div>
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<strong class="block text-xl text-[#137fec]">Who it fits</strong>
<p class="mt-2 text-sm text-slate-600">Manufacturers, engineers, drawing offices, steel fabricators.</p>
</div>
</div>
</header>
<div class="grid gap-6 bg-[#f6f7f8] p-6 md:grid-cols-3 md:gap-8 md:p-10">
<article class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 md:col-span-2 md:p-8">
<section>
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">From manual minutes to automated flow</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">The carousel spells it out: from three hours of manual work to fifteen minutes—from a partly manual path to a <strong class="text-[#137fec]">100%</strong> automated flow in that scenario. That is the promise of pairing DI-TOOLS-style automation with clear process rules: less clicking, fewer wrong files, more predictable releases.</p>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">What you actually gain</h2>
<ul class="mt-4 list-none space-y-3 p-0">
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">01</span><div><strong class="block text-base text-slate-900">Less stress</strong><span class="text-sm text-slate-600">Reduce pressure on the drawing office with clearer flow and fewer fire drills.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">02</span><div><strong class="block text-base text-slate-900">Stable planning</strong><span class="text-sm text-slate-600">More predictable throughput so commitments to production and customers hold.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">03</span><div><strong class="block text-base text-slate-900">Higher output</strong><span class="text-sm text-slate-600">Ship more complete drawing packages in the same calendar time.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">04</span><div><strong class="block text-base text-slate-900">Fewer mistakes</strong><span class="text-sm text-slate-600">Standardized exports, naming, and QC cut wrong-file moments before release.</span></div></li>
<li class="grid grid-cols-[40px_1fr] gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4"><span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#137fec]/10 text-sm font-extrabold text-[#137fec]">05</span><div><strong class="block text-base text-slate-900">Faster team performance</strong><span class="text-sm text-slate-600">The whole office moves faster when repetition is automated, not hero-coded.</span></div></li>
</ul>
</section>
<section class="border-t border-slate-200 pt-8">
<h2 class="text-2xl font-bold text-slate-900 md:text-3xl">Want to accelerate your engineering workflow?</h2>
<p class="mt-3 text-[15.8px] leading-relaxed text-slate-700">Let’s map out where engineering support, automation, and process can save time and reduce pressure on your drawing office.</p>
<div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm">
<p class="font-semibold text-slate-900">CADINVO — Engineering Support &amp; CAD Automation · <a href="https://www.cadinvo.com" class="text-[#137fec] underline hover:text-[#0f6ecd]" target="_blank" rel="noopener noreferrer">www.cadinvo.com</a></p>
<p class="mt-3"><a href="mailto:daniel@cadinvo.com" class="text-[#137fec] underline hover:text-[#0f6ecd]">daniel@cadinvo.com</a></p>
<p class="mt-1"><a href="tel:+31630725787" class="text-[#137fec] underline hover:text-[#0f6ecd]">+31 6 3072 5787</a></p>
<p class="mt-3 text-slate-600">Coffee is on me.</p>
</div>
</section>
</article>
<aside class="md:col-span-1">
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
<img src="https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&amp;fit=crop&amp;w=1200&amp;q=80" alt="Manufacturing floor" class="mb-4 h-56 w-full rounded-2xl object-cover" width="1200" height="236" />
<h3 class="text-xl font-bold text-slate-900">Industries on the carousel</h3>
<p class="mt-2 text-sm text-slate-600">Manufacturers, engineers, drawing offices, steel fabricators—teams that need drawings and data to match shop reality.</p>
<blockquote class="mt-4 border-l-4 border-[#137fec] rounded-r-2xl bg-[#137fec]/5 py-4 pl-5 pr-4 text-sm text-slate-700 not-italic"><strong class="text-slate-900">CADINVO + DI-TOOLS</strong> — automation and process so your office ships faster with fewer fire drills.</blockquote>
</div>
</aside>
</div>
</div>
</div>
HTML,
            ],
        ];

        foreach ($posts as $row) {
            $avatarSource = $row['avatar_source'] ?? null;
            unset($row['avatar_source']);
            $avatarPath = null;
            if (is_string($avatarSource) && $avatarSource !== '') {
                $avatarPath = $this->seedPostAvatarFromUrl((string) $row['slug'], $avatarSource);
            }

            Post::updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'excerpt' => $row['excerpt'],
                    'content' => $row['content'],
                    'status' => 'published',
                    'published_at' => now()->subDays(45 - (int) $row['order']),
                    'user_id' => $author->id,
                    'order' => (int) $row['order'],
                    'avatar' => $avatarPath,
                ]
            );
        }
    }

    /**
     * Save a small remote image to storage/app/public/posts/avatars for home card avatars.
     * Returns null if the request fails (posts still seed; content images apply via featured_image_url).
     */
    private function seedPostAvatarFromUrl(string $slug, string $url): ?string
    {
        try {
            $response = Http::timeout(25)->connectTimeout(10)->get($url);
            if (! $response->successful()) {
                return null;
            }

            $ext = 'jpg';
            $ct = $response->header('Content-Type');
            if (is_string($ct)) {
                if (str_contains($ct, 'png')) {
                    $ext = 'png';
                } elseif (str_contains($ct, 'webp')) {
                    $ext = 'webp';
                }
            }

            $path = 'posts/avatars/'.$slug.'.'.$ext;
            Storage::disk('public')->put($path, $response->body());

            return $path;
        } catch (Throwable) {
            return null;
        }
    }

    private function seedIssueTypes(): void
    {
        if (IssueType::query()->exists()) {
            return;
        }

        // Level 1
        $whatsNew = IssueType::create(['name' => "Di-tool What's New", 'slug' => 'di-tool-whats-new', 'sort_order' => 0, 'has_url' => false]);
        $releaseNotes = IssueType::create(['name' => 'Release Notes', 'slug' => 'release-notes', 'sort_order' => 1, 'has_url' => false]);
        $getStarted = IssueType::create(['name' => 'Get Started videos', 'slug' => 'get-started-videos', 'sort_order' => 2, 'has_url' => false]);
        $tutorials = IssueType::create(['name' => 'Tutorials', 'slug' => 'tutorials', 'sort_order' => 3, 'has_url' => false]);
        $helpTopics = IssueType::create(['name' => 'Di-tool Help Topics', 'slug' => 'di-tool-help-topics', 'sort_order' => 4, 'has_url' => false]);

        // Level 2 under Help Topics
        $inventorBasics = IssueType::create(['parent_id' => $helpTopics->id, 'name' => 'Inventor Basics', 'slug' => 'inventor-basics', 'sort_order' => 0, 'has_url' => false]);
        $userInterface = IssueType::create(['parent_id' => $helpTopics->id, 'name' => 'User Interface', 'slug' => 'user-interface', 'sort_order' => 1, 'has_url' => false]);

        // Level 3 under Inventor Basics
        $gettingStarted = IssueType::create(['parent_id' => $inventorBasics->id, 'name' => 'Getting Started', 'slug' => 'getting-started', 'sort_order' => 0, 'has_url' => true, 'description' => 'Getting Started']);
        $partModeling = IssueType::create(['parent_id' => $inventorBasics->id, 'name' => 'Part Modeling', 'slug' => 'part-modeling', 'sort_order' => 1, 'has_url' => false]);

        // Level 4 under Getting Started
        $installation = IssueType::create(['parent_id' => $gettingStarted->id, 'name' => 'Installation', 'slug' => 'installation', 'sort_order' => 0, 'has_url' => true]);
        $firstLaunch = IssueType::create(['parent_id' => $gettingStarted->id, 'name' => 'First Launch', 'slug' => 'first-launch', 'sort_order' => 1, 'has_url' => true]);

        // Level 4 under Part Modeling
        $sketching = IssueType::create(['parent_id' => $partModeling->id, 'name' => 'Sketching', 'slug' => 'sketching', 'sort_order' => 0, 'has_url' => false]);
        $features = IssueType::create(['parent_id' => $partModeling->id, 'name' => 'Features', 'slug' => 'features', 'sort_order' => 1, 'has_url' => false]);

        // Level 5 under Sketching
        IssueType::create(['parent_id' => $sketching->id, 'name' => 'Create Sketch', 'slug' => 'create-sketch', 'sort_order' => 0, 'has_url' => true]);
        IssueType::create(['parent_id' => $sketching->id, 'name' => 'Dimensions', 'slug' => 'dimensions', 'sort_order' => 1, 'has_url' => true]);

        // Level 5 under Features
        IssueType::create(['parent_id' => $features->id, 'name' => 'Extrude', 'slug' => 'extrude', 'sort_order' => 0, 'has_url' => true]);
        IssueType::create(['parent_id' => $features->id, 'name' => 'Revolve', 'slug' => 'revolve', 'sort_order' => 1, 'has_url' => true]);

        // Level 3 under User Interface
        $aboutHome = IssueType::create(['parent_id' => $userInterface->id, 'name' => 'About Home', 'slug' => 'about-home', 'sort_order' => 0, 'has_url' => false]);
        IssueType::create(['parent_id' => $userInterface->id, 'name' => 'Browser Panel', 'slug' => 'browser-panel', 'sort_order' => 1, 'has_url' => true]);

        // Level 4 under About Home
        $aboutRibbon = IssueType::create(['parent_id' => $aboutHome->id, 'name' => 'About the Ribbon', 'slug' => 'about-the-ribbon', 'sort_order' => 0, 'has_url' => false]);

        // Level 5 under About the Ribbon
        IssueType::create(['parent_id' => $aboutRibbon->id, 'name' => 'To Work with the Ribbon', 'slug' => 'to-work-with-the-ribbon', 'sort_order' => 0, 'has_url' => true]);
        IssueType::create(['parent_id' => $aboutRibbon->id, 'name' => 'To Work with Icons, Tooltips', 'slug' => 'to-work-with-icons-tooltips', 'sort_order' => 1, 'has_url' => true]);
        IssueType::create(['parent_id' => $aboutRibbon->id, 'name' => 'To Customize User Commands', 'slug' => 'to-customize-user-commands', 'sort_order' => 2, 'has_url' => true]);

        // More Level 1
        IssueType::create(['name' => 'Di-tool Browser', 'slug' => 'di-tool-browser', 'sort_order' => 5, 'has_url' => false]);
        IssueType::create(['name' => 'About Marking Menus', 'slug' => 'about-marking-menus', 'sort_order' => 6, 'has_url' => false]);
        IssueType::create(['name' => 'To Work with the Navigation Bar', 'slug' => 'to-work-with-navigation-bar', 'sort_order' => 7, 'has_url' => false]);
        IssueType::create(['name' => 'About Graphics Windows', 'slug' => 'about-graphics-windows', 'sort_order' => 8, 'has_url' => false]);
        IssueType::create(['name' => 'About InfoCenter', 'slug' => 'about-infocenter', 'sort_order' => 9, 'has_url' => false]);
    }
}
