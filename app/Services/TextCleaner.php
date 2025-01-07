<?php

namespace App\Services;

use DOMDocument;
use DOMNode;

class TextCleaner
{
    public static function clean(string $content): string
    {
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Convertir encabezados a párrafos con negrita
        foreach (['h1', 'h2', 'h3', 'h4'] as $tag) {
            $headers = $dom->getElementsByTagName($tag);
            while ($headers->length > 0) {
                $header = $headers->item(0);
                $p = $dom->createElement('p');
                $strong = $dom->createElement('strong', $header->nodeValue);
                $p->appendChild($strong);
                $header->parentNode->replaceChild($p, $header);
            }
        }

        // Limpiar estilos y clases
        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query('//*');
        
        foreach ($elements as $element) {
            // Limpiar clases específicas
            if ($element->hasAttribute('class')) {
                $classes = $element->getAttribute('class');
                $classes = preg_replace('/(MsoBodyText|TableNormal|MsoNormal|MsoTableGrid)/i', '', $classes);
                if (trim($classes) === '') {
                    $element->removeAttribute('class');
                } else {
                    $element->setAttribute('class', trim($classes));
                }
            }

            // Limpiar estilos
            if ($element->hasAttribute('style')) {
                $style = $element->getAttribute('style');
                $style = preg_replace('/mso-[^:]+:[^;]+;?/i', '', $style);
                
                // Preservar alineación si existe
                $textAlign = '';
                if (preg_match('/text-align:\s*(justify|center);?/', $style, $matches)) {
                    $textAlign = $matches[1];
                }
                
                // Eliminar propiedades específicas
                $style = preg_replace('/(font-size|font-family|line-height|margin|letter-spacing)[^;]+;?/', '', $style);
                
                if ($textAlign) {
                    $element->setAttribute('style', "text-align: $textAlign");
                } else {
                    $element->removeAttribute('style');
                }
            }
        }

        // Limpiar etiquetas vacías
        $elements = $xpath->query('//span|//div|//em|//strong|//a');
        foreach ($elements as $element) {
            $content = trim(str_replace('&nbsp;', ' ', $element->nodeValue));
            if (empty($content)) {
                $space = $dom->createTextNode(' ');
                $element->parentNode->replaceChild($space, $element);
            }
        }

        $cleanedHtml = $dom->saveHTML();
        $cleanedHtml = preg_replace('/<\?xml encoding="UTF-8"\>/', '', $cleanedHtml);
        $cleanedHtml = str_replace('&nbsp;', ' ', $cleanedHtml);
        
        return $cleanedHtml;
    }
}