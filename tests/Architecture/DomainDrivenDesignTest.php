<?php

declare(strict_types=1);

// Domain-Driven Design (DDD) Architecture Tests
// Tests are active for both current Shared structure and future Bounded Contexts

// ============================================================================
// DDD: Layer Separation - Current Shared + Future Bounded Contexts
// ============================================================================

// Domain layer must have no Symfony dependencies (Shared + all contexts)
arch('DDD - domain layer has no symfony dependencies')
    ->expect(['App\Shared\Domain', 'App\*\Domain'])
    ->not->toUse('Symfony\*');

// Domain layer must have no Doctrine dependencies (Shared + all contexts)
arch('DDD - domain layer has no doctrine dependencies')
    ->expect(['App\Shared\Domain', 'App\*\Domain'])
    ->not->toUse('Doctrine\*');

// Application layer must not depend on Infrastructure layer (Shared + all contexts)
arch('DDD - application layer does not depend on infrastructure')
    ->expect(['App\Shared\Application', 'App\*\Application'])
    ->not->toUse(['App\Shared\Infrastructure', 'App\*\Infrastructure']);

// Domain must not depend on Infrastructure layer (Shared + all contexts)
arch('DDD - domain layer does not depend on infrastructure')
    ->expect(['App\Shared\Infrastructure', 'App\*\Infrastructure'])
    ->not->toBeUsedIn(['App\Shared\Domain', 'App\*\Domain']);

// ============================================================================
// DDD: Doctrine ORM Configuration
// ============================================================================

// Doctrine mappings must be YAML files in Infrastructure/Persistence/Doctrine
arch('DDD - doctrine mappings are yaml files in infrastructure')
    ->expect(['App\Shared\Infrastructure\Persistence\Doctrine', 'App\*\Infrastructure\Persistence\Doctrine'])
    ->toHaveSuffix('.orm.yaml');

// No Doctrine mappings allowed in config/ directory
arch('DDD - no doctrine mappings in config directory')
    ->expect(glob('config/doctrine/*.orm.yaml'))
    ->toBeEmpty();
