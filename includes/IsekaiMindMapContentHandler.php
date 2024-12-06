<?php

namespace Isekai\MindMap;

use Content;
use JsonContentHandler;
use MediaWiki\Parser\ParserOutput;
use MediaWiki\Content\Renderer\ContentParseParams;

class IsekaiMindMapContentHandler extends JsonContentHandler {
    public function __construct($modelId = CONTENT_MODEL_ISEKAI_MINDMAP) {
        parent::__construct($modelId, [CONTENT_FORMAT_JSON]);
    }

    /**
	 * @return string
	 */
	protected function getContentClass() {
		return IsekaiMindMapContent::class;
	}

    public function supportsDirectEditing() {
        return true;
    }

    /**
	 * Set the HTML and add the appropriate styles.
	 *
	 * @since 1.38
	 * @param Content $content
	 * @param ContentParseParams $cpoParams
	 * @param ParserOutput &$parserOutput The output object to fill (reference).
	 */
	protected function fillParserOutput(
		Content $content,
		ContentParseParams $cpoParams,
		ParserOutput &$parserOutput
	) {
		/** @var IsekaiMindMapContent $content */
		// FIXME: WikiPage::doUserEditContent generates parser output before validation.
		// As such, native data may be invalid (though output is discarded later in that case).
		if ($cpoParams->getGenerateHtml() && $content->isValid()) {
			$parserOutput->setRawText($content->getOutputScriptData());
			$parserOutput->addModuleStyles(['ext.isekaiMindMap']);
			$parserOutput->addModules(['ext.isekaiMindMap']);
		} else {
			$parserOutput->setRawText(null);
		}
	}
}
