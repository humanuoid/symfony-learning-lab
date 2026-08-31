<?php

declare(strict_types=1);

// KISS Principle Architecture Tests
// Tests are active for both current Shared structure and future Bounded Contexts

// ============================================================================
// KISS: Use Case Organization
// ============================================================================

// Use cases should have command naming convention
arch('KISS - use cases have command naming convention')
    ->expect(['App\Shared\Application\UseCase', 'App\*\Application\UseCase'])
    ->toHaveSuffix('Command');

// Use cases should have handler naming convention
arch('KISS - use cases have handler naming convention')
    ->expect(['App\Shared\Application\UseCase', 'App\*\Application\UseCase'])
    ->toHaveSuffix('Handler');

// ============================================================================
// KISS: Shared Kernel
// ============================================================================

// Shared kernel should not be used incorrectly
arch('KISS - shared kernel is cross-cutting')
    ->expect(['App\Shared'])
    ->not->toBeUsedIn(['App\Shared\Infrastructure']);
