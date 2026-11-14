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
 - PHP >= 8.2


### Security Note:
- Geshi has security problem https://github.com/GeSHi/geshi-1.0/issues/159
- This doesn't seem relevant for XbbCode.
- To avoid composer blocking, use `--no-blocking` option.


### Installation:
```bash
composer require gemorroj/xbbcode --no-blocking
```


### Code highlighting:
- **Server-side (default)** — GeSHi; `num`, `tab`, `extra`, `links`, `title` and `footer` are rendered by PHP. The markup carries CSS classes only, so colors come from `resources/style.css` and no JS is needed.
- **Client-side** — `$xbbcode->setCodeHighlighting(false)` emits plain `<pre><code class="language-*">` plus `data-*` hints for the highlighter (`num` → `data-start`, `tab` → `data-tab-width`, `extra` → `data-highlight-lines`, `links` → `data-keyword-links`). Colors come from the highlighter's theme.


### Notes:
- Optional styling: `resources/style.css`. Colors follow the page `color-scheme` via `light-dark()` — declare `color-scheme: dark` for the dark palette; any `--xbbcode-*` variable can be overridden.
- `[spoiler]`/`[hide]` render native `<details>`; the legacy `Spoiler` handler is deprecated.


### License: 
 - GNU GPL v 2
