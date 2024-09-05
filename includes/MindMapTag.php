<?php

namespace Isekai\MindMap;

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
            return '<div>MindMap格式错误</div>';
        }

        $mindMapData = json_decode($text);
        if (!$mindMapData) {
            return '<div>MindMap格式错误</div>';
        }

        $mindMapPlainText = Utils::getMindMapPlainTextOutput($mindMapData);

        return '<div class="isekai-mindMap-plaintext">' . $mindMapPlainText . '</div>' .
            '<script type="application/x-isekai-mindmap">' . Utils::simpleHtmlEscape($text) . '</script>';
    }
}
