# Parser BBcode

[![Continuous Integration](https://github.com/Gemorroj/xBBCode/workflows/Continuous%20Integration/badge.svg)](https://github.com/Gemorroj/xBBCode/actions?query=workflow%3A%22Continuous+Integration%22)


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
 - PHP >= 8.1


### Security Note:
- Geshi has security problem https://github.com/GeSHi/geshi-1.0/issues/159
- This doesn't seem relevant for XbbCode.
- To avoid composer blocking, use `--no-security-blocking` option.


### Installation:
```bash
composer require gemorroj/xbbcode --no-security-blocking
```


### License: 
 - GNU GPL v 2
