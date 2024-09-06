# Isekai MindMap
Isekai MindMap 可以让你在 MediaWiki 中编辑和展示思维导图。基于 [simple-mind-map](https://github.com/wanglin2/mind-map) 开发。

## 安装
1. 下载扩展并将其放在 MediaWiki 安装的 `extensions` 目录中。
2. 在 LocalSettings.php 中添加以下代码：
```php
wfLoadExtension( 'IsekaiMindMap' );
```

## 用法
只需在 `MindMap` 命名空间下创建新页面即可创建思维导图。

要在页面中嵌入思维导图，请使用与插入模板相同的语法：
```wikicode
{{MindMap:PageName}}
```