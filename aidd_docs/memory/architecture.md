# Architecture

The macro technical shape: the stack, how the pieces fit, and the decisions behind them. Point to the code, do not restate it.

## Stack

- PHP 8.2+ with Symfony 7.4 full-stack framework
- FrankenPHP as PHP application server in Docker containers
- Twig for templating, Doctrine for ORM
- Pest for testing, PHPStan for static analysis

## How it fits together

The macro flow between the main parts. One box per area, high level only.

```mermaid
flowchart LR
    Request[HTTP Request] --> Presentation[Presentation]
    Presentation --> Application[Application]
    Application --> Domain[Domain]
    Infrastructure[Infrastructure] --> Domain
    Infrastructure --> Database[(Database)]
    Presentation --> Twig[Twig Templates]
    Twig --> Response[HTTP Response]
```

## Key decisions

- Docker-based development environment for consistency across platforms
- FrankenPHP for modern PHP application serving
- Symfony 7.4 for latest features and long-term support

## Gotchas

- Docker configuration in `.docker/frankenphp/` for local development

## Domain-Driven Design (DDD) & Clean Architecture

### Structure
Code organized by **bounded contexts** (business capabilities) with strict layer separation. See `src/` for implementation.

```
src/
├── {BoundedContext}/          # e.g. User/, Billing/
│   ├── Domain/               # Business rules (entities, value objects, repository interfaces)
│   ├── Application/          # Use cases (organized by feature in UseCase/)
│   │   └── UseCase/         # Feature-based use cases (e.g. RegisterUser/, LoginUser/)
│   ├── Infrastructure/       # Technical details (Doctrine, API clients)
│   └── Presentation/         # HTTP/CLI entry points (controllers, templates)
└── Shared/                   # Cross-cutting concerns (Kernel, Bus, exceptions)
```

### Layers
| Layer | Responsibility | Can depend on | Cannot depend on |
|-------|----------------|---------------|-------------------|
| Domain | Business rules (pure PHP) | Self, Shared/Domain | Application, Infrastructure, Presentation, Symfony, Doctrine |
| Application | Use case coordination | Domain, Shared/Application | Infrastructure, Presentation |
| Infrastructure | Technical implementation | Domain, Application, Shared | - |
| Presentation | HTTP/CLI entry points | Domain, Application, Infrastructure, Symfony, Doctrine | - |

> **Domain layer contains only pure PHP objects** (entities, value objects, repository interfaces) with zero framework dependencies.

### Key Decisions
- **Bounded Contexts**: Group code by business capability (User, Billing), not by technical type (Controller, Entity)
- **Doctrine Mappings**: External YAML files in `src/{BoundedContext}/Infrastructure/Persistence/Doctrine/` to decouple Domain from ORM (UNIQUE correct location)
- **UseCase Organization**: Features are grouped under `Application/UseCase/{FeatureName}/` with strict DDD layer separation
- **CQRS**: Available but optional; use only when read/write have different requirements (e.g. projections, caching)
- **Event-Driven**: 
  - Synchronous events via `EventDispatcher` (immediate, atomic)
  - Asynchronous via Messenger (long-running, retryable)
- **Architecture Enforcement**: Pest Arch Testing (see `tests/Architecture/`)
