<?php

namespace Isekai\MindMap;

use Html;

class MindMapTag {
    /**
     * @param string $text
     * @param array $params
     * @param \Parser $parser
     * @param \PPFrame $frame
     * @return string|string[]
     */
    public static function render($text, $params, \Parser $parser, \PPFrame $frame) {
        $parser->getOutput()->addModules(['ext.isekaiMindMap']);

        if (!trim($text) === "") {
            return Html::element('div', [], wfMessage('error-isekai-mindmap-invalid')->parse());
        }

        $mindMapData = json_decode($text);
        if (!$mindMapData) {
            return Html::element('div', [], wfMessage('error-isekai-mindmap-invalid')->parse());
        }

        $mindMapPlainText = Utils::getMindMapPlainTextOutput($mindMapData);

        return Html::rawElement('div', ['class' => 'isekai-mindMap-plaintext'], $mindMapPlainText) .
            Html::rawElement('script', ['type' => 'application/x-isekai-mindmap'], Utils::simpleHtmlEscape($text));
    }
}
