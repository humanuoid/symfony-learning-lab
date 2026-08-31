<?php

declare(strict_types=1);

// DRY Principle Architecture Tests
// Tests are active for both current Shared structure and future Bounded Contexts

// ============================================================================
// DRY: Domain does not duplicate infrastructure concerns
// ============================================================================

arch('DRY - domain does not duplicate infrastructure concerns')
    ->expect(['App\Shared\Domain', 'App\*\Domain'])
    ->not->toUse(['App\Shared\Infrastructure', 'App\*\Infrastructure']);

// ============================================================================
// DRY: Application does not duplicate domain logic
// ============================================================================

arch('DRY - application does not duplicate domain logic')
    ->expect(['App\Shared\Application', 'App\*\Application'])
    ->not->toUse(['App\Shared\Domain', 'App\*\Domain']);

// ============================================================================
// DRY: Doctrine mappings in unique location
// ============================================================================

// Doctrine mappings should be in Infrastructure/Persistence/Doctrine only
arch('DRY - doctrine mappings in unique location')
    ->expect(['App\Shared\Infrastructure\Persistence\Doctrine', 'App\*\Infrastructure\Persistence\Doctrine'])
    ->toHaveSuffix('.orm.yaml');

// No Doctrine mappings allowed in config/ directory (enforces single source of truth)
arch('DRY - no doctrine mappings in config directory')
    ->expect(glob('config/doctrine/*.orm.yaml'))
    ->toBeEmpty();
