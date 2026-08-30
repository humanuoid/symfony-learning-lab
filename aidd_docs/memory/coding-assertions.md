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

Enforce DDD layer separation and UseCase organization using Pest Arch Testing (see `tests/Architecture/DomainTest.php`):

```php
// Layer separation
test('Domain ne dépend pas de Symfony ou Doctrine')
    ->expect('App\**\Domain\*')
    ->not->toDependOnAny(['Symfony\*', 'Doctrine\*']);

test('Application ne dépend pas de Infrastructure')
    ->expect('App\**\Application\*')
    ->not->toDependOn('App\**\Infrastructure\*');

test('Infrastructure peut dépendre de Domain et Application')
    ->expect('App\**\Infrastructure\*')
    ->toDependOnAny(['App\**\Domain\*', 'App\**\Application\*']);

// UseCase organization
test('Les UseCases sont dans Application/UseCase/')
    ->expect('App\**\Application\UseCase\*')
    ->toBeDirectories();

test('Les Commandes sont dans leur UseCase')
    ->expect('App\**\Application\UseCase\*\*Command')
    ->toBeClasses();

test('Les Handlers sont dans leur UseCase')
    ->expect('App\**\Application\UseCase\*\*Handler')
    ->toBeClasses();

// Doctrine mappings location
test('Les mappings Doctrine sont dans Infrastructure/Persistence/Doctrine/')
    ->expect('App\**\Infrastructure\Persistence\Doctrine\*.orm.yaml')
    ->toExist();

test('Aucun mapping Doctrine dans config/')
    ->expect('config\/doctrine\/\*.orm.yaml')
    ->not->toExist();
```