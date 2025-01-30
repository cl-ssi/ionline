<?php

namespace App\Services;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Illuminate\Support\Str;

class TextCleaner
{
    public static function clean(string $content): string
    {
        // Create a new DOM document
        $dom = new DOMDocument();
        
        // Suppress warnings from invalid HTML
        libxml_use_internal_errors(true);
        
        // Properly encode content before loading
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
        
        // Wrap content in a root element to prevent unexpected end tags
        $content = "<div>$content</div>";
        
        // Load HTML with options to prevent adding extra nodes
        $dom->loadHTML($content, 
            LIBXML_HTML_NOIMPLIED | 
            LIBXML_HTML_NODEFDTD | 
            LIBXML_NOERROR | 
            LIBXML_NOWARNING
        );
        
        // Clear any libxml errors that occurred during loading
        libxml_clear_errors();

        // Create xpath for querying
        $xpath = new DOMXPath($dom);

        // Convert headers to paragraphs with bold text
        self::convertHeadersToParagraphs($dom);

        // Clean styles and classes
        self::cleanStylesAndClasses($xpath);

        // Remove empty tags
        self::removeEmptyTags($xpath, $dom);

        // Get the cleaned HTML
        $cleanedHtml = $dom->saveHTML();

        // Post-process the HTML
        return self::postProcessHtml($cleanedHtml);
    }

    private static function convertHeadersToParagraphs(DOMDocument $dom): void
    {
        // Process each header type
        foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $tag) {
            $headers = iterator_to_array($dom->getElementsByTagName($tag));
            foreach ($headers as $header) {
                if ($header->parentNode) {
                    $p = $dom->createElement('p');
                    $strong = $dom->createElement('strong');
                    
                    // Preserve existing content structure
                    while ($header->firstChild) {
                        $strong->appendChild($header->firstChild);
                    }
                    
                    $p->appendChild($strong);
                    $header->parentNode->replaceChild($p, $header);
                }
            }
        }
    }

    private static function cleanStylesAndClasses(DOMXPath $xpath): void
    {
        $elements = $xpath->query('//*');
        
        foreach ($elements as $element) {
            // Clean classes
            if ($element->hasAttribute('class')) {
                $classes = $element->getAttribute('class');
                $classes = preg_replace([
                    '/(MsoBodyText|TableNormal|MsoNormal|MsoTableGrid)/i',
                    '/\s{2,}/'
                ], [
                    '',
                    ' '
                ], $classes);
                
                if (trim($classes) === '') {
                    $element->removeAttribute('class');
                } else {
                    $element->setAttribute('class', trim($classes));
                }
            }

            // Clean styles
            if ($element->hasAttribute('style')) {
                $style = $element->getAttribute('style');
                
                // Remove MSO specific styles
                $style = preg_replace('/mso-[^:]+:[^;]+;?\s*/i', '', $style);
                
                // Extract text alignment if present
                $textAlign = '';
                if (preg_match('/text-align:\s*(justify|center|left|right);?/i', $style, $matches)) {
                    $textAlign = strtolower($matches[1]);
                }
                
                // Remove unwanted style properties
                $unwantedProps = [
                    'font-size',
                    'font-family',
                    'line-height',
                    'margin',
                    'padding',
                    'border',
                    'background',
                    'color',
                    'letter-spacing',
                    'text-indent',
                    'text-decoration'
                ];
                
                foreach ($unwantedProps as $prop) {
                    $style = preg_replace("/$prop:[^;]+;?\s*/i", '', $style);
                }
                
                // Set only text alignment if it exists
                if ($textAlign) {
                    $element->setAttribute('style', "text-align: $textAlign");
                } else {
                    $element->removeAttribute('style');
                }
            }
        }
    }

    private static function removeEmptyTags(DOMXPath $xpath, DOMDocument $dom): void
    {
        $emptyTags = $xpath->query('//span|//div|//em|//strong|//a|//p|//b|//i');
        
        foreach ($emptyTags as $tag) {
            // Convert non-breaking spaces and trim
            $content = trim(str_replace(["\xC2\xA0", "\xA0", "&nbsp;"], ' ', $tag->nodeValue));
            
            if (empty($content)) {
                // Replace empty tags with a single space
                if ($tag->parentNode) {
                    $space = $dom->createTextNode(' ');
                    $tag->parentNode->replaceChild($space, $tag);
                }
            }
        }
    }

    private static function postProcessHtml(string $html): string
    {
        // Remove XML declaration and DOCTYPE
        $html = preg_replace([
            '/<\?xml[^>]+>/i',
            '/<!DOCTYPE[^>]+>/i',
            '/<html><body>/',
            '/<\/body><\/html>/',
            '/<div>(.*?)<\/div>/s'
        ], [
            '',
            '',
            '',
            '',
            '$1'
        ], $html);

        // Replace multiple spaces
        $html = preg_replace('/\s+/', ' ', $html);
        
        // Replace non-breaking spaces
        $html = str_replace(['&nbsp;', '&#160;'], ' ', $html);
        
        // Clean up multiple blank lines
        $html = preg_replace("/(\r?\n){2,}/", "\n\n", $html);
        
        return trim($html);
    }
}