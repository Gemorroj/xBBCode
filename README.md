# Парсер BBcode

[![Build Status](https://secure.travis-ci.org/Gemorroj/xBBCode.png?branch=master)](https://travis-ci.org/Gemorroj/xBBCode)


### Пример работы:

```php
<?php
use Xbbcode\Xbbcode;

$text = 'Это [b]пример[/b] работы парсера [url=https://github.com/Gemorroj/xBBCode]xBBCode[/url].';
$xbbcode = new Xbbcode();
$xbbcode->parse($text);

echo $xbbcode->getHtml();
```

### Требования:

- PHP >= 5.3


### Установка через composer:

- Добавьте проект в ваш файл composer.json:

```json
{
    "require": {
        "gemorroj/xbbcode": "dev-master"
    }
}
```
- Установите проект:

```bash
$ php composer.phar update gemorroj/xbbcode
```


### Условия использования:

Скрипт распространяется бесплатно по лицензии GNU GPL v 2.

Согласно этой лицензии, вы можете свободно использовать, распространять и
менять этот скрипт, при условии, что ваши собственные программные продукты,
использующие этот скрипт, не будут распространяться, либо будут
распространяться по той-же лицензии GNU GPL.
