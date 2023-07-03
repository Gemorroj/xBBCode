# Parser BBcode

[![Continuous Integration](https://github.com/Gemorroj/xBBCode/workflows/Continuous%20Integration/badge.svg?branch=master)](https://github.com/Gemorroj/xBBCode/actions?query=workflow%3A%22Continuous+Integration%22)


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
 - PHP >= 8.0.2


### Installation:
```bash
composer require gemorroj/xbbcode
```


### License: 
 - GNU GPL v 2
