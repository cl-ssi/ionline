<?php

namespace App\Services;

use DOMDocument;

class ColorCleaner
{
    public static function clean(string $content): string
    {
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query('//span|//p');

        foreach ($elements as $element) {
            if ($element->hasAttribute('style')) {
                $style = $element->getAttribute('style');
                $style = preg_replace('/(color|background[^:]*):([^;]+;)/', '', $style);
                
                if (trim($style) === '') {
                    $element->removeAttribute('style');
                    if (!$element->hasAttributes()) {
                        $fragment = $dom->createDocumentFragment();
                        $fragment->appendChild($dom->createTextNode($element->textContent));
                        $element->parentNode->replaceChild($fragment, $element);
                    }
                } else {
                    $element->setAttribute('style', trim($style));
                }
            }
        }

        $cleanedHtml = $dom->saveHTML();
        return preg_replace('/<\?xml encoding="UTF-8"\>/', '', $cleanedHtml);
    }
}