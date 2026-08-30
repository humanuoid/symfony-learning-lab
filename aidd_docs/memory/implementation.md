# Implementation

The practical patterns, methodology, and examples for implementing features following the project's architecture.

## Patterns

### Command Pattern
- **Purpose**: Encapsulate write operations as explicit objects
- **Structure**: `{Action}Command` + `{Action}Handler`
- **Example**: `CreateUserCommand` → `CreateUserHandler`
- **Bus**: `command.bus` (Symfony Messenger)

### Query Pattern
- **Purpose**: Encapsulate read operations
- **Structure**: `{Action}Query` + `{Action}Handler` (optional, only if complex)
- **Usage**: Direct service calls for simple reads, Query objects for complex logic

### Event Pattern
- **Synchronous**: `EventDispatcher` for immediate side effects (e.g. validation, audit)
- **Asynchronous**: Messenger for long-running tasks (e.g. email, webhooks)
- **Nomenclature**: `{Action}Event` (sync), `{Action}Notification` (async)

### Repository Pattern
- **Interface**: Defined in `Domain/` (e.g. `UserRepository`)
- **Implementation**: In `Infrastructure/` (e.g. `DoctrineUserRepository`)
- **Purpose**: Decouple persistence from domain logic

### Value Object Pattern
- **Purpose**: Immutable objects representing values (e.g. `Email`, `UserId`)
- **Location**: `Domain/Model/ValueObject/`
- **Rule**: Always validate in constructor

## Implementation Methodology

### Steps to Implement a Feature in a Bounded Context
1. **Identify the bounded context** (e.g. `User/`)
2. **Define business rules** → `Domain/Entity` or `Domain/Service`
3. **Define user action** → `Application/UseCase/{FeatureName}/{FeatureName}Command` or `{FeatureName}Query`
4. **Define coordination** → `Application/UseCase/{FeatureName}/{FeatureName}Handler`
5. **Define persistence** → `Infrastructure/Persistence/{ORM}/{Entity}Repository`
6. **Define exposure** → `Infrastructure/Controller/{FeatureName}Controller` (HTTP) or `Infrastructure/Console/` (CLI)
7. **Define side effects** → `Domain/Event` (sync) or `Application/Notification` (async)
8. **Write tests** → Unit tests for Domain, integration tests for Application

### Example: User Registration (in `User/` context)
```
src/User/
├── Domain/
│   ├── Model/
│   │   ├── Entity/
│   │   │   └── User.php              # Business rules (User::create())
│   │   ├── Repository/
│   │   │   └── UserRepository.php    # Interface
│   │   └── ValueObject/
│   │       ├── UserId.php
│   │       └── Email.php
│   └── Event/
│       └── UserRegisteredEvent.php   # Domain event
│
├── Application/
│   └── UseCase/
│       └── RegisterUser/            # Feature-based organization
│           ├── RegisterUserCommand.php    # DTO
│           ├── RegisterUserHandler.php    # Coordinates use case
│           └── Exception/
│               └── EmailAlreadyUsedException.php
│
└── Infrastructure/
    ├── Persistence/
    │   ├── Doctrine/
    │   │   ├── User.orm.yaml         # YAML mapping (UNIQUE location)
    │   │   └── DoctrineUserRepository.php
    │   └── InMemoryUserRepository.php # For tests
    └── Controller/
        └── RegisterUserController.php # HTTP endpoint
```

### Example: User Deletion
- **Business Rule**: "User cannot delete account with active subscriptions"
  → `User::canBeDeleted()` in `Domain/Entity/User.php`
- **Action**: User clicks "Delete Account"
  → `DeleteUserCommand` in `Application/Command/`
- **Coordination**: Check subscriptions, delete user, notify admins
  → `DeleteUserHandler` in `Application/CommandHandler/`
- **Side Effects**: Send admin notification
  → `UserDeletedEvent` (sync) + `NotifyAdminsNotification` (async)

### Example: Authentication
- **Business Rule**: "User locked after 5 failed attempts"
  → `User::incrementFailedAttempts()` + `User::isLocked()` in `Domain/Entity/User.php`
- **Action**: User submits credentials
  → `AuthenticateUserCommand` in `Application/Command/`
- **Coordination**: Verify password, update attempts
  → `AuthenticateUserHandler` in `Application/CommandHandler/`
- **Side Effects**: 
  - `UserAuthenticatedEvent` (sync, for session)
  - `FailedLoginAttemptEvent` (sync, for counter)
  - `SecurityAlertNotification` (async, for admin email)

## When to Use Which Pattern

| Pattern | Use When | Example | Avoid When |
|---------|----------|---------|------------|
| Command | Write operation | `CreateUser`, `DeleteUser` | Read-only operations |
| Query | Complex read operation | `GetUserStats` | Simple reads (use service directly) |
| Event (sync) | Immediate side effects | Audit log, validation | Long-running tasks |
| Event (async) | Long-running tasks | Email, webhook, PDF generation | Atomic operations |

## Nomenclature Rules

### General Patterns
| Type | Prefix/Suffix | Example |
|------|---------------|---------|
| Command | `{Action}Command` | `RegisterUserCommand` |
| Query | `{Action}Query` | `GetUserQuery` |
| Event (domain) | `{Action}Event` | `UserRegisteredEvent` |
| Notification | `{Action}Notification` | `UserRegisteredNotification` |
| Repository (interface) | `{Entity}Repository` | `UserRepository` |
| Repository (implementation) | `Doctrine{Entity}Repository` | `DoctrineUserRepository` |

### UseCase Organization Rules
| Element | Convention | Example | Location |
|---------|------------|---------|----------|
| UseCase folder | `{Verbe}{Objet}` (PascalCase) | `RegisterUser/` | `Application/UseCase/` |
| Command | `{UseCase}Command` | `RegisterUserCommand.php` | `Application/UseCase/{UseCase}/` |
| Handler | `{UseCase}Handler` | `RegisterUserHandler.php` | `Application/UseCase/{UseCase}/` |
| Exception | `{UseCase}{Error}Exception` | `RegisterUserEmailAlreadyUsedException.php` | `Application/UseCase/{UseCase}/Exception/` |
| Controller | `{UseCase}Controller` | `RegisterUserController.php` | `Infrastructure/Controller/` |
| Template | `{context}/{use_case}.html.twig` | `user/register_user.html.twig` | `templates/` |
| Route | `/{context}/{action}` (kebab-case) | `/user/register` | `config/routes.yaml` |

### Doctrine Mapping Rules
- **UNIQUE location**: `src/{BoundedContext}/Infrastructure/Persistence/Doctrine/{Entity}.orm.yaml`
- **Never** in `config/doctrine/` (reserved for Symfony bundle configuration only)
- **Naming**: `{Entity}.orm.yaml` (e.g., `User.orm.yaml`)

## Doctrine Configuration
External YAML mappings to decouple Domain from ORM. **MUST** be located in `src/{BoundedContext}/Infrastructure/Persistence/Doctrine/{Entity}.orm.yaml` (UNIQUE correct location).

```yaml
# src/User/Infrastructure/Persistence/Doctrine/User.orm.yaml
App\User\Domain\Model\Entity\User:
  type: entity
  repositoryClass: App\User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository
  table: users
  id:
    id:
      type: user_id
      column: id
  fields:
    email:
      type: string
      unique: true
```
