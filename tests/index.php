<?php
//TODO
require __DIR__ . '/../src/Xbbcode/Xbbcode.php';
require __DIR__ . '/../src/Xbbcode/Tag/Tag.php';
require __DIR__ . '/../src/Xbbcode/Tag/A.php';
require __DIR__ . '/../src/Xbbcode/Tag/Simple.php';
require __DIR__ . '/../src/Xbbcode/Tag/Code.php';
require __DIR__ . '/../src/Xbbcode/Attributes.php';
require 's:\VCS\Git\geshi\geshi.php';

$text = '
Это [b]пример[/b] работы парсера [url=https://github.com/Gemorroj/xBBCode]Xbbcode[/url].
[php]$str = "Hello github!";
echo str_replace("github", "world", $str);
[/]
ссылка http://github.com/Gemorroj/xBBCode
';
$xbbcode = new \Xbbcode\Xbbcode();
$xbbcode->setKeywordLinks(true);
$xbbcode->setAutoLinks(true);
$xbbcode->parse($text);

echo $xbbcode->getHtml();
$stat = $xbbcode->getStatistics();
$stat['memory_peak_usage'] = ($stat['memory_peak_usage'] / 1024 / 1024) . ' mb';
print_r($stat);

