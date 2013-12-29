<?php
//TODO
require __DIR__ . '/../src/Xbbcode/Xbbcode.php';
require __DIR__ . '/../src/Xbbcode/Tag/Tag.php';
require __DIR__ . '/../src/Xbbcode/Tag/A.php';
require __DIR__ . '/../src/Xbbcode/Tag/Simple.php';
require __DIR__ . '/../src/Xbbcode/Attributes.php';

$text = 'Это [b]пример[/b] работы парсера [url=https://github.com/Gemorroj/xBBCode]Xbbcode[/url].';
$xbbcode = new \Xbbcode\Xbbcode($text);

echo $xbbcode->getHtml();
