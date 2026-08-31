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

| Order | Command               | Checks              |
| ----- | --------------------- | ------------------- |
| 1     | pest                  | tests               |

## Behavior

If a fix is needed, spawn 1 agent per assertion to fix (e.g typechecking / tests / rules violated on category UI = 3 agents).

## Before push

| Order | Command               | Checks              |
| ----- | --------------------- | ------------------- |
| 1     | pest                  | tests               |
| 2     | pest --filter Architecture | architecture rules |

## Architecture Tests

Architecture principles are enforced via Pest Arch Testing in `tests/Architecture/`:

- **DomainDrivenDesignTest.php**: Domain-Driven Design layer separation rules (Domain, Application, Infrastructure, Presentation)
- **SolidTest.php**: SOLID principles enforcement (SRP, OCP, LSP, ISP, DIP)
- **DryTest.php**: DRY (Don't Repeat Yourself) principle enforcement
- **KissTest.php**: KISS (Keep It Simple, Stupid) principle enforcement

## Coding Principles

See [coding-principles.md](coding-principles.md) for SOLID, KISS, DRY, and code commenting rules that must be followed in all production code.