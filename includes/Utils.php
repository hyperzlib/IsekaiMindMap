<?php
namespace Isekai\MindMap;

use MediaWiki\Html\Html;

class Utils {
    public static function simpleHtmlEscape($text) {
        return str_replace(
            ['<', '>'],
            ['&lt;', '&gt;'],
            $text
        );
    }

    private static function getNodePlainTextOutput($nodeData, $depth = 0) {
        $htmlContent = '';
        if (isset($nodeData->data) && isset($nodeData->data->text)) {
            $text = strip_tags($nodeData->data->text);
            $htmlContent .= Html::element('li', [], $text);
        }

        if (isset($nodeData->children) && count($nodeData->children) > 0) {
            $childrenHtml = '';
            foreach ($nodeData->children as $child) {
                $childrenHtml .= self::getNodePlainTextOutput($child, $depth + 1);
            }

            $htmlContent .= Html::rawElement('ul', [], $childrenHtml);
        }
        
        return $htmlContent;
    }

    public static function getMindMapPlainTextOutput($mindMapData) {
        // walk through the mind map content and return the text
        if (!$mindMapData || !isset($mindMapData->root)) {
            return '';
        }

        $root = $mindMapData->root;

        $rootHtml = self::getNodePlainTextOutput($root, 0);
        return Html::rawElement('ul', [], $rootHtml);
    }
}