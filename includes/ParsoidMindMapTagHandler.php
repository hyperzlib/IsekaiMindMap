<?php

namespace Isekai\MindMap;

use Wikimedia\Parsoid\DOM\DocumentFragment;
use Wikimedia\Parsoid\Ext\ExtensionTagHandler;
use Wikimedia\Parsoid\Ext\ParsoidExtensionAPI;
use Wikimedia\Parsoid\Tokens\KV;

class ParsoidMindMapTagHandler extends ExtensionTagHandler {
    public function toArgs(array $extArgs): array {
        $ret = [];
        /** @var KV $extArg */
        foreach ($extArgs as $extArg) {
            $ret[$extArg->k] = $extArg->v;
        }
        return $ret;
    }

    public function sourceToDom(ParsoidExtensionAPI $extApi, string $src, array $extArgs): DocumentFragment {
        $plainTextOutput = Utils::getMindMapPlainTextOutput(json_decode($src));

        $parsed = $extApi->extTagToDOM(
            [],
            $plainTextOutput,
            [
                'wrapperTag' => 'div',
                'parseOpts' => [
                    'extTag' => 'isekaimindmap',
                    'context' => 'block'
                ],
            ]
        );

        return $parsed;
    }
}