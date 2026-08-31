# Coding Principles

The fundamental principles that guide how we write code in this project. These are non-negotiable and must be followed in all production code.

## Core Principles

### SOLID

#### Single Responsibility Principle (SRP)
Each class, method, or module should have only one reason to change. It does one thing and does it well.

> A class should have only one responsibility, meaning it should have only one reason to change.

**Example**: A `UserRepository` should only handle user persistence. It should not also send emails or validate business rules.

#### Open/Closed Principle (OCP)
Software entities (classes, modules, functions) should be open for extension but closed for modification.

> You should be able to extend behavior without modifying existing code.

**Implementation**: Use interfaces and dependency injection. Extend via new classes, not by modifying existing ones.

**Example**: Add new validation rules by creating new validator classes, not by modifying the existing validator.

#### Liskov Substitution Principle (LSP)
Subtypes must be substitutable for their base types without altering the correctness of the program.

> If S is a subtype of T, then objects of type T should be replaceable with objects of type S without breaking the program.

**Example**: If `AdminUser` extends `User`, any code that works with `User` must also work with `AdminUser`.

#### Interface Segregation Principle (ISP)
Clients should not be forced to depend on interfaces they do not use.

> Many small, specific interfaces are better than one large, general interface.

**Implementation**: Split large interfaces into smaller, focused ones. Clients depend only on what they need.

**Example**: Instead of `UserRepository` with 20 methods, have `UserReader`, `UserWriter`, `UserDeleter` interfaces.

#### Dependency Inversion Principle (DIP)
High-level modules should not depend on low-level modules. Both should depend on abstractions.

> Depend on abstractions, not on concretions.

**Implementation**: 
- Domain layer depends only on interfaces (defined in Domain)
- Infrastructure layer implements those interfaces
- Application layer coordinates using Domain interfaces

**Example**: `UserService` depends on `UserRepository` interface, not `DoctrineUserRepository` concrete class.

### KISS (Keep It Simple, Stupid)
Simplicity is key. Avoid unnecessary complexity. Prefer simple, clear solutions over clever ones.

> The simplest solution that solves the problem is the best solution.

**Guidelines**:
- Avoid deep nesting (max 2-3 levels)
- Methods should do one thing
- Classes should be small and focused
- If you need to explain it, it's probably too complex

**DRY is part of KISS**: Don't Repeat Yourself. Duplicate code is a maintenance burden and violates simplicity.

### DRY (Don't Repeat Yourself)
Every piece of knowledge must have a single, unambiguous, authoritative representation within a system.

> If you find yourself copying and pasting code, extract it into a reusable component.

**Implementation**:
- Shared business logic belongs in Domain layer
- Shared infrastructure logic belongs in Shared/ or Infrastructure/
- Exception: Test code may repeat for clarity (but DRY still applies to test helpers)

**When NOT to apply DRY**:
- Two similar but independent pieces of code that happen to look alike
- Code that would become harder to understand if extracted
- Test code where repetition improves clarity

## Code Commenting Rules

### When to Comment
Only comment code when it is not self-explanatory. If the code clearly expresses its intent, no comment is needed.

**Good candidates for comments**:
- Non-obvious business rules
- Workarounds for bugs or limitations
- Complex algorithms
- Decisions that might seem wrong but are intentional
- Security considerations

**Bad candidates for comments**:
- Code that does what it obviously does
- Getters and setters
- Simple type checks
- Standard framework boilerplate

### What to Comment
**Always explain WHY, never WHAT.**

The code shows WHAT it does. Comments should explain WHY it exists, the reasoning behind it, or the business rule it implements.

```php
// Good: Explains WHY
// We use BCrypt for password hashing because Argon2 is not available on all production servers
// This ensures compatibility with our legacy authentication system

// Bad: Explains WHAT (obvious from code)
// This method hashes the password
// It takes a plain text password and returns a hash

// Good: Explains business rule
// Users cannot delete their account if they have active subscriptions
// This is a legal requirement from our payment processor
if ($user->hasActiveSubscriptions()) {
    throw new CannotDeleteUserException();
}

// Bad: Explains WHAT
// Check if user has active subscriptions
// If yes, throw exception
```

### Language
Use **simple English** that is understandable for French speakers with basic English knowledge.

**Guidelines**:
- Use short, clear sentences
- Avoid idioms and complex grammar
- Use common technical terms (method, class, interface, etc.)
- Prefer active voice
- Keep sentences under 20 words when possible

### PHPDoc
Only add PHPDoc when it provides value beyond what the code already expresses.

**Add PHPDoc for**:
- Public API methods (to document the contract)
- Complex return types that aren't obvious
- Non-obvious side effects
- Interface methods (to document the contract)

**Skip PHPDoc for**:
- Obvious parameter types (when type is clear from variable name)
- Obvious return types (when method name makes it clear)
- Simple getters and setters
- Private methods (unless complex)

```php
// Good: PHPDoc adds value
/**
 * @throws EmailAlreadyUsedException When email is already registered
 */
public function register(UserRegistrationCommand $command): void

// Bad: PHPDoc is redundant
/**
 * @param string $email
 * @return User
 */
public function findByEmail(string $email): ?User
```

### Comment Format
- Use `//` for single-line comments
- Use `/** */` for PHPDoc
- Place comments **above** the code they describe
- Keep comments on their own line (don't append to code)
- Separate paragraphs with a blank line

### Examples from Project Context

```php
// In Domain/Entity/User.php

// Good: Explains business rule
// User is locked after 5 consecutive failed login attempts
// This is a security measure to prevent brute force attacks
public function incrementFailedAttempts(): void
{
    $this->failedAttempts++;
    if ($this->failedAttempts >= 5) {
        $this->locked = true;
    }
}

// In Application/UseCase/RegisterUser/RegisterUserHandler.php

// Good: Explains integration decision
// We dispatch UserRegisteredEvent synchronously to ensure
// all side effects (email, audit) happen atomically with registration
$eventDispatcher->dispatch(new UserRegisteredEvent($user));

// In Infrastructure/Persistence/Doctrine/DoctrineUserRepository.php

// Good: Explains technical constraint
// We use a native query here instead of DQL because
// the JOIN syntax for this specific case is not supported by Doctrine QueryBuilder
$results = $this->getEntityManager()->getConnection()->executeQuery($sql);
```

## Priority Order

When principles conflict, follow this priority:

1. **Correctness** - Code must work correctly first
2. **SOLID** - Especially SRP and DIP for maintainability
3. **KISS** - Simplicity over cleverness
4. **DRY** - Avoid duplication
5. **Readability** - Code should be easy to understand

## References
- [SOLID Principles Explained](https://scalastic.io/solid-dry-kiss/)
- Clean Code by Robert C. Martin
- Domain-Driven Design by Eric Evans
