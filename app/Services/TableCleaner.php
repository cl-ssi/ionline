<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use Illuminate\Support\Str;

class TableCleaner
{
    public static function clean(string $content): string
    {
        // Create a new DOM document
        $dom = new DOMDocument();
        
        // Suppress warnings from invalid HTML
        libxml_use_internal_errors(true);
        
        // Load HTML content and preserve UTF-8 encoding
        // Using additional options to handle HTML5 and prevent adding extra nodes
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), 
            LIBXML_HTML_NOIMPLIED | 
            LIBXML_HTML_NODEFDTD | 
            LIBXML_NOERROR | 
            LIBXML_NOWARNING
        );
        
        // Clear any libxml errors that occurred during loading
        libxml_clear_errors();
        
        // Find all tables
        $tables = $dom->getElementsByTagName('table');
        
        // Process each table
        foreach ($tables as $table) {
            self::processTable($table);
        }
        
        // Get the cleaned HTML content
        $cleanedHtml = $dom->saveHTML();
        
        // Remove DOCTYPE, html and body tags that might have been added
        $cleanedHtml = preg_replace(
            [
                '/^<!DOCTYPE.*?>/i',
                '/<html><body>/i',
                '/<\/body><\/html>$/i'
            ], 
            '', 
            $cleanedHtml
        );
        
        // Remove any duplicate IDs
        $cleanedHtml = self::removeDuplicateIds($cleanedHtml);
        
        return trim($cleanedHtml);
    }
    
    private static function processTable(DOMElement $table): void
    {
        // Set table attributes
        $table->setAttribute('style', 'border-collapse: collapse; width: 100%;');
        $table->setAttribute('border', '1');
        
        // Remove unnecessary table attributes
        $unnecessaryAttributes = ['width', 'height', 'cellspacing', 'cellpadding', 'align'];
        foreach ($unnecessaryAttributes as $attr) {
            if ($table->hasAttribute($attr)) {
                $table->removeAttribute($attr);
            }
        }
        
        // Process cells
        $cells = $table->getElementsByTagName('td');
        foreach ($cells as $cell) {
            self::processCell($cell);
        }
        
        // Process headers
        $headers = $table->getElementsByTagName('th');
        foreach ($headers as $header) {
            self::processCell($header);
        }
    }
    
    private static function processCell(DOMElement $cell): void
    {
        // Preserve important attributes
        $preservedAttributes = [
            'colspan' => $cell->getAttribute('colspan'),
            'rowspan' => $cell->getAttribute('rowspan'),
            'align' => $cell->getAttribute('align'),
        ];
        
        // Check for center alignment in styles
        $hasTextAlignCenter = false;
        if ($cell->hasAttribute('style')) {
            $hasTextAlignCenter = str_contains(strtolower($cell->getAttribute('style')), 'text-align: center');
        }
        
        // Check nested elements for center alignment
        $spans = $cell->getElementsByTagName('span');
        foreach ($spans as $span) {
            if ($span->hasAttribute('style') && 
                str_contains(strtolower($span->getAttribute('style')), 'text-align: center')) {
                $hasTextAlignCenter = true;
                break;
            }
        }
        
        // Remove all existing attributes
        while ($cell->hasAttributes()) {
            $cell->removeAttribute($cell->attributes->item(0)->name);
        }
        
        // Restore preserved attributes if they had values
        foreach ($preservedAttributes as $attr => $value) {
            if (!empty($value)) {
                $cell->setAttribute($attr, $value);
            }
        }
        
        // Add center alignment if needed
        if ($hasTextAlignCenter) {
            $cell->setAttribute('style', 'text-align: center');
        }
        
        // Convert paragraphs to spans
        $paragraphs = iterator_to_array($cell->getElementsByTagName('p'));
        foreach ($paragraphs as $p) {
            $span = $cell->ownerDocument->createElement('span');
            
            // Preserve paragraph styles if they exist
            if ($p->hasAttribute('style')) {
                $span->setAttribute('style', $p->getAttribute('style'));
            }
            
            // Move all children to the new span
            while ($p->firstChild) {
                $span->appendChild($p->firstChild);
            }
            
            // Replace paragraph with span
            $p->parentNode->replaceChild($span, $p);
        }
    }
    
    private static function removeDuplicateIds(string $html): string
    {
        // Replace any Google Docs internal IDs
        $pattern = '/id="docs-internal-guid-[^"]*"/i';
        $html = preg_replace($pattern, '', $html);
        
        // Generate unique IDs for any remaining duplicate IDs
        return preg_replace_callback(
            '/id="([^"]+)"/',
            function ($matches) {
                return 'id="' . $matches[1] . '_' . Str::random(6) . '"';
            },
            $html
        );
    }
}