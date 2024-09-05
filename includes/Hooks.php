<?php
namespace Isekai\MindMap;

use EditPage;
use OutputPage;
use Title;

class Hooks {
    public static function registrationCallback() {
		require_once dirname(__DIR__) . '/defines.php';
    }

    /**
	 * 设置默认的内容模型
	 * @param Title $title the Title in question
	 * @param string &$model The model name
	 * @return bool
	 */
	public static function onContentHandlerDefaultModelFor($title, &$model) {
		if ($title->getNamespace() === NS_MINDMAP) {
			$model = CONTENT_MODEL_ISEKAI_MINDMAP;
			return false;
		}
		return true;
	}

	/**
	 * 显示思维导图编辑器
	 * @param EditPage $editpage
	 * @param OutputPage $output
	 * @throws ErrorPageError
	 */
	public static function onEditPageShowEditFormInitial(EditPage $editpage, OutputPage $output) {
		$title = $editpage->getContextTitle();
		$model = $editpage->contentModel;
		$format = $editpage->contentFormat;

		if ($model === CONTENT_MODEL_ISEKAI_MINDMAP) {
			$output->addModules('ext.isekaiMindMap.editor');
		}
	}

	/**
     * @param \Parser $parser
     * @return bool
     * @throws \MWException
     */
    public static function onParserSetup(&$parser) {
		$parser->setHook('isekaimindmap', [MindMapTag::class, 'render']);
		return true;
	}
}