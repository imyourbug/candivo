<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

/**
 * Extracts embedded images from the Di-Tools Word manual (.docx), grouped by section title.
 * Writes files under storage/app/public/help-manual/{slug}/01.png, …
 */
class DiToolsManualAssetExtractor
{
    private const W_NS = 'http://schemas.openxmlformats.org/wordprocessingml/2006/main';

    private const R_NS = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships';

    /** Section headings in document order (must match Word + IssueTypeSeeder slugs). */
    private const DOC_TITLES = [
        'COPY DRAWING OBJECTS',
        'MOVE FILE',
        'CREATE DRAWING',
        'EXPORT TO PDF [DWG]',
        'EXPORT PDF SET',
        'EXPORT PDF SERIES',
        'EXPORT TO DXF',
        'EXPORT TO STP',
        'EXPORT TO BIM',
        'COMPONENT SIZE',
        'NAME BODIES',
        'CUSTOM QUANTITY',
        'SUM QTY',
        'DRAWING STATUS',
        'UPDATE PROPERTY',
        'GET SURFACE AREA',
        'STANDARD PROPERTIES',
        'PLACE COMPONENTS',
        'PATTERN QTY FROM EXCEL',
        'SAVE AND REPLACE COMPOENTS',
        'REVISION-SAVE AS-REPLACE',
        'BOM STRUCTURE',
        'SHEET METAL TO NORMAL',
        'EXPORT STEP BY CATEGORY',
        'EXPORT COMPONENTS TO EXCEL',
        'SYNC NAME',
        'MANAGE VIEWS',
        'COPY DESIGN',
        'CHECK MISSING FILES',
        'DELETE NON-SOLID',
        'DELETE HIDDEN COMPONETS',
        'EXPORT CUSTOM PRODUCTION',
        'MODEL PLANES',
        'GET BODY NAME IN BALLOON',
        'IPROPERTIES',
        'INSTALLATION',
    ];

    /**
     * @return array<string, list<string>> slug => storage paths relative to the public disk
     */
    public function extract(string $docxPath): array
    {
        if (! is_readable($docxPath)) {
            throw new RuntimeException('DOCX not readable: '.$docxPath);
        }

        $map = [];
        foreach (self::DOC_TITLES as $title) {
            $map[Str::slug($title)] = [];
        }

        $zip = new ZipArchive;
        if ($zip->open($docxPath) !== true) {
            throw new RuntimeException('Cannot open DOCX: '.$docxPath);
        }

        $relsXml = $zip->getFromName('word/_rels/document.xml.rels');
        $docXml = $zip->getFromName('word/document.xml');

        if ($relsXml === false || $docXml === false) {
            $zip->close();
            throw new RuntimeException('Invalid DOCX: missing document parts.');
        }

        $ridToTarget = $this->parseRelationships($relsXml);

        $xml = simplexml_load_string($docXml);
        if ($xml === false) {
            $zip->close();
            throw new RuntimeException('Invalid document.xml');
        }

        $xml->registerXPathNamespace('w', self::W_NS);
        $body = $xml->children(self::W_NS)->body;
        if ($body === null) {
            $zip->close();

            return $map;
        }

        $currentTitle = null;

        foreach ($body->children(self::W_NS) as $child) {
            if ($child->getName() !== 'p') {
                continue;
            }

            $text = $this->paragraphText($child);
            if ($text !== '' && in_array($text, self::DOC_TITLES, true)) {
                $currentTitle = $text;

                continue;
            }

            foreach ($this->blipEmbedIds($child) as $rid) {
                $target = $ridToTarget[$rid] ?? null;
                if ($target === null || ! str_starts_with($target, 'media/')) {
                    continue;
                }
                if ($currentTitle === null) {
                    continue;
                }

                $slug = Str::slug($currentTitle);
                if (! isset($map[$slug])) {
                    $map[$slug] = [];
                }

                $internalPath = 'word/'.str_replace('\\', '/', $target);
                $binary = $zip->getFromName($internalPath);

                if ($binary === false) {
                    continue;
                }

                $ext = pathinfo($target, PATHINFO_EXTENSION);
                if ($ext === '') {
                    $ext = 'png';
                }
                $index = count($map[$slug]) + 1;
                $relativePath = 'help-manual/'.$slug.'/'.sprintf('%02d', $index).'.'.$ext;
                Storage::disk('public')->put($relativePath, $binary);
                $map[$slug][] = $relativePath;
            }
        }

        $zip->close();

        return $map;
    }

    /**
     * @return array<string, string>
     */
    private function parseRelationships(string $relsXml): array
    {
        $rels = simplexml_load_string($relsXml);
        if ($rels === false) {
            return [];
        }

        $out = [];
        foreach ($rels->Relationship as $rel) {
            $id = (string) $rel['Id'];
            $target = (string) $rel['Target'];
            if ($id !== '' && $target !== '') {
                $out[$id] = $target;
            }
        }

        return $out;
    }

    private function paragraphText(SimpleXMLElement $p): string
    {
        $parts = [];
        foreach ($p->xpath('.//w:t') as $t) {
            $parts[] = (string) $t;
        }

        return trim(implode('', $parts));
    }

    /**
     * @return list<string>
     */
    private function blipEmbedIds(SimpleXMLElement $p): array
    {
        $blips = $p->xpath('.//*[local-name()="blip"]');
        if ($blips === false) {
            return [];
        }

        $ids = [];
        foreach ($blips as $blip) {
            $attrs = $blip->attributes(self::R_NS);
            if ($attrs !== null && isset($attrs['embed'])) {
                $ids[] = (string) $attrs['embed'];
            }
        }

        return $ids;
    }
}
