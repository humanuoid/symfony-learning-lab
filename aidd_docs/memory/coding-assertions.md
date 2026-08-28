# Coding Assertions

The project's coding standards and how they are enforced. What must hold and how to check it.

## Standards

- PSR-12 coding style via PHP CodeSniffer
- PHPStan level 9 for static analysis
- Symfony best practices
- Strict types declarations
- **Clean Architecture**: Dependencies only point inwards (Infrastructure → Application → Domain)
- **KISS**: Keep It Simple, Stupid - prefer simplicity over complexity
- **SOLID** principles strictly enforced

## Code Commenting Rules

### When to Comment
- **Only if necessary**: If the code is **not self-explanatory** or **non-obvious**.
- **Avoid comments for trivial code**: Well-written code should not need comments to explain **what** it does.

### Language
- **Use simple English**: Easy to understand for a French developer with **intermediate English level**.
- **Avoid complex terms**: Prefer short, clear sentences.

### Content: WHY, Not WHAT
- **✅ DO comment**: The **reason** behind the code (business rule, technical constraint, historical context).
- **❌ DO NOT comment**: What the code does (the code itself should be clear).

### Examples

#### Good Comments (WHY)
```php
// We use a custom hash algorithm here because the standard one
// was compromised in a security audit in 2023.
$hashedPassword = $this->customHash($password);

// This check is required by GDPR to ensure users can delete their data.
if ($user->hasActiveOrders()) {
    throw new CannotDeleteUserException();
}

// TODO: Remove this workaround when Symfony fixes the bug in v6.4
// See: https://github.com/symfony/symfony/issues/12345
$response = $this->fixResponseHeaders($response);
```

#### Bad Comments (WHAT)
```php
// Increment the counter
$counter++;

// Get the user by ID
$user = $this->userRepository->findById($id);

// Loop through all users
foreach ($users as $user) {
    // Print user name
    echo $user->name();
}
```

#### Better Than Comments: Well-Named Code
```php
// ❌ Bad: Comment explains what the code does
// Check if user is admin
if ($user->role === 'admin') {
    // ...
}

// ✅ Good: Code is self-explanatory
if ($user->isAdmin()) {
    // ...
}
```

### Special Cases
- **Public APIs**: Add **brief** PHPDoc for public methods (type hints are not enough for complex return types).
- **Complex Algorithms**: Add a **short explanation** of the logic (not line-by-line).
- **Temporary Code**: Use `// TODO:` or `// FIXME:` with a clear reason and deadline.

### PHPDoc Standards
- Use **only for public APIs** (classes, methods, functions).
- **Avoid** for private/protected methods (the code should be self-explanatory).
- **Keep it short**: 1-2 lines max.

```php
/**
 * Registers a new user in the system.
 * Throws exception if email is already in use.
 */
public function register(RegisterUserRequest $request): RegisterUserResponse
{
    // ...
}
```

## SOLID Principles

| Principle | Application | Enforcement |
|-----------|-------------|-------------|
| **S**ingle Responsibility | One class = one reason to change | Code review, PHPStan |
| **O**pen/Closed | Open for extension, closed for modification | Design review |
| **L**iskov Substitution | Subtypes must be substitutable | PHPStan, unit tests |
| **I**nterface Segregation | Small, focused interfaces | Code review |
| **D**ependency Inversion | Depend on abstractions (interfaces), not concretions | Autowiring + interfaces |

## Clean Architecture Rules

### Dependency Direction
- **Domain Layer** must **NOT** depend on **Application** or **Infrastructure** layers.
- **Application Layer** must **NOT** depend on **Infrastructure** layer.
- **Infrastructure Layer** can depend on **Domain** and **Application** layers.

**Violations**:
- ❌ `Domain/User/Entity/User.php` imports `Symfony\Component\HttpFoundation\Response`
- ❌ `Application/User/UseCase/RegisterUserUseCase.php` imports `Doctrine\ORM\EntityManager`
- ✅ `Infrastructure/User/Controller/UserController.php` imports `Application/User/UseCase/RegisterUserUseCase`

### Layer Responsibilities
| Layer | Must Contain | Must NOT Contain |
|-------|--------------|------------------|
| **Domain** | Entities, Value Objects, Repository Interfaces, Domain Events | Framework code, HTTP logic, DB logic |
| **Application** | Use Cases, DTOs, Application Services | Framework code, DB logic |
| **Infrastructure** | Controllers, Repository Implementations, Message Handlers | Business logic |

## KISS Guidelines

- **Max 1 level of abstraction** per method
- **Avoid premature optimization**
- **YAGNI**: You Aren't Gonna Need It - don't build what isn't needed
- **Prefer composition** over inheritance
- **Small methods**: Fit on screen (max ~20 lines)
- **Avoid deep nesting**: Max 2-3 levels of indentation

## DDD-Specific Assertions

### Domain Layer
- **Entities** must have rich behavior (not just getters/setters)
- **Value Objects** must be immutable (`final`, `readonly`)
- **Repository Interfaces** must be defined in `Domain/{Context}/Repository/`
- **Domain Events** must be immutable and extend Symfony's `Event`
- **No framework imports** in Domain Layer (no Symfony, no Doctrine)

### Application Layer
- **Use Cases** must orchestrate a single workflow
- **DTOs** must be immutable where possible (`readonly`)
- **No direct DB access** (use Repository Interfaces from Domain)
- **No framework imports** except for DTO validation (e.g., Symfony Validator attributes)

### Infrastructure Layer
- **Controllers** must be thin (delegate to Use Cases)
- **Repository Implementations** must implement Domain Repository Interfaces
- **Message Handlers** must be idempotent
- **No business logic** (delegate to Use Cases or Domain)

## Event-Driven Assertions

### Domain Events
- **Must** be raised within Domain Layer (Entities or Domain Services)
- **Must** be dispatched via Symfony EventDispatcher
- **Must** be named in past tense (e.g., `UserRegistered`, not `RegisterUser`)
- **Must** contain all relevant data for handlers

### Async Messages
- **Must** be dispatched via Symfony Messenger
- **Must** be handled by idempotent handlers
- **Must** have retry configuration in `messenger.yaml`
- **Must** use DTOs for input data (no raw arrays)

## How to Check

### Static Analysis
- `composer require --dev squizlabs/php_codesniffer` then `./vendor/bin/phpcs`
- `composer require --dev phpstan/phpstan` then `./vendor/bin/phpstan analyse`
- `composer require --dev rector/rector` then `./vendor/bin/rector`

### Dependency Checks
- **Domain Layer**: Run `grep -r "Symfony\\\\" src/Domain/` → **must return nothing**
- **Domain Layer**: Run `grep -r "Doctrine\\\\" src/Domain/` → **must return nothing**
- **Application Layer**: Run `grep -r "EntityManager" src/Application/` → **must return nothing**

### Architecture Tests
- **Domain Layer**: Must be testable with **only mocks for Repository Interfaces**
- **Application Layer**: Must be testable with **real Domain Layer + mocks for external services**
- **Infrastructure Layer**: Must be testable with **real Domain + Application Layers**

## Assertions

### General
- All PHP files must declare `declare(strict_types=1)`
- All classes must have proper type hints
- All public methods must have return type declarations
- All dependencies must be declared in composer.json
- No direct SQL queries - use Doctrine repositories
- Controllers must return Symfony Response objects

### Domain Layer
- **Domain entities** must NOT have Symfony/Doctrine imports
- **Value Objects** must be `final` and immutable
- **Repository Interfaces** must be in `Domain/{Context}/Repository/`
- **Domain Events** must extend `Symfony\Contracts\EventDispatcher\Event`

### Application Layer
- **Use Cases** must depend only on Domain Layer interfaces
- **DTOs** must be `readonly` where possible
- **Application Services** must NOT contain business logic (delegate to Domain)

### Infrastructure Layer
- **Controllers** must depend on Use Cases, not Domain directly
- **Repository Implementations** must implement Domain Repository Interfaces
- **Message Handlers** must implement `__invoke()` method
- **Message Handlers** must be idempotent (handle duplicates safely)

## Layer-Specific File Patterns

| Layer | File Pattern | Example |
|-------|--------------|---------|
| **Domain** | `src/Domain/{Context}/Entity/{Name}.php` | `src/Domain/User/Entity/User.php` |
| **Domain** | `src/Domain/{Context}/ValueObject/{Name}.php` | `src/Domain/User/ValueObject/Email.php` |
| **Domain** | `src/Domain/{Context}/Repository/{Name}RepositoryInterface.php` | `src/Domain/User/Repository/UserRepositoryInterface.php` |
| **Domain** | `src/Domain/{Context}/Event/{Name}.php` | `src/Domain/User/Event/UserRegistered.php` |
| **Application** | `src/Application/{Context}/UseCase/{Action}/{Name}UseCase.php` | `src/Application/User/UseCase/RegisterUser/RegisterUserUseCase.php` |
| **Application** | `src/Application/{Context}/UseCase/{Action}/{Name}Request.php` | `src/Application/User/UseCase/RegisterUser/RegisterUserRequest.php` |
| **Infrastructure** | `src/Infrastructure/{Context}/Controller/{Name}Controller.php` | `src/Infrastructure/User/Controller/UserController.php` |
| **Infrastructure** | `src/Infrastructure/{Context}/Repository/Doctrine{Name}Repository.php` | `src/Infrastructure/User/Repository/DoctrineUserRepository.php` |
| **Infrastructure** | `src/Infrastructure/{Context}/Messenger/{Name}Handler.php` | `src/Infrastructure/User/Messenger/SendWelcomeEmailHandler.php` |

## Common Violations and Fixes

| Violation | Example | Fix |
|-----------|---------|-----|
| Domain depends on Symfony | `new Response()` in `User.php` | Move to Infrastructure Layer |
| Application depends on Doctrine | `EntityManager` in Use Case | Use Repository Interface from Domain |
| Business logic in Controller | `if ($user->isValid())` in Controller | Move to Domain Entity or Use Case |
| Non-idempotent Handler | No duplicate check in Messenger Handler | Add idempotency key (e.g., `user_id + message_type`) |
| Large Use Case | 100+ lines in a Use Case | Split into smaller Use Cases or Domain Services |
| Anemic Domain Model | Only getters/setters in Entity | Add business methods to Entity |

## Example: Validating Architecture

### Check Domain Layer Independence
```bash
# Must return no results (Domain Layer should not depend on Symfony)
grep -r "Symfony\\\\" src/Domain/

# Must return no results (Domain Layer should not depend on Doctrine)
grep -r "Doctrine\\\\" src/Domain/
```

### Check Dependency Direction
```bash
# Must return no results (Application should not depend on Infrastructure)
grep -r "Infrastructure\\\\" src/Application/

# Must return no results (Domain should not depend on Application)
grep -r "Application\\\\" src/Domain/
```

### Check Use Case Thinness
```bash
# Controllers should be thin (delegate to Use Cases)
# Each controller method should have < 10 lines of logic
wc -l src/Infrastructure/*/Controller/*.php
```

## Summary

- **Clean Architecture**: Dependencies only point inwards.
- **DDD**: Rich Domain Layer, Bounded Contexts via namespaces.
- **Hexagonal**: Ports (interfaces) in Domain, Adapters (implementations) in Infrastructure.
- **KISS/SOLID**: Keep it simple, follow SOLID principles.
- **Testability**: Domain and Application layers must be testable in isolation.