# Testing

How the project is tested: the layers, the tools, and the conventions. Where tests live and how to run them.

## Strategy

- Unit and integration tests with Pest
- Architecture tests with Pest Arch Testing

## Types

- **Unit tests**: Test individual classes or functions in isolation (Domain layer: entities, value objects, services). Use Pest's `it()` or `test()` for pure PHP logic without dependencies.

- **Integration tests**: Verify multiple components work together (Application layer: use cases, handlers) with their real dependencies (repositories, services). Test coordination logic with mocked or real Infrastructure.

- **Functional tests**: Verify end-to-end behavior as a user would experience it (Presentation layer: controllers, CLI commands). Test full HTTP requests or console commands with real or test database.

## Directory Structure

```
tests/
├── Unit/                    # Unit tests for Domain layer
│   └── {BoundedContext}/    # e.g., User/, Dashboard/
│       └── Domain/
│           ├── Model/
│           │   ├── Entity/
│           │   └── ValueObject/
│           └── Event/
│
├── Integration/             # Integration tests for Application layer
│   └── {BoundedContext}/
│       └── Application/
│           └── UseCase/
│               └── {FeatureName}/
│
├── Functional/              # Functional tests for Presentation layer
│   └── {BoundedContext}/
│       └── Presentation/
│           ├── Web/
│           └── Console/
│
└── Architecture/            # Architecture tests
```

## Tools

- Pest as test runner and assertion library

## Conventions

- Tests live in `tests/` directory
- Test files follow Pest conventions
- Architecture tests in `tests/Architecture/`

## Naming Conventions

| Test Type | Naming Pattern | Location |
|-----------|----------------|----------|
| Unit | `{ClassName}Test.php` | `tests/Unit/{BoundedContext}/Domain/...` |
| Integration | `{UseCase}Test.php` | `tests/Integration/{BoundedContext}/Application/UseCase/{FeatureName}/` |
| Functional | `{Controller}Test.php` or `{Command}Test.php` | `tests/Functional/{BoundedContext}/Presentation/{Web|Console}/` |
| Architecture | `{Principle}Test.php` | `tests/Architecture/` |

## Run

- Run all tests: `pest` or `./vendor/bin/pest`
- Run architecture tests only: `pest --filter Architecture`

## Browser QA

- Entry: http://localhost (when running with Docker/FrankenPHP)
- Auth: Not configured (starter project)
- State: No fixtures yet (starter project)