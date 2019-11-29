# Parser BBcode

[![Build Status](https://secure.travis-ci.org/Gemorroj/xBBCode.png?branch=master)](https://travis-ci.org/Gemorroj/xBBCode)


### Example:

```php
<?php
use Xbbcode\Xbbcode;

$text = 'Это [b]пример[/b] работы парсера [url=https://github.com/Gemorroj/xBBCode]xBBCode[/url].';
$xbbcode = new Xbbcode();
$xbbcode->parse($text);

echo $xbbcode->getHtml();
```

### Requirements:
 - PHP >= 7.1.3


### Installation:
```bash
composer require gemorroj/xbbcode
```


### License: 
 - GNU GPL v 2
