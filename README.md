# Isekai MindMap

[中文文档](README_zh.md)

Isekai MindMap is a MediaWiki extension that allows users to create mind maps in a wiki page. It is based on the [simple-mind-map](https://github.com/wanglin2/mind-map)

## Installation
1. Download the extension and place it in the `extensions` directory of your MediaWiki installation.
2. Add the following code at the bottom of your LocalSettings.php:
```php
wfLoadExtension( 'IsekaiMindMap' );
```

## Usage
To create a mind map, just create new pages under the `MindMap` namespace.

To embed a mind map in a page, use the same syntax as inserting an template:
```wikicode
{{MindMap:PageName}}
```