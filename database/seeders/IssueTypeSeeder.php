<?php

namespace Database\Seeders;

use App\Models\IssueType;
use App\Services\DiToolsManualAssetExtractor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IssueTypeSeeder extends Seeder
{
    /**
     * Seed issue types from DI-TOOLS manual posts (HTML descriptions).
     */
    public function run(): void
    {
        if (IssueType::query()->exists()) {
            return;
        }

        $csvPath = public_path('Di-Tools.csv');
        $packageData = self::parseIsToolZeroPackageData($csvPath);
        $packageNamesOrdered = $packageData['all_package_names'];
        if ($packageNamesOrdered === []) {
            throw new \RuntimeException('No packages found (IsTool = 0) in Di-Tools.csv.');
        }
        $validPackageNames = self::uniquePackageNamesPreserveOrder($packageNamesOrdered);
        $tierPackageNames = $packageData['tier_package_names'];
        if (count($tierPackageNames) !== 3) {
            throw new \RuntimeException('Expected exactly 3 Level-1 Package rows (Basic, Expert, Premium) in Di-Tools.csv, found '.count($tierPackageNames).'.');
        }
        $toolToParentPackages = self::toolToParentPackagesFromCsv($csvPath, $validPackageNames, $tierPackageNames);

        $packageRoots = [];
        foreach ($validPackageNames as $index => $pkgName) {
            $packageRoots[$pkgName] = IssueType::create([
                'name' => $pkgName,
                'slug' => Str::slug($pkgName),
                'sort_order' => $index,
                'has_url' => false,
                'parent_id' => null,
            ]);
        }

        Storage::disk('public')->deleteDirectory('help-manual');

        $docxPath = public_path('Di-Tools Manual_Ver01.docx');
        if (! is_file($docxPath)) {
            throw new \RuntimeException('Manual DOCX not found at: '.$docxPath);
        }

        $imageMap = (new DiToolsManualAssetExtractor)->extract($docxPath);

        $posts = [
            [
                'name' => 'COPY DRAWING OBJECTS',
                'slug' => 'copy-drawing-objects',
                'has_url' => true,
                'sort_order' => 0,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Copy Drawing Objects tool allows users to copy title blocks and borders from a specified template to selected drawings. Additionally, it provides an option to clean custom title blocks and borders before copying new ones.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Toolbar</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Open Template</span><span class="text-slate-600 dark:text-slate-400">: Click this button to browse and select a drawing template.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Load Template</span><span class="text-slate-600 dark:text-slate-400">: Reload the current template.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Object Selection</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Title Blocks</span><span class="text-slate-600 dark:text-slate-400">: Choose a title block from the dropdown list.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Borders</span><span class="text-slate-600 dark:text-slate-400">: Choose a border from the dropdown list.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Clean all custom title blocks and borders in selected drawings</span><span class="text-slate-600 dark:text-slate-400">: Enable this checkbox to remove existing custom title blocks and borders before applying the new ones.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">File Management</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Add Files</span><span class="text-slate-600 dark:text-slate-400">: Click to add drawing files to the list.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Past Files from Clipboard</span><span class="text-slate-600 dark:text-slate-400">: Click to remove a selected file from the list.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Clear File List</span><span class="text-slate-600 dark:text-slate-400">: Click to remove all files from the list.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(9) Copy</span><span class="text-slate-600 dark:text-slate-400">: Start the process of copying the selected objects to the drawings.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(10) Close</span><span class="text-slate-600 dark:text-slate-400">: Exit the tool.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(11) Help</span><span class="text-slate-600 dark:text-slate-400">: Open this user guide.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Click Open Template (1) and select a drawing template.</li><li class="leading-relaxed">Choose the desired Title Block (3) and Border (4).</li><li class="leading-relaxed">(Optional) Enable Clean all custom title blocks and borders (5) if necessary.</li><li class="leading-relaxed">Add drawing files using Add Files (6).</li><li class="leading-relaxed">Click Copy (9) to apply the changes.</li><li class="leading-relaxed">Review the status of each file in the list.</li><li class="leading-relaxed">Click Close (10) to exit when done.</li><li class="leading-relaxed">This tool streamlines the process of updating multiple drawings efficiently.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure that all selected drawing files are accessible and not open in another application.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">If any errors occur during the process, check the "Status" column for details.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'MOVE FILE',
                'slug' => 'move-file',
                'has_url' => true,
                'sort_order' => 1,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Move Files tool allows users to move selected files to a specified target folder. Additionally, it provides an option to include associated drawings when moving files.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Toolbar</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Browse Target Folder</span><span class="text-slate-600 dark:text-slate-400">: Click this button to select the destination folder.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Including associated drawings when moving</span><span class="text-slate-600 dark:text-slate-400">: Enable this checkbox to move related drawing files along with the selected files.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">File Management</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Add Files</span><span class="text-slate-600 dark:text-slate-400">: Click to add files to the list.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Paste Files from Clipboard</span><span class="text-slate-600 dark:text-slate-400">: Click to paste copied file paths into the list.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Clear File List</span><span class="text-slate-600 dark:text-slate-400">: Click to remove all files from the list.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Move</span><span class="text-slate-600 dark:text-slate-400">: Start the process of moving the selected files.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Close</span><span class="text-slate-600 dark:text-slate-400">: Exit the tool.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Help</span><span class="text-slate-600 dark:text-slate-400">: Open this user guide.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Click the Browse Target Folder (1) and select the destination folder.</li><li class="leading-relaxed">(Optional) Enable Including associated drawings when moving (2) if necessary.</li><li class="leading-relaxed">Add files using Add Files (3).</li><li class="leading-relaxed">Click Move (6) to transfer the files.</li><li class="leading-relaxed">Review the status of each file in the list.</li><li class="leading-relaxed">Click Close (7) to exit when done.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure that all selected files are accessible and not open in another application.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">If any errors occur during the process, check the "Status" column for details.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'CREATE DRAWING',
                'slug' => 'create-drawing',
                'has_url' => true,
                'sort_order' => 2,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Create Drawing tool allows users to generate 2D drawings from 3D Inventor models using a selected template. It includes options for automatic dimensions, view orientation, and file handling behavior.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Template Selection</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Template</span><span class="text-slate-600 dark:text-slate-400"> – Specify the path to the drawing template (.idw or .dwg) used to create the new drawings. Click Browser to select a file.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Options Panel</span><span class="text-slate-600 dark:text-slate-400"> – Configure default drawing behaviors</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Create overall dimensions – Adds bounding dimensions automatically.</li><li class="text-sm leading-relaxed py-0.5">Close drawing when completed – Auto-closes drawing files after creation.</li><li class="text-sm leading-relaxed py-0.5">Auto Save – Saves drawing files automatically after generation.</li><li class="text-sm leading-relaxed py-0.5">Base View – Choose the base view orientation (Auto, Front, Top, Right, etc.).</li><li class="text-sm leading-relaxed py-0.5">Component Type – Choose between Part or Assembly.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">File Names List</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) File Table</span><span class="text-slate-600 dark:text-slate-400"> – Displays the files being processed</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">File Name – Name of the model to draw.</li><li class="text-sm leading-relaxed py-0.5">Open – Indicates whether the file is currently open.</li><li class="text-sm leading-relaxed py-0.5">Status – Shows results (e.g., Success, Error, In Progress).</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Assembly Loader</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Load File From Assembly</span><span class="text-slate-600 dark:text-slate-400"> – Allows batch loading of files directly from an assembly to auto-create drawings for each component.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Orientation Tools</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Look At</span><span class="text-slate-600 dark:text-slate-400"> – View control buttons</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Set as Front – Assign current view as front.</li><li class="text-sm leading-relaxed py-0.5">Set as Top – Assign current view as top. These are used to control base view orientation manually.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Run</span><span class="text-slate-600 dark:text-slate-400"> – Start the drawing creation process.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Access this guide or get quick tips about how to use the tool.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select a drawing template (1).</li><li class="leading-relaxed">Adjust options like dimensions, base view, and auto-save (2).</li><li class="leading-relaxed">Past the File Names of Part or Assembly (CTRL) or if you are opening an assembly, you can use Load files or use Load File From Assembly (4) to populate the table.</li><li class="leading-relaxed">Use Look At tools (5) if you need to redefine front/top views.</li><li class="leading-relaxed">Click Run (6) to generate drawings.</li><li class="leading-relaxed">Click Close (7) when done.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Make sure your template includes desired title blocks and standards.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">When working with large assemblies, Auto Save and Close drawing help streamline batch generation.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT TO PDF [DWG]',
                'slug' => 'export-to-pdf-dwg',
                'has_url' => true,
                'sort_order' => 3,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export to PDF tool allows users to export drawings to PDF or DWG format with customizable options, including sheet selection, file naming, stamping, and additional export settings.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Toolbar</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Browse Target Folder</span><span class="text-slate-600 dark:text-slate-400">: Click this button to select the destination folder for the exported files.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Custom File Name</span><span class="text-slate-600 dark:text-slate-400">: Update or define the custom file name format. You can load and save the format using the adjacent buttons.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Format</span><span class="text-slate-600 dark:text-slate-400">: Select one or both output types:• Export to PDF• Export to DWG</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Drawing File Management</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Add From Folder Add multiple drawings from a selected folder.</span></li>
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Load By  i Properties (Only works when an assembly is opened)</span></li>
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Paste From Clipboard Paste file paths directly from clipboard into the list.</span></li>
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Clear Remove all files from the current list.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">File Settings</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Detect and Add File Extension Automatically Automatically append the correct file extension (.pdf or .dwg) based on your export selection.</span></li>
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">File Settings</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Review All File Names</li><li class="text-sm leading-relaxed py-0.5">Combine PDF</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Auto Replace Old Files</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Print Range</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">All Sheets</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Sheets In Range (manually define range using the input boxes)</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">PDF Settings</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">All Color As Black</li><li class="text-sm leading-relaxed py-0.5">Remove Object Line Weights</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Show Stamp Texts</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Display Settings</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Display Published File in Viewer</li><li class="text-sm leading-relaxed py-0.5">Show Drawing When Opening</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(13) Export</span><span class="text-slate-600 dark:text-slate-400">: Start the export process for all listed files.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(14) Close</span><span class="text-slate-600 dark:text-slate-400">: Exit the tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">TEMP</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Stamp Table</span><span class="text-slate-600 dark:text-slate-400">: Displays the list of stamp items to be applied. Each row allows you to configure the following properties</span></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Text: The content of the stamp (can include i Properties).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Font: The font type used for the text.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Font Size: The size of the text.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Color: The color of the text.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Position [X], [Y]: The coordinates on the drawing where the stamp will be placed.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Rotation: The angle of rotation for the text.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Text Alignment: Horizontal or vertical alignment of the text.</p>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Add Row</span><span class="text-slate-600 dark:text-slate-400">: Add a new row to the stamp table for defining a new text stamp.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Save Template</span><span class="text-slate-600 dark:text-slate-400">: Save the current list of stamps and their configurations as a template.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Load Template</span><span class="text-slate-600 dark:text-slate-400">: Load a previously saved stamp template to reuse common setups.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps – Main Tab</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Click Browse Target Folder to select where the exported PDFs will be saved.</li><li class="leading-relaxed">(Optional) Enter a Custom File Name.</li><li class="leading-relaxed">Configure export options based on your requirements.</li><li class="leading-relaxed">Add drawing files using Select from Folder/ Load from i Properties/Paste from Clipboard.</li><li class="leading-relaxed">Click Export to start exporting the drawings to PDF.</li><li class="leading-relaxed">Review the status of each file in the list.</li><li class="leading-relaxed">Click Close to exit when done.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure that all selected drawing files are accessible and not open in another application.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">If any errors occur during the process, check the "Status" column for details.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps – Temp Tab</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Use Add Row to create a new stamp.</li><li class="leading-relaxed">Fill in the details for Text, Font, Size, Color, Position, and Rotation in the Stamp Table.</li><li class="leading-relaxed">Use the &lt;#Property Name&gt; format to pull i Properties from the drawing.</li><li class="leading-relaxed">For drawing properties: &lt;#Property Name&gt;</li><li class="leading-relaxed">For referenced model properties: &lt;Property Name&gt;</li><li class="leading-relaxed">Save the configuration using Save Template if needed.</li><li class="leading-relaxed">Reuse saved settings using Load Template`.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">To reference drawing i Properties, use: &lt;#Property Name&gt;</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">To reference model (Part/Assembly/Presentation) i Properties, use: &lt;Property Name&gt;</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The referenced model is taken from the first view on the drawing.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT PDF SET',
                'slug' => 'export-pdf-set',
                'has_url' => true,
                'sort_order' => 4,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export to PDF Set tool automates batch exporting of Inventor drawings to PDF format based on part/assembly categories and customizable sheet range and naming rules. This is especially useful for organizing production sets by category.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Target Folder</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click the folder icon to select where exported PDF files will be saved.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Custom File Name</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Define the file naming format. Use &lt;Property Name&gt; tags or fixed text.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use the Save and Load buttons to manage file name templates.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Options – Sheet Range</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">All Sheets: Export all sheets from each drawing.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Sheets in Range From–To: Export a selected range of sheets (e.g., only sheet 1 or 1–2).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Optionally check Review all file names to confirm before exporting.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Category – Parts &amp; Assemblies</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Enter a keyword (e.g., C1, CIN, ASSY, etc.) and click Add to define which categories to include in the export.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">List of Assemblies</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This table displays the drawing files matching the selected categories. It includes:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Item: Row index</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">File Name: Name of the drawing</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Status: Export status (Success, Error, etc.)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Clear</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Clears all selected categories and file lists.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Export</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Begins exporting drawings to PDF using the specified folder, naming format, sheet settings, and categories.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Close</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Exits the tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help Icon</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Open this user guide or shows tooltips for quick reference.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Advanced Tab Load by Property (This function is only work when open an assembly)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Property Selection:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Choose the i Property you want to filter by (e.g., Category, Keywords, …). Once selected, click Apply to display all available values for that property.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Value: After applying the property filter, this field displays all available values. You can select one or multiple values from the list.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Load: After choosing the property and selecting the values, click Load to populate the drawing list on the Main tab with files that match the selected criteria.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Set the Target Folder (1) to store exported PDFs.</li><li class="leading-relaxed">Define the Custom File Name (2) or load an existing template.</li><li class="leading-relaxed">Choose to export All Sheets or a Sheet Range (3).</li><li class="leading-relaxed">Enter and add Part and Assembly categories (4) to filter files.</li><li class="leading-relaxed">Review the List of Assemblies (5) to be exported.</li><li class="leading-relaxed">Click Export (7) to start the batch export.</li><li class="leading-relaxed">Use Clear (6) to reset inputs or Close (8) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool is optimized for Da Cu3D-style category structures.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The naming template supports i Property-driven automation.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Exported PDFs follow consistent naming and folder structure for easy project documentation.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT PDF SERIES',
                'slug' => 'export-pdf-series',
                'has_url' => true,
                'sort_order' => 5,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export PDF Series tool enables batch-exporting of drawings to PDF format based on custom i Property filters. It supports full or partial sheet exports and organizes output using configurable paths.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Export Location</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Location</span><span class="text-slate-600 dark:text-slate-400"> – Set the folder where all exported PDFs will be saved. Use the Browser button to select the directory.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Load By Property</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Property Filter</span><span class="text-slate-600 dark:text-slate-400"> – Export files based on a selected i Property</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Property – Choose a custom property such as Category, Project, or Material.</li><li class="text-sm leading-relaxed py-0.5">Value – Define one or more values (e.g., C1, Mech) to filter target drawings.</li><li class="text-sm leading-relaxed py-0.5">Apply – Load matching files based on the selected property and values.</li></ul></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Options</li><li class="text-sm leading-relaxed py-0.5">All sheets – Export all sheets in each drawing.</li><li class="text-sm leading-relaxed py-0.5">Sheets in range – Export only a specific range (e.g., from Sheet 1 to 2).</li></ul></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Set the From and To fields to define the sheet range.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Export</span><span class="text-slate-600 dark:text-slate-400"> – Begin the batch export process using current filters and settings.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Opens this guide or in-app tips for assistance.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the export Location (1) where PDF files will be saved.</li><li class="leading-relaxed">Use the Property dropdown (2) to choose a filtering i Property (e.g., Category).</li><li class="leading-relaxed">Enter one or more Values and click Apply.</li><li class="leading-relaxed">Choose whether to export All sheets or define a Sheet range (3).</li><li class="leading-relaxed">Click Export (4) to begin the process.</li><li class="leading-relaxed">Click Close (5) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ideal for organized exports by category, project, or status.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Each drawing is exported into the selected folder with naming retained.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure the property and value combinations are correctly set to match files.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT TO DXF',
                'slug' => 'export-to-dxf',
                'has_url' => true,
                'sort_order' => 6,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export to DXF tool allows users to export flat patterns or sheet metal parts from Inventor into DXF format. This version provides a streamlined interface for selecting files, defining file naming patterns, applying a drawing template, and configuring export behaviors.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Toolbar</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Drawing Template</span><span class="text-slate-600 dark:text-slate-400">: Select a drawing template file to control the exported DXF layout.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Target Folder</span><span class="text-slate-600 dark:text-slate-400">: Click the folder icon to choose where exported DXF files will be saved.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Custom File Nam</span><span class="text-slate-600 dark:text-slate-400">: Define a file naming pattern for your exported DXF files.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Refresh File Name</span><span class="text-slate-600 dark:text-slate-400">: Reload the custom name field using current data.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Save Settings</span><span class="text-slate-600 dark:text-slate-400">: Save the current export configuration (template, folder, name format, etc.).</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Load Settings</span><span class="text-slate-600 dark:text-slate-400">: Load previously saved settings.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">File Management</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Add from Folder</span><span class="text-slate-600 dark:text-slate-400">: Load parts from a selected folder.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Load by i Properties</span><span class="text-slate-600 dark:text-slate-400">: only works when assembly is opened.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(9) Paste from Clipboard</span><span class="text-slate-600 dark:text-slate-400">: Paste file paths copied from the clipboard.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(10) Clear List</span><span class="text-slate-600 dark:text-slate-400">: Remove all parts from the list.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(11) Reload File List</span><span class="text-slate-600 dark:text-slate-400">: Update the list view or refresh file status and properties.</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Options (12)</li></ul></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Preview All Component Names: View all component names before exporting.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Show Hidden Lines: Include hidden geometry in the DXF output.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Create Right View: Add a right-side view in addition to the flat pattern view.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Thumbnail (13)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Displays a preview image of the selected part (if available).</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Export Settings</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(14) Export All Views to One DXF</span><span class="text-slate-600 dark:text-slate-400">: Combine multiple views into a single DXF file.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(15) Place View (Export)</span><span class="text-slate-600 dark:text-slate-400">: Start place all flat views into a DXF drawing template before Export.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(16) Close</span><span class="text-slate-600 dark:text-slate-400">: Exit the Export to DXF tool.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(17) Help</span><span class="text-slate-600 dark:text-slate-400">: Opens this guide or in-app tips for assistance.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps – Main Tab</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Click Drawing Template (1) to choose a layout file.</li><li class="leading-relaxed">Set the Target Folder (2) to specify the save location.</li><li class="leading-relaxed">Enter a Custom File Name (3) or preview  it with (4).</li><li class="leading-relaxed">Use (5) to save your current configuration, or (6) to load a previous one.</li><li class="leading-relaxed">Add parts with (7), (8), or (9). Use (10) to clear the list if needed.</li><li class="leading-relaxed">Refresh the part list with (11).</li><li class="leading-relaxed">Configure options under (12) such as hidden lines and right views.</li><li class="leading-relaxed">(Optional) View part thumbnails in section (13).</li><li class="leading-relaxed">Enable (14) to export all views into one DXF file.</li><li class="leading-relaxed">Click Place View (15) to add views into drawing and then Export (15) to generate the DXF files.</li><li class="leading-relaxed">Click Close (16) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Drawing templates control layout, view styles in exported DXFs.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Previewing component names is helpful for validation before export.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure selected parts support flat pattern export for DXF generation.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use hidden line options and view controls to match manufacturing needs.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The tool supports batch operations for efficient multi-part processing.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT TO STP',
                'slug' => 'export-to-stp',
                'has_url' => true,
                'sort_order' => 7,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export to STP tool allows users to export component files to STEP format (.stp or .step) in batch mode. It includes options for customizing file names, managing file lists, previewing file status, and applying consistent export settings.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">1. Toolbar</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Target Folder</span><span class="text-slate-600 dark:text-slate-400">: Choose where the exported STEP files will be saved.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Custom File Name</span><span class="text-slate-600 dark:text-slate-400">: Enter a naming pattern to apply to the exported files.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Refresh File Name</span><span class="text-slate-600 dark:text-slate-400">: Reload the custom name field using updated model data.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Save Settings</span><span class="text-slate-600 dark:text-slate-400">: Save the current export configuration for reuse.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Load Settings</span><span class="text-slate-600 dark:text-slate-400">: Load previously saved export settings.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">File Management</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Add from Folder</span><span class="text-slate-600 dark:text-slate-400">: Load parts from a selected folder.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Load by i Properties</span><span class="text-slate-600 dark:text-slate-400">: only works when assembly is opened.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Paste from Clipboard</span><span class="text-slate-600 dark:text-slate-400">: Paste file paths copied to your clipboard.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(9) Clear List</span><span class="text-slate-600 dark:text-slate-400">: Remove all files from the current list.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(10) Review All Component Names</span><span class="text-slate-600 dark:text-slate-400">: Show and review all component names before exporting.</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Thumbnail (11)</li></ul></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Preview image of the selected part or assembly file (if available).</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(12) Export</span><span class="text-slate-600 dark:text-slate-400">: Start the STEP export process using the selected settings.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(13) Close</span><span class="text-slate-600 dark:text-slate-400">: Exit the Export to STP tool.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(14) Help</span><span class="text-slate-600 dark:text-slate-400">: Opens this guide or in-app tips for assistance.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Set the Target Folder (1) for saving your STEP files.</li><li class="leading-relaxed">Enter a Custom File Name (2).</li><li class="leading-relaxed">(Optional) Save your current setup using (4), or load a saved one with (5).</li><li class="leading-relaxed">Add files using (6), (7), or (8). Use (9) to clear the list.</li><li class="leading-relaxed">Enable the option Review All Component Names (10) if needed.</li><li class="leading-relaxed">(Optional) Preview files using the Thumbnail (11) area.</li><li class="leading-relaxed">Click Export (12) to start exporting to STEP.</li><li class="leading-relaxed">Click Close (13) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Only supported Inventor part or assembly files can be exported.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">File names will follow the pattern defined in the Custom File Name field.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The status column will indicate success or error for each file.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use the settings buttons to ensure consistent exports across sessions.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT TO BIM',
                'slug' => 'export-to-bim',
                'has_url' => true,
                'sort_order' => 8,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export to BIM tool allows users to export Inventor components to Revit Family format (.rfa). It includes options for file naming, model state selection, insertion point control, and property assignment, making it easier to prepare components for BIM workflows.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Toolbar</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Target Folder</span><span class="text-slate-600 dark:text-slate-400">: Select the destination where Revit Family files will be saved.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Custom File Name</span><span class="text-slate-600 dark:text-slate-400">: Define the export file name using fixed text or property placeholders.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) File Extension</span><span class="text-slate-600 dark:text-slate-400">: Select .rfa as the export format (default).</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Refresh File Name</span><span class="text-slate-600 dark:text-slate-400">: Reload the file name using the current component or property data.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Save Settings</span><span class="text-slate-600 dark:text-slate-400">: Save the current export configuration for future reuse.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Load Settings</span><span class="text-slate-600 dark:text-slate-400">: Load previously saved export settings.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">List of Components</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Add from Folder</span><span class="text-slate-600 dark:text-slate-400">: Load parts from a selected folder.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Load by i Properties</span><span class="text-slate-600 dark:text-slate-400">: only works when assembly is opened.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(9) Paste from Clipboard</span><span class="text-slate-600 dark:text-slate-400">: Add file paths copied from clipboard into the list.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(10) Clear List</span><span class="text-slate-600 dark:text-slate-400">: Remove all components from the list.</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Options (11)</li></ul></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Review All Component Names: Enable to review and confirm file names before export.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Models (12)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Model State: Select the desired model state to export for each component.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Insert Point: Define the insertion point used in the exported Revit file.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Properties (13)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Get Model Properties: Extract and list available i Properties from the selected component.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Clear Selection: Deselect all chosen properties.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(14) Export</span><span class="text-slate-600 dark:text-slate-400">: Start the export process to generate .rfa files.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(15) Close</span><span class="text-slate-600 dark:text-slate-400">: Exit the Export to BIM tool.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(16) Help</span><span class="text-slate-600 dark:text-slate-400">: Opens this guide or in-app tips for assistance.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps – Main Tab</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Set the Target Folder (1) for the exported .rfa files.</li><li class="leading-relaxed">Define a Custom File Name (2).</li><li class="leading-relaxed">Save or load export settings using (5) and (6).</li><li class="leading-relaxed">Add components using (7), (8), or (9). Use (10) to clear the list.</li><li class="leading-relaxed">(Optional) Enable Review All Component Names (11).</li><li class="leading-relaxed">Select a Model State and Insert Point (12).</li><li class="leading-relaxed">Click Get Model Properties (13) to retrieve and assign i Properties.</li><li class="leading-relaxed">Click Export (14) to start exporting the files.</li><li class="leading-relaxed">Press Close (15) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Only compatible Inventor components will be exported to Revit Family format.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Custom file naming supports property-driven automation.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use model states and insert points to optimize Revit placement behavior.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">i Properties can be used to transfer metadata into the BIM environment.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The status bar shows progress and any warnings or errors during export.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'COMPONENT SIZE',
                'slug' => 'component-size',
                'has_url' => true,
                'sort_order' => 9,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Component Size tool analyzes and extracts size-related information from Inventor parts. It can calculate dimensions, assign property names, and output values based on different measurement settings.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface – Main Tab</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Options (1) - Enable or disable the following data extractions:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Auto Thickness – Automatically detect the material thickness of each part.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Min Bounding Box – Calculate the smallest bounding box that contains the geometry.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Flat Pattern Size – Capture the size dimensions of the flat pattern.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Flat Pattern Extent – Record the extents of the flat pattern view.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">2. Files</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Load by i Properties</span><span class="text-slate-600 dark:text-slate-400">: only works when assembly is opened.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Clear</span><span class="text-slate-600 dark:text-slate-400"> – Remove all files from the list.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">3. Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Run</span><span class="text-slate-600 dark:text-slate-400"> – Start processing all listed files using the selected options.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Component Size tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">4. Status Bar</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Status</span><span class="text-slate-600 dark:text-slate-400"> – Displays the current tool status (e.g., “Ready”, “Processing”, or errors).</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the options you want enabled under the Options (1) section.</li><li class="leading-relaxed">Add files to the list using Add File (2) or clear them with (3).</li><li class="leading-relaxed">Click Run (4) to begin extracting the size data.</li><li class="leading-relaxed">Monitor progress and results in the Status column.</li><li class="leading-relaxed">Click Close (5) to exit when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Only part files are supported; assemblies will be ignored.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Flat pattern options apply only to sheet metal parts with valid flat pattern definitions.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Extracted results can be used for BOM, nesting, or documentation purposes.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Settings Tab</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Property Name Configuration: (1) Property Groups:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Tool: Assign name for Auto Thickness property.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Normal [Min Box]: Assign property names for standard thickness, width, and length.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Flat Pattern [Min Box]: Assign property names for flat pattern thickness, width, and length.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Flat Pattern Extents [Default]: Assign property names for width related to Y axis, length width related to X axis, and area.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Measurement Settings</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(2) Linear Units: Select the unit (e.g., millimeter) and precision for linear values.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(3) Area Units: Select the unit (e.g., square millimeter) and precision for area measurements.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Actions</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(4) Default – Reset all fields to the default naming.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(5) Save – Save current settings for future sessions.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'NAME BODIES',
                'slug' => 'name-bodies',
                'has_url' => true,
                'sort_order' => 10,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Name Bodies tool allows users to generate standardized body names using a combination of prefixes, digits, and suffixes. It also checks for existing file names in the working folder to avoid duplication.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Name Formatting</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Prefix</span><span class="text-slate-600 dark:text-slate-400"> – Enter the text to appear at the beginning of each body name.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Digit</span><span class="text-slate-600 dark:text-slate-400"> – Set the number of digits for the numbering sequence (e.g., 2 → 01, 02, 03).</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Suffix</span><span class="text-slate-600 dark:text-slate-400"> – Enter the text to appear at the end of each body name.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) File Name Check</span><span class="text-slate-600 dark:text-slate-400"> – When enabled, the tool verifies if a body name already exists files in the working folder to prevent conflicts.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Apply</span><span class="text-slate-600 dark:text-slate-400"> – Apply the naming convention to all selected bodies.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Name Bodies dialog.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Open this user guide or view tooltip descriptions.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Enter a Prefix (1) and optionally a Suffix (3).</li><li class="leading-relaxed">Choose the desired Digit length (2) for automatic numbering.</li><li class="leading-relaxed">Check the Options (4) box to prevent overwriting existing names.</li><li class="leading-relaxed">Click Apply (5) to rename all selected bodies.</li><li class="leading-relaxed">Click Close (6) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The tool will generate names like PL-01-A, PL-02-A if Prefix = PL-, Digit = 2, Suffix = -A.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">If a name already exists and the option is checked, that body will be skipped or flagged.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'CUSTOM QUANTITY',
                'slug' => 'custom-quantity',
                'has_url' => true,
                'sort_order' => 11,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Custom Quantity tool allows users to define a quantity property based on conditions applied to part properties. This enables dynamic BOM (Bill of Materials) management, tailored to project-specific rules.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Quantity Settings</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Component Type</span><span class="text-slate-600 dark:text-slate-400"> – Choose the type of components the rule applies to (e.g., All, Parts only, Assemblies only).(2) Qty Property Name – Enter the name of the custom quantity property to be calculated (e.g., Project Qty).</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Conditions Panel</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Property Name</span><span class="text-slate-600 dark:text-slate-400"> – Select the i Property to filter components (e.g., Material, Category). Value(s) – Enter one or more matching values that define the condition for inclusion in the quantity calculation.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Add Value</span><span class="text-slate-600 dark:text-slate-400"> – Add a new value to the list of condition values.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Clear</span><span class="text-slate-600 dark:text-slate-400"> – Clear the list of added values.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Get</span><span class="text-slate-600 dark:text-slate-400"> – Apply the condition and compute the custom quantity values.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Custom Quantity tool.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Open this user guide or show tooltips for more information.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the Component Type (1) to define the target scope.</li><li class="leading-relaxed">Enter a Qty Property Name (2) that will store the calculated quantity.</li><li class="leading-relaxed">In the Conditions section:</li><li class="leading-relaxed">Choose a Property Name (3).</li><li class="leading-relaxed">Enter one or more Value(s) and click Add Value (4).</li><li class="leading-relaxed">Click Get (6) to calculate and assign the custom quantity property.</li><li class="leading-relaxed">Click Clear (5) to reset the condition values if needed.</li><li class="leading-relaxed">Click Close (7) to exit.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The assigned quantity appears in the selected i Property of each component.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use this tool to control part quantities in drawings, schedules, or Parts lists.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Supports multi-condition evaluation for advanced filtering.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'SUM QTY',
                'slug' => 'sum-qty',
                'has_url' => true,
                'sort_order' => 12,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Sum Qty tool totals quantities from components based on a specific property. It’s useful for accumulating custom quantity values (e.g., Project Qty) into a summary property in assemblies or parts.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Property Selection</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Total Qty Property Name</span><span class="text-slate-600 dark:text-slate-400"> – Select the property that will store the total summed value (e.g., Total Qty, Sum Project Qty).</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Run With Property Contains</span><span class="text-slate-600 dark:text-slate-400"> – Filter which components to include in the sum based on whether their properties contain a specific string. (e.g., &lt;Qty1&gt;+&lt;Qty2&gt;….).</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Sum</span><span class="text-slate-600 dark:text-slate-400"> – Run the calculation and assign the total quantity to the selected property.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Sum Qty tool.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Open this user guide or display in-tool help messages.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Choose the Total Qty Property Name (1) where the summed result will be stored.</li><li class="leading-relaxed">Enter Run With Property Contains filter (2) to restrict which components are included in the calculation.</li><li class="leading-relaxed">Click Sum (3) to begin the calculation.</li><li class="leading-relaxed">View results or errors in the Status panel.</li><li class="leading-relaxed">Click Close (4) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool works well in combination with the Custom Quantity tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The filter in (2) allows partial matching of property values for flexible control.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use this tool to summarize values into a parent component or main assembly property.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'DRAWING STATUS',
                'slug' => 'drawing-status',
                'has_url' => true,
                'sort_order' => 13,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Update Drawing Status tool checks the status of drawing files by comparing part properties with drawing filenames, helping to validate or synchronize drawing documentation across your project directory. It allows you to define the search path, select the custom property to check, and choose the naming structure to analyze.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Working Location</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Enter or browse to the folder where drawing files are stored.</span></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This location is deeply searched to speed up drawing checks.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Custom Property</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Select the i Property (custom property) used to determine the drawing’s status (e.g., _Drawing Status).</span></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This property is compared between the part and the drawing.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Drawing Name Structure</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Choose how drawing filenames are structured, such as &lt;Part Number&gt; or another naming pattern.</span></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This helps the tool match part files to their corresponding drawings.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Check</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Run the comparison process.</span></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The tool will find the related drawing files and compare their status.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Close</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Exit the tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Click the Help icon to view this guide or get contextual help for each feature.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Specify the Working Location (1) by typing the path or clicking Browse.</li><li class="leading-relaxed">Select the relevant Custom Property (2) that stores the drawing status.</li><li class="leading-relaxed">Choose the appropriate Drawing Name Structure (3) to ensure correct matching.</li><li class="leading-relaxed">Click Check (4) to start the verification process.</li><li class="leading-relaxed">Review the results and take action if inconsistencies are found.</li><li class="leading-relaxed">Click Close (5) when done.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure that part and drawing files follow consistent naming conventions for best results.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool is especially useful for large projects where manual tracking is inefficient.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use the Help icon (6) for additional guidance or troubleshooting tips.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'UPDATE PROPERTY',
                'slug' => 'update-property',
                'has_url' => true,
                'sort_order' => 14,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Update Properties tool allows you to batch-update i Properties for multiple components. You can optionally filter the updates using specific property conditions and customize how the update behaves.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Property Assignment</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Update to Property</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Name – Select the i Property you want to update (e.g., Material, Project, Status).</li><li class="text-sm leading-relaxed py-0.5">Value – Enter or select the new value to assign to the selected property.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Conditional Filter (Optional)</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Run With Property Contains</span></li>
</ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Enable the checkbox to activate conditional filtering.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Name – Choose the property to be checked.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Value – Enter a value substring to filter matching components (e.g., only apply to parts with Category = Sheet Metal).</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Update Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Options Dropdown</span><span class="text-slate-600 dark:text-slate-400"> – Choose behavior such as</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Update</li><li class="text-sm leading-relaxed py-0.5">Delete</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Update</span><span class="text-slate-600 dark:text-slate-400"> – Execute the property update based on your selections.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Open this user guide or view inline help/tips for each option.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">In the Update to Property section (1), select the property and value to apply.</li><li class="leading-relaxed">(Optional) Enable and configure Run With Property Contains (2) to limit updates to matching files.</li><li class="leading-relaxed">Choose additional behavior from the Options dropdown (3).</li><li class="leading-relaxed">Click Update (4) to apply changes.</li><li class="leading-relaxed">Click Close (5) to exit.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool helps ensure consistency across large assemblies or libraries.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Filters are useful for avoiding accidental changes to unintended components.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use the Help icon (6) to understand each option more clearly before applying.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'GET SURFACE AREA',
                'slug' => 'get-surface-area',
                'has_url' => true,
                'sort_order' => 15,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Get Surface Area tool calculates the surface area of parts and presents the result in a selected unit and precision format. It helps you quickly extract surface values for material estimation or documentation.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">1. Measurement Settings</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Unit</span><span class="text-slate-600 dark:text-slate-400"> – Select the desired unit for the calculated surface area (e.g., m2, cm2, mm2).</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Decimal</span><span class="text-slate-600 dark:text-slate-400"> – Choose the number of decimal places to display in the result (e.g., 0–5 digits).</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">2. Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Run</span><span class="text-slate-600 dark:text-slate-400"> – Calculate the surface area using the selected unit and decimal format.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Get Surface Area tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">3. Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Opens this user guide or provides additional usage information.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Choose the Unit (1) to define the output measurement (e.g., square meters).</li><li class="leading-relaxed">Set the Decimal (2) precision for rounding results.</li><li class="leading-relaxed">Click Run (3) to compute and display the surface area.</li><li class="leading-relaxed">Click Close (4) to exit the tool.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool works best on solid bodies or surfaces with visible geometry.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'STANDARD PROPERTIES',
                'slug' => 'standard-properties',
                'has_url' => true,
                'sort_order' => 16,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Standard Properties tool allows users to batch-assign or update multiple i Properties for selected components. It supports conditional filtering, import/export of property sets, component type filtering, and a visibility filter to apply changes only to visible components.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Options (1)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Only visible components in assembly - When checked, the tool only applies updates to components currently visible in the active Inventor assembly.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Properties Table (2)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Property to Set - The i Property to apply the value to (e.g., Stock Number).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Value to Apply - The value to assign, which can include formulas like &lt;_Width&gt;x&lt;_Thickness&gt;.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Condition Property - The property used for filtering (e.g., Keywords).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Condition Value - Value(s) to match from the Condition Property to apply the update.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Status - Displays the update result after pressing Run.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Action Buttons</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Add Row (3) - Add a new i Property rule to the list.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Export (4) - Save the current property rules to a file.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Import (5) - Load saved property rules from a file.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Run (6) - Execute the update on all listed components.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Close (7) - Exit the tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help Icon (8): Opens this user guide or in-app instructions.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Check Only visible components in assembly (1) if you want to limit updates to visible parts.</li><li class="leading-relaxed">Use Add Row (3) to define a property and its conditional update.</li><li class="leading-relaxed">Enter:</li><li class="leading-relaxed">Property to Set (e.g., Stock Number)</li><li class="leading-relaxed">Value to Apply (e.g., =&lt;_Width&gt;x&lt;_Thickness&gt; or =&lt;_Auto Thickness&gt;)</li><li class="leading-relaxed">Condition Property (e.g., Keywords)</li><li class="leading-relaxed">Condition Value (e.g., Plaat, Trede)</li><li class="leading-relaxed">Repeat step 2–3 for additional rules.</li><li class="leading-relaxed">Click Run (6) to apply all updates.</li><li class="leading-relaxed">Use Export (4) to save configurations or Import (5) to reuse existing ones.</li><li class="leading-relaxed">Click Close (7) to exit.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use formulas in Value to Apply for dynamic property generation.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Multiple values in Condition Value can be separated by commas (,).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Status will show success/failure for each component after running.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool streamlines applying grouped property logic to categorized parts.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'PLACE COMPONENTS',
                'slug' => 'place-components',
                'has_url' => true,
                'sort_order' => 17,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Place Components tool allows users to place multiple parts or assemblies into an Inventor assembly based on either file paths or file names. This tool speeds up repetitive placement tasks in large assemblies.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Source Selection</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Source From</span><span class="text-slate-600 dark:text-slate-400"> – Choose the method used to locate files</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">File Path – Use full file paths to find components.</li><li class="text-sm leading-relaxed py-0.5">File Name – Use just the file name (must exist in the project or search paths).</li></ul></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Document Type</span><span class="text-slate-600 dark:text-slate-400"> – Select the document type being placed (e.g., Part, Assembly).</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Component List</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Source Table</span><span class="text-slate-600 dark:text-slate-400"> – Displays the list of components to be placed, along with their file paths and placement status.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Place</span><span class="text-slate-600 dark:text-slate-400"> – Begin placing the listed components into the open Inventor assembly.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Place Components tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Open this user guide or show in-tool instructions.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the Source From option (1): File Path or File Name.</li><li class="leading-relaxed">Choose the appropriate Document Type (2) based on the files being placed.</li><li class="leading-relaxed">Past File Names or File Paths into the Source Table (3).</li><li class="leading-relaxed">Click Place (4) to insert all listed components into the current assembly.</li><li class="leading-relaxed">Click Close (5) to exit the tool.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">When using File Name, make sure the files are discoverable in Inventor’s active project paths.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Status column helps confirm successful or failed placement of each item.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool is ideal for automating the placement of common standard parts or subassemblies.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'PATTERN QTY FROM EXCEL',
                'slug' => 'pattern-qty-from-excel',
                'has_url' => true,
                'sort_order' => 18,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Pattern Qty From Excel tool updates quantity patterns for components in an Inventor assembly based on values from an Excel file. It is useful for automating part patterning using pre-defined data.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Source</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Excel File</span><span class="text-slate-600 dark:text-slate-400"> – Select the Excel file that contains the quantity data. Use the dropdown or click Browse to locate and load the file.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Run</span><span class="text-slate-600 dark:text-slate-400"> – Start reading the Excel file and apply pattern quantities to components.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Pattern Qty From Excel tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Open this user guide or view additional in-tool help.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the Excel File (1) containing your pattern quantity data.</li><li class="leading-relaxed">Click Run (2) to apply quantities to the matching components in the open assembly.</li><li class="leading-relaxed">Check the Status panel for results and confirmation messages.</li><li class="leading-relaxed">Click Close (3) when done.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Make sure the Excel file includes matching identifiers (e.g., part numbers) and quantity values.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The tool reads and applies data only if the format and values are compatible with the current assembly structure.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use the Status area to verify success and troubleshoot any mismatches.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'SAVE AND REPLACE COMPOENTS',
                'slug' => 'save-and-replace-compoents',
                'has_url' => true,
                'sort_order' => 19,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Save and Replace Components tool allows users to create copies of selected components (parts or assemblies), rename them based on custom rules, and automatically replace the original components in the active Inventor assembly. This is useful for branching out new design variants from existing designs.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select a component you want to duplicate.</li><li class="leading-relaxed">Launch the Save and Replace Components tool.</li><li class="leading-relaxed">Enter naming rules or mappings as needed (Prefix, Suffix, or Replace text).</li><li class="leading-relaxed">Choose a save location for the new files.</li><li class="leading-relaxed">Click Save to apply changes.</li><li class="leading-relaxed">Review the results in the assembly and save your work.</li></ol>
</div>
MANUALHTML,
            ],
            [
                'name' => 'REVISION-SAVE AS-REPLACE',
                'slug' => 'revision-save-as-replace',
                'has_url' => true,
                'sort_order' => 20,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Revision – Save As Replace tool allows users to create a new revision of an Inventor component. It saves the revised file under a new name, replaces the original component in the active assembly, and maintains a detailed revision history.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Selected Component Panel</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Doc. Name</span><span class="text-slate-600 dark:text-slate-400"> – Displays the name of the component selected for revision.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Rev. Name</span><span class="text-slate-600 dark:text-slate-400"> – Enter the name of the new revision (e.g., rev01). Click New to auto-generate the next revision name.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Rev. Date</span><span class="text-slate-600 dark:text-slate-400"> – Set the date of the revision using the calendar picker or by manual input.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Rev. By</span><span class="text-slate-600 dark:text-slate-400"> – Enter the initials or full name of the person creating the revision.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Rev. Description</span><span class="text-slate-600 dark:text-slate-400"> – Add a short explanation of the change, purpose, or scope of the revision.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">2. Preview &amp; History</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Preview</span><span class="text-slate-600 dark:text-slate-400"> – Displays a thumbnail image of the selected component.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Revision History Label</span><span class="text-slate-600 dark:text-slate-400"> – Indicates the name of the component whose revision history is shown.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Revision History Table</span><span class="text-slate-600 dark:text-slate-400"> – Lists all parents that are containing the selected component, showing</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">New Rev.</li><li class="text-sm leading-relaxed py-0.5">Reference File</li><li class="text-sm leading-relaxed py-0.5">Rev. Name</li><li class="text-sm leading-relaxed py-0.5">Rev. Date</li><li class="text-sm leading-relaxed py-0.5">Rev. By</li><li class="text-sm leading-relaxed py-0.5">Rev. Description</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">3. Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(9) Apply</span><span class="text-slate-600 dark:text-slate-400"> – Save the new file as a revision, update the current assembly to use the new file, and log the revision into history.(10) Close – Exit the tool without making any changes.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">4. Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(11) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Opens this user guide or provides in-tool assistance.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the component to revise; its Doc. Name (1) will display automatically.</li><li class="leading-relaxed">Enter the Rev. Name (2), or click New to auto-fill it.</li><li class="leading-relaxed">Set the Rev. Date (3), and fill in Rev. By (4) and Rev. Description (5).</li><li class="leading-relaxed">Verify the component preview (6) and review prior history (7, 8).</li><li class="leading-relaxed">Click Apply (9) to create and replace the revised component in the open assembly.</li><li class="leading-relaxed">Click Close (10) to exit the tool.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The tool duplicates the component file and replaces its reference in the current assembly.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Helps maintain a clean and traceable revision history.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Saved revisions appear in the table (8) and are useful for documentation and audits.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Be sure to save the open assembly after applying the changes.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'BOM STRUCTURE',
                'slug' => 'bom-structure',
                'has_url' => true,
                'sort_order' => 21,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The BOM Structure tool allows users to batch-update the Bill of Materials (BOM) structure of Inventor components. This is useful for organizing assemblies into the correct BOM roles like Normal, Reference, Phantom, etc.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Filter Conditions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Document Type</span><span class="text-slate-600 dark:text-slate-400"> – Choose which file types the update should apply to (e.g., All, Parts, Assemblies).</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Property Name</span><span class="text-slate-600 dark:text-slate-400"> – (Optional) Activate the checkbox to apply changes only to components that contain a specific property. Then specify</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Property Name – The property to check.</li><li class="text-sm leading-relaxed py-0.5">Value – The value the property must contain for the update to be applied.</li></ul></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Current Structure</span><span class="text-slate-600 dark:text-slate-400"> – Filter components based on their current BOM structure (e.g., All, Normal, Reference, Phantom).</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Target BOM Structure</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) BOM Structure</span><span class="text-slate-600 dark:text-slate-400"> – Select the desired BOM structure to apply</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Normal</li><li class="text-sm leading-relaxed py-0.5">Reference</li><li class="text-sm leading-relaxed py-0.5">Phantom</li><li class="text-sm leading-relaxed py-0.5">Purchased</li><li class="text-sm leading-relaxed py-0.5">Inseparable</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Update</span><span class="text-slate-600 dark:text-slate-400"> – Apply the selected BOM structure to all filtered components.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the BOM Structure tool.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Choose a Document Type (1) to limit which files are affected.</li><li class="leading-relaxed">(Optional) Use Property Name and Value (2) to apply updates conditionally.</li><li class="leading-relaxed">Filter by Current Structure (3) to focus only on components with a specific BOM role.</li><li class="leading-relaxed">Choose the new BOM Structure (4) to assign.</li><li class="leading-relaxed">Click Update (5) to apply the changes.</li><li class="leading-relaxed">Click Close (6) when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Only components matching all filter conditions will be updated.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Useful when switching a group of parts to Reference or Phantom in one go.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Always verify your changes in the assembly’s BOM view after applying updates.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'SHEET METAL TO NORMAL',
                'slug' => 'sheet-metal-to-normal',
                'has_url' => true,
                'sort_order' => 22,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Sheet Metal to Normal tool converts selected sheet metal parts in an Inventor assembly to standard (non-sheet metal) parts. This is helpful when components no longer require sheet metal features but should retain their geometry.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Conditional Filter</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Run With Property Contains</span><span class="text-slate-600 dark:text-slate-400"> – Enable this checkbox to restrict the conversion only to parts that match a specific i Property</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Name – Select the i Property to search in (e.g., Category, Material).</li><li class="text-sm leading-relaxed py-0.5">Value – Enter the keyword or string to match.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Convert</span><span class="text-slate-600 dark:text-slate-400"> – Perform the conversion on all matching sheet metal components.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the tool.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Help</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Help Icon</span><span class="text-slate-600 dark:text-slate-400"> – Open this guide or access additional tooltips for guidance.</span></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">(Optional) Enable Run With Property Contains (1) to limit which parts are affected.</li><li class="leading-relaxed">Select the Property Name and enter a Value to filter parts.</li><li class="leading-relaxed">Click Convert (2) to change matching sheet metal parts to standard parts.</li><li class="leading-relaxed">Click Close (3) when done.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This operation does not remove geometry but switches the part type from sheet metal to normal.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Useful in cases where flat pattern functionality is no longer needed.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Filtering allows selective conversion to avoid unintended changes.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT STEP BY CATEGORY',
                'slug' => 'export-step-by-category',
                'has_url' => true,
                'sort_order' => 23,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export STEP by Category tool allows you to export Inventor components to .STEP format based on a specific category. It includes options for automatic chamfer suppression and custom view creation for exported parts.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Export Criteria</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Category</span><span class="text-slate-600 dark:text-slate-400"> – Select the category of components to export. Only components that match this category will be processed.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Export Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Auto Suppress and Unsuppressed Chamfers</span><span class="text-slate-600 dark:text-slate-400"> – Enable this to automatically suppress chamfers before export and re-enable them afterward. This is useful when STEP output must exclude chamfered edges.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Create New View for Exported Components</span><span class="text-slate-600 dark:text-slate-400"> – If checked, a new named view is created for each exported part, ensuring consistent orientation during export.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Export</span><span class="text-slate-600 dark:text-slate-400"> – Begin exporting all components that match the selected category and apply the selected options.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Export STEP by Category tool.</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Help</li><li class="text-sm leading-relaxed py-0.5">Help Icon – Click the question mark in the bottom-left to open this user guide or view in-app tips.</li></ul></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Choose the target Category (1) from the dropdown list.</li><li class="leading-relaxed">Enable or disable the Chamfer Suppression (2) and View Creation (3) options as needed.</li><li class="leading-relaxed">Click Export (4) to begin the export process.</li><li class="leading-relaxed">When finished, click Close (5) to exit the tool.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Make sure the parts have the correct Category i Property set before running the tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Exported .STEP files are saved in the default or user-specified export folder.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Suppressed chamfers will be restored automatically if that option is selected.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT COMPONENTS TO EXCEL',
                'slug' => 'export-components-to-excel',
                'has_url' => true,
                'sort_order' => 24,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export Components to Excel tool allows users to export selected i Properties from an Inventor assembly into a structured Excel file using a predefined template. It supports conditional filtering, component type control, and multiple formatting options.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">1. Template Selection</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Excel Template</span><span class="text-slate-600 dark:text-slate-400"> – Select or browse for the Excel template that defines where and how the properties will be placed in the spreadsheet.</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">2. Property Mapping Table</li><li class="text-sm leading-relaxed py-0.5">Property Name – The i Property to export (e.g., Part Number, Category, Keywords Material).</li><li class="text-sm leading-relaxed py-0.5">Sheet Name – The worksheet name in the Excel file to write to.</li><li class="text-sm leading-relaxed py-0.5">Start Column – The Excel column where data writing will begin.</li><li class="text-sm leading-relaxed py-0.5">Start Row – The Excel row where data writing will begin.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">3. Component Filtering</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Add Row</span><span class="text-slate-600 dark:text-slate-400"> – Add a new row to define another property to export.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Component Type</span><span class="text-slate-600 dark:text-slate-400"> – Select which type of components to include (e.g., All, Parts, Assemblies).</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">4. Export Options Panel</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Export Mode</span><span class="text-slate-600 dark:text-slate-400"> – Choose how the components and their properties will be exported</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Export all components – Export the selected properties for all components.</li><li class="text-sm leading-relaxed py-0.5">Export components contain property – Export only components that have the specified property (use the field below to define the property name and values).</li><li class="text-sm leading-relaxed py-0.5">Export each property's value to each sheet – Export each selected property to its own individual Excel sheet.</li></ul></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Run With Property (applies to the second mode above)</li><li class="text-sm leading-relaxed py-0.5">Property Name – Select the i Property to filter by.</li><li class="text-sm leading-relaxed py-0.5">Contains Value(s) – Enter one or more values to match.</li><li class="text-sm leading-relaxed py-0.5">Add Value – Add values to the list.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">5. Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Export</span><span class="text-slate-600 dark:text-slate-400"> – Start the export process based on selected filters and mappings.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the Export Components to Excel tool.</span></li>
<li class="leading-relaxed"><span class="text-slate-800 dark:text-slate-200">Export (Bottom Left) - Saved property-to-template mappings for the future use.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(9) Import</span><span class="text-slate-600 dark:text-slate-400"> – Load saved property-to-template mappings.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(10) Visible Excel</span><span class="text-slate-600 dark:text-slate-400"> – Automatically open the exported Excel file when finished.</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">6. Help</li><li class="text-sm leading-relaxed py-0.5">Help Icon – Access this guide or additional in-tool help tips.</li></ul></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Load or browse for an Excel Template (1).</li><li class="leading-relaxed">Click Add Row (2) to define the properties you want to export.</li><li class="leading-relaxed">Choose a Component Type (3) and apply filters or values if needed.</li><li class="leading-relaxed">Select an Export Mode (4) and optionally enable Only visible components (5).</li><li class="leading-relaxed">Check Visible Excel (10) if you want the file to open after export.</li><li class="leading-relaxed">Click Export (6) to generate the spreadsheet.</li><li class="leading-relaxed">Use Close (7) to exit when done.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Make sure your Excel template file has the proper sheet and cell structure defined.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Exported data is ideal for reports, BOMs, procurement lists, or documentation workflows.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">You can reuse property mappings with the Import (9) feature.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'SYNC NAME',
                'slug' => 'sync-name',
                'has_url' => true,
                'sort_order' => 25,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Sync Name tool automatically renames components in your Inventor assembly to match a specific naming rule or reference. It includes options to move outdated files and filter by component type, helping to maintain clean and standardized file structures.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">File List (1)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Displays all loaded files along with:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">File Name – Current file name</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Drawing – Indicates if a drawing file is linked</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">New File Name – Proposed new name</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Status – Status or result after processing</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Options (2)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Move old files to Delete Folder – Moves renamed originals to a folder for archiving.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Rename only Normal components – Skips components with BOM structures like Reference or Phantom.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Compress Delete Folder to ZIP File – Compresses the archive folder into a ZIP after sync.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Run (3)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Executes the renaming process based on the selected options.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Close (4)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Exits the Sync Name tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help (5)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Opens this user guide or shows tooltips for additional explanation.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Review the loaded file list shown in section (1).</li><li class="leading-relaxed">Enable Move old files to Delete Folder, Rename only Normal components, and/or Compress Delete Folder to ZIP File under Options (2) as needed.</li><li class="leading-relaxed">Click Run (3) to begin syncing file names.</li><li class="leading-relaxed">Check the Status column for results.</li><li class="leading-relaxed">Click Close (4) when complete.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The tool ensures naming consistency across project files.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Moving and compressing old files can help with revision tracking and file cleanup.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Make sure no files are open or locked during the sync process.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'MANAGE VIEWS',
                'slug' => 'manage-views',
                'has_url' => true,
                'sort_order' => 26,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Manage Views tool allows users to automatically create or update Inventor Design View Representations based on component properties. It controls visibility (Show/Hide) of parts or assemblies in specific views, streamlining drawing setup and visual configuration.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Options Panel</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Component Type: Choose between Part or Assembly to filter which components are affected.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Action: Select Show or Hide to define visibility behavior.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">View Name: Enter or select the name of the view representation to apply changes to.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Update All Views</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Enable this option to apply the visibility logic to all views in the project rather than just the selected view.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Conditions Table</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Add conditional rules using the toolbar above the table. Each rule includes:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Property Name</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Condition (e.g., Equals, Contains)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Property Value</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Load Property Values Automatically populates available property names and values from the current document for easier rule creation.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Each Property Value Has a View When enabled, the tool will create one view per unique value of the selected property, and apply visibility settings accordingly.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Run Applies the action (Show/Hide) to all components that match the specified conditions in the selected (or all) views.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Close Exits the Manage Views tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help Icon Opens this user guide or shows quick help tips in the UI.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Choose Component Type, Action, and View Name (1).</li><li class="leading-relaxed">Optionally enable Update All Views (2) to apply changes globally.</li><li class="leading-relaxed">Use the Conditions Table (3) to define filtering rules:</li><li class="leading-relaxed">Add conditions based on i Properties like Material, Category, etc.</li><li class="leading-relaxed">Use Load Property Values (4) to auto-fill available properties and values.</li><li class="leading-relaxed">Enable Each Property Value Has a View (5) if you want to generate a separate view per value.</li><li class="leading-relaxed">Click Run (6) to apply the changes.</li><li class="leading-relaxed">Click Close (7) to exit.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Works best when used before documentation to organize component visibility.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">View names will be auto created if they don’t exist yet.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">You can hide bolts, steel profiles, or specific materials based on flexible filters.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'COPY DESIGN',
                'slug' => 'copy-design',
                'has_url' => true,
                'sort_order' => 27,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Copy Design tool allows you to duplicate an Inventor design (including all references and drawings), rename files, update part numbers, and organize files into new folders or project structures. It is ideal for reusing and branching off from existing projects.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Source and Destination</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(1) Full File Name</span><span class="text-slate-600 dark:text-slate-400"> – Select the main file (e.g., an assembly or part) you want to duplicate.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(2) Search Options</span><span class="text-slate-600 dark:text-slate-400"> – Choose whether to search in the active project or specify a custom folder.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(3) Target Folder</span><span class="text-slate-600 dark:text-slate-400"> – Set the destination for the new copies. Enable Keep Folder Hierarchy to preserve the original subfolder structure.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Copy Options</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(4) Copy Options</span><span class="text-slate-600 dark:text-slate-400"> – Configure how the tool handles linked files</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Copy Drawing – Also copy associated .idw or .dwg files.</li><li class="text-sm leading-relaxed py-0.5">Include Linked File – Include all reference files.</li><li class="text-sm leading-relaxed py-0.5">Create New Project – Create a new .ipj project file in the destination.</li><li class="text-sm leading-relaxed py-0.5">Update Part Number – Update part numbers automatically during the copy process.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Files to Copy</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(5) Files Table</span><span class="text-slate-600 dark:text-slate-400"> – Shows all components and references that will be duplicated. Columns include type, drawing status, old file name, and editable new name.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(6) Advance Selection</span><span class="text-slate-600 dark:text-slate-400"> – Use filters to quickly select/deselect files (e.g., by file name, extension, etc.).</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Controls &amp; Tools</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(7) File Controls</span><span class="text-slate-600 dark:text-slate-400"> – Access tools to expand/collapse file lists and configure view options.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(8) Gear Icon (Settings)</span><span class="text-slate-600 dark:text-slate-400"> – allowing you to customize which properties are shown in the file list. This helps you track additional i Properties or metadata when copying and renaming files.</span></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">File Naming</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(9) File Naming Options</span><span class="text-slate-600 dark:text-slate-400"> – Apply global renaming rules</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Find/Replace – Replace specific text in file names.</li><li class="text-sm leading-relaxed py-0.5">Prefix/Suffix – Add a prefix or suffix to new names. Click Apply to execute the changes or Reset to undo them.</li></ul></li>
</ul>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Actions</h4>
<ul class="list-none space-y-2.5 mb-5 pl-5 sm:pl-6 text-left">
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(10) Run</span><span class="text-slate-600 dark:text-slate-400"> – Start the copy and rename process.</span></li>
<li class="leading-relaxed"><span class="font-semibold text-slate-900 dark:text-slate-100">(11) Close</span><span class="text-slate-600 dark:text-slate-400"> – Exit the tool.</span></li>
<li class="mt-0.5 leading-relaxed"><ul class="list-none space-y-2 mb-3 ml-2 pl-4 sm:pl-5 border-l-2 border-[#137fec]/40 text-left"><li class="text-sm leading-relaxed py-0.5">Help</li><li class="text-sm leading-relaxed py-0.5">Help Icon – Access this user guide or in-app help for tooltips.</li></ul></li>
</ul>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the Full File Name (1) of the top-level file to copy.</li><li class="leading-relaxed">Set your Search Options (2) and Target Folder (3).</li><li class="leading-relaxed">Configure the desired Copy Options (4).</li><li class="leading-relaxed">Use filters (6) and view controls (7) to manage the file list (5).</li><li class="leading-relaxed">Apply bulk renaming with File Naming (9), if needed.</li><li class="leading-relaxed">Click Run (10) to begin copying the design files.</li><li class="leading-relaxed">Click Close (11) to exit the tool when finished.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ideal for project branching, product variants, and design templates.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Review all file names in the table before running to prevent conflicts.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">“Show Thumbnail” helps visually confirm components.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'CHECK MISSING FILES',
                'slug' => 'check-missing-files',
                'has_url' => true,
                'sort_order' => 28,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Check Missing Files tool scans your current Inventor project or open design to detect missing reference files. It helps ensure file integrity before running operations like export, copy design, or revision control.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Status Panel</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Status – Displays a detailed list of missing files, including paths or filenames that cannot be found. This helps you quickly locate which components need attention.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Actions</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Run – Starts the scan for missing references.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Status Bar (Bottom Left) – Shows the scan progress or summary result after execution.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help Icon – Opens this user guide or provides tooltips for quick in-app support.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Open the Inventor assembly or part file that you want to validate.</li><li class="leading-relaxed">Launch the Check Missing Files tool.</li><li class="leading-relaxed">Click Run to begin scanning for missing referenced files.</li><li class="leading-relaxed">Review the Status panel for any missing file entries.</li><li class="leading-relaxed">Locate and relink the missing files inside Inventor or your file system as needed.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool is helpful before performing Batch Exports, Copy Design, or generating BOMs, ensuring all linked files are intact.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Missing files may include referenced parts, subassemblies, or drawing resources.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use the information in the status window to manually relink files using Inventor’s Resolve References tool if necessary.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'DELETE NON-SOLID',
                'slug' => 'delete-non-solid',
                'has_url' => true,
                'sort_order' => 29,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Delete Non-Solid tool is a quick utility that automatically removes any components in an assembly or part that are non-solid (e.g., empty, corrupt, or surface-only bodies). It helps clean up your design environment before finalizing exports or analysis.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Open the desired Inventor assembly.</li><li class="leading-relaxed">Run the Delete Non-Solid command.</li><li class="leading-relaxed">The tool will automatically:</li><li class="leading-relaxed">Identify non-solid components.</li><li class="leading-relaxed">Delete them from the model.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool does not affect visible solids or valid components.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Non-solids include:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Bodies without volume</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Surfaces without thickness</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Corrupt imports with no geometry</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'DELETE HIDDEN COMPONETS',
                'slug' => 'delete-hidden-componets',
                'has_url' => true,
                'sort_order' => 30,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Delete Hidden Components tool quickly removes components from an Inventor assembly that are currently invisible (hidden). It is designed to streamline assemblies by eliminating unused or temporarily hidden elements that are no longer needed.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Open the Inventor assembly you want to clean.</li><li class="leading-relaxed">Run the Delete Hidden Components tool.</li><li class="leading-relaxed">The tool will automatically:</li><li class="leading-relaxed">Identify all components with visibility off.</li><li class="leading-relaxed">Delete them from the model.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Components must be hidden using visibility toggles, not suppressed.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Make sure important hidden parts (used for alternate views, configurations, etc.) are made visible before running this tool.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'EXPORT CUSTOM PRODUCTION',
                'slug' => 'export-custom-production',
                'has_url' => true,
                'sort_order' => 31,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Export Custom Production tool allows users to export Inventor components to various formats (PDF, DXF, STEP) based on custom logic such as document type, BOM structure, sorting rules, and naming patterns. This is useful for automating large-scale production exports with detailed control.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Main Tab – Interface Breakdown</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Target Folder Selection</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(1) Target Folder – Set the destination path where exported files will be saved.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Rule Configuration Panel</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(2) Input Settings – Define how the export is applied using:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Function – Export function type (e.g., export, skip, preview).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Document Type – Specify Part, Assembly, etc.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">BOM Structure – Filter by Normal, Reference, Purchased, etc.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Sort By / Sort Values – Control ordering of exports (optional).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ref. File – Select a reference file to assist export logic.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(3) New Row – Adds a new rule configuration line.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(4) Apply – Apply the settings from the panel to the selected rule row.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">File Table</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Displays the rule rows with columns for:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Function</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Document Type</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">BOM Structure</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Sort parameters</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Folder/File name formats</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This allows detailed batch processing of export tasks.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Actions</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(5) Run – Start the export process using all defined rules.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(6) Close – Exit the tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Import/Export Rules</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(7) Import – Load a saved export configuration.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(8) Export – Save the current export rules to a file for reuse.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(9) Help Icon – Opens this user guide or tooltips for in-tool support.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Setting Tab – Export Options</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">PDF Options</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(1) PDF Export Options</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">All sheets</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">All color as black</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Remove object line weights</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Display published file in viewer</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Sheets in range: Select a range using Form – To values</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">STEP Options</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(2) Auto Suppress and Unsuppressed Chamfers – Useful for cleaner STEP output where chamfers should not appear.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Template Selection</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">(3) File Templates – Assign custom templates for:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">DXF (Show Label)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">DXF (Hide Label)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">STEP Template</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Browse and select .idw, .dxf, or .step templates that control export formatting or labeling behavior.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Choose your Target Folder (1).</li><li class="leading-relaxed">Create a rule row using New Row (3), fill in rule details (2), and click Apply (4).</li><li class="leading-relaxed">Repeat for each rule needed.</li><li class="leading-relaxed">Switch to the Setting tab and configure PDF/STEP options and templates.</li><li class="leading-relaxed">Click Run (5) to export all components.</li><li class="leading-relaxed">Use Export (8) and Import (7) to manage rule sets for future runs.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Each rule operates independently and can be tailored to specific document types or BOM structures.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Templates allow strict control over output layout for manufacturing or client delivery.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Combine with revision or folder naming formats for full automation.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'MODEL PLANES',
                'slug' => 'model-planes',
                'has_url' => true,
                'sort_order' => 32,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Model Planes tool allows users to quickly show or hide specific work planes in a 3D model (part or assembly) by entering their names. It is useful for toggling visibility during modeling, review, or documentation tasks.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Input</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Plane(s) – Type the name(s) of the plane(s) you want to control visibility for (e.g., XY Plane, Right, Work Plane1). You can enter multiple names separated by commas or spaces.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Option</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Save plane(s) for the next time – When checked, the tool remembers the entered plane names for your next session, saving time for repetitive tasks.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Actions</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Show – Makes the specified planes visible in the model.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Hide – Hides the specified planes.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Cancel – Closes the tool without making changes.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help Icon – Opens this user guide or in-tool tips.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Type one or more Plane names in the input field.</li><li class="leading-relaxed">Check or uncheck Save plane(s) for the next time as needed.</li><li class="leading-relaxed">Click Show to make the planes visible or Hide to make them invisible.</li><li class="leading-relaxed">Use Cancel to exit without applying changes.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This tool is ideal for managing construction geometry in large or complex models.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure that plane names are correctly typed; spelling must match exactly as listed in the browser.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Frequently used with derived parts, multi-body modeling, or assembly constraints.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'GET BODY NAME IN BALLOON',
                'slug' => 'get-body-name-in-balloon',
                'has_url' => true,
                'sort_order' => 33,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Get Body Name in Balloon tool allows users to automatically update drawing balloons to display the Body Name instead of the default item number or part number. It is particularly useful for multi-body part drawings where individual bodies must be labeled clearly.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Interface</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Actions</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Run – Executes the command.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help Icon – Opens this user guide or tooltip for brief assistance.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Select the balloon that you want to get the name.</li><li class="leading-relaxed">Click Run.</li><li class="leading-relaxed">Balloons referencing body-level items will be updated to show their respective Body Name.</li><li class="leading-relaxed">Check the drawing to confirm correct labeling.</li></ol>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Additional Notes</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Works best when using multi-body part modeling workflows.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Ensure that each solid body has a Body Name property assigned in the 3D model.</p>
</div>
MANUALHTML,
            ],
            [
                'name' => 'IPROPERTIES',
                'slug' => 'iproperties',
                'has_url' => true,
                'sort_order' => 34,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This lightweight version allows you to view and edit basic file information and perform actions quickly without accessing the full property set.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">File Information</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">File Name (Default)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Dropdown or input to select a specific file name.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Open File Button: Opens a dialog to browse and select a file.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Full File Name (Default)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Displays the complete path of the selected file.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Copy Path Button: Copies the full file path to your clipboard.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Apply Button</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click Apply to save any changes made to the file’s i Properties.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Cancel Button</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click Cancel to exit without saving any changes.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Settings Button (⚙️)</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Opens the tool's settings window.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Lets you configure property groups, presets, or load/save configuration files</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">The Settings window allows you to configure which i Properties appear in the main tool, assign standard values, and manage settings storage.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Select Available Properties From</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Drop down menu to choose the source group of i Properties:</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Inventor Summary Information</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Inventor Document Summary Information</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Inventor Design Tracking Properties</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Inventor Custom Properties</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Physical Properties</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">User Properties</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Enter the name of a custom i Property.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Press Add to include it in the list of available properties.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Available Properties</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Shows all available properties from the selected source group.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use Refresh to reload the list.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use Delete to remove a selected custom property.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Add/Remove Buttons</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Add &gt;&gt;: Move selected properties to the Selected Properties list.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">&lt;&lt; Remove: Remove selected properties from the list of properties to be used in the main tool.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Selected Properties</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Displays properties currently selected for display/edit in the main form.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Use Move Up and Move Down to reorder them.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Standard Values</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Define commonly used values for the currently selected property.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Enter value in the box and click Add to include it as a suggestion in the dropdown.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">OK Button</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Save changes and close the Settings window.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Cancel Button</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Close the window without saving changes.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Settings Folder</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Specify or browse to a folder where configuration files (JSON) will be stored.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This allows the reuse of settings across sessions or machines.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Help / About Button</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Opens help or about documentation with more details about using the Settings window.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Usage Steps</h3>
<ol class="list-decimal list-outside mb-6 ml-0 pl-8 sm:pl-10 space-y-3 text-left marker:font-semibold marker:text-[#137fec] dark:marker:text-[#4a9ef5] text-slate-700 dark:text-slate-300"><li class="leading-relaxed">Click the Settings button to open the Settings dialog.</li><li class="leading-relaxed">Select Property’s Name in Available Properties to Selected Properties.</li><li class="leading-relaxed">Add standard value if needed (Optional).</li><li class="leading-relaxed">Click OK to apply your settings.</li></ol>
</div>
MANUALHTML,
            ],
            [
                'name' => 'INSTALLATION',
                'slug' => 'installation',
                'has_url' => true,
                'sort_order' => 35,
                'description' => <<<'MANUALHTML'
<div class="help-manual-doc space-y-5 text-[15px] leading-relaxed">
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Overview</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">This guide walks you through installing the Di-Tools application (version 3.0) on a Windows system. Di-Tools is packaged as a standalone executable installer and typically takes less than a minute to complete installation.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Installation Steps</h3>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 1: Locate the Installer</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Find the file named Di-Tools 3.0.exe on your computer. This is the setup file for the Di-Tools application.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 2: Run the Installer</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Right-click the file and choose Run as administrator to ensure the installer has sufficient permissions.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 3: Begin Installation</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">When the setup window appears, click Install to begin the installation process.</p>
<p class="my-4 pl-4 border-l-4 border-[#137fec] bg-slate-50 dark:bg-slate-800/50 py-3 rounded-r text-slate-700 dark:text-slate-300"><span class="font-semibold">💡</span> You may be prompted by Windows Defender or UAC. If so, confirm that you trust the file and proceed.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 4: Complete Installation</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">After the installation finishes, you will see the Setup Complete screen. Click Finish to exit the installer.</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Activate Di-Tools in Autodesk Inventor</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">After installation, follow these steps to ensure Di-Tools is enabled inside Inventor.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 1: Open the Add-In Manager</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Launch Autodesk Inventor.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Go to the Tools tab (📌 1) on the ribbon.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click Add-Ins (📌 2).</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 2: Enable Di-Tools Add-In</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">In the Add-In Manager, scroll through the list and select Da Cu3D (📌 1).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">On the right panel under Load Behavior (📌 2), check both:</p>
<ul class="list-disc list-outside ml-0 pl-8 sm:pl-10 space-y-2.5 mb-6 text-left text-slate-700 dark:text-slate-300"><li class="leading-relaxed pl-0.5">✅ Loaded/Unloaded</li><li class="leading-relaxed pl-0.5">✅ Load Automatically</li></ul>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click OK to save changes (📌 3).</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">Activate Your Di-Tools License</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">After installation and launching Inventor, you must activate your license to begin using Di-Tools.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 1: Open the License Panel</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Go to the Di-Tools tab (📌 1) in Autodesk Inventor.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click the License button (📌 2) on the right.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 2: Copy the System Key</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">In the Da Cu3D License window (📌 3), your unique System Key is displayed.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click Copy (📌 4) to copy the key to your clipboard.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 3: Request a License Key</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Send the copied System Key to the CADINVO team by email orders@cadinvo.com</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">You will receive a License Key in return.</p>
<h4 class="text-base font-semibold text-[#137fec] dark:text-[#4a9ef5] mt-5 mb-2.5">Step 4: Activate</h4>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Paste the License Key into the corresponding field (📌 5).</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Click Active (📌 6) to activate the software.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed font-medium">✅ If successful, the license window will close automatically and Di-Tools will be fully unlocked.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed font-medium">✅ You’re Done!</p>
<h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4 pb-2 border-b border-slate-200 dark:border-slate-600 first:mt-0">🎉 Special Thanks</h3>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Thank you for choosing Di-Tools by CADINVO.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">We are incredibly grateful for your support and trust in our tools. Your feedback, suggestions, and continued use help us improve and build smarter, faster solutions for Inventor users like you.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">If you encounter any issues or have ideas to enhance Di-Tools, don’t hesitate to reach out — we’re always here to help.</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">– The CADINVO Team</p>
<p class="my-4 text-slate-700 dark:text-slate-300 leading-relaxed">Innovating with you, for you.</p>
</div>
MANUALHTML,
            ],
        ];

        $videoByToolName = self::videoUrlsByToolNameFromCsv(public_path('Di-Tools.csv'));

        foreach ($posts as &$post) {
            $post['images'] = $imageMap[$post['slug']] ?? [];
            $csvToolName = self::seederNameToCsvColumn1($post['name']);
            $key = strtoupper(trim($csvToolName));
            $post['video'] = $videoByToolName[$key] ?? null;
        }
        unset($post);

        foreach ($posts as $post) {
            $packages = self::packagesForManualPost($post['name'], $toolToParentPackages, $validPackageNames);
            if ($packages === []) {
                $packages = ['iProperties (Advanced)'];
            }
            foreach ($packages as $pkgName) {
                if (! isset($packageRoots[$pkgName])) {
                    continue;
                }
                $row = $post;
                $row['parent_id'] = $packageRoots[$pkgName]->id;
                $row['slug'] = Str::slug($pkgName.' '.$post['name']);
                IssueType::create($row);
            }
        }
    }

    /**
     * @param  list<string>  $names
     * @return list<string>
     */
    private static function uniquePackageNamesPreserveOrder(array $names): array
    {
        $seen = [];
        $out = [];
        foreach ($names as $n) {
            if ($n === '' || isset($seen[$n])) {
                continue;
            }
            $seen[$n] = true;
            $out[] = $n;
        }

        return $out;
    }

    /**
     * Packages from rows where IsTool = 0 (Column1 = package name). All are top-level siblings.
     * tier_package_names = Level 1 + Type "Package" (Basic, Expert, Premium Service Layer) for Basic/Professional/Premium columns on tools.
     *
     * @return array{all_package_names: list<string>, tier_package_names: list<string>}
     */
    private static function parseIsToolZeroPackageData(string $path): array
    {
        if (! is_file($path) || ! is_readable($path)) {
            return ['all_package_names' => [], 'tier_package_names' => []];
        }
        $fh = fopen($path, 'r');
        if ($fh === false) {
            return ['all_package_names' => [], 'tier_package_names' => []];
        }
        $header = fgetcsv($fh);
        if ($header === false) {
            fclose($fh);

            return ['all_package_names' => [], 'tier_package_names' => []];
        }
        $nameIdx = array_search('Column1', $header, true);
        $isToolIdx = array_search('IsTool', $header, true);
        $levelIdx = array_search('Level', $header, true);
        $typeIdx = array_search('Type', $header, true);
        if ($nameIdx === false || $isToolIdx === false || $levelIdx === false || $typeIdx === false) {
            fclose($fh);

            return ['all_package_names' => [], 'tier_package_names' => []];
        }
        $allPackageNames = [];
        $tierPackageNames = [];
        while (($row = fgetcsv($fh)) !== false) {
            $isToolVal = isset($row[$isToolIdx]) ? trim((string) $row[$isToolIdx]) : '';
            if ($isToolVal === '' || (int) $isToolVal !== 0) {
                continue;
            }
            $name = isset($row[$nameIdx]) ? trim((string) $row[$nameIdx]) : '';
            if ($name === '') {
                continue;
            }
            $allPackageNames[] = $name;
            $level = isset($row[$levelIdx]) ? trim((string) $row[$levelIdx]) : '';
            $type = isset($row[$typeIdx]) ? trim((string) $row[$typeIdx]) : '';
            if ($level === '1' && strcasecmp($type, 'Package') === 0) {
                $tierPackageNames[] = $name;
            }
        }
        fclose($fh);

        return [
            'all_package_names' => $allPackageNames,
            'tier_package_names' => $tierPackageNames,
        ];
    }

    /**
     * Match a Category cell fragment to an IsTool=0 package name (packages are defined only by IsTool=0 rows).
     */
    private static function matchCategoryFragmentToPackageName(string $category, array $validPackageNames): ?string
    {
        $c = trim($category);
        if ($c === '') {
            return null;
        }
        $mapped = match ($c) {
            'Advanced Tools' => 'iProperties (Advanced)',
            default => $c,
        };
        if (in_array($mapped, $validPackageNames, true)) {
            return $mapped;
        }

        return null;
    }

    /**
     * For each tool row (IsTool = 1): parent packages = same-level tier packages from Basic/Professional/Premium
     * columns plus any Category fragments that match an IsTool=0 package name. Packages are only those IsTool=0 rows.
     * Last row wins for duplicate Column1.
     *
     * @param  list<string>  $validPackageNames
     * @param  list<string>  $tierPackageNames  Three Level-1 Package names in order: Basic, Expert, Premium Service Layer
     * @return array<string, list<string>>
     */
    private static function toolToParentPackagesFromCsv(string $path, array $validPackageNames, array $tierPackageNames): array
    {
        if (! is_file($path) || ! is_readable($path)) {
            return [];
        }
        $fh = fopen($path, 'r');
        if ($fh === false) {
            return [];
        }
        $header = fgetcsv($fh);
        if ($header === false) {
            fclose($fh);

            return [];
        }
        $catIdx = array_search('Category', $header, true);
        $nameIdx = array_search('Column1', $header, true);
        $isToolIdx = array_search('IsTool', $header, true);
        $basicIdx = array_search('Basic', $header, true);
        $proIdx = array_search('Professional', $header, true);
        $premIdx = array_search('Premium', $header, true);
        if ($catIdx === false || $nameIdx === false || $isToolIdx === false
            || $basicIdx === false || $proIdx === false || $premIdx === false) {
            fclose($fh);

            return [];
        }
        [$nameBasic, $nameExpert, $namePremium] = [
            $tierPackageNames[0] ?? 'Basic',
            $tierPackageNames[1] ?? 'Expert',
            $tierPackageNames[2] ?? 'Premium Service Layer',
        ];
        $map = [];
        while (($row = fgetcsv($fh)) !== false) {
            $isToolVal = isset($row[$isToolIdx]) ? trim((string) $row[$isToolIdx]) : '';
            if ($isToolVal === '' || (int) $isToolVal !== 1) {
                continue;
            }
            $tool = isset($row[$nameIdx]) ? trim((string) $row[$nameIdx]) : '';
            if ($tool === '') {
                continue;
            }
            $key = strtoupper($tool);
            $parents = [];
            if (self::csvBool(isset($row[$basicIdx]) ? (string) $row[$basicIdx] : '')) {
                $parents[$nameBasic] = true;
            }
            if (self::csvBool(isset($row[$proIdx]) ? (string) $row[$proIdx] : '')) {
                $parents[$nameExpert] = true;
            }
            if (self::csvBool(isset($row[$premIdx]) ? (string) $row[$premIdx] : '')) {
                $parents[$namePremium] = true;
            }
            $cat = isset($row[$catIdx]) ? trim((string) $row[$catIdx]) : '';
            if ($cat !== '') {
                foreach (array_map('trim', explode(',', $cat)) as $p) {
                    if ($p === '') {
                        continue;
                    }
                    $resolved = self::matchCategoryFragmentToPackageName($p, $validPackageNames);
                    if ($resolved !== null) {
                        $parents[$resolved] = true;
                    }
                }
            }
            $names = array_keys($parents);
            sort($names, SORT_STRING);
            $map[$key] = $names;
        }
        fclose($fh);

        return $map;
    }

    private static function csvBool(string $value): bool
    {
        $v = strtolower(trim($value));

        return in_array($v, ['true', '1', 'yes'], true);
    }

    /**
     * Manual post title -> Di-Tools.csv Column1 when the seeder name differs from the sheet.
     */
    private static function seederNameToCsvColumn1(string $name): string
    {
        $map = [
            'SAVE AND REPLACE COMPOENTS' => 'SAVE AND REPLACE COMPONENTS',
            'IPROPERTIES' => 'QUICK IPROPERTIES',
        ];

        return $map[strtoupper($name)] ?? $name;
    }

    /**
     * Parent package names for a manual entry (from CSV tool row mapping, with fallbacks when missing).
     *
     * @param  array<string, list<string>>  $toolToParentPackages
     * @param  list<string>  $validPackageNames
     * @return list<string>
     */
    private static function packagesForManualPost(string $name, array $toolToParentPackages, array $validPackageNames): array
    {
        $csvKey = strtoupper(self::seederNameToCsvColumn1($name));
        $packages = $toolToParentPackages[$csvKey] ?? [];
        if ($packages !== []) {
            return $packages;
        }
        $fallbacks = [
            'NAME BODIES' => ['iProperty & Quantity'],
            'IPROPERTIES' => ['iProperty & Quantity', 'Property Essentials Set'],
            'INSTALLATION' => ['File Management'],
        ];
        $upper = strtoupper($name);
        $raw = $fallbacks[$upper] ?? [];
        $out = [];
        foreach ($raw as $pkg) {
            $resolved = self::matchCategoryFragmentToPackageName($pkg, $validPackageNames);
            if ($resolved !== null) {
                $out[] = $resolved;
            }
        }

        return $out;
    }

    /**
     * Map uppercased CSV Column1 (tool name) to Video URL; empty cells become null.
     * Last row wins if duplicate names exist.
     */
    private static function videoUrlsByToolNameFromCsv(string $path): array
    {
        if (! is_file($path) || ! is_readable($path)) {
            return [];
        }

        $fh = fopen($path, 'r');
        if ($fh === false) {
            return [];
        }

        $header = fgetcsv($fh);
        if ($header === false) {
            fclose($fh);

            return [];
        }

        $nameIdx = array_search('Column1', $header, true);
        $videoIdx = array_search('Video', $header, true);
        $isToolIdx = array_search('IsTool', $header, true);
        if ($nameIdx === false || $videoIdx === false || $isToolIdx === false) {
            fclose($fh);

            return [];
        }

        $map = [];
        while (($row = fgetcsv($fh)) !== false) {
            $isToolVal = isset($row[$isToolIdx]) ? trim((string) $row[$isToolIdx]) : '';
            if ($isToolVal === '' || (int) $isToolVal !== 1) {
                continue;
            }
            if (! isset($row[$nameIdx])) {
                continue;
            }
            $name = trim((string) $row[$nameIdx]);
            if ($name === '') {
                continue;
            }
            $video = isset($row[$videoIdx]) ? trim((string) $row[$videoIdx]) : '';
            $map[strtoupper($name)] = $video !== '' ? $video : null;
        }
        fclose($fh);

        return $map;
    }
}
