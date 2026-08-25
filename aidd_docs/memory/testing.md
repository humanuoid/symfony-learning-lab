# Testing

The project's testing approach and how to run the suite.

## Stack

- Pest as the test framework (configured in composer.json)
- PHPUnit as the test runner (configured in phpunit.xml)
- Symfony BrowserKit and DebugBundle for functional testing

## How to run

- All tests: `composer exec pest` or `./vendor/bin/pest`
- With coverage: `XDEBUG_MODE=coverage ./vendor/bin/pest --coverage`

## Test structure

- Tests live in `tests/` directory
- Follow Pest's syntax: `it()`, `expect()`, `beforeEach()`, `afterEach()`
- Test files suffix: `Test.php`

## Current state

- No test files exist yet (empty tests/ directory except bootstrap.php)
- Pest and PHPUnit configured but no tests written
