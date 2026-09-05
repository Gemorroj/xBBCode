# AGENTS.md

## Project

xBBCode — a PHP BBCode-to-HTML parser (GNU GPL v2 license). Composer package `gemorroj/xbbcode`.

- Requirements: PHP >= 8.2, `geshi/geshi`.
- Namespaces: `Xbbcode\` → `src/`, tests `Xbbcode\Tests\` → `tests/`.
- Entry point: `Xbbcode\Xbbcode` (`$xbbcode->parse($text); echo $xbbcode->getHtml();`).
- Tags are implemented as classes in `src/Tag/` (extending `TagAbstract`), with tests in `tests/Tag/`.

## Commands

```bash
# Run tests
vendor/bin/phpunit

# Format code (php-cs-fixer)
vendor/bin/php-cs-fixer fix
```

## Code conventions

- Style: Symfony + PHP 8.2 migration rules (see `.php-cs-fixer.dist.php`).
- No `declare(strict_types=1)`.
- Always run `vendor/bin/php-cs-fixer fix` and `vendor/bin/phpunit` after making changes.
- When adding a new tag: create a class in `src/Tag/` and a test in `tests/Tag/`.

## Misc

- Installation: `composer require gemorroj/xbbcode --no-security-blocking` (Geshi has a known vulnerability, not relevant for xBBCode).
- Do not commit changes unless explicitly asked.
