<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Package;
use App\Models\Pricing;
use App\Constants\GlobalConstant;
use App\Models\Type;
use App\Models\IssueType;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

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
        if (!file_exists($csvPath)) {
            throw new RuntimeException('CSV file not found at: ' . $csvPath);
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
                $productSlug = $baseProductSlug . '-' . $productSuffix;
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

                $productIdCode = 'PRD-' . strtoupper($productSlug);
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
                    'category' => trim($row[$columns['Category']] ?? '')
                ];
            } else {
                // Package row (IsTool = 0)
                $packageIdCode = 'PKG-' . strtoupper($productSlug);
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

        if ($basicPkg && !empty($basicProducts)) {
            $basicPkg->products()->attach($basicProducts);
        }
        if ($expertPkg && !empty($expertProducts)) {
            $expertPkg->products()->attach($expertProducts);
        }
        if ($premiumLayerPkg && !empty($premiumLayerProducts)) {
            $premiumLayerPkg->products()->attach($premiumLayerProducts);
        }
        if ($fileManagerPkg && !empty($fileManagerProducts)) {
            $fileManagerPkg->products()->attach($fileManagerProducts);
        }
        if ($drawingExportPkg && !empty($drawingExportProducts)) {
            $drawingExportPkg->products()->attach($drawingExportProducts);
        }
        if ($iPropertyQuantityPkg && !empty($iPropertyQuantityProducts)) {
            $iPropertyQuantityPkg->products()->attach($iPropertyQuantityProducts);
        }
        if ($advancedToolsPkg && !empty($advancedToolsProducts)) {
            $advancedToolsPkg->products()->attach($advancedToolsProducts);
        }
        if ($assemblyModelingPkg && !empty($assemblyModelingProducts)) {
            $assemblyModelingPkg->products()->attach($assemblyModelingProducts);
        }
        if ($revisionAndReplacePkg && !empty($revisionAndReplaceProducts)) {
            $revisionAndReplacePkg->products()->attach($revisionAndReplaceProducts);
        }
        if ($pdfPublishingSetPkg && !empty($pdfPublishingSetProducts)) {
            $pdfPublishingSetPkg->products()->attach($pdfPublishingSetProducts);
        }
        if ($productionDrawingSetPkg && !empty($productionDrawingSetProducts)) {
            $productionDrawingSetPkg->products()->attach($productionDrawingSetProducts);
        }
        if ($propertyEssentialsSetPkg && !empty($propertyEssentialsSetProducts)) {
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
            'package_id' => 'PKG-' . strtoupper('core-free'),
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
        if (!empty($coreFreeProducts)) {
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
     * Six published posts matching the former home.blade.php Community cards (order 0–2)
     * and customer-story row (order 3–5), with hero images from the original markup.
     */
    private function seedHomeBlogPosts(User $author): void
    {
        $posts = [
            [
                'title' => 'DI-TOOL for Students',
                'slug' => 'di-tool-for-students',
                'excerpt' => 'As the industry standard for design and engineering, DI-TOOL is the perfect software platform for students building real-world skills.',
                'image' => 'https://www.solidworks.com/sites/default/filesd10/styles/og_image/public/migration/2022-11/solidworks-students-hero-3.jpg?itok=QOWmm9P9',
                'order' => 0,
                'body' => <<<'HTML'
<p>DI-TOOL gives students access to professional-grade 3D CAD, simulation, and collaboration workflows so coursework aligns with what employers expect in mechanical design and engineering.</p>
<p>From classroom projects to competitions, you can model, test, and document designs with the same mindset used in industry—without compromising on depth or quality.</p>
HTML,
            ],
            [
                'title' => 'DI-TOOL for Makers',
                'slug' => 'di-tool-for-makers',
                'excerpt' => 'DI-TOOL for Makers provides full-functionality 3D CAD tools for personal use. Just $48 USD a year for makers who want serious design power.',
                'image' => 'https://www.solidworks.com/sites/default/filesd10/styles/og_image/public/2025-01/solidworks-makers-card-thumb.jpg?itok=HM7Y7HF_',
                'order' => 1,
                'body' => <<<'HTML'
<p>Whether you are prototyping at home or building a side project, DI-TOOL for Makers delivers the core modeling, assembly, and drawing tools you need to turn ideas into manufacturable designs.</p>
<p>An affordable annual option keeps full-featured CAD within reach so you can iterate faster and share files with collaborators or service bureaus.</p>
HTML,
            ],
            [
                'title' => 'DI-TOOL for Startups Program',
                'slug' => 'di-tool-for-startups-program',
                'excerpt' => 'Industry-leading 3D design tools for hardware startups at nominal cost—scale your product development without outgrowing your stack overnight.',
                'image' => 'https://www.solidworks.com/sites/default/filesd10/styles/og_image/public/migration/opengraph_startup_drone_example1.jpg?itok=U6fjCCos',
                'order' => 2,
                'body' => <<<'HTML'
<p>Hardware startups need speed, clarity, and a toolchain that investors and manufacturing partners recognize. DI-TOOL helps teams move from concept to BOM-ready models with structured workflows.</p>
<p>The Startups Program is structured to keep costs predictable while you validate product–market fit and grow your engineering headcount.</p>
HTML,
            ],
            [
                'title' => 'How Metalworks Accelerates Production with DI-TOOL',
                'slug' => 'customer-story-metalworks',
                'excerpt' => 'Metalworks, Inc. slashes rework and handoffs by standardizing on DI-TOOL for Inventor automation and drawing delivery.',
                'image' => 'https://www.3ds.com/assets/invest/styles/card/public/2025-08/metalworks-banner.png.webp?itok=Pa3I3qDD',
                'order' => 3,
                'body' => <<<'HTML'
<p>Metalworks faced growing pressure to deliver fabrication-ready packages on tighter schedules. By adopting DI-TOOL alongside Autodesk Inventor, the team reduced repetitive documentation work and improved consistency across jobs.</p>
<p>Automations around title blocks, BOM exports, and revision tracking helped engineers stay focused on design changes instead of manual updates—cutting cycle time on repeat builds.</p>
HTML,
            ],
            [
                'title' => 'Resemin Standardizes Mine Operations Engineering on DI-TOOLS',
                'slug' => 'customer-story-resemin',
                'excerpt' => 'DI-TOOLS and a connected design experience help Resemin coordinate complex equipment programs across disciplines and sites.',
                'image' => 'https://www.3ds.com/assets/invest/styles/card/public/2023-01/resemin-customer-story-banner.jpg.webp?itok=wG1lKOqS',
                'order' => 4,
                'body' => <<<'HTML'
<p>Resemin engineers heavy machinery for demanding underground environments. Unified CAD practices and reusable templates mean fewer errors when specifications change late in a program.</p>
<p>With DI-TOOLS integrated into their workflow, teams can trace requirements from layout to detail drawings and keep stakeholders aligned on a single source of truth.</p>
HTML,
            ],
            [
                'title' => 'Best Tugs Takes Hybrid Tow Tractors from Concept to Ramp-Up',
                'slug' => 'customer-story-best-tugs',
                'excerpt' => 'BestTugs brings hybrid vehicle innovation to the ramp with DI-TOOL-backed design, validation, and supplier-ready documentation.',
                'image' => 'https://www.3ds.com/assets/invest/styles/card/public/2025-08/best-tug-top-banner.jpg.webp?itok=cwyJ69xX',
                'order' => 5,
                'body' => <<<'HTML'
<p>BestTugs develops hybrid tow tractors where weight, thermal management, and safety systems must evolve together. DI-TOOL supports rapid iteration as powertrain and chassis teams converge on a buildable architecture.</p>
<p>From customer-specific options to certification packages, structured data and drawing automation reduce friction as production volumes increase.</p>
HTML,
            ],
        ];

        foreach ($posts as $row) {
            $alt = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
            $content = '<p><img src="' . $row['image'] . '" alt="' . $alt . '"></p>' . $row['body'];

            Post::updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'excerpt' => $row['excerpt'],
                    'content' => $content,
                    'status' => 'published',
                    'published_at' => now()->subDays(60 - (int) $row['order']),
                    'user_id' => $author->id,
                    'order' => (int) $row['order'],
                ]
            );
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
