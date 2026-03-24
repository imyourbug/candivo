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

        $handle = fopen($csvPath, 'r');
        if ($handle === false) {
            throw new RuntimeException('CSV file not found at: '.$csvPath);
        }
        $header = fgetcsv($handle);
        if ($header === false || ($header[0] ?? null) === null) {
            fclose($handle);
            throw new RuntimeException('CSV header row missing or invalid.');
        }
        $columns = array_flip($header);
        $dataRows = [];
        while (($row = fgetcsv($handle)) !== false) {
            if ($row === [null] || (count($row) === 1 && ($row[0] ?? '') === '')) {
                continue;
            }
            if (count($row) < count($header)) {
                $row = array_pad($row, count($header), '');
            }
            $dataRows[] = $row;
        }
        fclose($handle);

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

                $productIdCode = 'PRD-'.strtoupper(Str::slug($name, '-'));
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
                    'video' => trim($row[$columns['Video']] ?? ''),
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
                $packageIdCode = 'PKG-'.strtoupper(Str::slug($name, '_'));
                $package = Package::create([
                    'package_id' => $packageIdCode,
                    'name' => $name,
                    'slug' => $productSlug,
                    'level' => (int) trim($row[$columns['Level']] ?? 1),
                    'description' => trim($row[$columns['Description']] ?? '') ?: null,
                    'avatar' => trim($row[$columns['Avatar']] ?? '') ?: 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                    'video' => trim($row[$columns['Video']] ?? ''),
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
            // 'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
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

        // Seed issue types from DI-TOOLS manual posts.
        $this->call('Database\\Seeders\\IssueTypeSeeder');
    }

    /**
     * Published posts: DI-TOOLS (order 0–2) and CADINVO (order 3–5). Content is plain text plus one figure each.
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
<div class="not-prose text-left text-slate-700 space-y-6">
<figure class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
<img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Engineering team collaborating" class="w-full max-h-[420px] object-cover" width="1400" height="420" />
</figure>
<div class="space-y-4 text-[15.8px] leading-relaxed">
<p>As teams grow, different working habits create inconsistency across projects. Workflow, properties, and outputs start to vary from engineer to engineer, which makes collaboration harder and scaling more difficult. <strong class="text-slate-900">DI-TOOLS for Engineering Teams</strong> helps you create a more consistent environment where every team member follows the same structure, standards, and workflow logic.</p>
<p>It improves alignment by bringing engineers under one shared way of working, makes onboarding easier with clear structure and shared expectations, and supports scalable teamwork so you can grow projects without losing control over process. Managers and team leads get a clearer system for collaboration, onboarding, and project consistency.</p>
<p>The outcome is easier collaboration, faster onboarding, and more scalable delivery: the whole team works with more consistency and control instead of relying on individual habits.</p>
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
<div class="not-prose text-left text-slate-700 space-y-6">
<figure class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
<img src="https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Manufacturing workflow and production planning" class="w-full max-h-[420px] object-cover" width="1400" height="420" />
</figure>
<div class="space-y-4 text-[15.8px] leading-relaxed">
<p>Production teams need correct files, complete data, and reliable outputs—not extra CAD complexity. When exports are inconsistent or incomplete, small handoff issues quickly become manufacturing delays. <strong class="text-slate-900">DI-TOOLS for Manufacturing Output</strong> helps you create production-ready deliverables with cleaner exports, more complete handoff, and fewer problems before release.</p>
<p>It supports complete outputs through a clearer delivery process, more reliable BOM and documentation before production, and smoother handoff so manufacturing receives the right files with less confusion and rework.</p>
<p>You get a cleaner path from design to manufacturing: fewer missing files, better delivery confidence, and a more reliable production release.</p>
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
<div class="not-prose text-left text-slate-700 space-y-6">
<figure class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
<img src="https://images.unsplash.com/photo-1581092335397-9583eb92d232?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="CAD workflow and engineering automation" class="w-full max-h-[420px] object-cover" width="1400" height="420" />
</figure>
<div class="space-y-4 text-[15.8px] leading-relaxed">
<p>Engineers often lose too much time exporting files, renaming outputs, updating data, and repeating the same CAD actions. That work rarely adds design value, but it consumes hours every day. <strong class="text-slate-900">DI-TOOLS for CAD Automation</strong> helps teams spend less time on repetitive CAD work and more time on real design decisions.</p>
<p>It reduces repeated steps that slow everyday work, cuts manual updates to the same data, and shifts effort away from admin-heavy file handling toward engineering. The goal is a faster, more practical daily workflow with less clicking and frustration.</p>
<p>Teams work faster, repeat themselves less, and focus more on designing instead of managing routine CAD tasks.</p>
</div>
</div>
HTML,
            ],
            [
                'title' => '64% Faster from Request to Drawing',
                'slug' => 'cadinvo-64-percent-faster-request-to-drawing',
                'excerpt' => 'For drawing offices and Inventor teams—how CADINVO combines engineering support, automation, and process to shorten the path from request to drawing.',
                'order' => 3,
                'avatar_source' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left text-slate-700 space-y-6">
<figure class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
<img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Engineering drawings and planning" class="w-full max-h-[420px] object-cover" width="1400" height="420" />
</figure>
<div class="space-y-4 text-[15.8px] leading-relaxed">
<p>For drawing offices and Inventor teams, every delay between a request and a clean, buildable drawing costs capacity. <strong class="text-slate-900">CADINVO</strong> combines engineering support, automation, and process so you move from customer request to released drawings with less friction—benchmarked at <strong class="text-slate-900">64% faster</strong> from request to drawing in their positioning.</p>
<p>Clear intake structures how requests become work; engineering support covers modeling, assembly, and detailing when the office is full; and an automation layer (DI-TOOLS and iLogic-style routines) cuts manual steps on each order. The aim is speed without sacrificing standards: one coherent path from intake to deliverable.</p>
<p><strong class="text-slate-900">CADINVO</strong> — Engineering Support &amp; CAD Automation: help your drawing office deliver faster without burning out the team.</p>
</div>
</div>
HTML,
            ],
            [
                'title' => 'Bottlenecks & Engineering Support',
                'slug' => 'cadinvo-bottlenecks-engineering-support',
                'excerpt' => 'Manual workflows and overload slow every drawing office. CADINVO removes bottlenecks with hands-on engineering support and scalable capacity.',
                'order' => 4,
                'avatar_source' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left text-slate-700 space-y-6">
<figure class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
<img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="Engineer at work in industrial environment" class="w-full max-h-[420px] object-cover" width="1400" height="420" />
</figure>
<div class="space-y-4 text-[15.8px] leading-relaxed">
<p>When requests stack up and every drawing feels like a custom firefight, drawing offices hit the same walls: rework, waiting, and stress. Manual handoffs, unclear ownership, and repetitive CAD work eat hours that should go into engineering judgment. <strong class="text-slate-900">CADINVO</strong> targets those bottlenecks with engineering support and automation—not generic IT projects.</p>
<p>Support can cover part and assembly modeling that matches how you manufacture, detailing and revisions through change orders, and extra drawing-office capacity when backlog outruns headcount—aligned to your standards, not one-off heroics. You can blend internal staff with CADINVO capacity for peak periods.</p>
<p>The shift is from “always behind” to a more controlled pipeline: humans where judgment matters, automation where repetition dominates, and fewer surprises between request and released drawings.</p>
</div>
</div>
HTML,
            ],
            [
                'title' => 'Automation, Process & Time Saved',
                'slug' => 'cadinvo-automation-process-and-results',
                'excerpt' => 'DI-TOOLS plus iLogic-style automation, standardized exports and QC—and a real example: from three hours of manual work to fifteen minutes per order.',
                'order' => 5,
                'avatar_source' => 'https://images.unsplash.com/photo-1581092335397-9583eb92d232?auto=format&fit=crop&w=480&q=75',
                'content' => <<<'HTML'
<div class="not-prose text-left text-slate-700 space-y-6">
<figure class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
<img src="https://images.unsplash.com/photo-1581092335397-9583eb92d232?auto=format&amp;fit=crop&amp;w=1400&amp;q=80" alt="CAD and automation" class="w-full max-h-[420px] object-cover" width="1400" height="420" />
</figure>
<div class="space-y-4 text-[15.8px] leading-relaxed">
<p>CAD automation with <strong class="text-slate-900">DI-TOOLS</strong> and iLogic-style routines covers exports, naming, BOM, and QC checkpoints—turning repetitive tasks into flows with fewer errors and more control. In the story used on the site, one flow went from about three hours of manual work to fifteen minutes, with a large share of time saved overall—pairing automation with clear process rules means less clicking, fewer wrong files, and more predictable releases.</p>
<p>Teams typically see less stress on the drawing office, more stable planning and throughput, higher output in the same calendar time, fewer mistakes from standardized exports and naming, and faster performance when repetition is automated instead of hero-coded. It fits manufacturers, engineers, drawing offices, and steel fabricators—anyone who needs drawings and data to match shop reality.</p>
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
