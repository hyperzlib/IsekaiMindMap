<?php
namespace Isekai\MindMap;

use AbstractContent;
use Html;
use JsonContent;
use MediaWiki\MediaWikiServices;

class IsekaiMindMapContent extends JsonContent {
    public function __construct($text, $modelId = CONTENT_MODEL_ISEKAI_MINDMAP) {
        parent::__construct($text, $modelId);
    }

    public function isCountable($hasLinks = null) {
        if ($hasLinks === null) {
            return false;
        }
        
        return !$hasLinks;
    }

    public function getPlainTextOutput() {
        $mindMapContent = $this->getData()->value;

        return Utils::getMindMapPlainTextOutput($mindMapContent);
    }

    public function getTextForSearchIndex() {
        $plainTextOutput = $this->getPlainTextOutput();
        return preg_replace('/^\*+ ?/', '', $plainTextOutput);
    }

    public function getTextForSummary($maxlength = 250) {
        $text = $this->getTextForSearchIndex();

		$truncatedtext = MediaWikiServices::getInstance()->getContentLanguage()->
			truncateForDatabase( preg_replace( "/[\n\r]/", ' ', $text ), max( 0, $maxlength ) );

		return $truncatedtext;
    }

    public function getOutputScriptData() {
        return Html::rawElement('div', ['class' => 'isekai-mindMap-plaintext'], $this->getPlainTextOutput()) .
            Html::rawElement('script', ['type' => 'application/x-isekai-mindmap'], Utils::simpleHtmlEscape($this->getText()));
    }

    public function getWikitextForTransclusion() {
        return '<isekaimindmap>' . json_encode($this->getData()->value) . '</isekaimindmap>';
    }

    public function getName() {
        return 'MindMap';
    }
}
