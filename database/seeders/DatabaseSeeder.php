<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Package;
use App\Models\Pricing;
use App\Constants\GlobalConstant;
use App\Models\Type;
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
        $coreFreeType = Type::create(['name' => GlobalConstant::TYPE_CORE_FREE]);
        $packageType = Type::create(['name' => GlobalConstant::TYPE_PACKAGE]);
        $standAloneType = Type::create(['name' => GlobalConstant::TYPE_STAND_ALONE]);
        // Create categories
        Category::insert([
            ['name' => 'File Management', 'type_id' => $coreFreeType->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drawing & Export', 'type_id' => $packageType->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'iProperty & Quantity', 'type_id' => $standAloneType->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Assembly & Modeling', 'type_id' => $coreFreeType->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Advanced Tools', 'type_id' => $packageType->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // create products from CSV data
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
            ];
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
        //
        $advancedToolsCategory = Category::where('name', 'Advanced Tools')->first();
        $fileManagementCategory = Category::where('name', 'File Management')->first();
        $drawingExportCategory = Category::where('name', 'Drawing & Export')->first();
        $iPropertyCategory = Category::where('name', 'iProperty & Quantity')->first();
        $assemblyModelingCategory = Category::where('name', 'Assembly & Modeling')->first();

        // create packages from CSV (Basic, Professional, Premium bundles)
        $coreFreePkg = Package::create([
            'package_id' => 'PKG-' . strtoupper('core-free'),
            'name' => 'Core Free',
            'slug' => 'core-free',
            'description' => 'Essential tools for Core Free Inventor operations.',
            'avatar' => 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
            'images' => implode(',', [
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            ]),
            'type_id' => $coreFreeType->id,
        ]);
        $basicPkg = Package::create([
            'package_id' => 'PKG-' . strtoupper('basic'),
            'name' => 'Basic',
            'slug' => 'basic',
            'description' => 'Essential tools for basic Inventor operations.',
            'avatar' => 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
            'images' => implode(',', [
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            ]),
            'type_id' => $packageType->id,
        ]);

        $professionalPkg = Package::create([
            'package_id' => 'PKG-' . strtoupper('professional'),
            'name' => 'Professional',
            'slug' => 'professional',
            'description' => 'Comprehensive toolset for professional Inventor users.',
            'avatar' => 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
            'images' => implode(',', [
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            ]),
            'type_id' => $packageType->id,
        ]);

        $premiumPkg = Package::create([
            'package_id' => 'PKG-' . strtoupper('premium'),
            'name' => 'Premium',
            'slug' => 'premium',
            'description' => 'Complete premium service layer with all advanced tools.',
            'avatar' => 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            'video' => 'https://www.youtube.com/embed/4SOkxF6oeKI',
            'images' => implode(',', [
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
                'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png',
            ]),
            'type_id' => $packageType->id,
        ]);

        // Map products to packages based on CSV inclusion flags
        $basicProducts = [];
        $professionalProducts = [];
        $premiumProducts = [];
        $coreFreeProducts = [];

        foreach ($productRecords as $record) {
            if ($record['is_basic']) {
                $basicProducts[] = $record['model']->id;
            }
            if ($record['is_professional']) {
                $professionalProducts[] = $record['model']->id;
            }
            if ($record['is_premium']) {
                $premiumProducts[] = $record['model']->id;
            }
            if ($record['is_core_free']) {
                $coreFreeProducts[] = $record['model']->id;
            }
        }

        $coreFreePkg->products()->attach($coreFreeProducts);
        $basicPkg->products()->attach($basicProducts);
        $professionalPkg->products()->attach($professionalProducts);
        $premiumPkg->products()->attach($premiumProducts);

        // pricing for packages
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
            [
                'entity_id' => $basicPkg->id,
                'entity_type' => 'package',
                'duration_months' => 3,
                'price' => 179.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $basicPkg->id,
                'entity_type' => 'package',
                'duration_months' => 6,
                'price' => 449.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $basicPkg->id,
                'entity_type' => 'package',
                'duration_months' => 12,
                'price' => 999.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $professionalPkg->id,
                'entity_type' => 'package',
                'duration_months' => 3,
                'price' => 179.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $professionalPkg->id,
                'entity_type' => 'package',
                'duration_months' => 6,
                'price' => 449.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $professionalPkg->id,
                'entity_type' => 'package',
                'duration_months' => 12,
                'price' => 999.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $premiumPkg->id,
                'entity_type' => 'package',
                'duration_months' => 3,
                'price' => 179.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $premiumPkg->id,
                'entity_type' => 'package',
                'duration_months' => 6,
                'price' => 449.00,
                'currency' => 'EUR',
            ],
            [
                'entity_id' => $premiumPkg->id,
                'entity_type' => 'package',
                'duration_months' => 12,
                'price' => 999.00,
                'currency' => 'EUR',
            ],
        ]);
    }
}
