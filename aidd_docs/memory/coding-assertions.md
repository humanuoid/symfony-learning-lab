# Coding Assertions

The checks that must pass for code to count as done. Minimal, run after every change.

## Before commit

The fast gate.

| Order | Command     | Checks           |
| ----- | ----------- | ---------------- |
| 1     | phpcs       | code style       |
| 2     | phpstan     | static analysis  |

## Before push

The heavier gate.

| Order | Command     | Checks              |
| ----- | ----------- | ------------------- |
| 1     | pest        | tests               |

## Behavior

If a fix is needed, spawn 1 agent per assertion to fix (e.g typechecking / tests / rules violated on category UI = 3 agents).

## Before push

| Order | Command               | Checks              |
| ----- | --------------------- | ------------------- |
| 1     | pest                  | tests               |
| 2     | pest --filter Architecture | architecture rules |

## Architecture Tests

Enforce DDD layer separation using Pest Arch Testing (see `tests/Architecture/DomainTest.php`):

```php
test('Domain ne dépend pas de Symfony ou Doctrine')
    ->expect('App\**\Domain\*')
    ->not->toDependOnAny(['Symfony\*', 'Doctrine\*']);

test('Application ne dépend pas de Infrastructure')
    ->expect('App\**\Application\*')
    ->not->toDependOn('App\**\Infrastructure\*');

test('Infrastructure peut dépendre de Domain et Application')
    ->expect('App\**\Infrastructure\*')
    ->toDependOnAny(['App\**\Domain\*', 'App\**\Application\*']);
```