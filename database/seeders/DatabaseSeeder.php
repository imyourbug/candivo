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
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

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
