<?php

namespace App\Services;

use DOMDocument;
use DOMElement;

class TableCleaner
{
    public static function clean(string $content): string
    {
        // Create a new DOM document
        $dom = new DOMDocument();
        
        // Load HTML content and preserve UTF-8 encoding
        $dom->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        // Find all tables
        $tables = $dom->getElementsByTagName('table');
        
        // Process each table
        foreach ($tables as $table) {
            // Set table attributes
            $table->setAttribute('style', 'border-collapse: collapse; width: 100%;');
            $table->setAttribute('border', '1');
            
            // Remove unnecessary attributes
            $table->removeAttribute('width');
            $table->removeAttribute('height');
            $table->removeAttribute('cellspacing');
            $table->removeAttribute('cellpadding');
            $table->removeAttribute('align');
            
            // Process all cells (td and th) and rows
            $cells = $dom->getElementsByTagName('td');
            foreach ($cells as $cell) {
                self::processCell($cell);
            }
            
            $headers = $dom->getElementsByTagName('th');
            foreach ($headers as $header) {
                self::processCell($header);
            }
        }
        
        // Get the cleaned HTML content
        $cleanedHtml = $dom->saveHTML();
        
        // Remove the XML encoding declaration we added
        $cleanedHtml = preg_replace('/<\?xml encoding="UTF-8"\>/', '', $cleanedHtml);
        
        return $cleanedHtml;
    }
    
    private static function processCell(DOMElement $cell): void
    {
        // Save colspan and rowspan
        $colspan = $cell->getAttribute('colspan');
        $rowspan = $cell->getAttribute('rowspan');
        $textAlignCenter = false;
        
        // Check if cell has center alignment
        if ($cell->hasAttribute('style')) {
            $textAlignCenter = str_contains($cell->getAttribute('style'), 'text-align: center');
        }
        
        // Check spans for center alignment
        $spans = $cell->getElementsByTagName('span');
        foreach ($spans as $span) {
            if ($span->hasAttribute('style') && str_contains($span->getAttribute('style'), 'text-align: center')) {
                $textAlignCenter = true;
                break;
            }
        }
        
        // Remove all attributes
        while ($cell->hasAttributes()) {
            $cell->removeAttribute($cell->attributes->item(0)->name);
        }
        
        // Restore necessary attributes
        if ($colspan) {
            $cell->setAttribute('colspan', $colspan);
        }
        if ($rowspan) {
            $cell->setAttribute('rowspan', $rowspan);
        }
        if ($textAlignCenter) {
            $cell->setAttribute('style', 'text-align: center');
        }
        
        // Replace paragraphs with spans
        $paragraphs = $cell->getElementsByTagName('p');
        while ($paragraphs->length > 0) {
            $p = $paragraphs->item(0);
            $span = $cell->ownerDocument->createElement('span');
            while ($p->firstChild) {
                $span->appendChild($p->firstChild);
            }
            if ($p->hasAttribute('style')) {
                $span->setAttribute('style', $p->getAttribute('style'));
            }
            $p->parentNode->replaceChild($span, $p);
        }
    }
}