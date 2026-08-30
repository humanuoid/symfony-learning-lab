# Testing

How the project is tested: the layers, the tools, and the conventions. Where tests live and how to run them.

## Strategy

- Unit and integration tests with Pest
- Architecture tests with Pest Arch Testing

## Tools

- Pest as test runner and assertion library

## Conventions

- Tests live in `tests/` directory
- Test files follow Pest conventions
- Architecture tests in `tests/Architecture/`

## Run

- Run all tests: `pest` or `./vendor/bin/pest`
- Run architecture tests only: `pest --filter Architecture`

## Browser QA

- Entry: http://localhost (when running with Docker/FrankenPHP)
- Auth: Not configured (starter project)
- State: No fixtures yet (starter project)