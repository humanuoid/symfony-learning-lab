<?php

declare(strict_types=1);

// SOLID Principles Architecture Tests
// Tests are active for both current Shared structure and future Bounded Contexts

// ============================================================================
// SOLID: Single Responsibility Principle (SRP)
// ============================================================================

arch('SOLID - SRP: domain maintains single responsibilities')
    ->expect(['App\Shared\Domain', 'App\*\Domain'])
    ->not->toUse('Symfony\*');

arch('SOLID - SRP: application maintains single responsibilities')
    ->expect(['App\Shared\Application', 'App\*\Application'])
    ->not->toUse('Symfony\*');

// ============================================================================
// SOLID: Open/Closed Principle (OCP)
// ============================================================================

// Domain value objects should follow naming convention
arch('SOLID - OCP: domain value objects follow naming convention')
    ->expect(['App\Shared\Domain\Model\ValueObject', 'App\*\Domain\Model\ValueObject'])
    ->toHaveSuffix('ValueObject');

// ============================================================================
// SOLID: Liskov Substitution Principle (LSP)
// ============================================================================

// Infrastructure should implement domain repository interfaces
arch('SOLID - LSP: infrastructure implements domain repository interfaces')
    ->expect(['App\Shared\Infrastructure\Persistence', 'App\*\Infrastructure\Persistence'])
    ->toImplement(['App\Shared\Domain\Model\Repository\*', 'App\*\Domain\Model\Repository\*']);

// ============================================================================
// SOLID: Interface Segregation Principle (ISP)
// ============================================================================

// Domain defines repository interfaces
arch('SOLID - ISP: domain defines repository interfaces')
    ->expect(['App\Shared\Domain\Model\Repository', 'App\*\Domain\Model\Repository'])
    ->toHaveSuffix('Repository');

// Infrastructure implements domain repository interfaces with Doctrine prefix
arch('SOLID - ISP: infrastructure implements domain repository interfaces')
    ->expect(['App\Shared\Infrastructure\Persistence\Doctrine', 'App\*\Infrastructure\Persistence\Doctrine'])
    ->toHaveSuffix('Doctrine*Repository');

// ============================================================================
// SOLID: Dependency Inversion Principle (DIP)
// ============================================================================

// Domain depends only on abstractions (not on infrastructure)
arch('SOLID - DIP: domain depends only on abstractions')
    ->expect(['App\Shared\Infrastructure', 'App\*\Infrastructure'])
    ->not->toBeUsedIn(['App\Shared\Domain', 'App\*\Domain']);

// Application depends on domain abstractions (not on infrastructure)
arch('SOLID - DIP: application depends on domain abstractions')
    ->expect(['App\Shared\Application', 'App\*\Application'])
    ->not->toUse(['App\Shared\Infrastructure', 'App\*\Infrastructure']);
