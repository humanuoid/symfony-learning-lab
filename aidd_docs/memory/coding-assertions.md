# Coding Assertions

The project's coding standards and how they are enforced. What must hold and how to check it.

## Standards

- PSR-12 coding style via PHP CodeSniffer
- PHPStan level 9 for static analysis
- Symfony best practices
- Strict types declarations

## How to check

- `composer require --dev squizlabs/php_codesniffer` then `./vendor/bin/phpcs`
- `composer require --dev phpstan/phpstan` then `./vendor/bin/phpstan analyse`
- `composer require --dev rector/rector` then `./vendor/bin/rector`

## Assertions

- All PHP files must declare `declare(strict_types=1)`
- All classes must have proper type hints
- All public methods must have return type declarations
- All dependencies must be declared in composer.json
- No direct SQL queries - use Doctrine repositories
- Controllers must return Symfony Response objects
