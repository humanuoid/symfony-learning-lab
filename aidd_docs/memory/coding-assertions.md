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

DDD layer separation and UseCase organization rules are enforced via Pest Arch Testing in `tests/Architecture/`:

- **DomainTest.php**: Layer separation rules (Domain, Application, Infrastructure)
- **UseCaseTest.php**: UseCase organization rules
- **DoctrineTest.php**: Doctrine mappings location rules