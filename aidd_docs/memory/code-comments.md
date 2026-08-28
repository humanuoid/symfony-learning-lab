# Code Comments

Rules and guidelines for writing comments in the codebase.

## Core Principles

### 1. When to Comment
- **Only if necessary**: If the code is **not self-explanatory** or the logic is **non-obvious**.
- **Avoid comments for trivial code**: Well-written code should **not** need comments to explain **what** it does.
- **Prefer refactoring**: If you need to write a comment to explain complex code, consider **refactoring** it to be self-explanatory.

### 2. Language
- **Use simple English**: Easy to understand for a French developer with **intermediate English level**.
- **Avoid complex terms**: Use short, clear sentences.
- **Avoid jargon**: Use common words instead of technical terms when possible.

### 3. Content: WHY, Not WHAT
- **✅ Comment the WHY**: The **reason** behind the code (business rule, technical constraint, historical context).
- **❌ Do NOT comment the WHAT**: What the code does (the code itself should be clear).

---

## Good vs Bad Comments

### Good Comments (WHY)

#### Business Rules
```php
// We block registration from this domain because of fraud detected in 2023.
if (str_ends_with($email, '@bad-domain.com')) {
    throw new RegistrationBlockedException();
}
```

#### Technical Constraints
```php
// We use a custom serializer here because the default one fails with circular references.
$serializer = new CustomJsonSerializer();
```

#### Historical Context
```php
// TODO: Remove this legacy check when we migrate to the new payment system (Q3 2024).
// Old system: Stripe, New system: PayPal
if ($this->isLegacyPayment()) {
    $this->processWithStripe();
}
```

#### Security Notes
```php
// Never log the full credit card number, only the last 4 digits (PCI compliance).
$logData = [
    'card_last_four' => substr($cardNumber, -4),
];
```

#### Performance Notes
```php
// We cache this result because it takes ~2 seconds to compute.
// Cache TTL: 1 hour (adjust if data changes frequently).
$cachedResult = $this->cache->get('expensive_operation', fn() => $this->compute());
```

### Bad Comments (WHAT)

#### Redundant Comments
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

#### Obvious Comments
```php
// Constructor
public function __construct() {}

// Return the user
return $user;

// If user is admin
if ($user->isAdmin()) {
    // ...
}
```

---

## Alternatives to Comments

### 1. Well-Named Code
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

### 2. Extract Methods
```php
// ❌ Bad: Comment explains a complex block
// Calculate total price with taxes and discounts
$total = $price;
if ($this->hasTaxes()) {
    $total += $price * 0.2;
}
if ($this->hasDiscount()) {
    $total -= $price * 0.1;
}

// ✅ Good: Extract method with clear name
$total = $this->calculateTotalPriceWithTaxesAndDiscounts($price);
```

### 3. Use Constants
```php
// ❌ Bad: Magic number with comment
// Max retry attempts
if ($attempts >= 3) {
    // ...
}

// ✅ Good: Named constant
private const MAX_RETRY_ATTEMPTS = 3;

if ($attempts >= self::MAX_RETRY_ATTEMPTS) {
    // ...
}
```

---

## Special Comment Types

### 1. PHPDoc
- **Use only for public APIs** (classes, public methods, functions).
- **Avoid for private/protected methods** (the code should be self-explanatory).
- **Keep it short**: 1-2 lines max.
- **Focus on WHY, not WHAT**: Explain the purpose, not the implementation.

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

#### Bad PHPDoc (WHAT)
```php
/**
 * This method takes a RegisterUserRequest and returns a RegisterUserResponse.
 * It calls the user repository to check if the email exists.
 */
public function register(RegisterUserRequest $request): RegisterUserResponse
{
    // ...
}
```

#### Good PHPDoc (WHY)
```php
/**
 * Registers a new user after validating the request.
 * Used by the registration controller and CLI command.
 */
public function register(RegisterUserRequest $request): RegisterUserResponse
{
    // ...
}
```

### 2. TODO Comments
- Use `// TODO:` for **temporary code** that needs to be improved.
- **Always include a reason and a deadline** (if possible).
- **Assign an owner** if the team is large.

```php
// TODO: Remove this workaround when Symfony fixes the bug in v6.4 (Q3 2024)
// See: https://github.com/symfony/symfony/issues/12345
$response = $this->fixResponseHeaders($response);

// TODO(@john): Refactor this method to use the new API (before 2024-12-01)
$oldResult = $this->legacyCall();
```

### 3. FIXME Comments
- Use `// FIXME:` for **broken code** that needs to be fixed.
- **Always include a description of the issue**.

```php
// FIXME: This fails when the user has no orders (NullException)
// Temporary fix: Check for null before accessing orders
if ($user->orders() !== null) {
    $this->processOrders($user->orders());
}
```

### 4. Deprecation Notices
- Use `@deprecated` for **deprecated code**.
- **Always include a replacement** (if available).

```php
/**
 * @deprecated Use User::isAdmin() instead. Will be removed in v2.0.
 */
public function hasAdminRole(): bool
{
    return $this->isAdmin();
}
```

---

## Commenting in Different Layers

### Domain Layer
- **Comment WHY**: Business rules, invariants, or complex logic.
- **Avoid WHAT**: The code should be self-explanatory.

```php
// We enforce a minimum password length of 12 characters for security reasons.
// This is a company policy since the 2023 security audit.
if (strlen($password) < 12) {
    throw new PasswordTooShortException();
}
```

### Application Layer
- **Comment WHY**: Application-specific rules or workflows.
- **Avoid WHAT**: The orchestration should be clear from the code.

```php
// We send a welcome email only for users registered via the web form.
// Mobile app users get a different onboarding flow.
if ($request->source === 'web') {
    $this->sendWelcomeEmail($user);
}
```

### Infrastructure Layer
- **Comment WHY**: Technical constraints or framework-specific quirks.
- **Avoid WHAT**: The code should be self-explanatory.

```php
// We use a custom query here because Doctrine's default query builder
// does not support the JSONB contains operator in PostgreSQL.
$results = $this->connection->executeQuery(
    'SELECT * FROM users WHERE metadata @> ?',
    [$filter]
);
```

---

## Code Review Guidelines

### For Reviewers
- **Flag comments that explain WHAT**: Ask the author to refactor the code to be self-explanatory.
- **Encourage WHY comments**: If the code has a non-obvious reason, ask for a comment.
- **Check for outdated comments**: If the code changes but the comment doesn't, flag it.

### For Authors
- **Before writing a comment**: Ask yourself, "Can I make the code clearer instead?"
- **After writing a comment**: Ask yourself, "Does this explain WHY, not WHAT?"
- **When refactoring**: Update or remove comments that are no longer relevant.

---

## Tools to Enforce Comment Quality

### 1. PHP_CodeSniffer
- Configure to **warn on redundant comments** (e.g., comments that restate the code).
- Example rule: `Generic.Commenting.TodoComment` (for TODO/FIXME).

### 2. PHPStan
- Use **level 9** to catch unused code (which may indicate outdated comments).

### 3. Manual Review
- **Pair programming**: Discuss comments during code reviews.
- **Comment audits**: Periodically review comments for relevance.

---

## Summary

| Rule | Example | Good/Bad |
|------|---------|----------|
| Only comment if necessary | `// We use this for GDPR compliance` | ✅ Good |
| Use simple English | `// This check is required by law` | ✅ Good |
| Comment WHY, not WHAT | `// We cache this because it's slow` | ✅ Good |
| Avoid WHAT comments | `// Increment counter` | ❌ Bad |
| Use well-named code | `if ($user->isAdmin())` | ✅ Good |
| Use TODO/FIXME with reason | `// TODO: Remove in v2.0` | ✅ Good |
| Keep PHPDoc short | `/** Registers a user. */` | ✅ Good |

**Golden Rule**: 
> If you can replace the comment with a **better variable/method name**, do it. 
> If you can't, the comment should explain **WHY** the code exists.